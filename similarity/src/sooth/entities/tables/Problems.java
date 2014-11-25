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
public class Problems extends org.jooq.impl.TableImpl<sooth.entities.tables.records.ProblemsRecord> {

	private static final long serialVersionUID = -1814199690;

	/**
	 * The reference instance of <code>asmregen.problems</code>
	 */
	public static final sooth.entities.tables.Problems PROBLEMS = new sooth.entities.tables.Problems();

	/**
	 * The class holding records for this type
	 */
	@Override
	public java.lang.Class<sooth.entities.tables.records.ProblemsRecord> getRecordType() {
		return sooth.entities.tables.records.ProblemsRecord.class;
	}

	/**
	 * The column <code>asmregen.problems.id</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemsRecord, java.lang.Integer> ID = createField("id", org.jooq.impl.SQLDataType.INTEGER.nullable(false), this, "");

	/**
	 * The column <code>asmregen.problems.name</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemsRecord, java.lang.String> NAME = createField("name", org.jooq.impl.SQLDataType.VARCHAR.length(50).nullable(false), this, "");

	/**
	 * The column <code>asmregen.problems.description</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemsRecord, java.lang.String> DESCRIPTION = createField("description", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.problems.config</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemsRecord, java.lang.String> CONFIG = createField("config", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.problems.lectureId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemsRecord, java.lang.Integer> LECTUREID = createField("lectureId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * The column <code>asmregen.problems.deleted</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemsRecord, java.lang.Byte> DELETED = createField("deleted", org.jooq.impl.SQLDataType.TINYINT.nullable(false), this, "");

	/**
	 * The column <code>asmregen.problems.pluginId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.ProblemsRecord, java.lang.Integer> PLUGINID = createField("pluginId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * Create a <code>asmregen.problems</code> table reference
	 */
	public Problems() {
		this("problems", null);
	}

	/**
	 * Create an aliased <code>asmregen.problems</code> table reference
	 */
	public Problems(java.lang.String alias) {
		this(alias, sooth.entities.tables.Problems.PROBLEMS);
	}

	private Problems(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.ProblemsRecord> aliased) {
		this(alias, aliased, null);
	}

	private Problems(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.ProblemsRecord> aliased, org.jooq.Field<?>[] parameters) {
		super(alias, sooth.entities.Asmregen.ASMREGEN, aliased, parameters, "");
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Identity<sooth.entities.tables.records.ProblemsRecord, java.lang.Integer> getIdentity() {
		return sooth.entities.Keys.IDENTITY_PROBLEMS;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.UniqueKey<sooth.entities.tables.records.ProblemsRecord> getPrimaryKey() {
		return sooth.entities.Keys.KEY_PROBLEMS_PRIMARY;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.UniqueKey<sooth.entities.tables.records.ProblemsRecord>> getKeys() {
		return java.util.Arrays.<org.jooq.UniqueKey<sooth.entities.tables.records.ProblemsRecord>>asList(sooth.entities.Keys.KEY_PROBLEMS_PRIMARY, sooth.entities.Keys.KEY_PROBLEMS_NAME);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.ForeignKey<sooth.entities.tables.records.ProblemsRecord, ?>> getReferences() {
		return java.util.Arrays.<org.jooq.ForeignKey<sooth.entities.tables.records.ProblemsRecord, ?>>asList(sooth.entities.Keys.FK_8E6662453BC48E00, sooth.entities.Keys.FK_8E6662459A9A50E9);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public sooth.entities.tables.Problems as(java.lang.String alias) {
		return new sooth.entities.tables.Problems(alias, this);
	}

	/**
	 * Rename this table
	 */
	public sooth.entities.tables.Problems rename(java.lang.String name) {
		return new sooth.entities.tables.Problems(name, null);
	}
}
