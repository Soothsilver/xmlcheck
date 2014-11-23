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
public class Problemslectures extends org.jooq.impl.TableImpl<sooth.entities.tables.records.ProblemslecturesRecord> {

	private static final long serialVersionUID = 878588531;

	/**
	 * The reference instance of <code>asmregen.problemslectures</code>
	 */
	public static final sooth.entities.tables.Problemslectures PROBLEMSLECTURES = new sooth.entities.tables.Problemslectures();

	/**
	 * The class holding records for this type
	 */
	@Override
	public java.lang.Class<sooth.entities.tables.records.ProblemslecturesRecord> getRecordType() {
		return sooth.entities.tables.records.ProblemslecturesRecord.class;
	}

	/**
	 * The column <code>asmregen.problemslectures.id</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemslecturesRecord, java.lang.Integer> ID = createField("id", org.jooq.impl.SQLDataType.INTEGER.nullable(false).defaulted(true), this, "");

	/**
	 * The column <code>asmregen.problemslectures.problemName</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemslecturesRecord, java.lang.String> PROBLEMNAME = createField("problemName", org.jooq.impl.SQLDataType.VARCHAR.length(50).nullable(false), this, "");

	/**
	 * The column <code>asmregen.problemslectures.problemDescription</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemslecturesRecord, java.lang.String> PROBLEMDESCRIPTION = createField("problemDescription", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.problemslectures.pluginId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemslecturesRecord, java.lang.Integer> PLUGINID = createField("pluginId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * The column <code>asmregen.problemslectures.config</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemslecturesRecord, java.lang.String> CONFIG = createField("config", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.problemslectures.lectureId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemslecturesRecord, java.lang.Integer> LECTUREID = createField("lectureId", org.jooq.impl.SQLDataType.INTEGER.nullable(false).defaulted(true), this, "");

	/**
	 * The column <code>asmregen.problemslectures.lectureName</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemslecturesRecord, java.lang.String> LECTURENAME = createField("lectureName", org.jooq.impl.SQLDataType.VARCHAR.length(20).nullable(false), this, "");

	/**
	 * The column <code>asmregen.problemslectures.lectureDescription</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemslecturesRecord, java.lang.String> LECTUREDESCRIPTION = createField("lectureDescription", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.problemslectures.ownerId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemslecturesRecord, java.lang.Integer> OWNERID = createField("ownerId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * Create a <code>asmregen.problemslectures</code> table reference
	 */
	public Problemslectures() {
		this("problemslectures", null);
	}

	/**
	 * Create an aliased <code>asmregen.problemslectures</code> table reference
	 */
	public Problemslectures(java.lang.String alias) {
		this(alias, sooth.entities.tables.Problemslectures.PROBLEMSLECTURES);
	}

	private Problemslectures(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.ProblemslecturesRecord> aliased) {
		this(alias, aliased, null);
	}

	private Problemslectures(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.ProblemslecturesRecord> aliased, org.jooq.Field<?>[] parameters) {
		super(alias, sooth.entities.Asmregen.ASMREGEN, aliased, parameters, "VIEW");
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public sooth.entities.tables.Problemslectures as(java.lang.String alias) {
		return new sooth.entities.tables.Problemslectures(alias, this);
	}

	/**
	 * Rename this table
	 */
	public sooth.entities.tables.Problemslectures rename(java.lang.String name) {
		return new sooth.entities.tables.Problemslectures(name, null);
	}
}
