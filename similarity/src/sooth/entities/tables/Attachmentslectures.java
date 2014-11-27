/**
 * This class is generated by jOOQ
 */
package sooth.entities.tables;

/**
 * VIEW
 */
@javax.annotation.Generated(
	value = {
		"http://www.jooq.org",
		"jOOQ version:3.5.0"
	},
	comments = "This class is generated by jOOQ"
)
@java.lang.SuppressWarnings({ "all", "unchecked", "rawtypes" })
public class Attachmentslectures extends org.jooq.impl.TableImpl<sooth.entities.tables.records.AttachmentslecturesRecord> {

	private static final long serialVersionUID = 628700135;

	/**
	 * The reference instance of <code>asmregen.attachmentslectures</code>
	 */
	public static final sooth.entities.tables.Attachmentslectures ATTACHMENTSLECTURES = new sooth.entities.tables.Attachmentslectures();

	/**
	 * The class holding records for this type
	 */
	@Override
	public java.lang.Class<sooth.entities.tables.records.AttachmentslecturesRecord> getRecordType() {
		return sooth.entities.tables.records.AttachmentslecturesRecord.class;
	}

	/**
	 * The column <code>asmregen.attachmentslectures.id</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AttachmentslecturesRecord, java.lang.Integer> ID = createField("id", org.jooq.impl.SQLDataType.INTEGER.nullable(false).defaulted(true), this, "");

	/**
	 * The column <code>asmregen.attachmentslectures.name</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AttachmentslecturesRecord, java.lang.String> NAME = createField("name", org.jooq.impl.SQLDataType.VARCHAR.length(20).nullable(false), this, "");

	/**
	 * The column <code>asmregen.attachmentslectures.type</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AttachmentslecturesRecord, java.lang.String> TYPE = createField("type", org.jooq.impl.SQLDataType.VARCHAR.length(255).nullable(false), this, "");

	/**
	 * The column <code>asmregen.attachmentslectures.file</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AttachmentslecturesRecord, java.lang.String> FILE = createField("file", org.jooq.impl.SQLDataType.VARCHAR.length(100).nullable(false), this, "");

	/**
	 * The column <code>asmregen.attachmentslectures.lectureId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AttachmentslecturesRecord, java.lang.Integer> LECTUREID = createField("lectureId", org.jooq.impl.SQLDataType.INTEGER.nullable(false).defaulted(true), this, "");

	/**
	 * The column <code>asmregen.attachmentslectures.lectureName</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AttachmentslecturesRecord, java.lang.String> LECTURENAME = createField("lectureName", org.jooq.impl.SQLDataType.VARCHAR.length(20).nullable(false), this, "");

	/**
	 * The column <code>asmregen.attachmentslectures.lectureDescription</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AttachmentslecturesRecord, java.lang.String> LECTUREDESCRIPTION = createField("lectureDescription", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.attachmentslectures.ownerId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AttachmentslecturesRecord, java.lang.Integer> OWNERID = createField("ownerId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * Create a <code>asmregen.attachmentslectures</code> table reference
	 */
	public Attachmentslectures() {
		this("attachmentslectures", null);
	}

	/**
	 * Create an aliased <code>asmregen.attachmentslectures</code> table reference
	 */
	public Attachmentslectures(java.lang.String alias) {
		this(alias, sooth.entities.tables.Attachmentslectures.ATTACHMENTSLECTURES);
	}

	private Attachmentslectures(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.AttachmentslecturesRecord> aliased) {
		this(alias, aliased, null);
	}

	private Attachmentslectures(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.AttachmentslecturesRecord> aliased, org.jooq.Field<?>[] parameters) {
		super(alias, sooth.entities.Asmregen.ASMREGEN, aliased, parameters, "VIEW");
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public sooth.entities.tables.Attachmentslectures as(java.lang.String alias) {
		return new sooth.entities.tables.Attachmentslectures(alias, this);
	}

	/**
	 * Rename this table
	 */
	public sooth.entities.tables.Attachmentslectures rename(java.lang.String name) {
		return new sooth.entities.tables.Attachmentslectures(name, null);
	}
}