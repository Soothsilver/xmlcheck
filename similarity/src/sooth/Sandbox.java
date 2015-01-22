package sooth;


import org.ini4j.Wini;
import sooth.scripts.BatchActions;

import java.io.File;
import java.io.IOException;

/**
 * This class serves no purpose.
 * It is used strictly for debugging purposes if a developer wants to quickly try to run a similarity module function.
 */
public class Sandbox {
    /**
     * The developer may test stuff here.
     * @param args Command-line arguments.
     */
    @SuppressWarnings("EmptyMethod")
    public static void main(String[] args) throws IOException {
        Configuration.loadFromConfigIni(new Wini(new File("config.ini")));
        BatchActions.extractAndAnalyzeNewSubmissionsIfPossible();
        /*
        BatchActions.extractAndAnalyzeNewSubmissionsIfPossible();
        */
    }
}

