package sooth.scripts;

import org.jooq.DSLContext;
import sooth.connection.Database;
import sooth.entities.Tables;

import java.util.logging.Logger;

public class BatchActions {
    private static Logger logger = Logger.getLogger(BatchActions.class.getName());
    /**
     * Deletes all documents and similarities detected, recreates all documents, and then runs similarity checking on everything.
     * This method will take a great amount of time to run.
     */
    public static void recheckEntireDatabase() {
        logger.info("I will now recheck the entire database for plagiarism.");
        BatchActions.destroyAllDocuments();
      //  BatchActions.createDocumentsFromAllSubmissions();
      //  BatchActions.destroyAllSimilarities();
      //  BatchActions.runPlagiarismCheckingOnEntireDatabase();
        logger.info("The entire database has been checked for plagiarism.");
    }

    private static void destroyAllDocuments() {
        DSLContext context = Database.getContext();
        context.delete(Tables.DOCUMENTS)
                .execute();
        logger.info("All documents destroyed.");
    }
}
