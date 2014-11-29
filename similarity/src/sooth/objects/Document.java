package sooth.objects;

public class Document {
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


        private int mysqlIdentifier;
        private DocumentType(int mysqlIdentifier) {
            this.mysqlIdentifier = mysqlIdentifier;
        }
        public int getMysqlIdentifier() {
            return mysqlIdentifier;
        }
        public static DocumentType getDocumentTypeByMysqlIdentifier(int mysqlIdentifier) {
            for ( DocumentType type : DocumentType.values()) {
                if (type.getMysqlIdentifier() == mysqlIdentifier) {
                    return type;
                }
            }
            throw new EnumConstantNotPresentException(DocumentType.class, new Integer(mysqlIdentifier).toString());
        }

    }

    private String name;
    private String text;
    private DocumentType type;

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getText() {
        return text;
    }

    public void setText(String text) {
        this.text = text;
    }

    public DocumentType getType() {
        return type;
    }

    public void setType(DocumentType type) {
        this.type = type;
    }

    public Document(DocumentType type, String text, String name) {
        this.type = type;
        this.text = text;
        this.name = name;
    }
}

