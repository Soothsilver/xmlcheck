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
public class TestspluginsRecord extends org.jooq.impl.TableRecordImpl<sooth.entities.tables.records.TestspluginsRecord> implements org.jooq.Record13<java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.Integer, java.lang.String, java.lang.String> {

	private static final long serialVersionUID = 1573275719;

	/**
	 * Setter for <code>asmregen.testsplugins.id</code>.
	 */
	public void setId(java.lang.Integer value) {
		setValue(0, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.id</code>.
	 */
	public java.lang.Integer getId() {
		return (java.lang.Integer) getValue(0);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.description</code>.
	 */
	public void setDescription(java.lang.String value) {
		setValue(1, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.description</code>.
	 */
	public java.lang.String getDescription() {
		return (java.lang.String) getValue(1);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.pluginName</code>.
	 */
	public void setPluginname(java.lang.String value) {
		setValue(2, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.pluginName</code>.
	 */
	public java.lang.String getPluginname() {
		return (java.lang.String) getValue(2);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.pluginType</code>.
	 */
	public void setPlugintype(java.lang.String value) {
		setValue(3, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.pluginType</code>.
	 */
	public java.lang.String getPlugintype() {
		return (java.lang.String) getValue(3);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.pluginDescription</code>.
	 */
	public void setPlugindescription(java.lang.String value) {
		setValue(4, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.pluginDescription</code>.
	 */
	public java.lang.String getPlugindescription() {
		return (java.lang.String) getValue(4);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.pluginFile</code>.
	 */
	public void setPluginfile(java.lang.String value) {
		setValue(5, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.pluginFile</code>.
	 */
	public java.lang.String getPluginfile() {
		return (java.lang.String) getValue(5);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.pluginConfig</code>.
	 */
	public void setPluginconfig(java.lang.String value) {
		setValue(6, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.pluginConfig</code>.
	 */
	public java.lang.String getPluginconfig() {
		return (java.lang.String) getValue(6);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.config</code>.
	 */
	public void setConfig(java.lang.String value) {
		setValue(7, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.config</code>.
	 */
	public java.lang.String getConfig() {
		return (java.lang.String) getValue(7);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.input</code>.
	 */
	public void setInput(java.lang.String value) {
		setValue(8, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.input</code>.
	 */
	public java.lang.String getInput() {
		return (java.lang.String) getValue(8);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.status</code>.
	 */
	public void setStatus(java.lang.String value) {
		setValue(9, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.status</code>.
	 */
	public java.lang.String getStatus() {
		return (java.lang.String) getValue(9);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.success</code>.
	 */
	public void setSuccess(java.lang.Integer value) {
		setValue(10, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.success</code>.
	 */
	public java.lang.Integer getSuccess() {
		return (java.lang.Integer) getValue(10);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.info</code>.
	 */
	public void setInfo(java.lang.String value) {
		setValue(11, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.info</code>.
	 */
	public java.lang.String getInfo() {
		return (java.lang.String) getValue(11);
	}

	/**
	 * Setter for <code>asmregen.testsplugins.output</code>.
	 */
	public void setOutput(java.lang.String value) {
		setValue(12, value);
	}

	/**
	 * Getter for <code>asmregen.testsplugins.output</code>.
	 */
	public java.lang.String getOutput() {
		return (java.lang.String) getValue(12);
	}

	// -------------------------------------------------------------------------
	// Record13 type implementation
	// -------------------------------------------------------------------------

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row13<java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.Integer, java.lang.String, java.lang.String> fieldsRow() {
		return (org.jooq.Row13) super.fieldsRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row13<java.lang.Integer, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.String, java.lang.Integer, java.lang.String, java.lang.String> valuesRow() {
		return (org.jooq.Row13) super.valuesRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field1() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.ID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field2() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.DESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field3() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.PLUGINNAME;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field4() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.PLUGINTYPE;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field5() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.PLUGINDESCRIPTION;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field6() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.PLUGINFILE;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field7() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.PLUGINCONFIG;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field8() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.CONFIG;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field9() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.INPUT;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field10() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.STATUS;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field11() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.SUCCESS;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field12() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.INFO;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field13() {
		return sooth.entities.tables.Testsplugins.TESTSPLUGINS.OUTPUT;
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
		return getDescription();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value3() {
		return getPluginname();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value4() {
		return getPlugintype();
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
	public java.lang.String value6() {
		return getPluginfile();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value7() {
		return getPluginconfig();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value8() {
		return getConfig();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value9() {
		return getInput();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value10() {
		return getStatus();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value11() {
		return getSuccess();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value12() {
		return getInfo();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value13() {
		return getOutput();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value1(java.lang.Integer value) {
		setId(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value2(java.lang.String value) {
		setDescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value3(java.lang.String value) {
		setPluginname(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value4(java.lang.String value) {
		setPlugintype(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value5(java.lang.String value) {
		setPlugindescription(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value6(java.lang.String value) {
		setPluginfile(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value7(java.lang.String value) {
		setPluginconfig(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value8(java.lang.String value) {
		setConfig(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value9(java.lang.String value) {
		setInput(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value10(java.lang.String value) {
		setStatus(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value11(java.lang.Integer value) {
		setSuccess(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value12(java.lang.String value) {
		setInfo(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord value13(java.lang.String value) {
		setOutput(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public TestspluginsRecord values(java.lang.Integer value1, java.lang.String value2, java.lang.String value3, java.lang.String value4, java.lang.String value5, java.lang.String value6, java.lang.String value7, java.lang.String value8, java.lang.String value9, java.lang.String value10, java.lang.Integer value11, java.lang.String value12, java.lang.String value13) {
		return this;
	}

	// -------------------------------------------------------------------------
	// Constructors
	// -------------------------------------------------------------------------

	/**
	 * Create a detached TestspluginsRecord
	 */
	public TestspluginsRecord() {
		super(sooth.entities.tables.Testsplugins.TESTSPLUGINS);
	}

	/**
	 * Create a detached, initialised TestspluginsRecord
	 */
	public TestspluginsRecord(java.lang.Integer id, java.lang.String description, java.lang.String pluginname, java.lang.String plugintype, java.lang.String plugindescription, java.lang.String pluginfile, java.lang.String pluginconfig, java.lang.String config, java.lang.String input, java.lang.String status, java.lang.Integer success, java.lang.String info, java.lang.String output) {
		super(sooth.entities.tables.Testsplugins.TESTSPLUGINS);

		setValue(0, id);
		setValue(1, description);
		setValue(2, pluginname);
		setValue(3, plugintype);
		setValue(4, plugindescription);
		setValue(5, pluginfile);
		setValue(6, pluginconfig);
		setValue(7, config);
		setValue(8, input);
		setValue(9, status);
		setValue(10, success);
		setValue(11, info);
		setValue(12, output);
	}
}
