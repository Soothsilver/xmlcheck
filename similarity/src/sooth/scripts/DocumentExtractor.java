package sooth.scripts;

import sooth.FilesystemUtils;
import sooth.Logging;
import sooth.Problems;
import sooth.objects.Document;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.ArrayList;
import java.util.List;
import java.util.Objects;
import java.util.logging.Logger;

public class DocumentExtractor {
    private static final int MAXIMUM_DOCUMENT_SIZE = 50000; // 50 kB
    private static final int MAXIMUM_NUMBER_OF_SAME_DOCUMENT_TYPE = 3;

    private static Logger logger = Logging.getLogger(DocumentExtractor.class.getName());
    public static List<Document> getDocumentsFromZipArchive(Path pathToZipFile, String pluginIdentifier) {
        ArrayList<Document> documents = new ArrayList<>();
        if (!Files.exists(pathToZipFile)) {
            logger.warning("The specified path '" + pathToZipFile + "' does not lead to a file.");
            return documents;
        }
        File temporaryFolder;
        try {
            temporaryFolder = FilesystemUtils.createTempDirectory();
            FilesystemUtils.unzip(pathToZipFile.toFile(), temporaryFolder);
        } catch (IOException e) {
            logger.warning("The file '" + pathToZipFile + "' could not be extracted to a temporary folder.");
            return documents;
        }
        documents = getDocumentsFromDirectoryContents(temporaryFolder, pluginIdentifier);
        FilesystemUtils.removeDirectoryAndContents(temporaryFolder);
        return documents;
    }
    public static ArrayList<Document> getDocumentsFromDirectoryContents(File submissionDirectory, String pluginIdentifier) {
        ArrayList<Document> documents = new ArrayList<>();
        List<File> files = getAbsoluteFilesRecursively(submissionDirectory);

        // Extracting individual files.
        for (File file : files) {
            String extension = FilesystemUtils.getFileExtension(file).toLowerCase();
            if (file.getPath().contains("MACOSX")) {
                // Files in the __MACOSX folder will not be checked for plagiarism, because they are metadata created by
                // Macintosh computers.
                continue;
            }

            Document.DocumentType type = getDocumentTypeFromExtension(pluginIdentifier, file, extension);
            if (type == null)
            {
                continue;
            }
            if (type == Document.DocumentType.DTD_FILE ||
                type == Document.DocumentType.XQUERY_QUERY ||
                type == Document.DocumentType.XQUERY_ADDITIONAL_XML_FILE ||
                type == Document.DocumentType.XPATH_QUERY) {
                // These files are too small to be compared for similarity.
                continue;
            }

            int sameDocumentsPresent = 0;
            for(Document d : documents) {
                if (d.getType().equals(type)) {
                    if (type.canBePresentOnlyOnce()) {
                        logger.warning("In this submission, a document of the same type is already present. (present: " + d.getName() + ", being added: " + file.getName() + ")");
                    }
                    sameDocumentsPresent++;
                }
            }
            if (sameDocumentsPresent >= MAXIMUM_NUMBER_OF_SAME_DOCUMENT_TYPE) {
                logger.warning("There are too many of these files in the submission. Ignoring the rest.");
                continue;
            }

            try {
                String fileContents = FilesystemUtils.loadTextFile(file);
                if (fileContents.length() > MAXIMUM_DOCUMENT_SIZE)
                {
                    logger.warning("This document is too large. It won't be loaded in the database.");
                }
                else {
                    Document thisDocument = new Document(type, fileContents, file.getName());
                    documents.add(thisDocument);
                }
            } catch (IOException e) {
                logger.warning("This document could not be read from disk.");
            }

        }

        return documents;
    }

    private static Document.DocumentType getDocumentTypeFromExtension(String pluginIdentifier, File file, String extension) {
        Document.DocumentType type = null;
        switch (extension) {
            case "xml":
                if (Objects.equals(pluginIdentifier, Problems.HW5_XQUERY))
                {
                    type = Document.DocumentType.XQUERY_ADDITIONAL_XML_FILE;
                }
                else {
                    type = Document.DocumentType.PRIMARY_XML_FILE;
                }
                break;
            case "dtd":
                type = Document.DocumentType.DTD_FILE;
                break;
            case "xq":
                type = Document.DocumentType.XQUERY_QUERY;
                break;
            case "xp":
                type = Document.DocumentType.XPATH_QUERY;
                break;
            case "xsd":
                type = Document.DocumentType.XSD_SCHEMA;
                break;
            case "xsl":
                type = Document.DocumentType.XSLT_SCRIPT;
                break;
            case "java":
                if (file.getName().equals("MyDomTransformer.java")) {
                    type = Document.DocumentType.JAVA_DOM_TRANSFORMER;
                }
                else if (file.getName().equals("MySaxHandler.java")) {
                    type = Document.DocumentType.JAVA_SAX_HANDLER;
                }
                else {
                    logger.fine("This submission contains a java source file other than the two permitted files ("+file.getName()+").");
                }
                break;
            default:
                // This may be an additional text file or something, we don't want to check that
                logger.fine("Unknown file extension: " + extension);
                break;
        }
        return type;
    }

    // TODO catch exceptions from all this

    private static List<File> getAbsoluteFilesRecursively(File directory) {
        ArrayList<File> files = new ArrayList<>();
        for ( File file : directory.listFiles()) {
            files.add(file.getAbsoluteFile());
            if (file.isDirectory()) {
                files.addAll(getAbsoluteFilesRecursively(file));
            }
        }
        return files;
    }
}
