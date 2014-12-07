package sooth.similarity;

/**
 * Determines whether two documents are identical, character-by-character.
 */
public class TextIdentityTest {
    /**
     * Checks whether the two documents are identical, character-by-character.
     * This was a simple test to verify basic functionality and is not actually used in the XML Check system.
     *
     *
     * Best case complexity: O(1)
     * Worst case complexity: O(n)
     *
     *
     * @param oldDocument Text of a document.
     * @param newDocument Text of the second document.
     * @return True, if the documents are identical. False otherwise.
     */
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
