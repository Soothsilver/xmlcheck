/**
 * This class is generated by jOOQ
 */
package sooth.entities.tables;

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
public class Usersprivileges extends org.jooq.impl.TableImpl<sooth.entities.tables.records.UsersprivilegesRecord> {

	private static final long serialVersionUID = 621172633;

	/**
	 * The reference instance of <code>asmregen.usersprivileges</code>
	 */
	public static final sooth.entities.tables.Usersprivileges USERSPRIVILEGES = new sooth.entities.tables.Usersprivileges();

	/**
	 * The class holding records for this type
	 */
	@Override
	public java.lang.Class<sooth.entities.tables.records.UsersprivilegesRecord> getRecordType() {
		return sooth.entities.tables.records.UsersprivilegesRecord.class;
	}

	/**
	 * The column <code>asmregen.usersprivileges.id</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.Integer> ID = createField("id", org.jooq.impl.SQLDataType.INTEGER.nullable(false).defaulted(true), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.name</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.String> NAME = createField("name", org.jooq.impl.SQLDataType.VARCHAR.length(255).nullable(false), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.pass</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.String> PASS = createField("pass", org.jooq.impl.SQLDataType.VARCHAR.length(255).nullable(false), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.typeId</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.Integer> TYPEID = createField("typeId", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * The column <code>asmregen.usersprivileges.type</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.String> TYPE = createField("type", org.jooq.impl.SQLDataType.VARCHAR.length(20).nullable(false), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.privileges</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.Integer> PRIVILEGES = createField("privileges", org.jooq.impl.SQLDataType.INTEGER.nullable(false), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.realName</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.String> REALNAME = createField("realName", org.jooq.impl.SQLDataType.VARCHAR.length(30).nullable(false), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.email</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.String> EMAIL = createField("email", org.jooq.impl.SQLDataType.VARCHAR.length(50).nullable(false), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.lastAccess</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.sql.Timestamp> LASTACCESS = createField("lastAccess", org.jooq.impl.SQLDataType.TIMESTAMP.nullable(false), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.activationCode</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.String> ACTIVATIONCODE = createField("activationCode", org.jooq.impl.SQLDataType.VARCHAR.length(32).nullable(false), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.encryptionType</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.String> ENCRYPTIONTYPE = createField("encryptionType", org.jooq.impl.SQLDataType.VARCHAR.length(255).nullable(false), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.send_email_on_submission_rated</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.Byte> SEND_EMAIL_ON_SUBMISSION_RATED = createField("send_email_on_submission_rated", org.jooq.impl.SQLDataType.TINYINT.nullable(false), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.send_email_on_new_assignment</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.Byte> SEND_EMAIL_ON_NEW_ASSIGNMENT = createField("send_email_on_new_assignment", org.jooq.impl.SQLDataType.TINYINT.nullable(false), this, "");

	/**
	 * The column <code>asmregen.usersprivileges.send_email_on_new_submission</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersprivilegesRecord, java.lang.Byte> SEND_EMAIL_ON_NEW_SUBMISSION = createField("send_email_on_new_submission", org.jooq.impl.SQLDataType.TINYINT.nullable(false), this, "");

	/**
	 * Create a <code>asmregen.usersprivileges</code> table reference
	 */
	public Usersprivileges() {
		this("usersprivileges", null);
	}

	/**
	 * Create an aliased <code>asmregen.usersprivileges</code> table reference
	 */
	public Usersprivileges(java.lang.String alias) {
		this(alias, sooth.entities.tables.Usersprivileges.USERSPRIVILEGES);
	}

	private Usersprivileges(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.UsersprivilegesRecord> aliased) {
		this(alias, aliased, null);
	}

	private Usersprivileges(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.UsersprivilegesRecord> aliased, org.jooq.Field<?>[] parameters) {
		super(alias, sooth.entities.Asmregen.ASMREGEN, aliased, parameters, "VIEW");
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public sooth.entities.tables.Usersprivileges as(java.lang.String alias) {
		return new sooth.entities.tables.Usersprivileges(alias, this);
	}

	/**
	 * Rename this table
	 */
	public sooth.entities.tables.Usersprivileges rename(java.lang.String name) {
		return new sooth.entities.tables.Usersprivileges(name, null);
	}
}