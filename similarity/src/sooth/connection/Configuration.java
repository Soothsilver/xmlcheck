package sooth.connection;

import java.nio.file.Path;
import java.nio.file.Paths;

/**
 * Contains configuration information and information about filesystem paths.
 */
public class Configuration {

    /**
     * Indicates whether a similarity should be ignored if both submissions were submitted by the same student.
     */
    private static final boolean ignoreSelfPlagiarism = true;
    private static final String submissionsFolder = "C:\\Apps\\EasyPHP\\data\\localweb\\xmlcheck\\www\\files\\submissions";

    /**
     * Returns the absolute path to the specified submission.
     * @param submissionFile Path to the submission relative to the submission folder (exactly as it is in the database).
     * @return The absolute path to the specified submission.
     */
    public static Path getSubmissionInputPath(String submissionFile) {
        return Paths.get(submissionsFolder, submissionFile);
    }

    /**
     * Returns a value that indicates whether a similarity should be ignored if both submissions were submitted by the same student.
     * @return A value that indicates whether a similarity should be ignored if both submissions were submitted by the same student.
     */
    public static boolean ignoringSelfPlagiarism() {
        return ignoreSelfPlagiarism;
    }
}
