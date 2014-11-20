package sooth.similarity;

public interface ITextSimilarityTest {
    ComparisonResult compare(String oldDocument, String newDocument);
}
