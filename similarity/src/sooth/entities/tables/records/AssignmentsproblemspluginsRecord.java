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
public class AssignmentsproblemspluginsRecord extends org.jooq.impl.TableRecordImpl<sooth.entities.tables.records.AssignmentsproblemspluginsRecord> implements org.jooq.Record12<java.lang.Integer, java.sql.Timestamp, java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String> {

	private static final long serialVersionUID = 1945998512;

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.id</code>.
	 */
	public void setId(java.lang.Integer value) {
		setValue(0, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.id</code>.
	 */
	public java.lang.Integer getId() {
		return (java.lang.Integer) getValue(0);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.deadline</code>.
	 */
	public void setDeadline(java.sql.Timestamp value) {
		setValue(1, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.deadline</code>.
	 */
	public java.sql.Timestamp getDeadline() {
		return (java.sql.Timestamp) getValue(1);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.reward</code>.
	 */
	public void setReward(java.lang.Integer value) {
		setValue(2, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.reward</code>.
	 */
	public java.lang.Integer getReward() {
		return (java.lang.Integer) getValue(2);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.groupId</code>.
	 */
	public void setGroupid(java.lang.Integer value) {
		setValue(3, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.groupId</code>.
	 */
	public java.lang.Integer getGroupid() {
		return (java.lang.Integer) getValue(3);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.problemName</code>.
	 */
	public void setProblemname(java.lang.String value) {
		setValue(4, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.problemName</code>.
	 */
	public java.lang.String getProblemname() {
		return (java.lang.String) getValue(4);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.problemDescription</code>.
	 */
	public void setProblemdescription(java.lang.String value) {
		setValue(5, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.problemDescription</code>.
	 */
	public java.lang.String getProblemdescription() {
		return (java.lang.String) getValue(5);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.problemConfig</code>.
	 */
	public void setProblemconfig(java.lang.String value) {
		setValue(6, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.problemConfig</code>.
	 */
	public java.lang.String getProblemconfig() {
		return (java.lang.String) getValue(6);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.pluginName</code>.
	 */
	public void setPluginname(java.lang.String value) {
		setValue(7, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.pluginName</code>.
	 */
	public java.lang.String getPluginname() {
		return (java.lang.String) getValue(7);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.pluginType</code>.
	 */
	public void setPlugintype(java.lang.String value) {
		setValue(8, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.pluginType</code>.
	 */
	public java.lang.String getPlugintype() {
		return (java.lang.String) getValue(8);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.pluginDescription</code>.
	 */
	public void setPlugindescription(java.lang.String value) {
		setValue(9, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.pluginDescription</code>.
	 */
	public java.lang.String getPlugindescription() {
		return (java.lang.String) getValue(9);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.pluginMainFile</code>.
	 */
	public void setPluginmainfile(java.lang.String value) {
		setValue(10, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.pluginMainFile</code>.
	 */
	public java.lang.String getPluginmainfile() {
		return (java.lang.String) getValue(10);
	}

	/**
	 * Setter for <code>asmregen.assignmentsproblemsplugins.pluginConfig</code>.
	 */
	public void setPluginconfig(java.lang.String value) {
		setValue(11, value);
	}

	/**
	 * Getter for <code>asmregen.assignmentsproblemsplugins.pluginConfig</code>.
	 */
	public java.lang.String getPluginconfig() {
		return (java.lang.String) getValue(11);
	}

	// -------------------------------------------------------------------------
	// Record12 type implementation
	// -------------------------------------------------------------------------

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row12<java.lang.Integer, java.sql.Timestamp, java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String> fieldsRow() {
		return (org.jooq.Row12) super.fieldsRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row12<java.lang.Integer, java.sql.Timestamp, java.lang.Integer, java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String> valuesRow() {
		return (org.jooq.Row12) super.valuesRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field1() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.ID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.sql.Timestamp> field2() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.DEADLINE;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field3() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.REWARD;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field4() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.GROUPID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field5() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.PROBLEMNAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field6() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.PROBLEMDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field7() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.PROBLEMCONFIG;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field8() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.PLUGINNAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field9() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.PLUGINTYPE;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field10() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.PLUGINDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field11() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.PLUGINMAINFILE;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field12() {
		return sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS.PLUGINCONFIG;
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
	public java.sql.Timestamp value2() {
		return getDeadline();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value3() {
		return getReward();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value4() {
		return getGroupid();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value5() {
		return getProblemname();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value6() {
		return getProblemdescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value7() {
		return getProblemconfig();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value8() {
		return getPluginname();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value9() {
		return getPlugintype();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value10() {
		return getPlugindescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value11() {
		return getPluginmainfile();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value12() {
		return getPluginconfig();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value1(java.lang.Integer value) {
		setId(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value2(java.sql.Timestamp value) {
		setDeadline(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value3(java.lang.Integer value) {
		setReward(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value4(java.lang.Integer value) {
		setGroupid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value5(java.lang.String value) {
		setProblemname(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value6(java.lang.String value) {
		setProblemdescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value7(java.lang.String value) {
		setProblemconfig(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value8(java.lang.String value) {
		setPluginname(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value9(java.lang.String value) {
		setPlugintype(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value10(java.lang.String value) {
		setPlugindescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value11(java.lang.String value) {
		setPluginmainfile(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord value12(java.lang.String value) {
		setPluginconfig(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public AssignmentsproblemspluginsRecord values(java.lang.Integer value1, java.sql.Timestamp value2, java.lang.Integer value3, java.lang.Integer value4, java.lang.String value5, java.lang.String value6, java.lang.String value7, java.lang.String value8, java.lang.String value9, java.lang.String value10, java.lang.String value11, java.lang.String value12) {
		return this;
	}

	// -------------------------------------------------------------------------
	// Constructors
	// -------------------------------------------------------------------------

	/**
	 * Create a detached AssignmentsproblemspluginsRecord
	 */
	public AssignmentsproblemspluginsRecord() {
		super(sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS);
	}

	/**
	 * Create a detached, initialised AssignmentsproblemspluginsRecord
	 */
	public AssignmentsproblemspluginsRecord(java.lang.Integer id, java.sql.Timestamp deadline, java.lang.Integer reward, java.lang.Integer groupid, java.lang.String problemname, java.lang.String problemdescription, java.lang.String problemconfig, java.lang.String pluginname, java.lang.String plugintype, java.lang.String plugindescription, java.lang.String pluginmainfile, java.lang.String pluginconfig) {
		super(sooth.entities.tables.Assignmentsproblemsplugins.ASSIGNMENTSPROBLEMSPLUGINS);

		setValue(0, id);
		setValue(1, deadline);
		setValue(2, reward);
		setValue(3, groupid);
		setValue(4, problemname);
		setValue(5, problemdescription);
		setValue(6, problemconfig);
		setValue(7, pluginname);
		setValue(8, plugintype);
		setValue(9, plugindescription);
		setValue(10, pluginmainfile);
		setValue(11, pluginconfig);
	}
}