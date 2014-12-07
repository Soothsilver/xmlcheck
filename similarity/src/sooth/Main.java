package sooth;

import sooth.scripts.BatchActions;

public class Main {
    public static void main(String[] args) {
        /*
        SubmissionsByPlugin submissionsByPlugin = Database.runSubmissionsByPluginQueryOnAllIdentifiers();
        int len = 0;
        int count = 0;

        for (Submission submission : submissionsByPlugin.get(Problems.HW1_DTD)) {
            for (Document document : submission.getDocuments()) {
                if (document.getType() == Document.DocumentType.PRIMARY_XML_FILE) {
                    len += document.getText().length();
                    count++;
                    System.out.println("SIZE: " + document.getText().length());
                }
            }
        }
        System.out.println("AVERAGE: " + (len / count));
        */
        BatchActions.runPlagiarismCheckingOnEntireDatabase();
    }
}

