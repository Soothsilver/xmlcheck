package sooth.scripts;

import org.jooq.DSLContext;
import org.jooq.Result;
import sooth.Logging;
import sooth.Problems;
import sooth.connection.Database;
import sooth.connection.InsertSimilaritiesBatch;
import sooth.entities.Tables;
import sooth.entities.tables.records.SubmissionsRecord;
import sooth.objects.Similarity;
import sooth.objects.Submission;
import sooth.objects.SubmissionsByPlugin;

import java.util.ArrayList;
import java.util.Date;
import java.util.Objects;
import java.util.logging.Logger;
// TODO (elsewhere) document and mind java heap space
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

    public static void runPlagiarismCheckingOnEntireDatabase() {
        BatchActions.destroyAllSimilarities();
        logger.info("I will now recheck the entire database for plagiarism.");
        logger.info("Extracting documents and submissions from database to memory.");
        SubmissionsByPlugin submissionsByPlugin = Database.runSubmissionsByPluginQueryOnAllIdentifiers();
        logger.info("Running comparisons.");

        InsertSimilaritiesBatch batch = new InsertSimilaritiesBatch();
        for (ArrayList<Submission> submissions : submissionsByPlugin.values())
        {
            int k = 1;
            if (submissions.isEmpty()) {
                continue;
            }
            logger.info("Identifier category: " + submissions.get(0).getPluginIdentifier() + " (count " + submissions.size() + ")");
            logger.info("Time: " + new Date());
            if (!Objects.equals(submissions.get(0).getPluginIdentifier(), Problems.HW1_DTD)) {
                logger.info("Ignoring.");
                continue;
            }

            for (int i = 1; i < submissions.size(); i++)
            {
                Iterable<Similarity> similarities = Operations.compareToAll(submissions.get(i), submissions, 0, i);
                for (Similarity similarity : similarities) {
                    if (similarity.getScore() >= Similarity.MINIMUM_INTERESTING_SCORE) {
                        batch.add(similarity);
                    }
                }
                if (i == submissions.size()*k/10)
                {
                    logger.info("Percent done: " + (k*10));
                    logger.info("Time: " + new Date());
                    k++;
                }
            }
        }

        logger.info("Submitting the batch to the database.");
        batch.execute();
        logger.info("Done.");
        logger.info("The entire database has been fully checked for plagiarism.");
    }

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

    private static void destroyAllSimilarities() {
        logger.info("I will destroy all similarities.");
        DSLContext context = Database.getContext();
        context.delete(Tables.SIMILARITIES).execute();
        logger.info("All similarities destroyed and removed from the database.");
    }

    private static void destroyAllDocuments() {
        logger.info("I will destroy all documents.");
        DSLContext context = Database.getContext();
         context.delete(Tables.DOCUMENTS).execute();
        logger.info("All documents destroyed and removed from the database..");
    }
}
