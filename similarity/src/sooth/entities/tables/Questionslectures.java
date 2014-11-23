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
public class Questionslectures extends org.jooq.impl.TableImpl<sooth.entities.tables.records.QuestionslecturesRecord> {

	private static final long serialVersionUID = -1578647089;

	/**
	 * The reference instance of <code>asmregen.questionslectures</code>
	 */
	public static final sooth.entities.tables.Questionslectures QUESTIONSLECTURES = new sooth.entities.tables.Questionslectures();

	/**
	 * The class holding records for this type
	 */
	@Override
	public java.lang.Class<sooth.entities.tables.records.QuestionslecturesRecord> getRecordType() {
		return sooth.entities.tables.records.QuestionslecturesRecord.class;
	}

	/**
	 * The column <code>asmregen.questionslectures.id</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionslecturesRecord, java.lang.Integer> ID = createField("id", org.jooq.impl.SQLDataType.INTEGER.nullable(false).defaulted(true), this, "");

	/**
	 * The column <code>asmregen.questionslectures.text</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionslecturesRecord, java.lang.String> TEXT = createField("text", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.questionslectures.type</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionslecturesRecord, java.lang.String> TYPE = createField("type", org.jooq.impl.SQLDataType.VARCHAR.length(255).nullable(false), this, "");

	/**
	 * The column <code>asmregen.questionslectures.options</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionslecturesRecord, java.lang.String> OPTIONS = createField("options", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.questionslectures.attachments</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionslecturesRecord, java.lang.String> ATTACHMENTS = createField("attachments", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.questionslectures.lectureId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionslecturesRecord, java.lang.Integer> LECTUREID = createField("lectureId", org.jooq.impl.SQLDataType.INTEGER.nullable(false).defaulted(true), this, "");

	/**
	 * The column <code>asmregen.questionslectures.lectureName</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionslecturesRecord, java.lang.String> LECTURENAME = createField("lectureName", org.jooq.impl.SQLDataType.VARCHAR.length(20).nullable(false), this, "");

	/**
	 * The column <code>asmregen.questionslectures.lectureDescription</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionslecturesRecord, java.lang.String> LECTUREDESCRIPTION = createField("lectureDescription", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.questionslectures.ownerId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionslecturesRecord, java.lang.Integer> OWNERID = createField("ownerId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * Create a <code>asmregen.questionslectures</code> table reference
	 */
	public Questionslectures() {
		this("questionslectures", null);
	}

	/**
	 * Create an aliased <code>asmregen.questionslectures</code> table reference
	 */
	public Questionslectures(java.lang.String alias) {
		this(alias, sooth.entities.tables.Questionslectures.QUESTIONSLECTURES);
	}

	private Questionslectures(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.QuestionslecturesRecord> aliased) {
		this(alias, aliased, null);
	}

	private Questionslectures(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.QuestionslecturesRecord> aliased, org.jooq.Field<?>[] parameters) {
		super(alias, sooth.entities.Asmregen.ASMREGEN, aliased, parameters, "VIEW");
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public sooth.entities.tables.Questionslectures as(java.lang.String alias) {
		return new sooth.entities.tables.Questionslectures(alias, this);
	}

	/**
	 * Rename this table
	 */
	public sooth.entities.tables.Questionslectures rename(java.lang.String name) {
		return new sooth.entities.tables.Questionslectures(name, null);
	}
}
