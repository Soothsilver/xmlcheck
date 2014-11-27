package sooth.objects;
import sooth.connection.Database;
import sooth.entities.tables.records.DocumentsRecord;
import sooth.entities.tables.records.SubmissionsRecord;

import javax.xml.crypto.Data;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class Submission {
    public List<Document> documents = new ArrayList<>();
    public int DatabaseSubmissionsRecordId = -1;
    public int UserId = -1;
    public Date UploadTime = null;
    public String Identifier;

    public Submission(List<Document> documents, int databaseSubmissionsRecordId, int userId, Date uploadTime, String identifier) {
        this.documents = documents;
        DatabaseSubmissionsRecordId = databaseSubmissionsRecordId;
        UserId = userId;
        Identifier = identifier;
        UploadTime = uploadTime;
    }

    public static Submission createFromSubmissionsRecord(SubmissionsRecord record) {
        ArrayList<Document> documents = new ArrayList<>();
       for (DocumentsRecord documentsRecord : Database.allDocuments) {
           if (documentsRecord.getSubmissionid() == record.getId()) {
               documents.add(Document.createFromDocumentsRecord(documentsRecord));
           }
       }
       Submission submission = new Submission(documents, record.getId(), record.getUserid(), record.getDate(), record.get);
        return submission;
    }

    public static ArrayList<Submission> allSubmissions = null;
}
