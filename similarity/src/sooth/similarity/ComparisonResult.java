package sooth.similarity;

public class ComparisonResult {
    private int similarity;
    private String details;
    private boolean suspicious;

    public boolean isSuspicious() {
        return suspicious;
    }

    public ComparisonResult(int similarity, String details, boolean suspicious) {
        this.similarity = similarity;
        this.details = details;
        this.suspicious = suspicious;
    }

    public int getSimilarity() {
        return similarity;
    }

    public void setSimilarity(int similarity) {
        this.similarity = similarity;
    }

    public String getDetails() {
        return details;
    }

    public void setDetails(String details) {
        this.details = details;
    }
}
