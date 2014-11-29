package sooth.scripts;

import sooth.objects.Document;
import sooth.similarity.ComparisonResult;
import sooth.similarity.*;

public class DocumentComparisons {
    private static final int LEVENSHTEIN_MAX_DOCUMENT_SIZE = 4000;
    private static final int OBVIOUS_SIZE_DIFFERENCE = 2000;
    public static ComparisonResult compare(Document oldDocument, Document newDocument, String pluginIdentifier)
    {
        Document.DocumentType type = oldDocument.getType();
        switch (type) {
            case PRIMARY_XML_FILE:

                // Obvious size mismatch
                if (Math.abs(oldDocument.getText().length() - newDocument.getText().length()) > OBVIOUS_SIZE_DIFFERENCE)
                {
                    // TODO should compare whitespaceless documents
                    return new ComparisonResult(0, "One document has at least " + OBVIOUS_SIZE_DIFFERENCE + " more characters than the other one. It is unlikely they were copied from each other. Skipping the entire plagiarism check.", false);
                }

                // Identity comparison
                if (TextIdentityTest.compare(oldDocument.getText(), newDocument.getText()))
                {
                    return new ComparisonResult(100, "The documents are identical, character-by-character.", true);
                }
                int similarity = 0;
                String details = "";


                // Levenshtein comparison, if the document is small enough
                if (oldDocument.getText().length() < LEVENSHTEIN_MAX_DOCUMENT_SIZE && newDocument.getText().length() < LEVENSHTEIN_MAX_DOCUMENT_SIZE) {
                    int distance = LevenshteinDistanceIgnoreWhitespaceTest.compare(oldDocument.getText(), newDocument.getText());
                    if (distance < 98) {
                        return new ComparisonResult(100 - distance, "The two XML documents are separated by a Levenshtein distance of merely " + distance + ". It seems very unlikely for this to be a coincidence.", true);
                    }
                    else {
                        details += "Levenshtein test ran, but did not conclude that plagiarism occurred.\n";
                    }
                } else {
                    similarity = Math.max(similarity, 2);
                    details += "Levenshtein test is skipped because the documents are too large.\n";
                }
                details += "Based on this information, it seems unlikely that plagiarism occurred.";
                return new ComparisonResult(similarity, details, false);
            default:
                return new ComparisonResult(0, "This document type is unknown.", false);
        }
    }
}
