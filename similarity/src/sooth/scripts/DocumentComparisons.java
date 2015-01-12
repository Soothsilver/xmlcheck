package sooth.scripts;

import sooth.Configuration;
import sooth.objects.Document;
import sooth.similarity.DocumentComparisonResult;
import sooth.similarity.*;

public class DocumentComparisons {
    private static final int LEVENSHTEIN_MAXIMUM_DOCUMENT_SIZE = 50000;
    private static final int GREEDY_MAXIMUM_DOCUMENT_SIZE = 2000;

    private static final int OBVIOUS_SIZE_DIFFERENCE = 2000;
    private static GreedyStringTilingAlgorithm greedyStringTilingAlgorithm = new GreedyStringTilingAlgorithm();

    public static DocumentComparisonResult zhangShashaCompare(Document oldDocument, Document newDocument, String pluginIdentifier)
    {
        Document.DocumentType type = oldDocument.getType();
        ZhangShashaTree oldDocumentTree = oldDocument.getZhangShashaTree();
        ZhangShashaTree newDocumentTree = newDocument.getZhangShashaTree();

        switch (type) {
            // These are not tested because they are too small to test meaningfully.
            // case XQUERY_ADDITIONAL_XML_FILE:
            // case XQUERY_QUERY:
            // case XPATH_QUERY:

            // These are not tested because they are not XML files:
            // case DTD_FILE:
            // case JAVA_DOM_TRANSFORMER:
            // case JAVA_SAX_HANDLER:

            // Traditional XML files:
            case PRIMARY_XML_FILE:
            case XSLT_SCRIPT:
            case XSD_SCHEMA:
                // Use defaults.
                break;
            default:
                return new DocumentComparisonResult(0, "Documents of this type are not compared automatically by the Zhang-Shasha comparison algorithm.", false);
        }

        int distance = ZhangShashaAlgorithm.getInstance().compare(oldDocumentTree, newDocumentTree);
        int score = 100 - (100 * distance) / (oldDocumentTree.getNodeCount() * ZhangShashaAlgorithm.DELETION_COST + newDocumentTree.getNodeCount() * ZhangShashaAlgorithm.INSERTION_COST);

        return new DocumentComparisonResult(score,
                "The tree edit distance is " + distance + ". The first tree has " + oldDocumentTree.getNodeCount() + " nodes. The second tree has " + newDocumentTree.getNodeCount() + ".",
                score >= Configuration.zhangShashaSuspicionThreshold);

    }
    public static DocumentComparisonResult greedyStringTilingCompare(Document oldDocument, Document newDocument, String pluginIdentifier)
    {
        Document.DocumentType type = oldDocument.getType();
        String oldDocumentText = oldDocument.getPreprocessedText();
        String newDocumentText = newDocument.getPreprocessedText();
        float weight = 1;

        switch (type) {

            // These are not tested because they are too small to test meaningfully.
            // case DTD_FILE:
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
                return new DocumentComparisonResult(0, "Documents of this type are not compared automatically by the Greedy-String-Tiling algorithm.", false);
        }

        // Obvious size mismatch
        if (Math.abs(oldDocumentText.length() - newDocumentText.length()) > OBVIOUS_SIZE_DIFFERENCE)
        {
            return new DocumentComparisonResult(0, "One document has at least " + OBVIOUS_SIZE_DIFFERENCE + " more characters than the other one. It is unlikely they were copied from each other. Skipping the entire plagiarism check.", false);
        }
        int similarity = 0;

        // Greedy-String-Tiling comparison, if the document is small enough
        if ((oldDocumentText.length() < GREEDY_MAXIMUM_DOCUMENT_SIZE) && (newDocumentText.length() < GREEDY_MAXIMUM_DOCUMENT_SIZE)) {
            int matchedCharacters = greedyStringTilingAlgorithm.compare(oldDocumentText, newDocumentText);

            int score = (100 * 2 * matchedCharacters) / (oldDocumentText.length() + newDocumentText.length());

            return new DocumentComparisonResult((int)(score * weight), "The number of matched character is " + matchedCharacters + ". The document sizes are " + oldDocumentText.length() + " and " + newDocumentText.length() + ".",
                    false);

        } else {
            similarity = Math.max(similarity, 0);
            return new DocumentComparisonResult(similarity, "The Greedy-String-Tiling test was not performed because the size of one of the documents is too large.", false);
        }
    }
    public static DocumentComparisonResult levenshteinCompare(Document oldDocument, Document newDocument, String pluginIdentifier)
    {
        Document.DocumentType type = oldDocument.getType();
        String oldDocumentText = oldDocument.getPreprocessedText();
        String newDocumentText = newDocument.getPreprocessedText();
        float weight = 1;

        switch (type) {
                // These are not tested because they are too small to test meaningfully.
                // case XQUERY_ADDITIONAL_XML_FILE:
                // case XQUERY_QUERY:
                // case XPATH_QUERY:
                // case DTD_FILE:

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
                return new DocumentComparisonResult(0, "Documents of this type are not compared automatically by Levenshtein distance.", false);
        }

                // Obvious size mismatch
                if (Math.abs(oldDocumentText.length() - newDocumentText.length()) > OBVIOUS_SIZE_DIFFERENCE)
                {
                    return new DocumentComparisonResult(0, "One document has at least " + OBVIOUS_SIZE_DIFFERENCE + " more characters than the other one. It is unlikely they were copied from each other. Skipping the entire plagiarism check.", false);
                }
                int similarity = 0;

                // Levenshtein comparison, if the document is small enough
                if ((oldDocumentText.length() < LEVENSHTEIN_MAXIMUM_DOCUMENT_SIZE) && (newDocumentText.length() < LEVENSHTEIN_MAXIMUM_DOCUMENT_SIZE)) {
                    int distance = LevenshteinDistanceAlgorithm.getInstance().compare(oldDocumentText, newDocumentText);

                    int score = 100 - (100 * distance) / (Math.max(oldDocumentText.length(), newDocumentText.length()));

                    return new DocumentComparisonResult((int)(score * weight),
                            "The Levenshtein distance of the documents is " + distance + ". The bigger document length is " + (Math.max(oldDocumentText.length(), newDocumentText.length())) + ".",
                            score >= Configuration.levenshteinSuspicionThreshold);

                } else {
                    similarity = Math.max(similarity, 0);
                    return new DocumentComparisonResult(similarity,
                            "The Levenshtein test was not performed because the size of one of the documents is too large.",
                            false);
                }
}
        }
