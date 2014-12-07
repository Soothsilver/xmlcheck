package sooth.scripts;

import org.jooq.DSLContext;
import sooth.Logging;
import sooth.connection.Configuration;
import sooth.connection.Database;
import sooth.entities.Tables;
import sooth.entities.tables.records.PluginsRecord;
import sooth.entities.tables.records.SubmissionsRecord;
import sooth.objects.Document;
import sooth.objects.Similarity;
import sooth.objects.Submission;
import sooth.similarity.ComparisonResult;

import java.nio.file.Path;
import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.*;
import java.util.logging.Logger;

public class Operations {
    private static Logger logger = Logging.getLogger(Operations.class.getName());
    private static final boolean useMultithreading = false;

    public static String foldWhitespace(String text) {
        return text.replaceAll("\\s+", ""); // TODO this does not fold, but remove
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
                    logger.fine("Now comparing " + oldDocument.getType() + " documents.");
                    ComparisonResult result = DocumentComparisons.levenshteinCompare(oldDocument, newDocument, oldSubmission.getPluginIdentifier());
                    if (similarity.getScore() < result.getSimilarity()) {
                        similarity.setScore(result.getSimilarity());
                    }
                    if (result.isSuspicious()) {
                        similarity.setSuspicious(true);
                    }
                    similarity.setDetails(similarity.getDetails() +
                    oldDocument.getType() + " comparison (" + result.getSimilarity() + "%"+(result.isSuspicious() ? ", suspicious" : "")+ "):\n"
                        + "Details: \n" + result.getDetails() + "\n\n");
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
