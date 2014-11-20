package sooth.similarity;

public class TextIdentityTest implements ITextSimilarityTest {
    @Override
    public ComparisonResult compare(String oldDocument, String newDocument) {
        if (oldDocument.length() != newDocument.length())
        {
            return new ComparisonResult(0, "The documents don't have the same length.");
        }
        int length = oldDocument.length();
        for (int i = 0; i < length; i++)
        {
            if (oldDocument.charAt(i) != newDocument.charAt(i))
            {
                return new ComparisonResult(0, "At position " + i + ", the old document has the character '" + oldDocument.charAt(i) + "' while the new document has the character '" + newDocument.charAt(i) + "' at that position.");
            }
        }
        return new ComparisonResult(1, "These two documents are identical.");
    }
}
