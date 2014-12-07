package sooth.scripts;

import sooth.objects.Document;
import sooth.similarity.ComparisonResult;
import sooth.similarity.*;

public class DocumentComparisons {
    private static final int LEVENSHTEIN_MAX_DOCUMENT_SIZE = 10000;
    private static final int OBVIOUS_SIZE_DIFFERENCE = 2000;


    public static ComparisonResult levenshteinCompare(Document oldDocument, Document newDocument, String pluginIdentifier)
    {
        Document.DocumentType type = oldDocument.getType();
        String oldDocumentText = oldDocument.getTextWithFoldedWhitespace();
        String newDocumentText = newDocument.getTextWithFoldedWhitespace();
        int minimumScoreForSuspiciousness = 60;
        int maximumDistanceForAutomaticSuspicion = 98;
        float weight = 1;

        switch (type) {
            case DTD_FILE:
                weight = 0.3f; // DTD files are bound to be similar, because they use a lot of common parts (!ELEMENT, ...) and because they are smaller.
                break;

                // These are not tested because they are too small to test meaningfully.
                // case XQUERY_ADDITIONAL_XML_FILE:
                // case XQUERY_QUERY:
                // case XPATH_QUERY:

                // Traditional XML files:
            case PRIMARY_XML_FILE:
            case XSLT_SCRIPT:
            case XSD_SCHEMA:
                // Java scripts:
            case JAVA_DOM_TRANSFORMER:
            case JAVA_SAX_HANDLER:
                // Use defaults.
                break;
            default:
                return new ComparisonResult(0, "Documents of this type are not compared automatically by Levenshtein distance.", false);
        }

                // Obvious size mismatch
                if (Math.abs(oldDocumentText.length() - newDocumentText.length()) > OBVIOUS_SIZE_DIFFERENCE)
                {
                    return new ComparisonResult(0, "One document has at least " + OBVIOUS_SIZE_DIFFERENCE + " more characters than the other one. It is unlikely they were copied from each other. Skipping the entire plagiarism check.", false);
                }
                int similarity = 0;

                // Levenshtein comparison, if the document is small enough
                if ((oldDocumentText.length() < LEVENSHTEIN_MAX_DOCUMENT_SIZE) && (newDocumentText.length() < LEVENSHTEIN_MAX_DOCUMENT_SIZE)) {
                    int distance = LevenshteinDistanceTest.getInstance().compare(oldDocumentText, newDocumentText);

                    int score = 100 - (100 * distance) / (Math.max(oldDocumentText.length(), newDocumentText.length()));
                    if (distance < maximumDistanceForAutomaticSuspicion) {
                        return new ComparisonResult(score, "The two documents are separated by a Levenshtein distance of merely " + distance + ". It seems very unlikely for this to be a coincidence.", true);
                    }
                    else {
                        return new ComparisonResult((int)(score * weight), "The Levenshtein distance of the documents is " + distance + ". The actual unweighted similarity is " + score + "%.", score >= minimumScoreForSuspiciousness);
                    }
                } else {
                    similarity = Math.max(similarity, 2);
                    return new ComparisonResult(similarity, "The Levenshtein test was not performed because the size of one of the documents is too large.", false);
                }
    }
}
