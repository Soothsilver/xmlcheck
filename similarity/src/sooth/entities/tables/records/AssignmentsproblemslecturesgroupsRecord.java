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
public class AssignmentsproblemslecturesgroupsRecord extends org.jooq.impl.TableRecordImpl<sooth.entities.tables.records.AssignmentsproblemslecturesgroupsRecord> implements org.jooq.Record14<java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.sql.Timestamp, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.Integer, java.lang.String, java.lang.Integer, java.lang.Integer> {

	private static final long serialVersionUID = -404498652;

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.id</code>.
	 */
	public void setId(java.lang.Integer value) {
		setValue(0, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.id</code>.
	 */
	public java.lang.Integer getId() {
		return (java.lang.Integer) getValue(0);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.problemId</code>.
	 */
	public void setProblemid(java.lang.Integer value) {
		setValue(1, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.problemId</code>.
	 */
	public java.lang.Integer getProblemid() {
		return (java.lang.Integer) getValue(1);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.problemName</code>.
	 */
	public void setProblemname(java.lang.String value) {
		setValue(2, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.problemName</code>.
	 */
	public java.lang.String getProblemname() {
		return (java.lang.String) getValue(2);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.problemDescription</code>.
	 */
	public void setProblemdescription(java.lang.String value) {
		setValue(3, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.problemDescription</code>.
	 */
	public java.lang.String getProblemdescription() {
		return (java.lang.String) getValue(3);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.deadline</code>.
	 */
	public void setDeadline(java.sql.Timestamp value) {
		setValue(4, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.deadline</code>.
	 */
	public java.sql.Timestamp getDeadline() {
		return (java.sql.Timestamp) getValue(4);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.reward</code>.
	 */
	public void setReward(java.lang.Integer value) {
		setValue(5, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.reward</code>.
	 */
	public java.lang.Integer getReward() {
		return (java.lang.Integer) getValue(5);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.lectureName</code>.
	 */
	public void setLecturename(java.lang.String value) {
		setValue(6, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.lectureName</code>.
	 */
	public java.lang.String getLecturename() {
		return (java.lang.String) getValue(6);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.lectureDescription</code>.
	 */
	public void setLecturedescription(java.lang.String value) {
		setValue(7, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.lectureDescription</code>.
	 */
	public java.lang.String getLecturedescription() {
		return (java.lang.String) getValue(7);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.groupName</code>.
	 */
	public void setGroupname(java.lang.String value) {
		setValue(8, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.groupName</code>.
	 */
	public java.lang.String getGroupname() {
		return (java.lang.String) getValue(8);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.groupDescription</code>.
	 */
	public void setGroupdescription(java.lang.String value) {
		setValue(9, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.groupDescription</code>.
	 */
	public java.lang.String getGroupdescription() {
		return (java.lang.String) getValue(9);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.ownerId</code>.
	 */
	public void setOwnerid(java.lang.Integer value) {
		setValue(10, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.ownerId</code>.
	 */
	public java.lang.Integer getOwnerid() {
		return (java.lang.Integer) getValue(10);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.groupType</code>.
	 */
	public void setGrouptype(java.lang.String value) {
		setValue(11, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.groupType</code>.
	 */
	public java.lang.String getGrouptype() {
		return (java.lang.String) getValue(11);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.groupId</code>.
	 */
	public void setGroupid(java.lang.Integer value) {
		setValue(12, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.groupId</code>.
	 */
	public java.lang.Integer getGroupid() {
		return (java.lang.Integer) getValue(12);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemslecturesgroups.pluginId</code>.
	 */
	public void setPluginid(java.lang.Integer value) {
		setValue(13, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemslecturesgroups.pluginId</code>.
	 */
	public java.lang.Integer getPluginid() {
		return (java.lang.Integer) getValue(13);
	}

	// -------------------------------------------------------------------------
	// Record14 type implementation
	// -------------------------------------------------------------------------

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row14<java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.sql.Timestamp, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.Integer, java.lang.String, java.lang.Integer, java.lang.Integer> fieldsRow() {
		return (org.jooq.Row14) super.fieldsRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row14<java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.sql.Timestamp, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.Integer, java.lang.String, java.lang.Integer, java.lang.Integer> valuesRow() {
		return (org.jooq.Row14) super.valuesRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field1() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.ID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field2() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.PROBLEMID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field3() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.PROBLEMNAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field4() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.PROBLEMDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.sql.Timestamp> field5() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.DEADLINE;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field6() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.REWARD;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field7() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.LECTURENAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field8() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.LECTUREDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field9() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.GROUPNAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field10() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.GROUPDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field11() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.OWNERID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field12() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.GROUPTYPE;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field13() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.GROUPID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field14() {
		return sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS.PLUGINID;
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
		return getProblemid();
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
	public java.sql.Timestamp value5() {
		return getDeadline();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value6() {
		return getReward();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value7() {
		return getLecturename();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value8() {
		return getLecturedescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value9() {
		return getGroupname();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value10() {
		return getGroupdescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value11() {
		return getOwnerid();
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
	public java.lang.Integer value13() {
		return getGroupid();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value14() {
		return getPluginid();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value1(java.lang.Integer value) {
		setId(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value2(java.lang.Integer value) {
		setProblemid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value3(java.lang.String value) {
		setProblemname(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value4(java.lang.String value) {
		setProblemdescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value5(java.sql.Timestamp value) {
		setDeadline(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value6(java.lang.Integer value) {
		setReward(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value7(java.lang.String value) {
		setLecturename(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value8(java.lang.String value) {
		setLecturedescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value9(java.lang.String value) {
		setGroupname(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value10(java.lang.String value) {
		setGroupdescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value11(java.lang.Integer value) {
		setOwnerid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value12(java.lang.String value) {
		setGrouptype(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value13(java.lang.Integer value) {
		setGroupid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord value14(java.lang.Integer value) {
		setPluginid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemslecturesgroupsRecord values(java.lang.Integer value1, java.lang.Integer value2, java.lang.String value3, java.lang.String value4, java.sql.Timestamp value5, java.lang.Integer value6, java.lang.String value7, java.lang.String value8, java.lang.String value9, java.lang.String value10, java.lang.Integer value11, java.lang.String value12, java.lang.Integer value13, java.lang.Integer value14) {
		return this;
	}

	// -------------------------------------------------------------------------
	// Constructors
	// -------------------------------------------------------------------------

	/**
	 * Create a detached AssignmentsproblemslecturesgroupsRecord
	 */
	public AssignmentsproblemslecturesgroupsRecord() {
		super(sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS);
	}

	/**
	 * Create a detached, initialised AssignmentsproblemslecturesgroupsRecord
	 */
	public AssignmentsproblemslecturesgroupsRecord(java.lang.Integer id, java.lang.Integer problemid, java.lang.String problemname, java.lang.String problemdescription, java.sql.Timestamp deadline, java.lang.Integer reward, java.lang.String lecturename, java.lang.String lecturedescription, java.lang.String groupname, java.lang.String groupdescription, java.lang.Integer ownerid, java.lang.String grouptype, java.lang.Integer groupid, java.lang.Integer pluginid) {
		super(sooth.entities.tables.Assignmentsproblemslecturesgroups.ASSIGNMENTSPROBLEMSLECTURESGROUPS);

		setValue(0, id);
		setValue(1, problemid);
		setValue(2, problemname);
		setValue(3, problemdescription);
		setValue(4, deadline);
		setValue(5, reward);
		setValue(6, lecturename);
		setValue(7, lecturedescription);
		setValue(8, groupname);
		setValue(9, groupdescription);
		setValue(10, ownerid);
		setValue(11, grouptype);
		setValue(12, groupid);
		setValue(13, pluginid);
	}
}
