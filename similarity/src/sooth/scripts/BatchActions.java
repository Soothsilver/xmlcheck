package sooth.scripts;

import org.jooq.DSLContext;
import org.jooq.Result;
import org.omg.PortableInterceptor.SYSTEM_EXCEPTION;
import sooth.Logging;
import sooth.Problems;
import sooth.connection.Database;
import sooth.connection.InsertSimilaritiesBatch;
import sooth.entities.Tables;
import sooth.entities.tables.records.SubmissionsRecord;
import sooth.objects.Similarity;
import sooth.objects.Submission;
import sooth.objects.SubmissionsByPlugin;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.RandomAccessFile;
import java.nio.channels.FileLock;
import java.util.*;
import java.util.logging.Logger;
// TODO (elsewhere) document and mind java heap space

/**
 * This class contains static functions that perform actions on the entire database.
 */
public class BatchActions {
    private static Logger logger = Logging.getLogger(BatchActions.class.getName());
    /**
     * Deletes all documents and similarities detected, recreates all documents, and then runs similarity checking on everything.
     * This method will take a great amount of time to run.
     */
    public static void makeEntireDatabase() {
        BatchActions.createDocumentsFromAllSubmissions();
        BatchActions.runPlagiarismCheckingOnEntireDatabase();
    }

    /**
     * Deletes all similarity records from the database, then runs similarity checking on everything.
     */
    public static void runPlagiarismCheckingOnEntireDatabase() {
        BatchActions.destroyAllSimilarities();
        logger.info("I will now recheck the entire database for plagiarism.");
        logger.info("Extracting documents and submissions from database to memory.");
        SubmissionsByPlugin submissionsByPlugin = Database.runSubmissionsByPluginQueryOnAllIdentifiers();
        logger.info("Creating comparison commands.");

        int totalComparisons = 100; // safety margin
        for (ArrayList<Submission> submissions : submissionsByPlugin.values()) {
            totalComparisons += submissions.size() * (submissions.size()+1) /2;
        }

        SimilarityCheckingBatch similarityBatch = new SimilarityCheckingBatch(totalComparisons);
        for (ArrayList<Submission> submissions : submissionsByPlugin.values())
        {
            int k = 1;
            if (submissions.isEmpty()) {
                continue;
            }
            logger.info("Identifier category: " + submissions.get(0).getPluginIdentifier() + " (count " + submissions.size() + ")");
            logger.info("Time: " + new Date());

            // For debugging. Enable this if you only want to check submissions for a specific plugin.
            /*
            if (!Objects.equals(submissions.get(0).getPluginIdentifier(), Problems.HW1_DTD)) {
                logger.info("Ignoring.");
                continue;
            }
            */

            for (int i = 1; i < submissions.size(); i++) {
                similarityBatch.addComparisonOfOneToMany(submissions.get(i), submissions, 0, i);
            }

        }

        logger.info("There are "  + similarityBatch.size() + " similarity commands.");
        logger.info("Executing them!");
        logger.info("Time: " + new Date());
        Iterable<Similarity> similarities = similarityBatch.execute();
        logger.info("Submitting them to the database!");
        logger.info("Time: " + new Date());
        InsertSimilaritiesBatch batch = new InsertSimilaritiesBatch();
        for (Similarity similarity : similarities) {
            if (similarity.getScore() >= Similarity.MINIMUM_INTERESTING_SCORE) {
                batch.add(similarity);
            }
        }
        batch.execute();
        logger.info("Done.");
        logger.info("Time: " + new Date());
        logger.info("The entire database has been fully checked for plagiarism.");
    }

    /**
     * Destroys all document records in the database, then reloads documents from disk (from ZIP files) into the documents table in the database.
     * This method will take a lot of time because it makes a lot of I/O operations.
     */
    public static void createDocumentsFromAllSubmissions() {
        BatchActions.destroyAllDocuments();
        logger.info("I will now recreate document records from all submissions.");
        DSLContext context = Database.getContext();
        Result<SubmissionsRecord> submissions = context.selectFrom(Tables.SUBMISSIONS).where(Tables.SUBMISSIONS.STATUS.notEqual("deleted")).fetch();
        for(SubmissionsRecord record : submissions) {

            Operations.createDatabaseDocumentsFromSubmissionRecord(record);
        }
        logger.info("Document records created.");
    }

    /**
     * Removes all similarity records from the database by truncating the similarities table.
     */
    private static void destroyAllSimilarities() {
        logger.info("I will destroy all similarities.");
        DSLContext context = Database.getContext();
        context.truncate(Tables.SIMILARITIES).execute();
        context.delete(Tables.SIMILARITIES).execute();
        logger.info("All similarities destroyed and removed from the database.");
    }

    /**
     * Removes all document records from the database by truncating the documents table.
     */
    private static void destroyAllDocuments() {
        logger.info("I will destroy all documents.");
        DSLContext context = Database.getContext();
        context.truncate(Tables.DOCUMENTS).execute();
        context.delete(Tables.DOCUMENTS).execute();
        logger.info("All documents destroyed and removed from the database..");
    }

    public static void extractAndAnalyzeNewSubmissionsIfPossible() {
        // First, make a lock.
        File lockFile = new File("similarity.lock");
        RandomAccessFile randomAccessFile = null;
        try {
            randomAccessFile = new RandomAccessFile(lockFile, "rw");
        } catch (FileNotFoundException ignored) {
            System.err.println("You don't have privileges to open a lock file.");
            return;
        }
        try {
            FileLock fileLock = randomAccessFile.getChannel().tryLock();
            // We are now the only instance running.
            while (extractAndAnalyzeNewSubmissions()) {
                // Repeat until false is returned.
            }
            if (fileLock == null) {
                System.out.println("Another instance of the similarity module is in progress. Aborting this instance.");
                return;
            }
        } catch (IOException e) {
            System.err.println("An error occured when attempting to secure a file lock.");
            return;
        }
    }

    private static boolean extractAndAnalyzeNewSubmissions() {
        // We are now the only instance running.

        // Find new submissions.
        DSLContext context = Database.getContext();
        Result<SubmissionsRecord> submissions =
                context.selectFrom(Tables.SUBMISSIONS)
                       .where(Tables.SUBMISSIONS.STATUS.notEqual("deleted"))
                       .and(Tables.SUBMISSIONS.SIMILARITYSTATUS.equal("new")).fetch();

        if (submissions.size() == 0) {
            logger.info("No new submission detected. Success.");
            return false;
        }
        // Create documents
        logger.info("I will now recreate document records from all new submissions.");
        for(SubmissionsRecord record : submissions) {
            Operations.createDatabaseDocumentsFromSubmissionRecord(record);
        }
        logger.info("Document records created.");

        // Create set of submission ids that need to be checked
        SortedSet<Integer> newSubmissions = new TreeSet<>();
        for (SubmissionsRecord record : submissions) {
            newSubmissions.add(record.getId());
        }

        SubmissionsByPlugin submissionsByPlugin = Database.runSubmissionsByPluginQueryOnAllIdentifiers();

        // Set initial capacity
        int totalComparisons = 100;
        for (ArrayList<Submission> typedSubmissions : submissionsByPlugin.values()) {
            totalComparisons += typedSubmissions.size() * (typedSubmissions.size()+1) /2;
        }

        // Create comparison commands
        SimilarityCheckingBatch similarityBatch = new SimilarityCheckingBatch(totalComparisons);
        for (ArrayList<Submission> typedSubmissions : submissionsByPlugin.values())
        {
            int k = 1;
            if (submissions.isEmpty()) {
                continue;
            }

            for (int i = 1; i < typedSubmissions.size(); i++) {
                if (newSubmissions.contains(new Integer(typedSubmissions.get(i).getSubmissionId()))) {
                    similarityBatch.addComparisonOfOneToMany(typedSubmissions.get(i), typedSubmissions, 0, i);
                }
            }
        }

        logger.info("There are "  + similarityBatch.size() + " similarity commands. Executing.");
        Iterable<Similarity> similarities = similarityBatch.execute();
        InsertSimilaritiesBatch batch = new InsertSimilaritiesBatch();
        for (Similarity similarity : similarities) {
                batch.add(similarity);
        }
        batch.execute();
        logger.info("Time: " + new Date());
        logger.info("Updating status to 'checked'.");

        // Send to database information that these submissions are checked
        for (SubmissionsRecord record : submissions) {
            record.setSimilaritystatus("checked");
        }
        context.batchStore(submissions).execute();
        logger.info("Time: " + new Date() + ". Done.");

        // Determine guilt or innocence
        logger.info("Determining guilt...");
        Operations.redetermineGuiltOrInnocence();
        logger.info("Time: " + new Date() + ". Done.");

        // Repeat?
        logger.info("At least one new submission was processed. Similarity checking will not be immediately repeated.");
        return true;
    }
}
