package sooth.objects;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class Submission {
    private List<Document> documents = new ArrayList<>();
    private int submissionId = -1;
    private int userId = -1;
    private Date uploadTime = null;
    private String pluginIdentifier;

    public List<Document> getDocuments() {
        return documents;
    }

    public int getSubmissionId() {
        return submissionId;
    }

    public int getUserId() {
        return userId;
    }

    public Date getUploadTime() {
        return uploadTime;
    }

    public String getPluginIdentifier() {
        return pluginIdentifier;
    }

    public Submission(List<Document> documents, int submissionId, int userId, Date uploadTime, String pluginIdentifier) {
        this.documents = documents;
        this.submissionId = submissionId;
        this.userId = userId;
        this.uploadTime = uploadTime;
        this.pluginIdentifier = pluginIdentifier;
    }
}
