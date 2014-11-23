package sooth.similarity;

public class ComparisonResult {
    private float similarityPercentage;
    private String details;

    public ComparisonResult(float similarityPercentage, String details)
    {
        this.similarityPercentage = similarityPercentage;
        this.details = details;
    }

    public float getSimilarityPercentage() {
        return similarityPercentage;
    }

    public void setSimilarityPercentage(float similarityPercentage) {
        this.similarityPercentage = similarityPercentage;
    }

    public String getDetails() {
        return details;
    }

    public void setDetails(String details) {
        this.details = details;
    }
}
