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
public class SubscriptionsassignmentsproblemslecturesgroupsRecord extends org.jooq.impl.TableRecordImpl<sooth.entities.tables.records.SubscriptionsassignmentsproblemslecturesgroupsRecord> implements org.jooq.Record12<java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.sql.Timestamp, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String> {

	private static final long serialVersionUID = -94503864;

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.userId</code>.
	 */
	public void setUserid(java.lang.Integer value) {
		setValue(0, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.userId</code>.
	 */
	public java.lang.Integer getUserid() {
		return (java.lang.Integer) getValue(0);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.assignmentId</code>.
	 */
	public void setAssignmentid(java.lang.Integer value) {
		setValue(1, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.assignmentId</code>.
	 */
	public java.lang.Integer getAssignmentid() {
		return (java.lang.Integer) getValue(1);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.problemName</code>.
	 */
	public void setProblemname(java.lang.String value) {
		setValue(2, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.problemName</code>.
	 */
	public java.lang.String getProblemname() {
		return (java.lang.String) getValue(2);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.problemDescription</code>.
	 */
	public void setProblemdescription(java.lang.String value) {
		setValue(3, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.problemDescription</code>.
	 */
	public java.lang.String getProblemdescription() {
		return (java.lang.String) getValue(3);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.pluginDescription</code>.
	 */
	public void setPlugindescription(java.lang.String value) {
		setValue(4, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.pluginDescription</code>.
	 */
	public java.lang.String getPlugindescription() {
		return (java.lang.String) getValue(4);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.deadline</code>.
	 */
	public void setDeadline(java.sql.Timestamp value) {
		setValue(5, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.deadline</code>.
	 */
	public java.sql.Timestamp getDeadline() {
		return (java.sql.Timestamp) getValue(5);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.reward</code>.
	 */
	public void setReward(java.lang.Integer value) {
		setValue(6, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.reward</code>.
	 */
	public java.lang.Integer getReward() {
		return (java.lang.Integer) getValue(6);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.lectureName</code>.
	 */
	public void setLecturename(java.lang.String value) {
		setValue(7, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.lectureName</code>.
	 */
	public java.lang.String getLecturename() {
		return (java.lang.String) getValue(7);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.lectureDescription</code>.
	 */
	public void setLecturedescription(java.lang.String value) {
		setValue(8, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.lectureDescription</code>.
	 */
	public java.lang.String getLecturedescription() {
		return (java.lang.String) getValue(8);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.groupName</code>.
	 */
	public void setGroupname(java.lang.String value) {
		setValue(9, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.groupName</code>.
	 */
	public java.lang.String getGroupname() {
		return (java.lang.String) getValue(9);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.groupDescription</code>.
	 */
	public void setGroupdescription(java.lang.String value) {
		setValue(10, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.groupDescription</code>.
	 */
	public java.lang.String getGroupdescription() {
		return (java.lang.String) getValue(10);
	}

	/**
	 * Setter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.groupType</code>.
	 */
	public void setGrouptype(java.lang.String value) {
		setValue(11, value);
	}

	/**
	 * Getter for <code>asmregen.subscriptionsassignmentsproblemslecturesgroups.groupType</code>.
	 */
	public java.lang.String getGrouptype() {
		return (java.lang.String) getValue(11);
	}

	// -------------------------------------------------------------------------
	// Record12 type implementation
	// -------------------------------------------------------------------------

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row12<java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.sql.Timestamp, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String> fieldsRow() {
		return (org.jooq.Row12) super.fieldsRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row12<java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.sql.Timestamp, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String> valuesRow() {
		return (org.jooq.Row12) super.valuesRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field1() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.USERID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field2() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.ASSIGNMENTID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field3() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.PROBLEMNAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field4() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.PROBLEMDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field5() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.PLUGINDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.sql.Timestamp> field6() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.DEADLINE;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field7() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.REWARD;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field8() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.LECTURENAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field9() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.LECTUREDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field10() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.GROUPNAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field11() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.GROUPDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field12() {
		return sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS.GROUPTYPE;
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
	public java.lang.Integer value2() {
		return getAssignmentid();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value3() {
		return getProblemname();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value4() {
		return getProblemdescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value5() {
		return getPlugindescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.sql.Timestamp value6() {
		return getDeadline();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value7() {
		return getReward();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value8() {
		return getLecturename();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value9() {
		return getLecturedescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value10() {
		return getGroupname();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value11() {
		return getGroupdescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value12() {
		return getGrouptype();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value1(java.lang.Integer value) {
		setUserid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value2(java.lang.Integer value) {
		setAssignmentid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value3(java.lang.String value) {
		setProblemname(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value4(java.lang.String value) {
		setProblemdescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value5(java.lang.String value) {
		setPlugindescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value6(java.sql.Timestamp value) {
		setDeadline(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value7(java.lang.Integer value) {
		setReward(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value8(java.lang.String value) {
		setLecturename(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value9(java.lang.String value) {
		setLecturedescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value10(java.lang.String value) {
		setGroupname(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value11(java.lang.String value) {
		setGroupdescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord value12(java.lang.String value) {
		setGrouptype(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubscriptionsassignmentsproblemslecturesgroupsRecord values(java.lang.Integer value1, java.lang.Integer value2, java.lang.String value3, java.lang.String value4, java.lang.String value5, java.sql.Timestamp value6, java.lang.Integer value7, java.lang.String value8, java.lang.String value9, java.lang.String value10, java.lang.String value11, java.lang.String value12) {
		return this;
	}

	// -------------------------------------------------------------------------
	// Constructors
	// -------------------------------------------------------------------------

	/**
	 * Create a detached SubscriptionsassignmentsproblemslecturesgroupsRecord
	 */
	public SubscriptionsassignmentsproblemslecturesgroupsRecord() {
		super(sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS);
	}

	/**
	 * Create a detached, initialised SubscriptionsassignmentsproblemslecturesgroupsRecord
	 */
	public SubscriptionsassignmentsproblemslecturesgroupsRecord(java.lang.Integer userid, java.lang.Integer assignmentid, java.lang.String problemname, java.lang.String problemdescription, java.lang.String plugindescription, java.sql.Timestamp deadline, java.lang.Integer reward, java.lang.String lecturename, java.lang.String lecturedescription, java.lang.String groupname, java.lang.String groupdescription, java.lang.String grouptype) {
		super(sooth.entities.tables.Subscriptionsassignmentsproblemslecturesgroups.SUBSCRIPTIONSASSIGNMENTSPROBLEMSLECTURESGROUPS);

		setValue(0, userid);
		setValue(1, assignmentid);
		setValue(2, problemname);
		setValue(3, problemdescription);
		setValue(4, plugindescription);
		setValue(5, deadline);
		setValue(6, reward);
		setValue(7, lecturename);
		setValue(8, lecturedescription);
		setValue(9, groupname);
		setValue(10, groupdescription);
		setValue(11, grouptype);
	}
}
