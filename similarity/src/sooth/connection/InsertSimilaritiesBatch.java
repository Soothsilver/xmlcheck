package sooth.connection;

import org.jooq.DSLContext;
import org.jooq.InsertValuesStep4;
import sooth.Logging;
import sooth.entities.Tables;
import sooth.entities.tables.records.SimilaritiesRecord;
import sooth.objects.Similarity;

import java.util.logging.Logger;

public class InsertSimilaritiesBatch {
    private Logger logger = Logging.getLogger(InsertSimilaritiesBatch.class.getName());
    private InsertValuesStep4<SimilaritiesRecord, Integer, Integer, Integer, String> insertQuery;
    private int boundQueries = 0;
    private final int batchSize = 10000; // may not be optimal number, but definitely better than 1 (too many connections to database) and infinity (running out of memory)

    public void add(Similarity similarity) {
        if (insertQuery == null) {
            DSLContext context = Database.getContext();
            insertQuery = context.insertInto(Tables.SIMILARITIES, Tables.SIMILARITIES.OLDSUBMISSIONID, Tables.SIMILARITIES.NEWSUBMISSIONID, Tables.SIMILARITIES.SCORE, Tables.SIMILARITIES.DETAILS).values(similarity.getOldSubmissionId(), similarity.getNewSubmissionId(), similarity.getScore(), similarity.getDetails());
        }
        else {
            insertQuery = insertQuery.values(similarity.getOldSubmissionId(), similarity.getNewSubmissionId(), similarity.getScore(), similarity.getDetails());
        }
        boundQueries++;
        if (boundQueries == batchSize) {
            logger.info("Too many insert commands in the batch. Executing...");
            execute();
            logger.fine("Executed.");
        }
    }
    public void execute() {
        insertQuery.execute();
        boundQueries = 0;
        insertQuery = null;
    }
}
