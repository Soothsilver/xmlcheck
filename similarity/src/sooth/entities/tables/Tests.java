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
public class Tests extends org.jooq.impl.TableImpl<sooth.entities.tables.records.TestsRecord> {

	private static final long serialVersionUID = -1932926145;

	/**
	 * The reference instance of <code>asmregen.tests</code>
	 */
	public static final sooth.entities.tables.Tests TESTS = new sooth.entities.tables.Tests();

	/**
	 * The class holding records for this type
	 */
	@Override
	public java.lang.Class<sooth.entities.tables.records.TestsRecord> getRecordType() {
		return sooth.entities.tables.records.TestsRecord.class;
	}

	/**
	 * The column <code>asmregen.tests.id</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.TestsRecord, java.lang.Integer> ID = createField("id", org.jooq.impl.SQLDataType.INTEGER.nullable(false), this, "");

	/**
	 * The column <code>asmregen.tests.description</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.TestsRecord, java.lang.String> DESCRIPTION = createField("description", org.jooq.impl.SQLDataType.VARCHAR.length(50).nullable(false), this, "");

	/**
	 * The column <code>asmregen.tests.pluginId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.TestsRecord, java.lang.Integer> PLUGINID = createField("pluginId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * The column <code>asmregen.tests.config</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.TestsRecord, java.lang.String> CONFIG = createField("config", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.tests.input</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.TestsRecord, java.lang.String> INPUT = createField("input", org.jooq.impl.SQLDataType.VARCHAR.length(100).nullable(false), this, "");

	/**
	 * The column <code>asmregen.tests.status</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.TestsRecord, java.lang.String> STATUS = createField("status", org.jooq.impl.SQLDataType.VARCHAR.length(255).nullable(false), this, "");

	/**
	 * The column <code>asmregen.tests.success</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.TestsRecord, java.lang.Integer> SUCCESS = createField("success", org.jooq.impl.SQLDataType.INTEGER.nullable(false), this, "");

	/**
	 * The column <code>asmregen.tests.info</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.TestsRecord, java.lang.String> INFO = createField("info", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.tests.output</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.TestsRecord, java.lang.String> OUTPUT = createField("output", org.jooq.impl.SQLDataType.VARCHAR.length(100).nullable(false), this, "");

	/**
	 * Create a <code>asmregen.tests</code> table reference
	 */
	public Tests() {
		this("tests", null);
	}

	/**
	 * Create an aliased <code>asmregen.tests</code> table reference
	 */
	public Tests(java.lang.String alias) {
		this(alias, sooth.entities.tables.Tests.TESTS);
	}

	private Tests(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.TestsRecord> aliased) {
		this(alias, aliased, null);
	}

	private Tests(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.TestsRecord> aliased, org.jooq.Field<?>[] parameters) {
		super(alias, sooth.entities.Asmregen.ASMREGEN, aliased, parameters, "");
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Identity<sooth.entities.tables.records.TestsRecord, java.lang.Integer> getIdentity() {
		return sooth.entities.Keys.IDENTITY_TESTS;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.UniqueKey<sooth.entities.tables.records.TestsRecord> getPrimaryKey() {
		return sooth.entities.Keys.KEY_TESTS_PRIMARY;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.UniqueKey<sooth.entities.tables.records.TestsRecord>> getKeys() {
		return java.util.Arrays.<org.jooq.UniqueKey<sooth.entities.tables.records.TestsRecord>>asList(sooth.entities.Keys.KEY_TESTS_PRIMARY);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.ForeignKey<sooth.entities.tables.records.TestsRecord, ?>> getReferences() {
		return java.util.Arrays.<org.jooq.ForeignKey<sooth.entities.tables.records.TestsRecord, ?>>asList(sooth.entities.Keys.FK_1260FC5E9A9A50E9);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public sooth.entities.tables.Tests as(java.lang.String alias) {
		return new sooth.entities.tables.Tests(alias, this);
	}

	/**
	 * Rename this table
	 */
	public sooth.entities.tables.Tests rename(java.lang.String name) {
		return new sooth.entities.tables.Tests(name, null);
	}
}
