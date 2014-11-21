package sooth.similarity;

public class TextIdentityTest {
    public static boolean compare(String oldDocument, String newDocument) {
        if (oldDocument.length() != newDocument.length())
        {
            return false;
        }
        int length = oldDocument.length();
        for (int i = 0; i < length; i++)
        {
            if (oldDocument.charAt(i) != newDocument.charAt(i))
            {
                return false;
            }
        }
        return true;
    }
}
