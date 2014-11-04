<?php

namespace asm\db;

/**
 * Real database structure described in abstract terms @phpenum @singleton.
 *
 * Real table & field names are used only by QueryManager for abstract query
 * creation and are translated back to defined constants in request results.
 * Core classes refer to fields by @ref DbLayout "DbLayout::field*" constants.
 */
class DbLayout
{
	const defaultUsertypeId = 0;
	const rootUsertypeId = 1;
	const rootUserId = 0;

	/// @name Real tables in database (support all operations)
	//@{
	const tableAssignments		=	1;		///< assignments
	const tableGroups				=	2;		///< groups
	const tableLectures			=	3;		///< lectures
	const tablePlugins			=	4;		///< plugins
	const tablePrivileges		=	5;		///< user types
	const tableProblems			=	6;		///< problems
	const tableSubmissions		=	7;		///< problem solution submissions
	const tableSubscriptions	=	8;		///< group subscriptions
	const tableTests				=	9;		///< plugin tests
	const tableUsers				=	10;	///< users
	const tableQuestions			=	11;	///< test questions
	const tableGenTests			=	12;	///< tests (generated)
	const tableAttachments		=	13;	///< attachments for test questions
    const tableEmailNotificationSettings = 14;
	//@}

	/// @name Virtual tables in database (support only select operation)
	//@{
	/// assignments with their owners (+ problem & lecture data)
	const viewAssignmentsProblemsLecturesGroups					=	101;
	/// groups with lectures they belong to
	const viewGroupsLectures											=	102;
	/// problems with lectures they belong to
	const viewProblemsLectures											=	103;
	/// problems with plugins used by them
	const viewProblemsPlugins											=	104;
	/// submissions with their submitter (+ assignment, problem, lecture & group data)
	const viewSubmissionsAssignmentsProblemsLecturesGroups	=	105;
	/// submissions with their assignment owner (+ assignment, problem, lecture
	/// & group data)
	const viewSubmissionsFullWithOwners								=	106;
	/// subscriptions (+ group & lecture data)
	const viewSubscriptionsGroupsLectures							=	108;
	/// assignments with users subscribed to their groups (+ problem, lecture,
	/// group data & number of confirmed submissions for that assignment by that user)
	const viewUsersAssignmentsProblemsLecturesGroupsWithSubmissionCount	=	110;
	/// users (+ user type data)
	const viewUsersPrivileges											=	111;
	/// submissions with their problems' plugins (+ assignment & problem data)
	const viewSubmissionsAssignmentsProblemsPlugins				=	112;
	/// plugin tests with their plugins
	const viewTestsPlugins												=	113;
	/// requested subscriptions with their group owners (+ group data)
	const viewSubscriptionRequests									=	114;
	/// sum of user's submissions' ratings for each group (+ group & lecture data)
	const viewUserGroupRating											=	115;
	/// sum of user's submissions' ratings for each group with group owner Id (+ group & lecture data)
	const viewUserGroupRatingWithOwners								=	116;
	/// submission ratings for individual submissions w/ all necessary details
	const viewUserSubmissionRating									=	117;
	/// questions with their lectures
	const viewQuestionsLectures										=	118;
	/// generated tests with their lectures
	const viewGenTestsLectures											=	119;
	/// question attachments with their lectures
	const viewAttachmentsLectures										=	120;
	//@}

	/// @name Field types
	//@{
	const typeId		=	200;	///< ID (non-negative integer, in most cases positive)
	const typeDate		=	201;	///< date in "YYYY-MM-DD hh:mm:ss" format
	const typeEnum		=	202;	///< enum (has specific finite set of values)
	const typeInteger	=	203;	///< integer with up to 9 digits, signed
	const typeNumber	=	204;	///< unsigned integer with custom length
	const typeVarchar	=	205;	///< string with custom length
	const typeText		=	206;	///< string with unrestricted length
	//@}

	/// @name Field flags (indicating field properties)
	//@{
	const flagNumeric	=	0x01;	///< indicates field is numeric (as opposed to string)
	//@}

	/// @name 'Fields' (item properties) in database (self-explanatory semantic identification)
	//@{
	const fieldAssignmentId					=	300;
	const fieldAssignmentDeadline			=	301;
	const fieldAssignmentReward			=	302;
	const fieldGroupId						=	310;
	const fieldGroupName						=	311;
	const fieldGroupDescription			=	312;
	const fieldGroupType						=	313;
	const fieldLectureId						=	320;
	const fieldLectureName					=	321;
	const fieldLectureDescription			=	322;
	const fieldPluginId						=	330;
	const fieldPluginName					=	331;
	const fieldPluginType					=	332;
	const fieldPluginDescription			=	333;
	const fieldPluginMainFile				=	334;
	const fieldPluginArguments				=	335;
	const fieldProblemId						=	340;
	const fieldProblemName					=	341;
	const fieldProblemDescription			=	342;
	const fieldProblemPluginArguments	=	343;
	const fieldSubmissionId					=	350;
	const fieldSubmissionFile				=	351;
	const fieldSubmissionDate				=	352;
	const fieldSubmissionStatus			=	353;
	const fieldSubmissionFulfillment		=	354;
	const fieldSubmissionDetails			=	355;
	const fieldSubmissionOutputFile		=	356;
	const fieldSubmissionRating			=	357;
    const fieldSubmissionExplanation    =   358;
	const fieldSubscriptionId				=	360;
	const fieldSubscriptionStatus			=	361;
	const fieldTestId							=	390;
	const fieldTestDescription				=	391;
	const fieldTestConfig					=	392;
	const fieldTestInput						=	393;
	const fieldTestStatus					=	394;
	const fieldTestFulfillment				=	395;
	const fieldTestDetails					=	396;
	const fieldTestOutput					=	397;
	const fieldUserId							=	370;
	const fieldUserName						=	371;
	const fieldUserPassword					=	372;
	const fieldUserRealName					=	373;
	const fieldUserEmail						=	374;
	const fieldUserLastAccess				=	375;
	const fieldUserActivationCode			=	376;
    const fieldUserEncryptionType = 377;
    const fieldUserResetLink = 378;
    const fieldUserResetLinkExpiry = 379;
	const fieldUsertypeId					=	380;
	const fieldUsertypeName					=	381;
	const fieldUsertypePrivileges			=	382;
	const fieldQuestionId					=	400;
	const fieldQuestionText					=	401;
	const fieldQuestionType					=	402;
	const fieldQuestionOptions				=	403;
	const fieldQuestionAttachments		=	404;
	const fieldGenTestId						=	410;
	const fieldGenTestDescription			=	411;
	const fieldGenTestTemplate				=	412;
	const fieldGenTestCount					=	413;
	const fieldGenTestGenerated			=	414;
	const fieldAttachmentId					=	420;
	const fieldAttachmentName				=	421;
	const fieldAttachmentType				=	422;
	const fieldAttachmentFile				=	423;

	/// number of user's submissions for specific assignment
	const fieldSpecialCount					=	500;
	const fieldSpecialRatingSum			=	501;
	const fieldSpecialSecondaryId			=	502;


    const fieldEmailNotificationSettingsId = 529;
    const fieldUserOptionSendEmailOnSubmissionRated = 530;
    const fieldUserOptionSendEmailOnNewAssignment = 531;
    const fieldUserOptionSendEmailOnNewSubmission = 532;
	//@}

	private static $instance = null;	///< singleton instance

	/**
	 * (Creates and) gets singleton instance.
	 * @return DbLayout instance
	 */
	public static function instance ()
	{
		if (self::$instance == null)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	/// real table/view names belonging to defined table/view constants
	protected $tables = array(
		self::tableAssignments => 'assignments',
		self::tableGroups => 'groups',
		self::tableLectures => 'lectures',
		self::tablePlugins => 'plugins',
		self::tablePrivileges => 'privileges',
		self::tableProblems => 'problems',
		self::tableSubmissions => 'submissions',
		self::tableSubscriptions => 'subscriptions',
		self::tableTests => 'tests',
		self::tableUsers => 'users',
		self::tableQuestions => 'questions',
		self::tableGenTests => 'xtests',
		self::tableAttachments => 'attachments',
        self::tableEmailNotificationSettings => 'user_email_options',

		self::viewAssignmentsProblemsLecturesGroups => 'assignmentsproblemslecturesgroupsplugins',
		self::viewGroupsLectures => 'groupslectures',
		self::viewProblemsLectures => 'problemslectures',
		self::viewProblemsPlugins => 'problemsplugins',
		self::viewSubmissionsAssignmentsProblemsLecturesGroups => 'submissionsassignmentsproblemslecturesgroups',
		self::viewSubmissionsAssignmentsProblemsPlugins => 'submissionsassignmentsproblemsplugins',
		self::viewSubmissionsFullWithOwners => 'submissionsfullwithowners',
		self::viewSubscriptionsGroupsLectures => 'subscriptionsgroupslectures',
		self::viewUsersAssignmentsProblemsLecturesGroupsWithSubmissionCount => 'alltogether',
		self::viewUsersPrivileges => 'usersprivileges',
		self::viewTestsPlugins => 'testsplugins',
		self::viewSubscriptionRequests => 'subscriptionsusersgroupslectures',
		self::viewUserGroupRating => 'usergrouprating',
		self::viewUserGroupRatingWithOwners => 'usergroupratingwithowners',
		self::viewUserSubmissionRating => 'userssubmissionsconfirmedwithowners',
		self::viewQuestionsLectures => 'questionslectures',
		self::viewGenTestsLectures => 'xtestslectures',
		self::viewAttachmentsLectures => 'attachmentslectures',
	);

	/// structure of base tables and real field names for defined field constants
	protected $fields = array(
		self::tableAssignments => array(
			self::fieldAssignmentId => 'id',
			self::fieldAssignmentDeadline => 'deadline',
			self::fieldAssignmentReward => 'reward',
			self::fieldGroupId => 'groupId',
			self::fieldProblemId => 'problemId',
		),
		self::tableGroups => array(
			self::fieldGroupId => 'id',
			self::fieldGroupName => 'name',
			self::fieldGroupDescription => 'description',
			self::fieldUserId => 'ownerId',
			self::fieldGroupType => 'type',
			self::fieldLectureId => 'lectureId',
		),
		self::tableLectures => array(
			self::fieldLectureId => 'id',
			self::fieldLectureName => 'name',
			self::fieldLectureDescription => 'description',
			self::fieldUserId => 'ownerId',
		),
		self::tablePlugins => array(
			self::fieldPluginId => 'id',
			self::fieldPluginName => 'name',
			self::fieldPluginType => 'type',
			self::fieldPluginDescription => 'description',
			self::fieldPluginMainFile => 'mainFile',
			self::fieldPluginArguments => 'config',
		),
		self::tablePrivileges => array(
			self::fieldUsertypeId => 'id',
			self::fieldUsertypeName => 'name',
			self::fieldUsertypePrivileges => 'privileges',
		),
		self::tableProblems => array(
			self::fieldProblemId => 'id',
			self::fieldProblemName => 'name',
			self::fieldProblemDescription => 'description',
			self::fieldPluginId => 'pluginId',
			self::fieldProblemPluginArguments => 'config',
			self::fieldLectureId => 'lectureId',
		),
		self::tableSubmissions => array(
			self::fieldSubmissionId => 'id',
			self::fieldAssignmentId => 'assignmentId',
			self::fieldUserId => 'userId',
			self::fieldSubmissionFile => 'submissionFile',
			self::fieldSubmissionDate => 'date',
			self::fieldSubmissionStatus => 'status',
			self::fieldSubmissionFulfillment => 'success',
			self::fieldSubmissionDetails => 'info',
			self::fieldSubmissionOutputFile => 'outputFile',
			self::fieldSubmissionRating => 'rating',
            self::fieldSubmissionExplanation => 'explanation'
		),
		self::tableSubscriptions => array(
			self::fieldSubscriptionId => 'id',
			self::fieldUserId => 'userId',
			self::fieldGroupId => 'groupId',
			self::fieldSubscriptionStatus => 'status',
		),
		self::tableTests => array(
			self::fieldTestId => 'id',
			self::fieldTestDescription => 'description',
			self::fieldPluginId => 'pluginId',
			self::fieldTestConfig => 'config',
			self::fieldTestInput => 'input',
			self::fieldTestStatus => 'status',
			self::fieldTestFulfillment => 'success',
			self::fieldTestDetails => 'info',
			self::fieldTestOutput => 'output',
		),
		self::tableUsers => array(
			self::fieldUserId => 'id',
			self::fieldUserName => 'name',
			self::fieldUsertypeId => 'type',
			self::fieldUserPassword => 'pass',
			self::fieldUserRealName => 'realName',
			self::fieldUserEmail => 'email',
			self::fieldUserLastAccess => 'lastAccess',
			self::fieldUserActivationCode => 'activationCode',
            self::fieldUserEncryptionType => 'encryptionType',
            self::fieldUserResetLink => 'resetLink',
            self::fieldUserResetLinkExpiry => 'resetLinkExpiry'
		),
		self::tableQuestions => array(
			self::fieldQuestionId => 'id',
			self::fieldQuestionText => 'text',
			self::fieldQuestionType => 'type',
			self::fieldQuestionOptions => 'options',
			self::fieldQuestionAttachments => 'attachments',
			self::fieldLectureId => 'lectureId',
		),
		self::tableGenTests => array(
			self::fieldGenTestId => 'id',
			self::fieldGenTestDescription => 'description',
			self::fieldGenTestTemplate => 'template',
			self::fieldGenTestCount => 'count',
			self::fieldGenTestGenerated => 'generated',
			self::fieldLectureId => 'lectureId',
		),
		self::tableAttachments => array(
			self::fieldAttachmentId => 'id',
			self::fieldAttachmentName => 'name',
			self::fieldAttachmentType => 'type',
			self::fieldAttachmentFile => 'file',
			self::fieldLectureId => 'lectureId',
		),
        self::tableEmailNotificationSettings => array(
           self::fieldEmailNotificationSettingsId => 'id',
            self::fieldUserOptionSendEmailOnNewAssignment => 'send_email_on_new_assignment',
            self::fieldUserOptionSendEmailOnNewSubmission => 'send_email_on_new_submission',
            self::fieldUserOptionSendEmailOnSubmissionRated => 'send_email_on_submission_rated',
            self::fieldUserId => 'userId'
        ),


		self::viewAssignmentsProblemsLecturesGroups => array(
			self::fieldAssignmentId => 'id',
			self::fieldProblemId => 'problemId',
			self::fieldProblemName => 'problemName',
			self::fieldProblemDescription => 'problemDescription',
			self::fieldPluginDescription => 'pluginDescription',
			self::fieldAssignmentDeadline => 'deadline',
			self::fieldAssignmentReward => 'reward',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
			self::fieldGroupName => 'groupName',
			self::fieldGroupDescription => 'groupDescription',
			self::fieldUserId => 'ownerId',
			self::fieldGroupType => 'groupType',
			self::fieldGroupId => 'groupId',
		),
		self::viewGroupsLectures => array(
			self::fieldGroupId => 'id',
			self::fieldGroupName => 'name',
			self::fieldGroupDescription => 'description',
			self::fieldUserId => 'ownerId',
			self::fieldGroupType => 'type',
			self::fieldLectureId => 'lectureId',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
		),
		self::viewProblemsLectures => array(
			self::fieldProblemId => 'id',
			self::fieldProblemName => 'problemName',
			self::fieldProblemDescription => 'problemDescription',
			self::fieldPluginId => 'pluginId',
			self::fieldProblemPluginArguments => 'config',
			self::fieldLectureId => 'lectureId',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
			self::fieldUserId => 'ownerId',
		),
		self::viewProblemsPlugins => array(
			self::fieldProblemId => 'id',
			self::fieldProblemName => 'problemName',
			self::fieldProblemDescription => 'problemDescription',
			self::fieldProblemPluginArguments => 'problemConfig',
			self::fieldPluginName => 'pluginName',
			self::fieldPluginType => 'pluginType',
			self::fieldPluginDescription => 'pluginDescription',
			self::fieldPluginMainFile => 'pluginMainFile',
			self::fieldPluginArguments => 'pluginConfig',
		),
		self::viewSubmissionsAssignmentsProblemsLecturesGroups => array(
			self::fieldSubmissionId => 'id',
			self::fieldAssignmentId => 'assignmentId',
			self::fieldGroupId => 'groupId',
			self::fieldUserId => 'userId',
			self::fieldSubmissionFile => 'submissionFile',
			self::fieldSubmissionDate => 'date',
			self::fieldSubmissionStatus => 'status',
			self::fieldSubmissionFulfillment => 'success',
			self::fieldSubmissionDetails => 'info',
			self::fieldSubmissionOutputFile => 'outputFile',
			self::fieldSubmissionRating => 'rating',
            self::fieldSubmissionExplanation => 'explanation',
			self::fieldProblemName => 'problemName',
			self::fieldProblemDescription => 'problemDescription',
			self::fieldAssignmentDeadline => 'deadline',
			self::fieldAssignmentReward => 'reward',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
			self::fieldGroupName => 'groupName',
			self::fieldGroupDescription => 'groupDescription',
		),
		self::viewSubmissionsFullWithOwners => array(
			self::fieldSubmissionId => 'id',
			self::fieldAssignmentId => 'assignmentId',
			self::fieldGroupId => 'groupId',
			self::fieldSpecialSecondaryId => 'userId',
			self::fieldUserId => 'ownerId',
			self::fieldSubmissionFile => 'submissionFile',
			self::fieldSubmissionDate => 'date',
			self::fieldSubmissionStatus => 'status',
			self::fieldSubmissionFulfillment => 'success',
			self::fieldSubmissionDetails => 'info',
			self::fieldSubmissionOutputFile => 'outputFile',
			self::fieldSubmissionRating => 'rating',
            self::fieldSubmissionExplanation => 'explanation',
			self::fieldProblemName => 'problemName',
			self::fieldProblemDescription => 'problemDescription',
			self::fieldAssignmentDeadline => 'deadline',
			self::fieldAssignmentReward => 'reward',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
			self::fieldGroupName => 'groupName',
			self::fieldGroupDescription => 'groupDescription',
			self::fieldUserRealName => 'realName',
		),
		self::viewSubscriptionsGroupsLectures => array(
			self::fieldSubscriptionId => 'id',
			self::fieldUserId => 'userId',
			self::fieldSubscriptionStatus => 'status',
			self::fieldGroupName => 'groupName',
			self::fieldGroupDescription => 'groupDescription',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
		),
		self::viewUsersAssignmentsProblemsLecturesGroupsWithSubmissionCount => array(
			self::fieldUserId => 'userId',
			self::fieldAssignmentId => 'assignmentId',
			self::fieldProblemName => 'problemName',
			self::fieldProblemDescription => 'problemDescription',
			self::fieldPluginDescription => 'pluginDescription',
			self::fieldAssignmentDeadline => 'deadline',
			self::fieldAssignmentReward => 'reward',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
			self::fieldGroupName => 'groupName',
			self::fieldGroupDescription => 'groupDescription',
			self::fieldSpecialCount => 'submissionsCount',
		),
		self::viewUsersPrivileges => array(
			self::fieldUserId => 'id',
			self::fieldUserName => 'name',
			self::fieldUserPassword => 'pass',
			self::fieldUsertypeId => 'typeId',
			self::fieldUsertypeName => 'type',
			self::fieldUsertypePrivileges => 'privileges',
			self::fieldUserRealName => 'realName',
			self::fieldUserEmail => 'email',
			self::fieldUserLastAccess => 'lastAccess',
			self::fieldUserActivationCode => 'activationCode',
            self::fieldUserEncryptionType => 'encryptionType',
            self::fieldUserOptionSendEmailOnNewAssignment => 'send_email_on_new_assignment',
            self::fieldUserOptionSendEmailOnNewSubmission => 'send_email_on_new_submission',
            self::fieldUserOptionSendEmailOnSubmissionRated => 'send_email_on_submission_rated'
		),
		self::viewSubmissionsAssignmentsProblemsPlugins => array(
			self::fieldSubmissionId => 'id',
			self::fieldUserId => 'userId',
			self::fieldSubmissionFile => 'submissionFile',
			self::fieldSubmissionDate => 'date',
			self::fieldSubmissionStatus => 'status',
			self::fieldSubmissionFulfillment => 'success',
			self::fieldSubmissionDetails => 'info',
			self::fieldSubmissionOutputFile => 'outputFile',
			self::fieldSubmissionRating => 'rating',
            self::fieldSubmissionExplanation => 'explanation',
			self::fieldAssignmentDeadline => 'deadline',
			self::fieldAssignmentReward => 'reward',
			self::fieldGroupId => 'groupId',
			self::fieldProblemName => 'problemName',
			self::fieldProblemDescription => 'problemDescription',
			self::fieldProblemPluginArguments => 'problemConfig',
			self::fieldPluginName => 'pluginName',
			self::fieldPluginType => 'pluginType',
			self::fieldPluginDescription => 'pluginDescription',
			self::fieldPluginMainFile => 'pluginMainFile',
			self::fieldPluginArguments => 'pluginConfig',
		),
		self::viewTestsPlugins => array(
			self::fieldTestId => 'id',
			self::fieldTestDescription => 'description',
			self::fieldPluginName => 'pluginName',
			self::fieldPluginType => 'pluginType',
			self::fieldPluginDescription => 'pluginDescription',
			self::fieldPluginMainFile => 'pluginFile',
			self::fieldPluginArguments => 'pluginConfig',
			self::fieldTestConfig => 'config',
			self::fieldTestInput => 'input',
			self::fieldTestStatus => 'status',
			self::fieldTestFulfillment => 'success',
			self::fieldTestDetails => 'info',
			self::fieldTestOutput => 'output',
		),
		self::viewSubscriptionRequests => array(
			self::fieldSubscriptionId => 'id',
			self::fieldUserName => 'name',
			self::fieldUserRealName => 'realName',
			self::fieldUserEmail => 'email',
			self::fieldGroupName => 'groupName',
			self::fieldGroupDescription => 'groupDescription',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
			self::fieldUserId => 'ownerId',
		),
		self::viewUserGroupRating => array(
			self::fieldUserId => 'userId',
			self::fieldUserName => 'name',
			self::fieldUserRealName => 'realName',
			self::fieldUserEmail => 'email',
			self::fieldGroupId => 'groupId',
			self::fieldSpecialRatingSum => 'rating',
			self::fieldGroupName => 'groupName',
			self::fieldGroupDescription => 'groupDescription',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
		),
		self::viewUserGroupRatingWithOwners => array(
			self::fieldUserId => 'ownerId',
			self::fieldUserName => 'name',
			self::fieldUserRealName => 'realName',
			self::fieldUserEmail => 'email',
			self::fieldGroupId => 'groupId',
			self::fieldSpecialRatingSum => 'rating',
			self::fieldGroupName => 'groupName',
			self::fieldGroupDescription => 'groupDescription',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
		),
		self::viewUserSubmissionRating => array(
			self::fieldUserId => 'userId',
			self::fieldUserName => 'name',
			self::fieldUserRealName => 'realName',
			self::fieldUserEmail => 'email',
			self::fieldGroupId => 'groupId',
			self::fieldAssignmentId => 'assignmentId',
			self::fieldSubmissionId => 'submissionId',
			self::fieldSubmissionRating => 'rating',
            self::fieldSubmissionExplanation => 'explanation',
			self::fieldAssignmentReward => 'reward',
			self::fieldProblemName => 'problemName',
			self::fieldGroupName => 'groupName',
			self::fieldLectureName => 'lectureName',
			self::fieldSpecialSecondaryId => 'ownerId',
		),
		self::viewQuestionsLectures => array(
			self::fieldQuestionId => 'id',
			self::fieldQuestionText => 'text',
			self::fieldQuestionType => 'type',
			self::fieldQuestionOptions => 'options',
			self::fieldQuestionAttachments => 'attachments',
			self::fieldLectureId => 'lectureId',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
			self::fieldUserId => 'ownerId',
		),
		self::viewGenTestsLectures => array(
			self::fieldGenTestId => 'id',
			self::fieldGenTestDescription => 'description',
			self::fieldGenTestTemplate => 'template',
			self::fieldGenTestCount => 'count',
			self::fieldGenTestGenerated => 'generated',
			self::fieldLectureId => 'lectureId',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
			self::fieldUserId => 'ownerId',
		),
		self::viewAttachmentsLectures => array(
			self::fieldAttachmentId => 'id',
			self::fieldAttachmentName => 'name',
			self::fieldAttachmentType => 'type',
			self::fieldAttachmentFile => 'file',
			self::fieldLectureId => 'lectureId',
			self::fieldLectureName => 'lectureName',
			self::fieldLectureDescription => 'lectureDescription',
			self::fieldUserId => 'ownerId',
		)
	);

	/// detailed field types for defined field constants
	protected $types = array(
		self::fieldAssignmentId => self::typeId,
		self::fieldAssignmentDeadline	 => self::typeDate,
		self::fieldAssignmentReward => self::typeInteger,
		self::fieldGroupId => self::typeId,
		self::fieldGroupName => array(self::typeVarchar, 20),
		self::fieldGroupDescription => self::typeText,
		self::fieldGroupType => array(self::typeEnum, array('public', 'private')),
		self::fieldLectureId => self::typeId,
		self::fieldLectureName => array(self::typeVarchar, 20),
		self::fieldLectureDescription => self::typeText,
		self::fieldPluginId => self::typeId,
		self::fieldPluginName => array(self::typeVarchar, 20),
		self::fieldPluginType => array(self::typeEnum, array('php', 'java', 'exe')),
		self::fieldPluginDescription => self::typeText,
		self::fieldPluginMainFile => array(self::typeVarchar, 100),
		self::fieldPluginArguments => self::typeText,
		self::fieldProblemId => self::typeId,
		self::fieldProblemName => array(self::typeVarchar, 50),
		self::fieldProblemDescription => self::typeText,
		self::fieldProblemPluginArguments => self::typeText,
		self::fieldSubmissionId => self::typeId,
		self::fieldSubmissionFile => array(self::typeVarchar, 100),
		self::fieldSubmissionDate => self::typeDate,
		self::fieldSubmissionStatus => array(self::typeEnum, array('new', 'corrected', 'confirmed', 'rated')),
		self::fieldSubmissionFulfillment => array(self::typeNumber, array(0, 100)),
		self::fieldSubmissionDetails => self::typeText,
		self::fieldSubmissionOutputFile => array(self::typeVarchar, 100),
		self::fieldSubmissionRating => self::typeInteger,
        self::fieldSubmissionExplanation => self::typeText,
		self::fieldSubscriptionId => self::typeId,
		self::fieldSubscriptionStatus => array(self::typeEnum, array('requested', 'subscribed')),
		self::fieldTestId => self::typeId,
		self::fieldTestDescription => array(self::typeVarchar, 50),
		self::fieldTestConfig => self::typeText,
		self::fieldTestInput => array(self::typeVarchar, 100),
		self::fieldTestStatus => array(self::typeEnum, array('running', 'finished')),
		self::fieldTestFulfillment => array(self::typeNumber, array(0, 100)),
		self::fieldTestDetails => self::typeText,
		self::fieldTestOutput => array(self::typeVarchar, 100),
		self::fieldUserId => self::typeId,
		self::fieldUserName => array(self::typeVarchar, 20),
		self::fieldUserPassword => array(self::typeVarchar, 255),
		self::fieldUserRealName => array(self::typeVarchar, 30),
		self::fieldUserEmail => array(self::typeVarchar, 50),
		self::fieldUserLastAccess => self::typeDate,
		self::fieldUserActivationCode => array(self::typeVarchar, 32),
        self::fieldUserEncryptionType => array(self::typeVarchar, 255),
        self::fieldUserResetLink => array(self::typeVarchar, 255),
        self::fieldUserResetLinkExpiry => self::typeDate,
		self::fieldUsertypeId => self::typeId,
		self::fieldUsertypeName => array(self::typeVarchar, 20),
		self::fieldUsertypePrivileges => array(self::typeNumber, array(0, 549755813887)),
		self::fieldQuestionId => self::typeId,
		self::fieldQuestionText => self::typeText,
		self::fieldQuestionType => array(self::typeEnum, array('text', 'choice', 'multi')),
		self::fieldQuestionOptions => self::typeText,
		self::fieldQuestionAttachments => self::typeText,
		self::fieldGenTestId => self::typeId,
		self::fieldGenTestDescription => array(self::typeVarchar, 50),
		self::fieldGenTestTemplate => self::typeText,
		self::fieldGenTestCount => array(self::typeNumber, array(0, 10000)),
		self::fieldGenTestGenerated => self::typeText,
		self::fieldAttachmentId => self::typeId,
		self::fieldAttachmentName => array(self::typeVarchar, 20),
		self::fieldAttachmentType => array(self::typeEnum, array('text', 'image')),
		self::fieldAttachmentFile => array(self::typeVarchar, 100),

		self::fieldSpecialCount => array(self::typeNumber, array(0, 2147483647)),
		self::fieldSpecialRatingSum => array(self::typeNumber, array(0, 549755813887)),

        self::fieldEmailNotificationSettingsId => self::typeId,
        self::fieldUserOptionSendEmailOnNewSubmission => array(self::typeNumber, array(0, 2) ),
        self::fieldUserOptionSendEmailOnSubmissionRated => array(self::typeNumber, array(0, 2) ),
        self::fieldUserOptionSendEmailOnNewAssignment => array(self::typeNumber, array(0, 2) ),
	);

	/// inherent properties of field types (shared by more than one type)
	protected $flags = array(
		self::typeId => self::flagNumeric,
		self::typeDate => 0,
		self::typeEnum => 0,
		self::typeInteger => self::flagNumeric,
		self::typeNumber => self::flagNumeric,
		self::typeVarchar => 0,
		self::typeText => 0,
	);

	/// primary key fields of base tables
	protected $tableIds = array(
		self::tableAssignments => self::fieldAssignmentId,
		self::tableGroups => self::fieldGroupId,
		self::tableLectures => self::fieldLectureId,
		self::tablePlugins => self::fieldPluginId,
		self::tablePrivileges => self::fieldUsertypeId,
		self::tableProblems => self::fieldProblemId,
		self::tableSubmissions => self::fieldSubmissionId,
		self::tableSubscriptions => self::fieldSubscriptionId,
		self::tableTests => self::fieldTestId,
		self::tableUsers => self::fieldUserId,
		self::tableQuestions => self::fieldQuestionId,
		self::tableGenTests => self::fieldGenTestId,
		self::tableAttachments => self::fieldAttachmentId,
        self::tableEmailNotificationSettings => self::fieldEmailNotificationSettingsId,
	);

	/// name (unique) fields of some base tables
	protected $tableNames = array(
		self::tableGroups => self::fieldGroupName,
		self::tableLectures => self::fieldLectureName,
		self::tablePlugins => self::fieldPluginName,
		self::tablePrivileges => self::fieldUsertypeName,
		self::tableProblems => self::fieldProblemName,
		self::tableUsers => self::fieldUserName,
		self::tableAttachments => self::fieldAttachmentName,
	);

	/**
	 * All properties are read-only accessible.
	 */
	public function __get ($name)
	{
		if (isset($this->$name))
		{
			return $this->$name;
		}
		return null;
	}
}

