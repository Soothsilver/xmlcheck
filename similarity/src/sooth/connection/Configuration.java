package sooth.connection;

import java.nio.file.Path;
import java.nio.file.Paths;

public class Configuration {

    private static boolean ignoreSelfPlagiarism = true;
    private static String submissionsFolder = "C:\\Apps\\UwAmp\\www\\xmlcheck\\www\\files\\submissions";

    public static Path getSubmissionInputPath(String submissionfile) {
        return Paths.get(submissionsFolder, submissionfile);
    }

    public static boolean ignoringSelfPlagiarism() {
        return ignoreSelfPlagiarism;
    }
}
