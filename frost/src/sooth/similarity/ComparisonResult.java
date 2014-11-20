package sooth.similarity;

public class ComparisonResult {
    private float similarityScore;
    private String details;

    public ComparisonResult(float similarityScore, String details)
    {
        this.similarityScore = similarityScore;
        this.details = details;
    }

    public float getSimilarityScore() {
        return similarityScore;
    }

    public void setSimilarityScore(float similarityScore) {
        this.similarityScore = similarityScore;
    }

    public String getDetails() {
        return details;
    }

    public void setDetails(String details) {
        this.details = details;
    }
}
