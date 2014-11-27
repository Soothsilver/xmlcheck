/**
 * This class is generated by jOOQ
 */
package sooth.entities.tables;

/**
 * This class is generated by jOOQ.
 */
@javax.annotation.Generated(
	value = {
		"http://www.jooq.org",
		"jOOQ version:3.5.0"
	},
	comments = "This class is generated by jOOQ"
)
@java.lang.SuppressWarnings({ "all", "unchecked", "rawtypes" })
public class Questions extends org.jooq.impl.TableImpl<sooth.entities.tables.records.QuestionsRecord> {

	private static final long serialVersionUID = -1671020487;

	/**
	 * The reference instance of <code>asmregen.questions</code>
	 */
	public static final sooth.entities.tables.Questions QUESTIONS = new sooth.entities.tables.Questions();

	/**
	 * The class holding records for this type
	 */
	@Override
	public java.lang.Class<sooth.entities.tables.records.QuestionsRecord> getRecordType() {
		return sooth.entities.tables.records.QuestionsRecord.class;
	}

	/**
	 * The column <code>asmregen.questions.id</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionsRecord, java.lang.Integer> ID = createField("id", org.jooq.impl.SQLDataType.INTEGER.nullable(false), this, "");

	/**
	 * The column <code>asmregen.questions.text</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionsRecord, java.lang.String> TEXT = createField("text", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.questions.type</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionsRecord, java.lang.String> TYPE = createField("type", org.jooq.impl.SQLDataType.VARCHAR.length(255).nullable(false), this, "");

	/**
	 * The column <code>asmregen.questions.options</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionsRecord, java.lang.String> OPTIONS = createField("options", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.questions.attachments</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionsRecord, java.lang.String> ATTACHMENTS = createField("attachments", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.questions.lectureId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.QuestionsRecord, java.lang.Integer> LECTUREID = createField("lectureId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * Create a <code>asmregen.questions</code> table reference
	 */
	public Questions() {
		this("questions", null);
	}

	/**
	 * Create an aliased <code>asmregen.questions</code> table reference
	 */
	public Questions(java.lang.String alias) {
		this(alias, sooth.entities.tables.Questions.QUESTIONS);
	}

	private Questions(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.QuestionsRecord> aliased) {
		this(alias, aliased, null);
	}

	private Questions(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.QuestionsRecord> aliased, org.jooq.Field<?>[] parameters) {
		super(alias, sooth.entities.Asmregen.ASMREGEN, aliased, parameters, "");
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Identity<sooth.entities.tables.records.QuestionsRecord, java.lang.Integer> getIdentity() {
		return sooth.entities.Keys.IDENTITY_QUESTIONS;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.UniqueKey<sooth.entities.tables.records.QuestionsRecord> getPrimaryKey() {
		return sooth.entities.Keys.KEY_QUESTIONS_PRIMARY;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.UniqueKey<sooth.entities.tables.records.QuestionsRecord>> getKeys() {
		return java.util.Arrays.<org.jooq.UniqueKey<sooth.entities.tables.records.QuestionsRecord>>asList(sooth.entities.Keys.KEY_QUESTIONS_PRIMARY);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.ForeignKey<sooth.entities.tables.records.QuestionsRecord, ?>> getReferences() {
		return java.util.Arrays.<org.jooq.ForeignKey<sooth.entities.tables.records.QuestionsRecord, ?>>asList(sooth.entities.Keys.FK_8ADC54D53BC48E00);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public sooth.entities.tables.Questions as(java.lang.String alias) {
		return new sooth.entities.tables.Questions(alias, this);
	}

	/**
	 * Rename this table
	 */
	public sooth.entities.tables.Questions rename(java.lang.String name) {
		return new sooth.entities.tables.Questions(name, null);
	}
}