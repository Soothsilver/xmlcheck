package sooth.scripts;

import org.jooq.DSLContext;
import org.jooq.Result;
import sooth.Logging;
import sooth.connection.Configuration;
import sooth.connection.Database;
import sooth.entities.Tables;
import sooth.entities.tables.Submissions;
import sooth.entities.tables.records.PluginsRecord;
import sooth.entities.tables.records.SubmissionsRecord;
import sooth.objects.Document;
import sooth.objects.Similarity;
import sooth.objects.Submission;

import javax.naming.Context;
import javax.xml.crypto.Data;
import java.util.ArrayList;
import java.util.Comparator;
import java.util.List;
import java.util.logging.Logger;

public class BatchActions {
    private static Logger logger = Logging.getLogger(BatchActions.class.getName());
    /**
     * Deletes all documents and similarities detected, recreates all documents, and then runs similarity checking on everything.
     * This method will take a great amount of time to run.
     */
    public static void recheckEntireDatabase() {
        BatchActions.destroyAllDocuments();
        BatchActions.createDocumentsFromAllSubmissions();
        BatchActions.destroyAllSimilarities();
        BatchActions.runPlagiarismCheckingOnEntireDatabase();
    }

    public static void runPlagiarismCheckingOnEntireDatabase() {
        logger.info("I will now recheck the entire database for plagiarism.");
        logger.info("Extracting documents and submissions from database to memory.");
        DSLContext context = Database.getContext();
        Database.allSubmissions = context.selectFrom(Tables.SUBMISSIONS).where(Tables.SUBMISSIONS.STATUS.notEqual("deleted")).fetch();
        Database.allDocuments = context.selectFrom(Tables.DOCUMENTS).fetch();
        Submission.allSubmissions = new ArrayList<>();
        Database.allSubmissions.forEach(submissionsRecord -> Submission.allSubmissions.add(Submission.createFromSubmissionsRecord(submissionsRecord)));
        logger.info("There are " + Submission.allSubmissions.size() + " submissions to compare.");
        logger.info("Sorting submissions by date.");
        Submission.allSubmissions.sort((o1,o2) -> o1.UploadTime.compareTo(o2.UploadTime));
        logger.info("Sorting completed.");
        for (int i = 0; i < Submission.allSubmissions.size(); i++) {
            List<Similarity> similarities;
            similarities = Operations.compareToAll(Submission.allSubmissions.get(i), Submission.allSubmissions, 0, i);
            for (Similarity similarity : similarities) {
                Operations.addToDatabase(similarity);
            }
        }
        logger.info("The entire database has been fully checked for plagiarism.");
    }

    public static void createDocumentsFromAllSubmissions() {
        logger.info("I will now recreate document records from all submissions.");
        DSLContext context = Database.getContext();
        Result<SubmissionsRecord> submissions = context.selectFrom(Tables.SUBMISSIONS).where(Tables.SUBMISSIONS.STATUS.notEqual("deleted")).fetch();
        for(SubmissionsRecord record : submissions) {

            Operations.createDatabaseDocumentsFromSubmissionRecord(record);
        }
        logger.info("Document records created.");
    }

    public static void destroyAllSimilarities() {
        logger.info("I will destroy all similarities.");
        DSLContext context = Database.getContext();
        context.delete(Tables.SIMILARITIES).execute();
        logger.info("All similarities destroyed and removed from the database.");
    }

    public static void destroyAllDocuments() {
        logger.info("I will destroy all documents.");
        DSLContext context = Database.getContext();
         context.delete(Tables.DOCUMENTS).execute();
        logger.info("All documents destroyed and removed from the database..");
    }
}
