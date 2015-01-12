package sooth.connection;

import com.sun.tools.internal.jxc.gen.config.Config;
import org.jooq.DSLContext;
import org.jooq.Record;
import org.jooq.Result;
import org.jooq.SQLDialect;
import org.jooq.impl.DSL;
import sooth.Configuration;
import sooth.Logging;
import sooth.entities.tables.records.DocumentsRecord;
import sooth.entities.tables.records.SubmissionsRecord;
import sooth.objects.Document;
import sooth.objects.Submission;
import sooth.objects.SubmissionsByPlugin;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 * Contains static data and methods relating to the use of database.
 */
public class Database {
    private static Logger logger = Logging.getLogger(Database.class.getName());
    /**
     * This logger is used to suppress logging data from the jOOQ framework which outputs excessive amounts of data, most of which is useless.
     */
    private static Logger orgLogger = Logger.getLogger("org");
    private static DSLContext context = null;
    private static Connection connection = null;

    public static List<SubmissionsRecord> allSubmissions;
    public static List<DocumentsRecord> allDocuments;

    /**
     * Returns a DSLContext with an established connection to the database. If a connection was established before calling this function,
     * then the context is reused.
     * @return The DSLContext.
     */
    public static DSLContext getContext()
    {
        orgLogger.setLevel(Level.WARNING);
        if (context == null) {
            connection = null;
            String userName = Configuration.dbUser;
            String password = Configuration.dbPassword;
            String url = "jdbc:mysql://" + Configuration.dbHostname  +":3306/" + Configuration.dbDatabaseName;
            try {
                Class.forName("com.mysql.jdbc.Driver").newInstance();
                connection = DriverManager.getConnection(url, userName, password);
                context = DSL.using(connection, SQLDialect.MYSQL);
                java.lang.Runtime.getRuntime().addShutdownHook(new Thread() {
                    @Override
                    public void run() {
                        try {
                            connection.close();
                        } catch (SQLException e) {
                            logger.info("SQL connection could not be closed: " + e.toString());
                        }
                    }
                });
            } catch (Exception e) {
                logger.info("Server: " + Configuration.dbHostname );
                logger.info("User: " + Configuration.dbUser);
                logger.info("Password: " + Configuration.dbPassword);
                logger.info("Database name: " + Configuration.dbDatabaseName);
                logger.severe("Database connection could not be established: " + e.toString());
                return null;
            }
        }
        return context;
    }

    public static SubmissionsByPlugin runSubmissionsByPluginQueryOnAllIdentifiers() {
        String query = getSubmissionsByPluginQuery(null);
        DSLContext context = getContext();
        Result<Record> result = context.fetch(query);
        return getSubmissionsByPluginFromResult(result);
    }
    public static SubmissionsByPlugin runSubmissionsByPluginQueryOnThisIdentifier(String pluginIdentifier) {
        String query = getSubmissionsByPluginQuery(pluginIdentifier);
        DSLContext context = getContext();
        Result<Record> result = context.fetch(query, pluginIdentifier);
        return getSubmissionsByPluginFromResult(result);
    }
    public static SubmissionsByPlugin runSubmissionsByPluginQueryOnTheseSubmissions(int submission1, int submission2) {
        String query = getSubmissionsByPluginQuery(submission1, submission2);
        DSLContext context = getContext();
        Result<Record> result = context.fetch(query, submission1, submission2);
        return getSubmissionsByPluginFromResult(result);
    }

    private static SubmissionsByPlugin getSubmissionsByPluginFromResult(Result<Record> result) {
        SubmissionsByPlugin tree = new SubmissionsByPlugin();
        Submission submissionBeingCreated = null;
        List<Document> createdDocumentList = null;
        for(Record record : result) {
            String pluginIdentifier = (String)record.getValue("plgIdentifier");
            int submissionId = (int)record.getValue("sid");

            if ((submissionBeingCreated != null) && (submissionBeingCreated.getSubmissionId() != submissionId))
            {
                // Save the old submission
                if (!tree.containsKey(submissionBeingCreated.getPluginIdentifier()))
                {
                    tree.put(submissionBeingCreated.getPluginIdentifier(), new ArrayList<>());
                }
                tree.get(submissionBeingCreated.getPluginIdentifier()).add(submissionBeingCreated);
                submissionBeingCreated = null;
            }
            if (submissionBeingCreated == null) {
                createdDocumentList = new ArrayList<>();
                int userId = (int)record.getValue("suser");
                Date uploadTime = (Date)record.getValue("sdate");
                submissionBeingCreated = new Submission(createdDocumentList, submissionId, userId, uploadTime, pluginIdentifier);
            }
            // Add this document to the submission
            String documentName = (String)record.getValue("dname");
            String documentText = (String)record.getValue("dtext");
            Document.DocumentType documentType = Document.DocumentType.getDocumentTypeByMysqlIdentifier((int)record.getValue("dtype"));
            Document document = new Document(documentType, documentText, documentName);
            document.preprocess();
            createdDocumentList.add(document);
        }
         // Save the last submission
        if (submissionBeingCreated != null)
        {
            if (!tree.containsKey(submissionBeingCreated.getPluginIdentifier())) {
                tree.put(submissionBeingCreated.getPluginIdentifier(), new ArrayList<>());
            }
            tree.get(submissionBeingCreated.getPluginIdentifier()).add(submissionBeingCreated);
        }
        return tree;
    }

    private static String getSubmissionsByPluginQuery(String pluginIdentifier) {
        return "SELECT d.name AS dname, d.text AS dtext, d.type AS dtype, s.userId AS suser, s.id AS sid, " +
                "plg.identifier AS plgIdentifier, s.date AS sdate " +
                "FROM documents AS d " +
                "INNER JOIN submissions AS s ON d.submissionId = s.id " +
                "INNER JOIN assignments AS a ON s.assignmentId = a.id " +
                "INNER JOIN problems AS p ON a.problemId = p.id " +
                "INNER JOIN plugins AS plg ON p.pluginId = plg.id " +
                "WHERE s.status <> 'deleted' " +
                (pluginIdentifier == null ? "" : "AND plg.identifier = ? ") +
                "ORDER BY plg.identifier, s.date, s.id, d.type";
    }
    private static String getSubmissionsByPluginQuery(int submission1, int submission2) {
        return "SELECT d.name AS dname, d.text AS dtext, d.type AS dtype, s.userId AS suser, s.id AS sid, " +
                "plg.identifier AS plgIdentifier, s.date AS sdate " +
                "FROM documents AS d " +
                "INNER JOIN submissions AS s ON d.submissionId = s.id " +
                "INNER JOIN assignments AS a ON s.assignmentId = a.id " +
                "INNER JOIN problems AS p ON a.problemId = p.id " +
                "INNER JOIN plugins AS plg ON p.pluginId = plg.id " +
                "WHERE s.status <> 'deleted' AND " +
                "(s.id = ? OR s.id = ?) " +
                "ORDER BY plg.identifier, s.date, s.id, d.type";
    }


}
