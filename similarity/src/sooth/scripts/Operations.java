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

import javax.xml.crypto.Data;
import java.nio.file.Path;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Logger;

public class Operations {
    private static Logger logger = Logging.getLogger(Operations.class.getName());
    private static int SimilarityThreshold = 0;

    public static List<Similarity> compareToAll(Submission newSubmission, List<Submission> submissions, int checkFrom, int checkUpToExclusive) {
        ArrayList<Similarity> similarities = new ArrayList<>();
        for (int i = checkFrom; i < checkUpToExclusive; i++) {
            Similarity similarity = Operations.compare(submissions.get(i), newSubmission);
            if (similarity.getScore() > SimilarityThreshold) {
                similarities.add(similarity);
            }
        }
        return similarities;
    }

    private static Similarity compare(Submission oldSubmission, Submission newSubmission) {
        switch (oldSubmission.)
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
        logger.info("Submission '" + submission.getId() + "' generated " + documents.size() + " documents.");
        DSLContext context = Database.getContext();
        for(Document document : documents) {
            context.insertInto(Tables.DOCUMENTS, Tables.DOCUMENTS.TEXT,Tables.DOCUMENTS.NAME, Tables.DOCUMENTS.TYPE, Tables.DOCUMENTS.SUBMISSIONID)
                    .values(document.getText(), document.getName(), document.getType().getMysqlIdentifier(), submission.getId())
                    .execute();
            logger.info("Document named '" + document.getName() + "' for submission '" + submission.getId() + "' was inserted into the database.");
        }
    }

    public static void addToDatabase(Similarity similarity) {
        DSLContext context = Database.getContext();
        context.insertInto(Tables.SIMILARITIES, Tables.SIMILARITIES.OLDSUBMISSIONID, Tables.SIMILARITIES.NEWSUBMISSIONID, Tables.SIMILARITIES.SCORE, Tables.SIMILARITIES.DETAILS)
                .values(similarity.getOldSubmissionId(), similarity.getNewSubmissionId(), similarity.getScore(), similarity.getDetails())
                .execute();
    }
}
