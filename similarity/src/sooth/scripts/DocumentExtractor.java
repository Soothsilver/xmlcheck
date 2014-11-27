package sooth.scripts;

import sooth.FilesystemUtils;
import sooth.Logging;
import sooth.Problems;
import sooth.objects.Document;
import sooth.problems.Dtd;

import java.io.File;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Logger;

public class DocumentExtractor {
    private static Logger logger = Logging.getLogger(DocumentExtractor.class.getName());
    public static List<Document> getDocumentsFromZipArchive(Path pathToZipFile, String pluginIdentifier) {
        ArrayList<Document> documents = new ArrayList<>();
        if (!Files.exists(pathToZipFile)) {
            logger.warning("The specified path '" + pathToZipFile + "' does not lead to a file.");
            return documents;
        }
        File temporaryFolder = null;
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
        // All submissions should have the DIRECTORY_STRUCTURE document extracted.
        StringBuilder textDirectoryStructure = new StringBuilder();
        files.forEach(file -> textDirectoryStructure.append(file.toPath().getFileName()));
        Document documentDirectoryStructure = new Document(Document.DocumentType.DIRECTORY_STRUCTURE, textDirectoryStructure.toString(), "Directory Structure");
        documents.add(documentDirectoryStructure);

        // Other extractions depends on the plugin identifier.
        switch (pluginIdentifier)
        {
            case Problems.HW1_DTD:
                documents.addAll(Dtd.extractDocuments(files));
                break;
            default:
                logger.warning("This plugin has an unknown identifier. We could not therefore extract useful documents from it.");
                break;
        }
        return documents;
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
