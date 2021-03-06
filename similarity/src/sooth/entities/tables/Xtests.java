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
public class Xtests extends org.jooq.impl.TableImpl<sooth.entities.tables.records.XtestsRecord> {

	private static final long serialVersionUID = 1402974482;

	/**
	 * The reference instance of <code>asmregen.xtests</code>
	 */
	public static final sooth.entities.tables.Xtests XTESTS = new sooth.entities.tables.Xtests();

	/**
	 * The class holding records for this type
	 */
	@Override
	public java.lang.Class<sooth.entities.tables.records.XtestsRecord> getRecordType() {
		return sooth.entities.tables.records.XtestsRecord.class;
	}

	/**
	 * The column <code>asmregen.xtests.id</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.XtestsRecord, java.lang.Integer> ID = createField("id", org.jooq.impl.SQLDataType.INTEGER.nullable(false), this, "");

	/**
	 * The column <code>asmregen.xtests.description</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.XtestsRecord, java.lang.String> DESCRIPTION = createField("description", org.jooq.impl.SQLDataType.VARCHAR.length(255).nullable(false), this, "");

	/**
	 * The column <code>asmregen.xtests.template</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.XtestsRecord, java.lang.String> TEMPLATE = createField("template", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.xtests.count</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.XtestsRecord, java.lang.Integer> COUNT = createField("count", org.jooq.impl.SQLDataType.INTEGER.nullable(false), this, "");

	/**
	 * The column <code>asmregen.xtests.generated</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.XtestsRecord, java.lang.String> GENERATED = createField("generated", org.jooq.impl.SQLDataType.CLOB.nullable(false), this, "");

	/**
	 * The column <code>asmregen.xtests.lectureId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.XtestsRecord, java.lang.Integer> LECTUREID = createField("lectureId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * Create a <code>asmregen.xtests</code> table reference
	 */
	public Xtests() {
		this("xtests", null);
	}

	/**
	 * Create an aliased <code>asmregen.xtests</code> table reference
	 */
	public Xtests(java.lang.String alias) {
		this(alias, sooth.entities.tables.Xtests.XTESTS);
	}

	private Xtests(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.XtestsRecord> aliased) {
		this(alias, aliased, null);
	}

	private Xtests(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.XtestsRecord> aliased, org.jooq.Field<?>[] parameters) {
		super(alias, sooth.entities.Asmregen.ASMREGEN, aliased, parameters, "");
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Identity<sooth.entities.tables.records.XtestsRecord, java.lang.Integer> getIdentity() {
		return sooth.entities.Keys.IDENTITY_XTESTS;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.UniqueKey<sooth.entities.tables.records.XtestsRecord> getPrimaryKey() {
		return sooth.entities.Keys.KEY_XTESTS_PRIMARY;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.UniqueKey<sooth.entities.tables.records.XtestsRecord>> getKeys() {
		return java.util.Arrays.<org.jooq.UniqueKey<sooth.entities.tables.records.XtestsRecord>>asList(sooth.entities.Keys.KEY_XTESTS_PRIMARY);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.ForeignKey<sooth.entities.tables.records.XtestsRecord, ?>> getReferences() {
		return java.util.Arrays.<org.jooq.ForeignKey<sooth.entities.tables.records.XtestsRecord, ?>>asList(sooth.entities.Keys.FK_82F1254C3BC48E00);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public sooth.entities.tables.Xtests as(java.lang.String alias) {
		return new sooth.entities.tables.Xtests(alias, this);
	}

	/**
	 * Rename this table
	 */
	public sooth.entities.tables.Xtests rename(java.lang.String name) {
		return new sooth.entities.tables.Xtests(name, null);
	}
}
