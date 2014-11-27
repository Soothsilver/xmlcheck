/**
 * This class is generated by jOOQ
 */
package sooth.entities.tables.records;

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
public class PrivilegesRecord extends org.jooq.impl.UpdatableRecordImpl<sooth.entities.tables.records.PrivilegesRecord> implements org.jooq.Record3<java.lang.Integer, java.lang.String, java.lang.Integer> {

	private static final long serialVersionUID = -409084684;

	/**
	 * Setter for <code>asmregen.privileges.id</code>.
	 */
	public void setId(java.lang.Integer value) {
		setValue(0, value);
	}

	/**
	 * Getter for <code>asmregen.privileges.id</code>.
	 */
	public java.lang.Integer getId() {
		return (java.lang.Integer) getValue(0);
	}

	/**
	 * Setter for <code>asmregen.privileges.name</code>.
	 */
	public void setName(java.lang.String value) {
		setValue(1, value);
	}

	/**
	 * Getter for <code>asmregen.privileges.name</code>.
	 */
	public java.lang.String getName() {
		return (java.lang.String) getValue(1);
	}

	/**
	 * Setter for <code>asmregen.privileges.privileges</code>.
	 */
	public void setPrivileges(java.lang.Integer value) {
		setValue(2, value);
	}

	/**
	 * Getter for <code>asmregen.privileges.privileges</code>.
	 */
	public java.lang.Integer getPrivileges() {
		return (java.lang.Integer) getValue(2);
	}

	// -------------------------------------------------------------------------
	// Primary key information
	// -------------------------------------------------------------------------

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Record1<java.lang.Integer> key() {
		return (org.jooq.Record1) super.key();
	}

	// -------------------------------------------------------------------------
	// Record3 type implementation
	// -------------------------------------------------------------------------

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row3<java.lang.Integer, java.lang.String, java.lang.Integer> fieldsRow() {
		return (org.jooq.Row3) super.fieldsRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row3<java.lang.Integer, java.lang.String, java.lang.Integer> valuesRow() {
		return (org.jooq.Row3) super.valuesRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field1() {
		return sooth.entities.tables.Privileges.PRIVILEGES.ID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field2() {
		return sooth.entities.tables.Privileges.PRIVILEGES.NAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field3() {
		return sooth.entities.tables.Privileges.PRIVILEGES.PRIVILEGES_;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value1() {
		return getId();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value2() {
		return getName();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value3() {
		return getPrivileges();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public PrivilegesRecord value1(java.lang.Integer value) {
		setId(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public PrivilegesRecord value2(java.lang.String value) {
		setName(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public PrivilegesRecord value3(java.lang.Integer value) {
		setPrivileges(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public PrivilegesRecord values(java.lang.Integer value1, java.lang.String value2, java.lang.Integer value3) {
		return this;
	}

	// -------------------------------------------------------------------------
	// Constructors
	// -------------------------------------------------------------------------

	/**
	 * Create a detached PrivilegesRecord
	 */
	public PrivilegesRecord() {
		super(sooth.entities.tables.Privileges.PRIVILEGES);
	}

	/**
	 * Create a detached, initialised PrivilegesRecord
	 */
	public PrivilegesRecord(java.lang.Integer id, java.lang.String name, java.lang.Integer privileges) {
		super(sooth.entities.tables.Privileges.PRIVILEGES);

		setValue(0, id);
		setValue(1, name);
		setValue(2, privileges);
	}
}