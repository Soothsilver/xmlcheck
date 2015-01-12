package sooth;

import com.sun.corba.se.impl.copyobject.FallbackObjectCopierImpl;
import org.ini4j.Profile;
import org.ini4j.Wini;
import sun.swing.SwingUtilities2;

import java.io.File;
import java.io.IOException;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Objects;

/**
 * Contains configuration information and information about filesystem paths.
 */
public class Configuration {

    /**
     * Parses a string as an integer or returns the default value if the parsing fails.
     * Source: http://stackoverflow.com/a/1486521/1580088
     * @param number The string to parse.
     * @param defaultValue The integer to return in case parsing fails.
     * @return Integer created by parsing the string, or the default value.
     */
    private static int parseIntegerWithDefault(String number, int defaultValue) {
        try {
            return Integer.parseInt(number);
        } catch (NumberFormatException e) {
            return defaultValue;
        }
    }

    public static void loadFromConfigIni(Wini configurationFile)
    {
        // MySQL credentials
        Profile.Section sectionMySQL = configurationFile.get("database");
        dbHostname = clearQuotes(sectionMySQL.get("host").trim());
        dbUser = clearQuotes(sectionMySQL.get("user").trim());
        dbPassword = clearQuotes(sectionMySQL.get("pass").trim());
        dbDatabaseName = clearQuotes(sectionMySQL.get("db").trim());

        // Submissions folder
        submissionsFolder = System.getProperty("user.dir") + File.separator + ".." + File.separator + "files" + File.separator + "submissions";

        // Similarity settings
        Profile.Section section = configurationFile.get("similarity");
        String enableSimilarityCheckingValue = section.get("enableSimilarityChecking").trim();
        String enableZhangShashaValue = section.get("enableZhangShasha").trim();
        String zhangShashaMasterThresholdValue = section.get("zhangShashaMasterThreshold").trim();
        String levenshteinMasterThresholdValue = section.get("levenshteinMasterThreshold").trim();
        String zhangShashaSuspicionThresholdValue = section.get("zhangShashaSuspicionThreshold").trim();
        String levenshteinSuspicionThresholdValue = section.get("levenshteinSuspicionThreshold").trim();

        if (enableSimilarityCheckingValue != null)
        {
            if (Objects.equals(enableSimilarityCheckingValue.toLowerCase(), "true")) {
                enableSimilarityChecking = true;
            } else {
                enableSimilarityChecking = false;
            }
        }
        if (enableZhangShashaValue != null)
        {
            if (Objects.equals(enableZhangShashaValue.toLowerCase(), "true")) {
                preprocessZhangShashaTrees = true;
            } else {
                preprocessZhangShashaTrees = false;
            }
        }
        if (zhangShashaMasterThresholdValue != null) {
            zhangShashaMasterThreshold = parseIntegerWithDefault(zhangShashaMasterThresholdValue, zhangShashaMasterThreshold);
        }
        if (levenshteinMasterThresholdValue != null) {
            levenshteinMasterThreshold = parseIntegerWithDefault(levenshteinMasterThresholdValue, levenshteinMasterThreshold);
        }
        if (zhangShashaSuspicionThresholdValue != null) {
            zhangShashaSuspicionThreshold = parseIntegerWithDefault(zhangShashaSuspicionThresholdValue, zhangShashaSuspicionThreshold);
        }
        if (levenshteinSuspicionThresholdValue != null) {
            levenshteinSuspicionThreshold = parseIntegerWithDefault(levenshteinSuspicionThresholdValue, levenshteinSuspicionThreshold);
        }
        /*
        Example of the appropriate section in the INI file.
        [similarity]
        enableSimilarityChecking = true
        enableZhangShasha = true
        zhangShashaMasterThreshold = 70
        levenshteinMasterThreshold = 60
        zhangShashaSuspicionThreshold = 90
        levenshteinSuspicionThreshold = 80
        */
    }

    private static String clearQuotes(String iniValue) {
        iniValue = iniValue.trim();
        if (iniValue.charAt(0) == '"' && iniValue.charAt(iniValue.length() - 1) == '"') {
            iniValue = iniValue.substring(1, iniValue.length() - 1);
        }
        return iniValue;
    }

    /**
     * Indicates whether a similarity should be ignored if both submissions were submitted by the same student.
     */
    private static final boolean ignoreSelfPlagiarism = true;

    /**
     * Indicates whether Zhang-Shasha post-order tree representations should be generated from XML files during preprocessing.
     */
    public static boolean preprocessZhangShashaTrees = true;
    public static boolean enableSimilarityChecking = true;
    public static int zhangShashaMasterThreshold = 0;
    public static int levenshteinMasterThreshold = 0;
    public static int zhangShashaSuspicionThreshold = 90;
    public static int levenshteinSuspicionThreshold = 80;

    public static String dbHostname = "";
    public static String dbUser = "";
    public static String dbPassword = "";
    public static String dbDatabaseName = "";



    private static String submissionsFolder = "C:\\Apps\\UwAmp\\www\\xmlcheck\\www\\files\\submissions";


    /**
     * Sets the folder where submission ZIP files are located. This folder is then used by the similarity module to locate
     * files to extract into documents.
     * @param submissionsFolder Path to the submissions folder, without the trailing slash.
     */
    public static void setSubmissionsFolder(String submissionsFolder) {
        Configuration.submissionsFolder = submissionsFolder;
    }


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
