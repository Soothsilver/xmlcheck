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

import javax.xml.crypto.Data;
import java.util.List;
import java.util.logging.Logger;

public class BatchActions {
    private static Logger logger = Logging.getLogger(BatchActions.class.getName());
    /**
     * Deletes all documents and similarities detected, recreates all documents, and then runs similarity checking on everything.
     * This method will take a great amount of time to run.
     */
    public static void recheckEntireDatabase() {
        logger.info("I will now recheck the entire database for plagiarism.");
        BatchActions.destroyAllDocuments();
        BatchActions.createDocumentsFromAllSubmissions();
        BatchActions.destroyAllSimilarities();
      //  BatchActions.runPlagiarismCheckingOnEntireDatabase();
        logger.info("The entire database has been fully checked for plagiarism.");
    }

    private static void createDocumentsFromAllSubmissions() {
        DSLContext context = Database.getContext();
        Result<SubmissionsRecord> submissions = context.selectFrom(Tables.SUBMISSIONS).where(Tables.SUBMISSIONS.STATUS.notEqual("deleted")).fetch();
        for(SubmissionsRecord record : submissions) {

            Operations.createDatabaseDocumentsFromSubmissionRecord(record);
        }
    }

    private static void destroyAllSimilarities() {
        DSLContext context = Database.getContext();
        context.delete(Tables.SIMILARITIES).execute();
        logger.info("All similarities destroyed and removed from the database.");
    }

    private static void destroyAllDocuments() {
        DSLContext context = Database.getContext();
         context.delete(Tables.DOCUMENTS).execute();
        logger.info("All documents destroyed and removed from the database..");
    }
}
