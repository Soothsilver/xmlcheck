package sooth;


import sooth.scripts.BatchActions;

/**
 * This class serves no purpose.
 * It is used strictly for debugging purposes if a developer wants to quickly try to run a similarity module function.
 */
public class Sandbox {
    public static void main(String[] args)
    {
        /*
        String a = "Hello\n//comment\nHi";

        String b = Pattern.compile("//.*").matcher(a).replaceAll("REPLACEMENT");
        System.out.println(b);
        */
       BatchActions.runPlagiarismCheckingOnEntireDatabase();
    }
}

