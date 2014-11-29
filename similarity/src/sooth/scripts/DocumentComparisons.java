package sooth.scripts;

import sooth.objects.Document;
import sooth.similarity.ComparisonResult;
import sooth.similarity.*;

public class DocumentComparisons {
    public static ComparisonResult compare(Document oldDocument, Document newDocument, String pluginIdentifier)
    {
        Document.DocumentType type = oldDocument.getType();
        switch (type) {
            case PRIMARY_XML_FILE:
                // Identity comparison
                if (TextIdentityTest.compare(oldDocument.getText(), newDocument.getText()))
                {
                    return new ComparisonResult(100, "The documents are identical, character-by-character.", true);
                }
                // Levenshtein comparison
                /*
                int distance = LevenshteinDistanceIgnoreWhitespaceTest.compare(oldDocument.getText(), newDocument.getText());
                if (distance < 80)
                {
                    return new ComparisonResult(100 - distance, "The two XML documents are separated by a Levenshtein distance of merely " + distance + ". It seems very unlikely for this to be a coincidence.", true);
                }*/
                return new ComparisonResult(0, "No significant similarity has been detected.", false);
            default:
                return new ComparisonResult(0, "This document type is unknown.", false);
        }
    }
}
