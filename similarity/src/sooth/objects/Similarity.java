package sooth.objects;

public class Similarity {
    private int score;
    private String details;
    private int oldSubmissionId;
    private int newSubmissionId;

    public int getScore() {
        return score;
    }

    public void setScore(int score) {
        this.score = score;
    }

    public String getDetails() {
        return details;
    }

    public void setDetails(String details) {
        this.details = details;
    }

    public int getOldSubmissionId() {
        return oldSubmissionId;
    }

    public void setOldSubmissionId(int oldSubmissionId) {
        this.oldSubmissionId = oldSubmissionId;
    }

    public int getNewSubmissionId() {
        return newSubmissionId;
    }

    public void setNewSubmissionId(int newSubmissionId) {
        this.newSubmissionId = newSubmissionId;
    }

    public Similarity(int score, String details, int oldSubmissionId, int newSubmissionId) {
        this.score = score;
        this.details = details;
        this.oldSubmissionId = oldSubmissionId;
        this.newSubmissionId = newSubmissionId;
    }
}
