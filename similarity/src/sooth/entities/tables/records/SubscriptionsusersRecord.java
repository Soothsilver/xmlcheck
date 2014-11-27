/**
 * This class is generated by jOOQ
 */
package sooth.entities.tables.records;

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
public class SubscriptionsusersRecord extends org.jooq.impl.TableRecordImpl<sooth.entities.tables.records.SubscriptionsusersRecord> implements org.jooq.Record6<java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String> {

	private static final long serialVersionUID = 1165483613;

	/**
	 * Setter for <code>asmregen.subscriptionsusers.id</code>.
	 */
	public void setId(java.lang.Integer value) {
		setValue(0, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsusers.id</code>.
	 */
	public java.lang.Integer getId() {
		return (java.lang.Integer) getValue(0);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsusers.groupId</code>.
	 */
	public void setGroupid(java.lang.Integer value) {
		setValue(1, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsusers.groupId</code>.
	 */
	public java.lang.Integer getGroupid() {
		return (java.lang.Integer) getValue(1);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsusers.status</code>.
	 */
	public void setStatus(java.lang.String value) {
		setValue(2, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsusers.status</code>.
	 */
	public java.lang.String getStatus() {
		return (java.lang.String) getValue(2);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsusers.name</code>.
	 */
	public void setName(java.lang.String value) {
		setValue(3, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsusers.name</code>.
	 */
	public java.lang.String getName() {
		return (java.lang.String) getValue(3);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsusers.realName</code>.
	 */
	public void setRealname(java.lang.String value) {
		setValue(4, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsusers.realName</code>.
	 */
	public java.lang.String getRealname() {
		return (java.lang.String) getValue(4);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsusers.email</code>.
	 */
	public void setEmail(java.lang.String value) {
		setValue(5, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsusers.email</code>.
	 */
	public java.lang.String getEmail() {
		return (java.lang.String) getValue(5);
	}

	// -------------------------------------------------------------------------
	// Record6 type implementation
	// -------------------------------------------------------------------------

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row6<java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String> fieldsRow() {
		return (org.jooq.Row6) super.fieldsRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row6<java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String> valuesRow() {
		return (org.jooq.Row6) super.valuesRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field1() {
		return sooth.entities.tables.Subscriptionsusers.SUBSCRIPTIONSUSERS.ID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field2() {
		return sooth.entities.tables.Subscriptionsusers.SUBSCRIPTIONSUSERS.GROUPID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field3() {
		return sooth.entities.tables.Subscriptionsusers.SUBSCRIPTIONSUSERS.STATUS;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field4() {
		return sooth.entities.tables.Subscriptionsusers.SUBSCRIPTIONSUSERS.NAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field5() {
		return sooth.entities.tables.Subscriptionsusers.SUBSCRIPTIONSUSERS.REALNAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field6() {
		return sooth.entities.tables.Subscriptionsusers.SUBSCRIPTIONSUSERS.EMAIL;
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
	public java.lang.Integer value2() {
		return getGroupid();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value3() {
		return getStatus();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value4() {
		return getName();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value5() {
		return getRealname();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value6() {
		return getEmail();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsusersRecord value1(java.lang.Integer value) {
		setId(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsusersRecord value2(java.lang.Integer value) {
		setGroupid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsusersRecord value3(java.lang.String value) {
		setStatus(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsusersRecord value4(java.lang.String value) {
		setName(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsusersRecord value5(java.lang.String value) {
		setRealname(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsusersRecord value6(java.lang.String value) {
		setEmail(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsusersRecord values(java.lang.Integer value1, java.lang.Integer value2, java.lang.String value3, java.lang.String value4, java.lang.String value5, java.lang.String value6) {
		return this;
	}

	// -------------------------------------------------------------------------
	// Constructors
	// -------------------------------------------------------------------------

	/**
	 * Create a detached SubscriptionsusersRecord
	 */
	public SubscriptionsusersRecord() {
		super(sooth.entities.tables.Subscriptionsusers.SUBSCRIPTIONSUSERS);
	}

	/**
	 * Create a detached, initialised SubscriptionsusersRecord
	 */
	public SubscriptionsusersRecord(java.lang.Integer id, java.lang.Integer groupid, java.lang.String status, java.lang.String name, java.lang.String realname, java.lang.String email) {
		super(sooth.entities.tables.Subscriptionsusers.SUBSCRIPTIONSUSERS);

		setValue(0, id);
		setValue(1, groupid);
		setValue(2, status);
		setValue(3, name);
		setValue(4, realname);
		setValue(5, email);
	}
}