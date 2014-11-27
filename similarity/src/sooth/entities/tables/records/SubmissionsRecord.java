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
public class SubmissionsRecord extends org.jooq.impl.UpdatableRecordImpl<sooth.entities.tables.records.SubmissionsRecord> implements org.jooq.Record11<java.lang.Integer, java.lang.Integer, java.lang.Integer, java.lang.String, java.sql.Timestamp, java.lang.String, java.lang.Integer, java.lang.String, java.lang.String, java.lang.Integer, java.lang.String> {

	private static final long serialVersionUID = -799571461;

	/**
	 * Setter for <code>asmregen.submissions.id</code>.
	 */
	public void setId(java.lang.Integer value) {
		setValue(0, value);
	}

	/**
	 * Getter for <code>asmregen.submissions.id</code>.
	 */
	public java.lang.Integer getId() {
		return (java.lang.Integer) getValue(0);
	}

	/**
	 * Setter for <code>asmregen.submissions.assignmentId</code>.
	 */
	public void setAssignmentid(java.lang.Integer value) {
		setValue(1, value);
	}

	/**
	 * Getter for <code>asmregen.submissions.assignmentId</code>.
	 */
	public java.lang.Integer getAssignmentid() {
		return (java.lang.Integer) getValue(1);
	}

	/**
	 * Setter for <code>asmregen.submissions.userId</code>.
	 */
	public void setUserid(java.lang.Integer value) {
		setValue(2, value);
	}

	/**
	 * Getter for <code>asmregen.submissions.userId</code>.
	 */
	public java.lang.Integer getUserid() {
		return (java.lang.Integer) getValue(2);
	}

	/**
	 * Setter for <code>asmregen.submissions.submissionFile</code>.
	 */
	public void setSubmissionfile(java.lang.String value) {
		setValue(3, value);
	}

	/**
	 * Getter for <code>asmregen.submissions.submissionFile</code>.
	 */
	public java.lang.String getSubmissionfile() {
		return (java.lang.String) getValue(3);
	}

	/**
	 * Setter for <code>asmregen.submissions.date</code>.
	 */
	public void setDate(java.sql.Timestamp value) {
		setValue(4, value);
	}

	/**
	 * Getter for <code>asmregen.submissions.date</code>.
	 */
	public java.sql.Timestamp getDate() {
		return (java.sql.Timestamp) getValue(4);
	}

	/**
	 * Setter for <code>asmregen.submissions.status</code>.
	 */
	public void setStatus(java.lang.String value) {
		setValue(5, value);
	}

	/**
	 * Getter for <code>asmregen.submissions.status</code>.
	 */
	public java.lang.String getStatus() {
		return (java.lang.String) getValue(5);
	}

	/**
	 * Setter for <code>asmregen.submissions.success</code>.
	 */
	public void setSuccess(java.lang.Integer value) {
		setValue(6, value);
	}

	/**
	 * Getter for <code>asmregen.submissions.success</code>.
	 */
	public java.lang.Integer getSuccess() {
		return (java.lang.Integer) getValue(6);
	}

	/**
	 * Setter for <code>asmregen.submissions.info</code>.
	 */
	public void setInfo(java.lang.String value) {
		setValue(7, value);
	}

	/**
	 * Getter for <code>asmregen.submissions.info</code>.
	 */
	public java.lang.String getInfo() {
		return (java.lang.String) getValue(7);
	}

	/**
	 * Setter for <code>asmregen.submissions.outputFile</code>.
	 */
	public void setOutputfile(java.lang.String value) {
		setValue(8, value);
	}

	/**
	 * Getter for <code>asmregen.submissions.outputFile</code>.
	 */
	public java.lang.String getOutputfile() {
		return (java.lang.String) getValue(8);
	}

	/**
	 * Setter for <code>asmregen.submissions.rating</code>.
	 */
	public void setRating(java.lang.Integer value) {
		setValue(9, value);
	}

	/**
	 * Getter for <code>asmregen.submissions.rating</code>.
	 */
	public java.lang.Integer getRating() {
		return (java.lang.Integer) getValue(9);
	}

	/**
	 * Setter for <code>asmregen.submissions.explanation</code>.
	 */
	public void setExplanation(java.lang.String value) {
		setValue(10, value);
	}

	/**
	 * Getter for <code>asmregen.submissions.explanation</code>.
	 */
	public java.lang.String getExplanation() {
		return (java.lang.String) getValue(10);
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
	// Record11 type implementation
	// -------------------------------------------------------------------------

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row11<java.lang.Integer, java.lang.Integer, java.lang.Integer, java.lang.String, java.sql.Timestamp, java.lang.String, java.lang.Integer, java.lang.String, java.lang.String, java.lang.Integer, java.lang.String> fieldsRow() {
		return (org.jooq.Row11) super.fieldsRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Row11<java.lang.Integer, java.lang.Integer, java.lang.Integer, java.lang.String, java.sql.Timestamp, java.lang.String, java.lang.Integer, java.lang.String, java.lang.String, java.lang.Integer, java.lang.String> valuesRow() {
		return (org.jooq.Row11) super.valuesRow();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field1() {
		return sooth.entities.tables.Submissions.SUBMISSIONS.ID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field2() {
		return sooth.entities.tables.Submissions.SUBMISSIONS.ASSIGNMENTID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field3() {
		return sooth.entities.tables.Submissions.SUBMISSIONS.USERID;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field4() {
		return sooth.entities.tables.Submissions.SUBMISSIONS.SUBMISSIONFILE;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.sql.Timestamp> field5() {
		return sooth.entities.tables.Submissions.SUBMISSIONS.DATE;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field6() {
		return sooth.entities.tables.Submissions.SUBMISSIONS.STATUS;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field7() {
		return sooth.entities.tables.Submissions.SUBMISSIONS.SUCCESS;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field8() {
		return sooth.entities.tables.Submissions.SUBMISSIONS.INFO;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field9() {
		return sooth.entities.tables.Submissions.SUBMISSIONS.OUTPUTFILE;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.Integer> field10() {
		return sooth.entities.tables.Submissions.SUBMISSIONS.RATING;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Field<java.lang.String> field11() {
		return sooth.entities.tables.Submissions.SUBMISSIONS.EXPLANATION;
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
		return getAssignmentid();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value3() {
		return getUserid();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value4() {
		return getSubmissionfile();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.sql.Timestamp value5() {
		return getDate();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value6() {
		return getStatus();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value7() {
		return getSuccess();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value8() {
		return getInfo();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value9() {
		return getOutputfile();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.Integer value10() {
		return getRating();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.lang.String value11() {
		return getExplanation();
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord value1(java.lang.Integer value) {
		setId(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord value2(java.lang.Integer value) {
		setAssignmentid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord value3(java.lang.Integer value) {
		setUserid(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord value4(java.lang.String value) {
		setSubmissionfile(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord value5(java.sql.Timestamp value) {
		setDate(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord value6(java.lang.String value) {
		setStatus(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord value7(java.lang.Integer value) {
		setSuccess(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord value8(java.lang.String value) {
		setInfo(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord value9(java.lang.String value) {
		setOutputfile(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord value10(java.lang.Integer value) {
		setRating(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord value11(java.lang.String value) {
		setExplanation(value);
		return this;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public SubmissionsRecord values(java.lang.Integer value1, java.lang.Integer value2, java.lang.Integer value3, java.lang.String value4, java.sql.Timestamp value5, java.lang.String value6, java.lang.Integer value7, java.lang.String value8, java.lang.String value9, java.lang.Integer value10, java.lang.String value11) {
		return this;
	}

	// -------------------------------------------------------------------------
	// Constructors
	// -------------------------------------------------------------------------

	/**
	 * Create a detached SubmissionsRecord
	 */
	public SubmissionsRecord() {
		super(sooth.entities.tables.Submissions.SUBMISSIONS);
	}

	/**
	 * Create a detached, initialised SubmissionsRecord
	 */
	public SubmissionsRecord(java.lang.Integer id, java.lang.Integer assignmentid, java.lang.Integer userid, java.lang.String submissionfile, java.sql.Timestamp date, java.lang.String status, java.lang.Integer success, java.lang.String info, java.lang.String outputfile, java.lang.Integer rating, java.lang.String explanation) {
		super(sooth.entities.tables.Submissions.SUBMISSIONS);

		setValue(0, id);
		setValue(1, assignmentid);
		setValue(2, userid);
		setValue(3, submissionfile);
		setValue(4, date);
		setValue(5, status);
		setValue(6, success);
		setValue(7, info);
		setValue(8, outputfile);
		setValue(9, rating);
		setValue(10, explanation);
	}
}