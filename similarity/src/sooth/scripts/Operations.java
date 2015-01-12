package sooth.scripts;

import org.jooq.DSLContext;
import sooth.Logging;
import sooth.Configuration;
import sooth.connection.Database;
import sooth.entities.Tables;
import sooth.entities.tables.records.PluginsRecord;
import sooth.entities.tables.records.SubmissionsRecord;
import sooth.objects.Document;
import sooth.objects.Similarity;
import sooth.objects.Submission;
import sooth.similarity.DocumentComparisonResult;

import java.nio.file.Path;
import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.*;
import java.util.logging.Logger;

public class Operations {
    private static Logger logger = Logging.getLogger(Operations.class.getName());
    private static final boolean useMultithreading = false;
    public static final int MINIMUM_DOCUMENT_LENGTH = 500; // 500 bytes

    /**
     * Removes whitespace from the specified string.
     * @param text The string to remove whitespace from.
     * @return The string with whitespace removed.
     */
    public static String removeWhitespace(String text) {
        return text.replaceAll("\\s+", "");
    }

    /**
     * Removes whitespace from each string in the array and returns an array with these modified strings.
     * @param stringsToRemoveWhitespaceFrom The array of strings where whitespace should be removed.
     * @return An array of the same size as the argument, containing the same strings in the same order, except that they have not whitespace.
     */
    public static String[] removeWhitespace(String[] stringsToRemoveWhitespaceFrom) {
        String[] result = new String[stringsToRemoveWhitespaceFrom.length];
        for (int i =0;i < stringsToRemoveWhitespaceFrom.length; i++)
        {
            result[i] = Operations.removeWhitespace(stringsToRemoveWhitespaceFrom[i]);
        }
        return result;
    }

    public static String removeSubstrings(String haystack, String[] needles) {
        // This might benefit from a better algorithm such as Aho-Corasick.
        // It's something to consider if this becomes a bottleneck.
        for(String needle : needles) {
            haystack = haystack.replace(needle, "");
        }
        return haystack;
    }

    public static void redetermineGuiltOrInnocence() {
        DSLContext context = Database.getContext();
        String guiltyQuery =
                "UPDATE submissions SET submissions.similarityStatus = 'guilty' " +
                "WHERE submissions.similarityStatus = 'checked' " +
                "AND submissions.status <> 'deleted' " +
                "AND EXISTS ( SELECT id FROM similarities WHERE similarities.newSubmissionId = submissions.id AND similarities.suspicious = 1)";
        context.execute(guiltyQuery);
        String innocentQuery =
                "UPDATE submissions SET submissions.similarityStatus = 'innocent' " +
                        "WHERE submissions.similarityStatus = 'checked' " +
                        "AND submissions.status <> 'deleted' " +
                        "AND NOT EXISTS ( SELECT id FROM similarities WHERE similarities.newSubmissionId = submissions.id AND similarities.suspicious = 1)";
        context.execute(innocentQuery);
    }

    private static class ComparisonRunner implements Runnable {
        private Submission oldSubmission;
        private Submission newSubmission;
        private ArrayBlockingQueue<Similarity> queue;

        public ComparisonRunner(Submission oldSubmission, Submission newSubmission, ArrayBlockingQueue<Similarity> queue) {

            this.oldSubmission = oldSubmission;
            this.newSubmission = newSubmission;
            this.queue = queue;
        }

        @Override
        public void run() {
            queue.add(Operations.compare(oldSubmission, newSubmission));
        }
    }

    private static ExecutorService executor = null;
    private static ExecutorCompletionService executorCompletionService;

    public static Iterable<Similarity> compareToAll(Submission newSubmission, List<Submission> submissions, int checkFrom, int checkUpToExclusive) {
        // TODO assert that (checkUpToExclusive - checkFrom > 0)
        int count = checkUpToExclusive - checkFrom;
        if (count <= 0) {
            throw new IllegalArgumentException("You must specify at least one submission to compare against.");
        }
         ArrayList<Similarity> similarities = new ArrayList<>();

        ArrayBlockingQueue<Similarity> similarityQueue = null;
        if (useMultithreading) {
            similarityQueue = new ArrayBlockingQueue<Similarity>(checkUpToExclusive - checkFrom);
            if (executor == null) {
                executor = Executors.newFixedThreadPool(2);
                executorCompletionService = new ExecutorCompletionService(executor);
            }
        }

        logger.fine("Comparing " + newSubmission.getSubmissionId() + " to older submissions.");
        for (int i = checkFrom; i < checkUpToExclusive; i++) {
            if (submissions.get(i).getUserId() == newSubmission.getUserId())
            {
                // These submissions were uploaded by the same user.
                if (Configuration.ignoringSelfPlagiarism())
                {
                    continue;
                }
            }

            if (useMultithreading) {
                executorCompletionService.submit(new ComparisonRunner(submissions.get(i), newSubmission, similarityQueue), null);
            }
            else {
                Similarity similarity = Operations.compare(submissions.get(i), newSubmission);
                if (similarity.getScore() > 0) {
                    similarities.add(similarity);
                }
            }
        }

        if (useMultithreading) {
            // Wait until all tasks are completed.
            try {
                for (int i = 0; i < count;i ++)
                {
                    executorCompletionService.take();
                }
            } catch (InterruptedException ignored) {
                // Won't happen unless someone meddles with this.
            }
            return similarityQueue;
        }
        else {
            return similarities;
        }
    }

    public static Similarity compare(Submission oldSubmission, Submission newSubmission) {
        // Compare all documents to all documents.
        // Default metric: take the highest similarity from among documents
        Similarity similarity = new Similarity(0, "", oldSubmission.getSubmissionId(), newSubmission.getSubmissionId(), false);
        for (Document oldDocument : oldSubmission.getDocuments())
        {

            for (Document newDocument : newSubmission.getDocuments())
            {

                if (oldDocument.getType().equals(newDocument.getType()))
                {
                    if (oldDocument.getPreprocessedText().length() < Operations.MINIMUM_DOCUMENT_LENGTH ||
                            newDocument.getPreprocessedText().length() < Operations.MINIMUM_DOCUMENT_LENGTH)
                    {
                        // It is meaningless to compare documents this small for similarity because they will be trivial.
                        continue;
                    }
                    logger.fine("Now comparing " + oldDocument.getType() + " documents.");


                    // Zhang-Shasha

                    DocumentComparisonResult result = null;
                    if (oldDocument.getType() == Document.DocumentType.PRIMARY_XML_FILE ||
                            oldDocument.getType() == Document.DocumentType.XSD_SCHEMA ||
                            oldDocument.getType() == Document.DocumentType.XSLT_SCRIPT) {
                        if (oldDocument.getZhangShashaTree() != null && newDocument.getZhangShashaTree() != null) {
                            result = DocumentComparisons.zhangShashaCompare(oldDocument, newDocument, oldSubmission.getPluginIdentifier());
                            if (!result.isSuspicious()) {
                                result = null; // We will still try a Levenshtein comparison if Zhang-Shasha did not trigger.
                            }
                        }
                    }

                    if (result == null) {
                        result = DocumentComparisons.levenshteinCompare(oldDocument, newDocument, oldSubmission.getPluginIdentifier());
                    }

                    if (similarity.getScore() < result.getSimilarity()) {
                        similarity.setScore(result.getSimilarity());
                    }
                    if (result.isSuspicious()) {
                        similarity.setSuspicious(true);
                    }
                    if (result.isSuspicious() || result.getSimilarity() >= Configuration.levenshteinMasterThreshold)
                    {
                        similarity.setDetails(similarity.getDetails() +
                                oldDocument.getType() + " comparison (" + result.getSimilarity() + "%"+(result.isSuspicious() ? ", suspicious" : "")+ "):\n"
                                + "Details: \n" + result.getDetails() + "\n\n");
                    }
                }
            }
        }
        if (similarity.getDetails().equals("")) {
            similarity.setDetails("No similarity detected.");
        }
        return similarity;
    }

    public static PluginsRecord getPluginsRecordFromSubmissionsRecord(SubmissionsRecord submission)
    {
        DSLContext context = Database.getContext();
        PluginsRecord correspondingPlugin = context.selectFrom(Tables.PLUGINS)
            .where(Tables.PLUGINS.ID.in(
                    context.select(Tables.PROBLEMS.PLUGINID).from(Tables.PROBLEMS)
                            .where(Tables.PROBLEMS.ID.in(
                                    context.select(Tables.ASSIGNMENTS.PROBLEMID).from(Tables.ASSIGNMENTS)
                                            .where(Tables.ASSIGNMENTS.ID.equal(submission.getAssignmentid())).fetch()
                            )).fetch()
            )).fetchAny();
        return correspondingPlugin;
    }

    /**
     * Extracts all relevant documents from the ZIP file associated with the specified submissions and puts those documents into the database.
     * @param submission The submission record identifying the submission whose documents should be put into the database.
     */
    public static void createDatabaseDocumentsFromSubmissionRecord(SubmissionsRecord submission) {
        PluginsRecord plugin = getPluginsRecordFromSubmissionsRecord(submission);
        if (plugin == null) {
            logger.info("The submission " + submission.getId() + " is not associated with any plugin. Skipping it.");
            return;
        }
        Path submissionInputPath = Configuration.getSubmissionInputPath(submission.getSubmissionfile());
        List<Document> documents = DocumentExtractor.getDocumentsFromZipArchive(submissionInputPath, plugin.getIdentifier());
        logger.fine("Submission '" + submission.getId() + "' generated " + documents.size() + " documents.");
        DSLContext context = Database.getContext();
        for(Document document : documents) {
            context.insertInto(Tables.DOCUMENTS, Tables.DOCUMENTS.TEXT,Tables.DOCUMENTS.NAME, Tables.DOCUMENTS.TYPE, Tables.DOCUMENTS.SUBMISSIONID)
                    .values(document.getText(), document.getName(), document.getType().getMysqlIdentifier(), submission.getId())
                    .execute();
            logger.fine("Document named '" + document.getName() + "' for submission '" + submission.getId() + "' was inserted into the database.");
        }
    }

}
