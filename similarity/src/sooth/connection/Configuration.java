package sooth.connection;

import sooth.FilesystemUtils;

import java.nio.file.Path;
import java.nio.file.Paths;

public class Configuration {
    private static String submissionsFolder = "C:\\Apps\\UwAmp\\www\\xmlcheck\\www\\files\\submissions";
    public static Path getSubmissionInputPath(String submissionfile) {
        return Paths.get(submissionsFolder, submissionfile);
    }
}
