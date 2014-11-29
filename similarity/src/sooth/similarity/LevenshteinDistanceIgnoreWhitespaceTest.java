package sooth.similarity;

public class LevenshteinDistanceIgnoreWhitespaceTest {
    // so far, this code is copied from wikipedia; rewrite later
    public static int compare(String oldDocument, String newDocument)
    {
        oldDocument = removeWhitespace(oldDocument);
        newDocument = removeWhitespace(newDocument);

        return LevenshteinDistanceTest.compare(oldDocument, newDocument);
    }

    private static String removeWhitespace(String oldDocument) {
        return oldDocument.replace(" ", "");
        /*
        StringBuilder builder = new StringBuilder(oldDocument.length() / 2);
        for (int i = 0; i < oldDocument.length(); i++)
        {
            if (oldDocument.charAt(i) == ' ' || oldDocument.charAt(i) == '\t') {
                continue;
            }
            builder.append(oldDocument.charAt(i));
        }
        return builder.toString();
        */
    }
}
