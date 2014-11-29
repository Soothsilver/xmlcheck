package sooth.objects;

public class Similarity {
    /**
     * Similarities with score lesser than this value are definitely not plagiates and therefore don't need to be
     * inserted into the database.
     */
    public static final int MINIMUM_INTERESTING_SCORE = 20;
    private int score;
    private String details;
    private int oldSubmissionId;
    private int newSubmissionId;

    public void setSuspicious(boolean suspicious) {
        this.suspicious = suspicious;
    }

    private boolean suspicious;

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

    public Similarity(int score, String details, int oldSubmissionId, int newSubmissionId, boolean suspicious) {
        this.score = score;
        this.details = details;
        this.oldSubmissionId = oldSubmissionId;
        this.newSubmissionId = newSubmissionId;
        this.suspicious = suspicious;
    }

    public boolean isSuspicious() {
        return suspicious;
    }
}
