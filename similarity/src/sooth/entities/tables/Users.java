/**
 * This class is generated by jOOQ
 */
package sooth.entities.tables;

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
public class Users extends org.jooq.impl.TableImpl<sooth.entities.tables.records.UsersRecord> {

	private static final long serialVersionUID = -1048284723;

	/**
	 * The reference instance of <code>asmregen.users</code>
	 */
	public static final sooth.entities.tables.Users USERS = new sooth.entities.tables.Users();

	/**
	 * The class holding records for this type
	 */
	@Override
	public java.lang.Class<sooth.entities.tables.records.UsersRecord> getRecordType() {
		return sooth.entities.tables.records.UsersRecord.class;
	}

	/**
	 * The column <code>asmregen.users.id</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.Integer> ID = createField("id", org.jooq.impl.SQLDataType.INTEGER.nullable(false), this, "");

	/**
	 * The column <code>asmregen.users.name</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.String> NAME = createField("name", org.jooq.impl.SQLDataType.VARCHAR.length(255).nullable(false), this, "");

	/**
	 * The column <code>asmregen.users.type</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.Integer> TYPE = createField("type", org.jooq.impl.SQLDataType.INTEGER, this, "");

	/**
	 * The column <code>asmregen.users.pass</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.String> PASS = createField("pass", org.jooq.impl.SQLDataType.VARCHAR.length(255).nullable(false), this, "");

	/**
	 * The column <code>asmregen.users.realName</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.String> REALNAME = createField("realName", org.jooq.impl.SQLDataType.VARCHAR.length(30).nullable(false), this, "");

	/**
	 * The column <code>asmregen.users.email</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.String> EMAIL = createField("email", org.jooq.impl.SQLDataType.VARCHAR.length(50).nullable(false), this, "");

	/**
	 * The column <code>asmregen.users.lastAccess</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.sql.Timestamp> LASTACCESS = createField("lastAccess", org.jooq.impl.SQLDataType.TIMESTAMP.nullable(false), this, "");

	/**
	 * The column <code>asmregen.users.activationCode</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.String> ACTIVATIONCODE = createField("activationCode", org.jooq.impl.SQLDataType.VARCHAR.length(32).nullable(false), this, "");

	/**
	 * The column <code>asmregen.users.encryptionType</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.String> ENCRYPTIONTYPE = createField("encryptionType", org.jooq.impl.SQLDataType.VARCHAR.length(255).nullable(false), this, "");

	/**
	 * The column <code>asmregen.users.resetLink</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.String> RESETLINK = createField("resetLink", org.jooq.impl.SQLDataType.VARCHAR.length(255), this, "");

	/**
	 * The column <code>asmregen.users.resetLinkExpiry</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.sql.Timestamp> RESETLINKEXPIRY = createField("resetLinkExpiry", org.jooq.impl.SQLDataType.TIMESTAMP, this, "");

	/**
	 * The column <code>asmregen.users.send_email_on_submission_rated</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.Byte> SEND_EMAIL_ON_SUBMISSION_RATED = createField("send_email_on_submission_rated", org.jooq.impl.SQLDataType.TINYINT.nullable(false), this, "");

	/**
	 * The column <code>asmregen.users.send_email_on_new_assignment</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.Byte> SEND_EMAIL_ON_NEW_ASSIGNMENT = createField("send_email_on_new_assignment", org.jooq.impl.SQLDataType.TINYINT.nullable(false), this, "");

	/**
	 * The column <code>asmregen.users.send_email_on_new_submission</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.Byte> SEND_EMAIL_ON_NEW_SUBMISSION = createField("send_email_on_new_submission", org.jooq.impl.SQLDataType.TINYINT.nullable(false), this, "");

	/**
	 * The column <code>asmregen.users.deleted</code>.
	 */
	public final org.jooq.TableField<sooth.entities.tables.records.UsersRecord, java.lang.Byte> DELETED = createField("deleted", org.jooq.impl.SQLDataType.TINYINT.nullable(false), this, "");

	/**
	 * Create a <code>asmregen.users</code> table reference
	 */
	public Users() {
		this("users", null);
	}

	/**
	 * Create an aliased <code>asmregen.users</code> table reference
	 */
	public Users(java.lang.String alias) {
		this(alias, sooth.entities.tables.Users.USERS);
	}

	private Users(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.UsersRecord> aliased) {
		this(alias, aliased, null);
	}

	private Users(java.lang.String alias, org.jooq.Table<sooth.entities.tables.records.UsersRecord> aliased, org.jooq.Field<?>[] parameters) {
		super(alias, sooth.entities.Asmregen.ASMREGEN, aliased, parameters, "");
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.Identity<sooth.entities.tables.records.UsersRecord, java.lang.Integer> getIdentity() {
		return sooth.entities.Keys.IDENTITY_USERS;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public org.jooq.UniqueKey<sooth.entities.tables.records.UsersRecord> getPrimaryKey() {
		return sooth.entities.Keys.KEY_USERS_PRIMARY;
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.UniqueKey<sooth.entities.tables.records.UsersRecord>> getKeys() {
		return java.util.Arrays.<org.jooq.UniqueKey<sooth.entities.tables.records.UsersRecord>>asList(sooth.entities.Keys.KEY_USERS_PRIMARY, sooth.entities.Keys.KEY_USERS_NAME);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public java.util.List<org.jooq.ForeignKey<sooth.entities.tables.records.UsersRecord, ?>> getReferences() {
		return java.util.Arrays.<org.jooq.ForeignKey<sooth.entities.tables.records.UsersRecord, ?>>asList(sooth.entities.Keys.FK_1483A5E98CDE5729);
	}

	/**
	 * {@inheritDoc}
	 */
	@Override
	public sooth.entities.tables.Users as(java.lang.String alias) {
		return new sooth.entities.tables.Users(alias, this);
	}

	/**
	 * Rename this table
	 */
	public sooth.entities.tables.Users rename(java.lang.String name) {
		return new sooth.entities.tables.Users(name, null);
	}
}
