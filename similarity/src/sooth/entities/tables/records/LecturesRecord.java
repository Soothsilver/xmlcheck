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
public class LecturesRecord extends org.jooq.impl.UpdatableRecordImpl<sooth.entities.tables.records.LecturesRecord> implements org.jooq.Record5<java.lang.Integer, java.lang.String, java.lang.String, java.lang.Integer, java.lang.Byte> {

	private static final long serialVersionUID = 838366530;

	/**
	 * Setter for <code>asmregen.lectures.id</code>.
	 */
	public void setId(java.lang.Integer value) {
		setValue(0, value);
	}

	/**
	 * Getter for <code>asmregen.lectures.id</code>.
	 */
	public java.lang.Integer getId() {
		return (java.lang.Integer) getValue(0);
	}

	/**
	 * Setter for <code>asmregen.lectures.name</code>.
	 */
	public void setName(java.lang.String value) {
		setValue(1, value);
	}

	/**
	 * Getter for <code>asmregen.lectures.name</code>.
	 */
	public java.lang.String getName() {
		return (java.lang.String) getValue(1);
	}

	/**
	 * Setter for <code>asmregen.lectures.description</code>.
	 */
	public void setDescription(java.lang.String value) {
		setValue(2, value);
	}

	/**
	 * Getter for <code>asmregen.lectures.description</code>.
	 */
	public java.lang.String getDescription() {
		return (java.lang.String) getValue(2);
	}

	/**
	 * Setter for <code>asmregen.lectures.ownerId</code>.
	 */
	public void setOwnerid(java.lang.Integer value) {
		setValue(3, value);
	}

	/**
	 * Getter for <code>asmregen.lectures.ownerId</code>.
	 */
	public java.lang.Integer getOwnerid() {
		return (java.lang.Integer) getValue(3);
	}

	/**
	 * Setter for <code>asmregen.lectures.deleted</code>.
	 */
	public void setDeleted(java.lang.Byte value) {
		setValue(4, value);
	}

	/**
	 * Getter for <code>asmregen.lectures.deleted</code>.
	 */
	public java.lang.Byte getDeleted() {
		return (java.lang.Byte) getValue(4);
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
	// Record5 type implementation
	// -------------------------------------------------------------------------

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row5<java.lang.Integer, java.lang.String, java.lang.String, java.lang.Integer, java.lang.Byte> fieldsRow() {
		return (org.jooq.Row5) super.fieldsRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row5<java.lang.Integer, java.lang.String, java.lang.String, java.lang.Integer, java.lang.Byte> valuesRow() {
		return (org.jooq.Row5) super.valuesRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field1() {
		return sooth.entities.tables.Lectures.LECTURES.ID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field2() {
		return sooth.entities.tables.Lectures.LECTURES.NAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field3() {
		return sooth.entities.tables.Lectures.LECTURES.DESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field4() {
		return sooth.entities.tables.Lectures.LECTURES.OWNERID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Byte> field5() {
		return sooth.entities.tables.Lectures.LECTURES.DELETED;
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
	public java.lang.String value3() {
		return getDescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value4() {
		return getOwnerid();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Byte value5() {
		return getDeleted();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public LecturesRecord value1(java.lang.Integer value) {
		setId(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public LecturesRecord value2(java.lang.String value) {
		setName(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public LecturesRecord value3(java.lang.String value) {
		setDescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public LecturesRecord value4(java.lang.Integer value) {
		setOwnerid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public LecturesRecord value5(java.lang.Byte value) {
		setDeleted(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public LecturesRecord values(java.lang.Integer value1, java.lang.String value2, java.lang.String value3, java.lang.Integer value4, java.lang.Byte value5) {
		return this;
	}

	// -------------------------------------------------------------------------
	// Constructors
	// -------------------------------------------------------------------------

	/**
	 * Create a detached LecturesRecord
	 */
	public LecturesRecord() {
		super(sooth.entities.tables.Lectures.LECTURES);
	}

	/**
	 * Create a detached, initialised LecturesRecord
	 */
	public LecturesRecord(java.lang.Integer id, java.lang.String name, java.lang.String description, java.lang.Integer ownerid, java.lang.Byte deleted) {
		super(sooth.entities.tables.Lectures.LECTURES);

		setValue(0, id);
		setValue(1, name);
		setValue(2, description);
		setValue(3, ownerid);
		setValue(4, deleted);
	}
}
