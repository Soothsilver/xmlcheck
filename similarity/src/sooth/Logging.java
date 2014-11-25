package sooth;

import java.util.Formatter;
import java.util.logging.*;

public class Logging {
    private static class SimpleRecordFormatter extends java.util.logging.Formatter {

        @Override
        public String format(LogRecord record) {
            StringBuilder stringBuilder = new StringBuilder();
            stringBuilder.append(record.getLevel()).append(": ").append(formatMessage(record)).append("[").append(record.getSourceMethodName()).append("] ");
            stringBuilder.append("\n");
            return stringBuilder.toString();
        }
    }
    public static Logger getLogger(String className) {
        Logger logger = Logger.getLogger(className);
        for (Handler parentHandler : logger.getParent().getHandlers())
        {
            logger.getParent().removeHandler(parentHandler);
        }
        ConsoleHandler consoleHandler = new ConsoleHandler();
        SimpleRecordFormatter formatter = new SimpleRecordFormatter();
        consoleHandler.setFormatter(formatter);
        logger.addHandler(consoleHandler);
        return logger;
    }
}
