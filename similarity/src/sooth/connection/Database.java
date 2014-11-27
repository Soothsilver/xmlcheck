package sooth.connection;

import org.jooq.DSLContext;
import org.jooq.Result;
import org.jooq.SQLDialect;
import org.jooq.impl.DSL;
import sooth.Logging;
import sooth.entities.Tables;
import sooth.entities.tables.records.DocumentsRecord;
import sooth.entities.tables.records.ProblemsRecord;
import sooth.entities.tables.records.SubmissionsRecord;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

public class Database {
    private static Logger logger = Logging.getLogger(Database.class.getName());
    private static Logger orgLogger = Logger.getLogger("org");
    private static DSLContext context = null;
    private static Connection connection = null;

    public static List<SubmissionsRecord> allSubmissions;
    public static List<DocumentsRecord> allDocuments;

    public static DSLContext getContext()
    {
        orgLogger.setLevel(Level.WARNING);
        if (context == null) {
            connection = null;
            String userName = "asmfull";
            String password = "RedSprite";
            String url = "jdbc:mysql://localhost:3306/";
            try {
                Class.forName("com.mysql.jdbc.Driver").newInstance();
                connection = DriverManager.getConnection(url, userName, password);
                DSLContext create = DSL.using(connection, SQLDialect.MYSQL);
                context = create;
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
                logger.severe("Database connection could not be established: " + e.toString());
                return null;
            }
        }
        return context;
    }

    public static void test()
    {
        Connection conn = null;

        String userName = "asmfull";
        String password = "RedSprite";
        String url = "jdbc:mysql://localhost:3306/";

        try {
            Class.forName("com.mysql.jdbc.Driver").newInstance();
            conn = DriverManager.getConnection(url, userName, password);
            DSLContext create = DSL.using(conn, SQLDialect.MYSQL);

            org.jooq.Result<ProblemsRecord> result = create.selectFrom(Tables.PROBLEMS).fetch();
            for (ProblemsRecord record : result) {
                System.out.println(record.getName());
            }
        } catch (Exception e) {
            // For the sake of this tutorial, let's keep exception handling simple
            e.printStackTrace();
        } finally {
            if (conn != null) {
                try {
                    conn.close();
                } catch (SQLException ignore) {
                }
            }
        }
    }
}
