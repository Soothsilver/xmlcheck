package sooth.problems;

import sooth.FilesystemUtils;
import sooth.objects.Document;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Locale;

public class Dtd {

    public static List<Document> extractDocuments(List<File> files) {
        ArrayList<Document> documents = new ArrayList<>();
        Document xmlDocument = null;
        Document dtdDocument = null;
        try {
            for (File file : files){
                if (file.getPath().toLowerCase(Locale.ROOT).endsWith(".xml")) {
                    String fileContents = null;
                    fileContents = FilesystemUtils.loadTextFile(file); // TODO handle second one, the same for DTD
                    xmlDocument = new Document(Document.DocumentType.PRIMARY_XML_FILE, fileContents, file.toPath().getFileName().toString());
                }
                if (file.getPath().toLowerCase(Locale.ROOT).endsWith(".dtd")) {
                    String fileContents = null;
                    fileContents = FilesystemUtils.loadTextFile(file);
                    dtdDocument = new Document(Document.DocumentType.DTD_FILE, fileContents, file.toPath().getFileName().toString());
                }
            }
            if (xmlDocument != null) documents.add(xmlDocument);
            if (dtdDocument != null) documents.add(dtdDocument);
            return documents;
        } catch (IOException e) {
            // TODO handle this better
            return new ArrayList<Document>();
        }
    }
}
