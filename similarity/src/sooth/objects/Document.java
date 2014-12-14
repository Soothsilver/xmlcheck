package sooth.objects;

import sooth.scripts.Operations;
import java.util.regex.Pattern;

/**
 * Represents a single file from a submission.
 */
public class Document {

    /**
     * Returns file contents with whitespace removed and, in some cases, with other preprocessing already done.
     *
     * @note
     * The preprocessing done is:
     * - Removing whitespace.
     * - In JAVA_SAX_HANDLER documents, removing multi-line Javadoc-style comments and removing substrings from the template available from the XML Technologies website.
     * - In JAVA_DOM_TRANSFORMER documents, removing single-line comments and substrings from the XML Technologies course template.
     * @endnote
     * @return The shortened text.
     */
    public String getPreprocessedText() {
        return preprocessedText;
    }

    /**
     * Removes some parts of the file contents and saves the shortened text into a local field.
     * See @ref getPreprocessedText for information on what preprocessing is done.
     */
    public void preprocess()
    {
        if ((type == DocumentType.JAVA_SAX_HANDLER))
        {
            // In this template, there are at times common single-line comments.
            this.preprocessedText = Pattern.compile("//.*").matcher(this.text).replaceAll("");

            // It is important this is done only after the previous command because otherwise we will erase the newline
            // that ends the single-line comments we want to delete.
            this.preprocessedText = Operations.removeWhitespace(this.text);

            String[] commonSaxText = new String[]
                {
                    "public static void main(String[] args) {",
                    "String sourcePath =",
                    "try {",
                    "} catch (Exception e) {",
                    "e.printStackTrace();",
                    "XMLReader parser = XMLReaderFactory.createXMLReader();",
                    "InputSource source = new InputSource(sourcePath);",
                    "parser.setContentHandler(new MujContentHandler());",
                    "parser.parse(source);",
                    "import org.xml.sax.",
                    "public class MySaxHandler extends DefaultHandler {",
                    "Locator locator;",
                    "package user;",
                    "@Override",
                    "public void setDocumentLocator(Locator locator) {",
                    "public void startDocument() throws SAXException {",
                    "// ...",
                    "public void endDocument() throws SAXException {",
                    "public void startElement(String uri, String localName, String qName, Attributes atts) throws SAXException {",
                    "public void startElement(String uri, String localName, String qName, Attributes attributes) throws SAXException {",
                    "public void endElement(String uri, String localName, String qName) throws SAXException {",
                    "public void characters(char[] chars, int start, int length) throws SAXException {",
                    "public void startPrefixMapping(String prefix, String uri) throws SAXException {",
                    "public void endPrefixMapping(String prefix) throws SAXException {",
                    "public void ignorableWhitespace(char[] chars, int start, int length) throws SAXException {",
                    "public void processingInstruction(String target, String data) throws SAXException {",
                    "public void skippedEntity(String name) throws SAXException {"
                };
            commonSaxText = Operations.removeWhitespace(commonSaxText);

            // Remove comments because the template offered during the lecture is used by many students and has long comments
            this.preprocessedText = Pattern.compile("/\\*\\*.+?\\*/", Pattern.DOTALL).matcher(this.preprocessedText).replaceAll("");

            // Remove parts common to all submissions
            this.preprocessedText = Operations.removeSubstrings(this.preprocessedText, commonSaxText);
        }
        else if (type == DocumentType.JAVA_DOM_TRANSFORMER)
        {
            // In this template, there are common single-line comments.
            this.preprocessedText = Pattern.compile("//.*").matcher(this.text).replaceAll("");

            // It is important this is done only after the previous command because otherwise we will erase the newline
            // that ends the single-line comments we want to delete.
            this.preprocessedText = Operations.removeWhitespace(this.text);

            String[] commonDomText = new String[]
                {
                    "import javax.xml.transform.",
                    "import javax.xml.parsers.",
                    "import org.w3c.dom.",
                    "private static final String ",
                    "package user;",
                    "public class MyDomTransformer {",
                    "public static void main(String[] args) {",
                    "try {",
                    "} catch (Exception e) {",
                    "e.printStackTrace();",
                    "DocumentBuilderFactory dbf = DocumentBuilderFactory.newInstance();",
                    "dbf.setValidating(false);",
                    "DocumentBuilder builder = dbf.newDocumentBuilder();",
                    "Document doc = builder.parse(",
                    "INPUT_FILE",
                    "OUTPUT_FILE",
                    "VSTUPNI_SOUBOR",
                    "VYSTUPNI_SOUBOR",
                    "MyDomTransformer mdt = new MyDomTransformer();",
                    "mdt.transform(doc);",
                    "processTree(doc);",
                    "private static void processTree(Document doc) {",
                    "TransformerFactory tf = TransformerFactory.newInstance();",
                    "Transformer writer = tf.newTransformer();",
                    "writer.setOutputProperty(OutputKeys.ENCODING, \"utf-8\");",
                    "writer.transform(new DOMSource(doc), new StreamResult(new File(",
                    "public void transform (Document xmlDocument) {"
                };
            commonDomText = Operations.removeWhitespace(commonDomText);


            // Remove parts common to all submissions
            this.preprocessedText = Operations.removeSubstrings(this.preprocessedText, commonDomText);
        }
        else
        {
            this.preprocessedText = Operations.removeWhitespace(this.text);
        }
    }


    /**
     * Represents the type of the file, such as an XML document or an XPath query.
     */
    public static enum DocumentType {
        PRIMARY_XML_FILE(1),
        DTD_FILE(2),
        JAVA_SAX_HANDLER(3),
        JAVA_DOM_TRANSFORMER(4),
        XPATH_QUERY(5),
        XSD_SCHEMA(6),
        XQUERY_QUERY(7),
        XQUERY_ADDITIONAL_XML_FILE(8),
        XSLT_SCRIPT(9),
        DIRECTORY_STRUCTURE(10);

        /**
         * Returns a value indicating whether a submission may legally contain several documents of this type.
         * @note
         * Only documents of type XPATH_QUERY, XQUERY_QUERY and XQUERY_ADDITIONAL_XML_FILE may be present multiple times.
         * @endnote
         * @return A value indicating whether a submission may legally contain several documents of this type.
         */
        public boolean canBePresentOnlyOnce()
        {
            return
                (this.mysqlIdentifier == 1) ||
                (this.mysqlIdentifier == 2) ||
                (this.mysqlIdentifier == 3) ||
                (this.mysqlIdentifier == 4) ||
                (this.mysqlIdentifier == 6) ||
                (this.mysqlIdentifier == 9) ||
                (this.mysqlIdentifier == 10);
        }

        /**
         * The integer this document type is represented by in a database table.
         */
        private int mysqlIdentifier;

        /**
         * Initializes a new instance of the DocumentType enumeration class.
         * @param mysqlIdentifier The integer this document type is represented by in a database table.
         */
        private DocumentType(int mysqlIdentifier) {
            this.mysqlIdentifier = mysqlIdentifier;
        }

        /**
         * Returns the integer this document type is represented by in a database table.
         * @return The integer this document type is represented by in a database table.
         */
        public int getMysqlIdentifier() {
            return mysqlIdentifier;
        }

        /**
         * Returns a DocumentType instance that is represented by the specified integer in the database table.
         * @param mysqlIdentifier The integer a document type is represented by in a database table.
         * @return The DocumentType instance that is represented by the specified integer in the database table.
         * @exception java.lang.EnumConstantNotPresentException When the specified integer does not correspond to any DocumentType.
         */
        public static DocumentType getDocumentTypeByMysqlIdentifier(int mysqlIdentifier) {
            for ( DocumentType type : DocumentType.values()) {
                if (type.getMysqlIdentifier() == mysqlIdentifier) {
                    return type;
                }
            }
            throw new EnumConstantNotPresentException(DocumentType.class, Integer.toString(mysqlIdentifier));
        }

    }

    /**
     * Filename of the document file.
     */
    private String name;
    /**
     * Contents of the document file.
     */
    private String text;
    /**
     * Type of the document. For example, this could be an XPATH_QUERY.
     */
    private DocumentType type;
    /**
     * Text of the document with whitespace removed and some other modifications performed. See @ref getPreprocessedText for details.
     */
    private String preprocessedText;

    /**
     * Gets the filename of the document file.
     * @return The filename of the document file.
     */
    public String getName() {
        return name;
    }

    /**
     * Gets the contents of this document.
     * @return The contents of the file this document represents.
     */
    public String getText() {
        return text;
    }

    /**
     * Gets the type of this document. For example, this could be an XPATH_QUERY.
     * @return The DocumentType of this document.
     */
    public DocumentType getType() {
        return type;
    }


    /**
     * Initializes a new instance of the Document class.
     * @param type Type of the document.
     * @param text Contents of the file.
     * @param name Name of the file (filename).
     */
    public Document(DocumentType type, String text, String name) {
        this.type = type;
        this.text = text;
        this.name = name;
    }
}

