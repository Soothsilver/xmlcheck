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
public class Assignments extends org.jooq.impl.TableImpl<sooth.entities.tables.records.AssignmentsRecord> {

	private static final long serialVersionUID = 1623765967;

	/**
	 * The reference instance of <code>asmregen.assignments</code>
	 */
	public static final sooth.entities.tables.Assignments ASSIGNMENTS = new sooth.entities.tables.Assignments();

	/**
	 * The class holding records for this type
	 */
	@Override
	public java.lang.Class<sooth.entities.tables.records.AssignmentsRecord> getRecordType() {
		return sooth.entities.tables.records.AssignmentsRecord.class;
	}

	/**
	 * The column <code>asmregen.assignments.id</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AssignmentsRecord, java.lang.Integer> ID = createField("id", org.jooq.impl.SQLDataType.INTEGER.nullable(false), this, "");

	/**
	 * The column <code>asmregen.assignments.deadline</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AssignmentsRecord, java.sql.Timestamp> DEADLINE = createField("deadline", org.jooq.impl.SQLDataType.TIMESTAMP.nullable(false), this, "");

	/**
	 * The column <code>asmregen.assignments.reward</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AssignmentsRecord, java.lang.Integer> REWARD = createField("reward", org.jooq.impl.SQLDataType.INTEGER.nullable(false), this, "");

	/**
	 * The column <code>asmregen.assignments.groupId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AssignmentsRecord, java.lang.Integer> GROUPID = createField("groupId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * The column <code>asmregen.assignments.problemId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AssignmentsRecord, java.lang.Integer> PROBLEMID = createField("problemId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * The column <code>asmregen.assignments.deleted</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.AssignmentsRecord, java.lang.Byte> DELETED = createField("deleted", org.jooq.impl.SQLDataType.TINYINT.nullable(false), this, "");

	/**
	 * Create a <code>asmregen.assignments</code> table reference
	 */
	public Assignments() {
		this("assignments", null);
	}

	/**
	 * Create an aliased <code>asmregen.assignments</code> table reference
	 */
	public Assignments(java.lang.String alias) {
		this(alias, sooth.entities.tables.Assignments.ASSIGNMENTS);
	}

	private Assignments(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.AssignmentsRecord> aliased) {
		this(alias, aliased, null);
	}

	private Assignments(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.AssignmentsRecord> aliased, org.jooq.Field<?>[] parameters) {
		super(alias, sooth.entities.Asmregen.ASMREGEN, aliased, parameters, "");
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Identity<sooth.entities.tables.records.AssignmentsRecord, java.lang.Integer> getIdentity() {
		return sooth.entities.Keys.IDENTITY_ASSIGNMENTS;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.UniqueKey<sooth.entities.tables.records.AssignmentsRecord> getPrimaryKey() {
		return sooth.entities.Keys.KEY_ASSIGNMENTS_PRIMARY;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.UniqueKey<sooth.entities.tables.records.AssignmentsRecord>> getKeys() {
		return java.util.Arrays.<org.jooq.UniqueKey<sooth.entities.tables.records.AssignmentsRecord>>asList(sooth.entities.Keys.KEY_ASSIGNMENTS_PRIMARY);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.ForeignKey<sooth.entities.tables.records.AssignmentsRecord, ?>> getReferences() {
		return java.util.Arrays.<org.jooq.ForeignKey<sooth.entities.tables.records.AssignmentsRecord, ?>>asList(sooth.entities.Keys.FK_308A50DDED8188B0, sooth.entities.Keys.FK_308A50DDBB4C47C8);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public sooth.entities.tables.Assignments as(java.lang.String alias) {
		return new sooth.entities.tables.Assignments(alias, this);
	}

	/**
	 * Rename this table
	 */
	public sooth.entities.tables.Assignments rename(java.lang.String name) {
		return new sooth.entities.tables.Assignments(name, null);
	}
}
