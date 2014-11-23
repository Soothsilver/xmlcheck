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
public class UsergroupratingRecord extends org.jooq.impl.TableRecordImpl<sooth.entities.tables.records.UsergroupratingRecord> implements org.jooq.Record10<java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.Integer, java.math.BigInteger, java.lang.String, java.lang.String, java.lang.String, java.lang.String> {

	private static final long serialVersionUID = -1163658797;

	/**
	 * Setter for <code>asmregen.usergrouprating.userId</code>.
	 */
	public void setUserid(java.lang.Integer value) {
		setValue(0, value);
	}

	/**
	 * Getter for <code>asmregen.usergrouprating.userId</code>.
	 */
	public java.lang.Integer getUserid() {
		return (java.lang.Integer) getValue(0);
	}

	/**
	 * Setter for <code>asmregen.usergrouprating.name</code>.
	 */
	public void setName(java.lang.String value) {
		setValue(1, value);
	}

	/**
	 * Getter for <code>asmregen.usergrouprating.name</code>.
	 */
	public java.lang.String getName() {
		return (java.lang.String) getValue(1);
	}

	/**
	 * Setter for <code>asmregen.usergrouprating.realName</code>.
	 */
	public void setRealname(java.lang.String value) {
		setValue(2, value);
	}

	/**
	 * Getter for <code>asmregen.usergrouprating.realName</code>.
	 */
	public java.lang.String getRealname() {
		return (java.lang.String) getValue(2);
	}

	/**
	 * Setter for <code>asmregen.usergrouprating.email</code>.
	 */
	public void setEmail(java.lang.String value) {
		setValue(3, value);
	}

	/**
	 * Getter for <code>asmregen.usergrouprating.email</code>.
	 */
	public java.lang.String getEmail() {
		return (java.lang.String) getValue(3);
	}

	/**
	 * Setter for <code>asmregen.usergrouprating.groupId</code>.
	 */
	public void setGroupid(java.lang.Integer value) {
		setValue(4, value);
	}

	/**
	 * Getter for <code>asmregen.usergrouprating.groupId</code>.
	 */
	public java.lang.Integer getGroupid() {
		return (java.lang.Integer) getValue(4);
	}

	/**
	 * Setter for <code>asmregen.usergrouprating.rating</code>.
	 */
	public void setRating(java.math.BigInteger value) {
		setValue(5, value);
	}

	/**
	 * Getter for <code>asmregen.usergrouprating.rating</code>.
	 */
	public java.math.BigInteger getRating() {
		return (java.math.BigInteger) getValue(5);
	}

	/**
	 * Setter for <code>asmregen.usergrouprating.groupName</code>.
	 */
	public void setGroupname(java.lang.String value) {
		setValue(6, value);
	}

	/**
	 * Getter for <code>asmregen.usergrouprating.groupName</code>.
	 */
	public java.lang.String getGroupname() {
		return (java.lang.String) getValue(6);
	}

	/**
	 * Setter for <code>asmregen.usergrouprating.groupDescription</code>.
	 */
	public void setGroupdescription(java.lang.String value) {
		setValue(7, value);
	}

	/**
	 * Getter for <code>asmregen.usergrouprating.groupDescription</code>.
	 */
	public java.lang.String getGroupdescription() {
		return (java.lang.String) getValue(7);
	}

	/**
	 * Setter for <code>asmregen.usergrouprating.lectureName</code>.
	 */
	public void setLecturename(java.lang.String value) {
		setValue(8, value);
	}

	/**
	 * Getter for <code>asmregen.usergrouprating.lectureName</code>.
	 */
	public java.lang.String getLecturename() {
		return (java.lang.String) getValue(8);
	}

	/**
	 * Setter for <code>asmregen.usergrouprating.lectureDescription</code>.
	 */
	public void setLecturedescription(java.lang.String value) {
		setValue(9, value);
	}

	/**
	 * Getter for <code>asmregen.usergrouprating.lectureDescription</code>.
	 */
	public java.lang.String getLecturedescription() {
		return (java.lang.String) getValue(9);
	}

	// -------------------------------------------------------------------------
	// Record10 type implementation
	// -------------------------------------------------------------------------

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row10<java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.Integer, java.math.BigInteger, java.lang.String, java.lang.String, java.lang.String, java.lang.String> fieldsRow() {
		return (org.jooq.Row10) super.fieldsRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row10<java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.Integer, java.math.BigInteger, java.lang.String, java.lang.String, java.lang.String, java.lang.String> valuesRow() {
		return (org.jooq.Row10) super.valuesRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field1() {
		return sooth.entities.tables.Usergrouprating.USERGROUPRATING.USERID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field2() {
		return sooth.entities.tables.Usergrouprating.USERGROUPRATING.NAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field3() {
		return sooth.entities.tables.Usergrouprating.USERGROUPRATING.REALNAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field4() {
		return sooth.entities.tables.Usergrouprating.USERGROUPRATING.EMAIL;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field5() {
		return sooth.entities.tables.Usergrouprating.USERGROUPRATING.GROUPID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.math.BigInteger> field6() {
		return sooth.entities.tables.Usergrouprating.USERGROUPRATING.RATING;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field7() {
		return sooth.entities.tables.Usergrouprating.USERGROUPRATING.GROUPNAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field8() {
		return sooth.entities.tables.Usergrouprating.USERGROUPRATING.GROUPDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field9() {
		return sooth.entities.tables.Usergrouprating.USERGROUPRATING.LECTURENAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field10() {
		return sooth.entities.tables.Usergrouprating.USERGROUPRATING.LECTUREDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value1() {
		return getUserid();
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
		return getRealname();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value4() {
		return getEmail();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value5() {
		return getGroupid();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.math.BigInteger value6() {
		return getRating();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value7() {
		return getGroupname();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value8() {
		return getGroupdescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value9() {
		return getLecturename();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value10() {
		return getLecturedescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public UsergroupratingRecord value1(java.lang.Integer value) {
		setUserid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public UsergroupratingRecord value2(java.lang.String value) {
		setName(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public UsergroupratingRecord value3(java.lang.String value) {
		setRealname(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public UsergroupratingRecord value4(java.lang.String value) {
		setEmail(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public UsergroupratingRecord value5(java.lang.Integer value) {
		setGroupid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public UsergroupratingRecord value6(java.math.BigInteger value) {
		setRating(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public UsergroupratingRecord value7(java.lang.String value) {
		setGroupname(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public UsergroupratingRecord value8(java.lang.String value) {
		setGroupdescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public UsergroupratingRecord value9(java.lang.String value) {
		setLecturename(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public UsergroupratingRecord value10(java.lang.String value) {
		setLecturedescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public UsergroupratingRecord values(java.lang.Integer value1, java.lang.String value2, java.lang.String value3, java.lang.String value4, java.lang.Integer value5, java.math.BigInteger value6, java.lang.String value7, java.lang.String value8, java.lang.String value9, java.lang.String value10) {
		return this;
	}

	// -------------------------------------------------------------------------
	// Constructors
	// -------------------------------------------------------------------------

	/**
	 * Create a detached UsergroupratingRecord
	 */
	public UsergroupratingRecord() {
		super(sooth.entities.tables.Usergrouprating.USERGROUPRATING);
	}

	/**
	 * Create a detached, initialised UsergroupratingRecord
	 */
	public UsergroupratingRecord(java.lang.Integer userid, java.lang.String name, java.lang.String realname, java.lang.String email, java.lang.Integer groupid, java.math.BigInteger rating, java.lang.String groupname, java.lang.String groupdescription, java.lang.String lecturename, java.lang.String lecturedescription) {
		super(sooth.entities.tables.Usergrouprating.USERGROUPRATING);

		setValue(0, userid);
		setValue(1, name);
		setValue(2, realname);
		setValue(3, email);
		setValue(4, groupid);
		setValue(5, rating);
		setValue(6, groupname);
		setValue(7, groupdescription);
		setValue(8, lecturename);
		setValue(9, lecturedescription);
	}
}
