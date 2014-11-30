package sooth;

import org.jooq.DSLContext;
import sooth.connection.Database;
import sooth.connection.InsertSimilaritiesBatch;
import sooth.entities.Tables;
import sooth.entities.tables.records.PluginsRecord;
import sooth.entities.tables.records.SubmissionsRecord;
import sooth.objects.Similarity;
import sooth.objects.Submission;
import sooth.objects.SubmissionsByPlugin;
import sooth.scripts.BatchActions;
import sooth.scripts.Operations;

import java.util.List;

public class EntryPoint {
    private static final String ACTION_HELP = "help";
    private static final String ACTION_RELOAD_ALL_DOCUMENTS = "reloadalldocuments";
    private static final String ACTION_RECHECK_ENTIRE_DATABASE = "recheckall";
    private static final String ACTION_LOAD_AND_CHECK_ARGUMENT = "makeone";
    private static final String ACTION_COMPARE_TWO_DIRECTLY = "compare";

    private static final String ERROR_NOT_ENOUGH_ARGUMENTS = "You did not supply enough arguments for this action.";
    private static final String ERROR_MUST_BE_INTEGER = "The argument must be an integer.";
    private static final String ERROR_SUBMISSION_DOES_NOT_EXIST = "The specified submission does not exist.";

    public static void main(String[] args) {
        if (args.length == 0) {
            printHelp();
            return;
        }
        String action = args[0];
        switch (action.toLowerCase()) {
            case ACTION_HELP:
                printHelp();
                return;
            case ACTION_RELOAD_ALL_DOCUMENTS:
                BatchActions.createDocumentsFromAllSubmissions();;
                return;
            case ACTION_RECHECK_ENTIRE_DATABASE:
                BatchActions.runPlagiarismCheckingOnEntireDatabase();;
                return;
            case ACTION_LOAD_AND_CHECK_ARGUMENT:
                if (args.length < 2) {
                    System.out.println(ERROR_NOT_ENOUGH_ARGUMENTS);
                    System.exit(1);
                    return;
                }
                int argumentId;
                try {
                    argumentId = Integer.parseInt(args[1]);
                }
                catch (NumberFormatException exception) {
                    System.out.println(ERROR_MUST_BE_INTEGER);
                    System.exit(1);
                    return;
                }
                DSLContext context = Database.getContext();
                SubmissionsRecord thisSubmission = context.selectFrom(Tables.SUBMISSIONS).where(Tables.SUBMISSIONS.ID.equal(argumentId)).fetchOne();
                if (thisSubmission == null) {
                    System.out.println(ERROR_SUBMISSION_DOES_NOT_EXIST);
                    System.exit(1);
                    return;
                }
                Operations.createDatabaseDocumentsFromSubmissionRecord(thisSubmission);
                PluginsRecord plugin = Operations.getPluginsRecordFromSubmissionsRecord(thisSubmission);
                if (plugin == null) {
                    System.out.println("This submission is not associated with a plugin.");
                    System.exit(1);
                    return;
                }
                SubmissionsByPlugin submissionsByPlugin = Database.runSubmissionsByPluginQueryOnThisIdentifier(plugin.getIdentifier());
                List<Submission> submissions = submissionsByPlugin.get(plugin.getIdentifier());
                int thisOrderId = -1;
                for (int i = 0; i < submissions.size(); i++) {
                    if (submissions.get(i).getSubmissionId() == thisSubmission.getId()) {
                        thisOrderId = i;
                        break;
                    }
                }
                InsertSimilaritiesBatch batch = new InsertSimilaritiesBatch();
                List<Similarity> similarities = Operations.compareToAll(submissions.get(thisOrderId), submissions, 0, thisOrderId);
                for (Similarity similarity : similarities) {
                    if (similarity.getScore() >= Similarity.MINIMUM_INTERESTING_SCORE) {
                        batch.add(similarity);
                    }
                }
                batch.execute();
                return;
            case ACTION_COMPARE_TWO_DIRECTLY:
                int submissionOne;
                int submissionTwo;
                try {
                    submissionOne = Integer.parseInt(args[1]);
                    submissionTwo = Integer.parseInt(args[2]);
                }
                catch (NumberFormatException exception) {
                    System.out.println(ERROR_MUST_BE_INTEGER);
                    System.exit(1);
                    return;
                }
                System.out.println("TODO: Not yet implemented.");
                System.exit(1);
                return;
            default:
                System.out.println("Argument 1 (action) not recognized.");
                printHelp();
                System.exit(1);
                return;
        }
        /*
            arguments are:
            1. action to be performed
             makeAll: delete all old similarity data, then create it anew (from source ZIP files)
             deleteAll: delete all old similarity data in database
             recheckAll: perform all comparisons from database again (but do not reload ZIP files)
             makeOne [id]: delete similarity data relating to submission [id], then reload it from ZIP files and check its similarity
             compare [id1] [id2]: do a direct comparison between two submissions
            2,3. parameters of this action
         */
    }

    private static void printHelp() {
        String help;
        help = "sooth.similarity: XML Check module checking for plagiarism\n";
        help += "This program must be located inside the core/ folder of the system.\n";
        help += "Usage: java -jar similarity.jar [action] [arguments, if any]\n\n";
        help += "Actions: \n";
        help += ACTION_HELP + ": Print this message.\n";
        help += ACTION_RELOAD_ALL_DOCUMENTS + ": Delete all documents from database and reload them anew from files.\n";
        help += ACTION_RECHECK_ENTIRE_DATABASE + ": Delete all similarity records from database and recalculate them anew from documents in the database.\n";
        help += ACTION_COMPARE_TWO_DIRECTLY + " [id1] [id2]: Run similarity checking on the two specified submissions in the database.\n";
        help += ACTION_LOAD_AND_CHECK_ARGUMENT + " [id1]: Extract documents for the specified submission and run similarity checking for this submission only.";
        System.out.println(help);
    }
}
