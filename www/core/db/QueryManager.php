<?php

namespace asm\db;
use asm\utils\Flags;

/**
 * Provides means for creating abstract queries for database requests and
 * translate results @module.
 */
class QueryManager
{
	/**
	 * Gets real table name for supplied table ID.
	 * @param int $table one of @ref DbLayout "DbLayout::table*" constants
	 * @return mixed table name (string) if @c $table is valid, otherwise false
	 */
	protected static function getTableName ($table)
	{
		if (isset(DbLayout::instance()->tables[$table]))
		{
			return DbLayout::instance()->tables[$table];
		}
		return false;
	}

	/**
	 * Gets real field name for supplied table & field IDs.
	 * @param int $table one of @ref DbLayout "DbLayout::table*" constants
	 * @param int $field one of @ref DbLayout "DbLayout::field*" constants
	 * @return string field name (string) if @c $table and @c $field are valid,
	 *		otherwise false
	 */
	protected static function getFieldName ($table, $field)
	{
		if (isset(DbLayout::instance()->fields[$table][$field]))
		{
			return DbLayout::instance()->fields[$table][$field];
		}
		return false;
	}

	/**
	 * Gets real field names for supplied table & field IDs.
	 * @param int $table one of @ref DbLayout "DbLayout::table*" constants
	 * @param array $fields @ref DbLayout "DbLayout::field*" constants
	 * @return mixed field names (array of strings) @c $table and all @c $fields
	 *		are valid, otherwise false
	 */
	protected static function getFieldNames ($table, $fields)
	{
		$fieldNames = array();
		for ($i = 0; $i < count($fields); ++$i)
		{
			$fieldName = self::getFieldName($table, $fields[$i]);
			if ($fieldName === false)
			{
				return false;
			}
			$fieldNames[] = $fieldName;
		}
		return $fieldNames;
	}

	/**
	 * Gets field names for all fields in supplied table except for those specified.
	 * @param int $table one of @ref DbLayout "DbLayout::table*" constants
	 * @param array $excludeFields @ref DbLayout "DbLayout::field*" constants
	 * @return mixed field names of all fields with IDs not in @c $excludeFields
	 *		if @c $table is valid, false otherwise
	 */
	protected static function getFieldNamesInverted ($table, $excludeFields)
	{
		if (!isset(DbLayout::instance()->fields[$table]))
		{
			return false;
		}
		$fields = DbLayout::instance()->fields[$table];
		$fieldNames = array();
		foreach ($fields as $id => $name)
		{
			if (!in_array($id, $excludeFields))
			{
				$fieldNames[] = $name;
			}
		}
		return $fieldNames;
	}

	/**
	 * Gets field type for supplied field ID.
	 * @param int $field one of @ref DbLayout "DbLayout::field*" constants
	 * @return mixed one of @ref DbLayout "DbLayout::type*" constants if @c $field
	 *		is valid, false otherwise
	 */
	protected static function getFieldType ($field)
	{
		if (isset(DbLayout::instance()->types[$field]))
		{
			if (is_array(DbLayout::instance()->types[$field]))
			{
				return DbLayout::instance()->types[$field][0];
			}
			return DbLayout::instance()->types[$field];
		}
		return false;
	}

	/**
	 * Gets field flags for supplied field ID.
	 * @param int $field one of @ref DbLayout "DbLayout::field*" constants
	 * @return mixed binary union of @ref DbLayout "DbLayout::flag*" constants
	 *		applicable for @c $field if @c $field is valid, false otherwise
	 */
	protected static function getFieldFlags ($field)
	{
		$fieldType = self::getFieldType($field);
		if (($fieldType !== false) && (isset(DbLayout::instance()->flags[$fieldType])))
		{
			return DbLayout::instance()->flags[$fieldType];
		}
		return false;
	}

	/**
	 * Create numeric or string literal expression from supplied field value and flags.
	 * @param mixed $value field value
	 * @param int $flags field flags (i.e. DbLayout::flagNumeric)
	 * @return Literal abstract literal expression
	 */
	protected static function makeValueLiteral ($value, $flags)
	{
		return Flags::match($flags, DbLayout::flagNumeric)
				? new NumericLiteral($value)
				: new StringLiteral($value);
	}

	/**
	 * Creates field assignment expression from supplied field name, value, and flags.
	 * @param string $field field name
	 * @param mixed $value field value
	 * @param int $flags field flags (i.e. DbLayout::flagNumeric)
	 * @return Assignment abstract assignment expression
	 */
	protected static function makeAssignment ($field, $value, $flags)
	{
		return new Assignment(new AbstractQueryIdentifier($field),
				self::makeValueLiteral($value, $flags));
	}

	/**
	 * Creates assignment expressions from supplied table ID and field names and values.
	 * @param int $table one of @ref DbLayout "DbLayout::table*" constants
	 * @param array $fields @ref DbLayout "DbLayout::field*" constants
	 * @param array $values field values
	 * @return array array of abstract assignment expressions
	 * @throws QueryManagerException if number of @c $fields doesn't match number
	 *		of @c $values
	 */
	protected static function makeAssignments ($table, $fields, $values)
	{
		$fieldCount = count($fields);
		if (count($values) != $fieldCount)
		{
			throw new QueryManagerException('Cannot build assignments; field and value counts don\'t match');
		}
		$assignments = array();
		for ($i = 0; $i < $fieldCount; ++$i)
		{
			$assignments[] = self::makeAssignment(self::getFieldName($table, $fields[$i]),
					$values[$i], self::getFieldFlags($fields[$i]));
		}
		return $assignments;
	}

	/**
	 * Creates equality expression from supplied table and field IDs and field value.
	 * @param int $table one of @ref DbLayout "DbLayout::table*" constants
	 * @param int $field one of @ref DbLayout "DbLayout::field*" constants
	 * @param mixed $value field value
	 * @return Equality abstract equality expression
	 */
	protected static function makeFieldEqualityCondition ($table, $field, $value)
	{
		$fieldIdent = ComparableExpression::identifier(
				new AbstractQueryIdentifier(self::getFieldName($table, $field)));
		return new Equality($fieldIdent, ComparableExpression::value(
				self::makeValueLiteral($value, self::getFieldFlags($field))));
	}



    /**
	 * Create table name expression from supplied table ID.
	 * @param int $table one of @ref DbLayout "DbLayout::table*" constants
	 * @return AbstractQueryTable abstract query table name expression
	 */
	protected static function makeTable ($table)
	{
		return new AbstractQueryTable(new AbstractQueryIdentifier(self::getTableName($table)));
	}

	/**
	 * Create field set expression from supplied field names.
	 * @param mixed $fieldNames field names (array of strings) or null for
	 *		expression selecting all fields
	 * @return QueryFields abstract field set expression
	 */
	protected static function makeFields ($fieldNames)
	{
		if ($fieldNames === null)
		{
			return QueryFields::allFields();
		}
		$fieldIdents = array();
		foreach ($fieldNames as $fieldName)
		{
			$fieldIdents[] = new AbstractQueryIdentifier($fieldName);
		}
		return QueryFields::fieldSet(new AbstractQueryFieldSet($fieldIdents));
	}

	/**
	 * Turns empty conditions into 'true' predicate.
	 * @param mixed $conditions Predicate or null
	 * @return Predicate unchanged @c $conditions if not null, TruePredicate otherwise
	 */
	protected static function makeConditions ($conditions)
	{
		if ($conditions === null)
		{
			return new TruePredicate();
		}
		return $conditions;
	}

	/**
	 * Turns boolean to expression with same meaning.
	 * @param bool $true
	 * @return Predicate abstract predicate expression
	 */
	protected static function makeSimplePredicate ($true)
	{
		return $true ? new TruePredicate() : new FalsePredicate();
	}

	/**
	 * Creates 'insert' query (for database item creation).
	 * @param int $table one of @ref DbLayout "DbLayout::table*" constants
	 * @param array $fields @ref DbLayout "DbLayout::field*" constants
	 * @param array $values respective field values
	 * @return InsertQuery abstract 'insert' query
	 */
	protected static function insertQuery ($table, $fields, $values)
	{
		return new InsertQuery(self::makeTable($table),
				new QueryAssignments(self::makeAssignments($table, $fields, $values)));
	}

	/**
	 * Creates 'select' query (for database item(s) selection).
	 * @param int $table one of @ref DbLayout "DbLayout::table*" constants
	 * @param mixed $fields @ref DbLayout "DbLayout::field*" constants (arary),
	 *		or null to select all fields
	 * @param mixed $conditions Predicate or null for no conditions
	 * @param bool $invertFields set to false to select @c $fields, otherwise
	 *		selects their complement
	 * @return SelectQuery abstract 'select' query
	 */
	protected static function selectQuery ($table, $fields = null, $conditions = null,
			$invertFields = true)
	{
		if ($fields !== null)
		{
			$fields = $invertFields ? self::getFieldNamesInverted($table, $fields)
					: self::getFieldNames($table, $fields);
		}
		return new SelectQuery(AbstractQuerySource::fromTable(self::makeTable($table)),
				self::makeFields($fields), self::makeConditions($conditions));
	}

	/**
	 * Creates 'update' query (for database item(s) change).
	 * @param int $table one of @ref DbLayout "DbLayout::table*" constants
	 * @param array|null $fields @ref DbLayout "DbLayout::field*" constants (arary),
	 *		or null to select all fields
	 * @param array $values respective field values
	 * @param mixed $conditions Predicate or null for no conditions
	 * @return UpdateQuery abstract 'update' query
	 */
	protected static function updateQuery ($table, $fields, $values, $conditions)
	{
		return new UpdateQuery(self::makeTable($table),
				new QueryAssignments(self::makeAssignments($table, $fields, $values)),
				self::makeConditions($conditions));
	}

	/**
	 * Creates 'delete' query (for database item(s) deletion).
	 * @param int $table one of @ref DbLayout "DbLayout::table*" constants
	 * @param mixed $conditions Predicate or null for no conditions
	 * @return DeleteQuery abstract 'delete' query
	 */
	protected static function deleteQuery ($table, $conditions)
	{
		return new DeleteQuery(self::makeTable($table), self::makeConditions($conditions));
	}

	/**
	 * Gets table ID for supplied select request ID.
	 * @param string $requestId select request ID
	 * @return mixed table ID (int) if @c $requestId is a valid, null otherwise
	 */
	protected static function getSelectTable ($requestId)
	{
		switch ($requestId)
		{
            case 'changePasswordByResetLink':
            case 'getUsersByEmail':
            case 'setResetLinkById':
                return DbLayout::tableUsers;
            case 'addEmailNotificationSettings':
            case 'editEmailNotificationSettings':
                return DbLayout::tableEmailNotificationSettings;
            case 'getUserById':
                return DbLayout::viewUsersPrivileges;
			case 'getAssignmentById':
				return DbLayout::viewAssignmentsProblemsLecturesGroups;
			case 'getAssignmentsByGroupId':
			case 'getAssignmentsByProblemId':
				return DbLayout::tableAssignments;
			case 'getAssignmentsByUserId':
				return DbLayout::viewUsersAssignmentsProblemsLecturesGroupsWithSubmissionCount;
			case 'getAttachmentById':
			case 'getAttachmentByNameAndLectureId':
				return DbLayout::tableAttachments;
			case 'getAttachmentsVisibleByUserId':
				return DbLayout::viewAttachmentsLectures;
			case 'getAvailableGroups':
				return DbLayout::viewGroupsLectures;
			case 'getGenTestById':
				return DbLayout::tableGenTests;
			case 'getGenTestsVisibleByUserId':
				return DbLayout::viewGenTestsLectures;
			case 'getGroupById':
			case 'getGroupByName':
			case 'getGroupsByLectureId':
				return DbLayout::tableGroups;
			case 'getLectureById':
			case 'getLectureByName':
				return DbLayout::tableLectures;
			case 'getPluginById':
			case 'getPlugins':
			case 'getPluginByName':
				return DbLayout::tablePlugins;
			case 'getProblemById':
			case 'getProblemByName':
			case 'getProblemsByLectureId':
			case 'getProblemsByPluginId':
				return DbLayout::tableProblems;
			case 'getQuestionById':
				return DbLayout::tableQuestions;
			case 'getQuestionsVisibleByUserId':
				return DbLayout::viewQuestionsLectures;
			case 'getSubmissionById':
			case 'getSubmissionsByAssignmentId':
				return DbLayout::tableSubmissions;
			case 'getSubmissionOwnerById':
				return DbLayout::viewSubmissionsFullWithOwners;
			case 'getSubmissionByFilename':
				return DbLayout::viewSubmissionsAssignmentsProblemsPlugins;
			case 'getSubmissionsByUserId':
				return DbLayout::viewSubmissionsAssignmentsProblemsLecturesGroups;
			case 'getSubmissionsCorrectibleByUserId':
			case 'getSubmissionsCorrectedByUserId':
				return DbLayout::viewSubmissionsFullWithOwners;
			case 'getSubscriptionsRawByUserId':
			case 'getSubscriptionById':
			case 'getSubscriptionsByGroupId':
				return DbLayout::tableSubscriptions;
			case 'getSubscriptionsByUserId':
				return DbLayout::viewSubscriptionsGroupsLectures;
			case 'getSubscriptionOwnerById':
			case 'getSubscriptionRequestsByUserId':
				return DbLayout::viewSubscriptionRequests;
			case 'getTestById':
			case 'getTestsByPluginId':
				return DbLayout::tableTests;
			case 'getTestByFilename':
			case 'getTests':
				return DbLayout::viewTestsPlugins;
			case 'getUserByName':
				return DbLayout::viewUsersPrivileges;
			case 'getUsertypeByName':
			case 'getUsertypes':
				return DbLayout::tablePrivileges;
			case 'getUsers':
				return DbLayout::viewUsersPrivileges;
			case 'getUsersByActivationCode':
				return DbLayout::tableUsers;
			case 'getAssignmentsVisibleByUserId':
				return DbLayout::viewAssignmentsProblemsLecturesGroups;
			case 'getGroupsVisibleByUserId':
				return DbLayout::viewGroupsLectures;
			case 'getLecturesVisibleByUserId':
				return DbLayout::tableLectures;
			case 'getProblemsVisibleByUserId':
				return DbLayout::viewProblemsLectures;
			case 'getUserRatingSumsByUserId':
				return DbLayout::viewUserGroupRating;
			case 'getUserRatingSumsByOwnerId':
				return DbLayout::viewUserGroupRatingWithOwners;
			case 'getUserSubmissionRatingsByOwnerId':
				return DbLayout::viewUserSubmissionRating;
            case 'getUsersByGroupId':
                return DbLayout::viewUserGroupRating;
			default:
				return null;
		}
	}

	/**
	 * Replaces real field names with @ref DbLayout "DbLayout::field*" constants
	 * in select request results.
	 * @param string $requestId request ID
	 * @param mixed $result result data array or bool
	 * @return mixed translated @c $result if it's a data array, unchanged otherwise
	 */
	public static function translateResult ($requestId, $result)
	{
		if (!is_array($result))
		{
			return $result;
		}
		$table = self::getSelectTable($requestId);
		$fields = array_flip(DbLayout::instance()->fields[$table]);
		$translated = array();
		foreach ($result as $row)
		{
			$translatedRow = array();
			foreach ($row as $fieldName => $value)
			{
				if (isset($fields[$fieldName]))
				{
					$translatedRow[$fields[$fieldName]] = $value;
				}
			}
			$translated[] = $translatedRow;
		}
		return $translated;
	}

	/**
	 * Create abstract database query for supplied request ID.
	 * @param string $requestId request ID
	 * @param array $args request-specific arguments
	 * @return AbstractQuery abstract database query
	 * @throws QueryManagerException in case @c $requestId is invalid
	 */
	public static function getQuery ($requestId, array $args)
	{
		$selectTable = self::getSelectTable($requestId);
		switch ($requestId)
		{

		/* --------------- INSERT -----------------*/

		case 'addAssignment':
			return self::insertQuery(DbLayout::tableAssignments, array(
				DbLayout::fieldGroupId,
				DbLayout::fieldProblemId,
				DbLayout::fieldAssignmentDeadline,
				DbLayout::fieldAssignmentReward,
			), $args);

		case 'addAttachment':
			return self::insertQuery(DbLayout::tableAttachments, array(
				DbLayout::fieldLectureId,
				DbLayout::fieldAttachmentName,
				DbLayout::fieldAttachmentType,
				DbLayout::fieldAttachmentFile,
			), $args);

		case 'addGenTest':
			return self::insertQuery(DbLayout::tableGenTests, array(
				DbLayout::fieldLectureId,
				DbLayout::fieldGenTestDescription,
				DbLayout::fieldGenTestTemplate,
				DbLayout::fieldGenTestCount,
				DbLayout::fieldGenTestGenerated,
			), $args);

		case 'addGroup':
			return self::insertQuery(DbLayout::tableGroups, array(
				DbLayout::fieldLectureId,
				DbLayout::fieldUserId,
				DbLayout::fieldGroupName,
				DbLayout::fieldGroupDescription,
				DbLayout::fieldGroupType,
			), $args);

		case 'addLecture':
			return self::insertQuery(DbLayout::tableLectures, array(
				DbLayout::fieldUserId,
				DbLayout::fieldLectureName,
				DbLayout::fieldLectureDescription,
			), $args);

		case 'addPlugin':
			return self::insertQuery(DbLayout::tablePlugins, array(
				DbLayout::fieldPluginName,
				DbLayout::fieldPluginType,
				DbLayout::fieldPluginDescription,
				DbLayout::fieldPluginMainFile,
				DbLayout::fieldPluginArguments,
			), $args);

		case 'addProblem':
			return self::insertQuery(DbLayout::tableProblems, array(
				DbLayout::fieldLectureId,
				DbLayout::fieldPluginId,
				DbLayout::fieldProblemName,
				DbLayout::fieldProblemDescription,
				DbLayout::fieldProblemPluginArguments,
			), $args);

		case 'addQuestion':
			return self::insertQuery(DbLayout::tableQuestions, array(
				 DbLayout::fieldLectureId,
				 DbLayout::fieldQuestionText,
				 DbLayout::fieldQuestionType,
				 DbLayout::fieldQuestionOptions,
				 DbLayout::fieldQuestionAttachments,
			), $args);

		case 'addSubmission':
			return self::insertQuery(DbLayout::tableSubmissions, array(
				DbLayout::fieldAssignmentId,
				DbLayout::fieldUserId,
				DbLayout::fieldSubmissionFile,
			), $args);

		case 'addSubscription':
			return self::insertQuery(DbLayout::tableSubscriptions, array(
				DbLayout::fieldGroupId,
				DbLayout::fieldUserId,
				DbLayout::fieldSubscriptionStatus,
			), $args);

		case 'addTest':
			return self::insertQuery(DbLayout::tableTests, array(
				DbLayout::fieldPluginId,
				DbLayout::fieldTestDescription,
				DbLayout::fieldTestConfig,
				DbLayout::fieldTestInput,
			), $args);

		case 'addUser':
			return self::insertQuery(DbLayout::tableUsers, array(
				DbLayout::fieldUsertypeId,
				DbLayout::fieldUserName,
				DbLayout::fieldUserPassword,
				DbLayout::fieldUserRealName,
				DbLayout::fieldUserEmail,
				DbLayout::fieldUserActivationCode,
                DbLayout::fieldUserEncryptionType,
			), $args);

		case 'addUsertype':
			return self::insertQuery(DbLayout::tablePrivileges, array(
				DbLayout::fieldUsertypeName,
				DbLayout::fieldUsertypePrivileges,
			), $args);

		/* --------------- SELECT -----------------*/
        case 'getUsersByEmail':
            return self::selectQuery(DbLayout::tableUsers, null,
                self::makeFieldEqualityCondition(DbLayout::tableUsers, DbLayout::fieldUserEmail, $args[0]));
		case 'getAssignmentById':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldAssignmentId, $args[0]));

		case 'getAssignmentsByGroupId':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldGroupId, $args[0]));

		case 'getAssignmentsByProblemId':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldProblemId, $args[0]));

		case 'getAttachmentById':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldAttachmentId, $args[0]));

		case 'getAttachmentByNameAndLectureId':
			return self::selectQuery($selectTable, null, new Conjunction(
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldAttachmentName, $args[0]),
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldLectureId, $args[1])
			));

		case 'getPluginById':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldPluginId, $args[0]));

		case 'getGenTestById':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldGenTestId, $args[0]));

		case 'getGroupById':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldGroupId, $args[0]));

		case 'getGroupByName':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldGroupName, $args[0]));

		case 'getGroupsByLectureId':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldLectureId, $args[0]));

		case 'getLectureById':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldLectureId, $args[0]));

		case 'getLectureByName':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldLectureName, $args[0]));

		case 'getPluginByName':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldPluginName, $args[0]));

		case 'getProblemById':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldProblemId, $args[0]));

		case 'getProblemByName':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldProblemName, $args[0]));

		case 'getProblemsByLectureId':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldLectureId, $args[0]));

		case 'getProblemsByPluginId':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldPluginId, $args[0]));

		case 'getQuestionById':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldQuestionId, $args[0]));

		case 'getUserByName':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserName, $args[0]));

		case 'getUsertypeByName':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUsertypeName, $args[0]));

		case 'getUsersByActivationCode':
			return self::selectQuery($selectTable, array(
				 DbLayout::fieldUserId,
			), self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserActivationCode, $args[0]), true);

		case 'getSubmissionById':
		case 'getSubmissionOwnerById':
			return self::selectQuery($selectTable, array(
					DbLayout::fieldGroupId,
					DbLayout::fieldUserRealName,
				),
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldSubmissionId, $args[0]));

		case 'getSubmissionsByAssignmentId':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldAssignmentId, $args[0]));

		case 'getSubmissionByFilename':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldSubmissionFile, $args[0]));

		case 'getSubscriptionById':
		case 'getSubscriptionOwnerById':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldSubscriptionId, $args[0]));

		case 'getSubscriptionsByGroupId':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldGroupId, $args[0]));

		case 'getSubscriptionRequestsByUserId':
			return self::selectQuery($selectTable, array(
					DbLayout::fieldUserId,
				),
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserId, $args[0]));

		case 'getTestByFilename':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldTestInput, $args[0]));

		case 'getTestById':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldTestId, $args[0]));

		case 'getTests':
			return self::selectQuery($selectTable, array(
				DbLayout::fieldPluginType,
				DbLayout::fieldPluginMainFile,
				DbLayout::fieldTestInput,
				DbLayout::fieldTestOutput,
			));

		case 'getTestsByPluginId':
			return self::selectQuery($selectTable, null,
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldPluginId, $args[0]));

		case 'getUsertypes':
			return self::selectQuery($selectTable);

            case 'getUserById':
                return self::selectQuery($selectTable, null, self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserId, $args[0]));
		case 'getUsers':
			return self::selectQuery($selectTable, array(
				DbLayout::fieldUserPassword,
				DbLayout::fieldUserActivationCode,
				DbLayout::fieldUsertypePrivileges,
			));

		case 'getPlugins':
			return self::selectQuery($selectTable, array(
				DbLayout::fieldPluginMainFile,
			));

		case 'getAssignmentsByUserId':
			return self::selectQuery($selectTable, array(
				DbLayout::fieldUserId,
			), self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserId, $args[0]));

		case 'getSubmissionsByUserId':
			return self::selectQuery($selectTable, array(
				DbLayout::fieldUserId,
				DbLayout::fieldGroupId,
				DbLayout::fieldAssignmentId,
			), self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserId, $args[0]));

		case 'getSubscriptionsByUserId':
			return self::selectQuery($selectTable, array(
				DbLayout::fieldUserId,
			), self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserId, $args[0]));

		case 'getSubscriptionsRawByUserId':
			return self::selectQuery($selectTable,
					array(DbLayout::fieldGroupId),
					self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserId, $args[0]),
					false);

		case 'getAvailableGroups':
			return self::selectQuery($selectTable,
					array(DbLayout::fieldUserId),
					new Disjunction(
							self::makeFieldEqualityCondition($selectTable,
									DbLayout::fieldGroupType, 'public'),
							self::makeSimplePredicate($args[0]))
					);

		case 'getSubmissionsCorrectibleByUserId':
			$correctible = true;
			// continue
		case 'getSubmissionsCorrectedByUserId':
			$submissionStatus = isset($correctible) && $correctible ? 'confirmed' : 'rated';
			return self::selectQuery($selectTable, array(
				DbLayout::fieldUserId,
				DbLayout::fieldGroupId,
				DbLayout::fieldSubmissionFile
			), new Conjunction(
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserId, $args[0]),
				self::makeFieldEqualityCondition($selectTable, DbLayout::fieldSubmissionStatus,
						$submissionStatus))
			);

		case 'getAssignmentsVisibleByUserId':
			return self::selectQuery($selectTable,
					array(
						DbLayout::fieldAssignmentId,
						DbLayout::fieldProblemId,
						DbLayout::fieldProblemName,
						DbLayout::fieldAssignmentDeadline,
						DbLayout::fieldAssignmentReward,
						DbLayout::fieldGroupId,
						DbLayout::fieldGroupName
					),
					new Disjunction(
							self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserId, $args[0]),
							self::makeSimplePredicate($args[1])),
					false
					);

		case 'getAttachmentsVisibleByUserId':
			return self::selectQuery($selectTable, array(
						DbLayout::fieldUserId,
						DbLayout::fieldAttachmentFile,
					),
					new Disjunction(
							self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserId, $args[0]),
							self::makeSimplePredicate($args[1]))
					);

		case 'getGenTestsVisibleByUserId':
		case 'getGroupsVisibleByUserId':
		case 'getLecturesVisibleByUserId':
		case 'getProblemsVisibleByUserId':
		case 'getQuestionsVisibleByUserId':
			return self::selectQuery($selectTable,
					array(DbLayout::fieldUserId),
					new Disjunction(
							self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserId, $args[0]),
							self::makeSimplePredicate($args[1]))
					);

		case 'getUserRatingSumsByUserId':
		case 'getUserRatingSumsByOwnerId':
			return self::selectQuery($selectTable, array(
				DbLayout::fieldUserId,
				DbLayout::fieldUserName,
			), self::makeFieldEqualityCondition($selectTable, DbLayout::fieldUserId, $args[0]));

		case 'getUserSubmissionRatingsByOwnerId':
			return self::selectQuery($selectTable,
					array(),
					new Disjunction(
							self::makeFieldEqualityCondition($selectTable, DbLayout::fieldSpecialSecondaryId, $args[0]),
							self::makeSimplePredicate($args[1]))
					);
         case 'getUsersByGroupId':
            return self::selectQuery($selectTable,
                array(),
                self::makeFieldEqualityCondition($selectTable, DbLayout::fieldGroupId, $args[0]));

		/* -------------- UPDATE -------------------*/
        case 'hideSubmissionById':
            return self::updateQuery(DbLayout::tableSubmissions,
                array (DbLayout::fieldSubmissionStatus),
                array( 'deleted'),
                self::makeFieldEqualityCondition(DbLayout::tableSubmissions, DbLayout::fieldSubmissionId, $args[0]));

        case 'changePasswordByResetLink':
            $newValues = array( null, $args[1], $args[2]);
            return self::updateQuery(DbLayout::tableUsers, array(
                DbLayout::fieldUserResetLink,
                DbLayout::fieldUserPassword,
                DbLayout::fieldUserEncryptionType),
                $newValues, self::makeFieldEqualityCondition(DbLayout::tableUsers, DbLayout::fieldUserResetLink, $args[0]),
                new SqlPredicate("resetLinkExpiry > NOW()"));
        case 'setResetLinkById':
            $id = array_shift($args);
            return self::updateQuery(DbLayout::tableUsers, array(
                DbLayout::fieldUserResetLink,
                DbLayout::fieldUserResetLinkExpiry
            ), $args, self::makeFieldEqualityCondition(DbLayout::tableUsers, DbLayout::fieldUserId, $id));
		case 'editAssignmentById':
			$id = array_shift($args);
			return self::updateQuery(DbLayout::tableAssignments, array(
				DbLayout::fieldAssignmentDeadline,
				DbLayout::fieldAssignmentReward,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableAssignments, DbLayout::fieldAssignmentId, $id));

		case 'editAttachmentById':
			$id = array_shift($args);
			return self::updateQuery(DbLayout::tableAttachments, array(
				DbLayout::fieldAttachmentType,
				DbLayout::fieldAttachmentFile,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableAttachments, DbLayout::fieldAttachmentId, $id));

		case 'editGenTestById':
			$table = DbLayout::tableGenTests;
			$id = array_shift($args);
			return self::updateQuery($table, array(
				DbLayout::fieldGenTestGenerated,
			), $args, self::makeFieldEqualityCondition($table,
					DbLayout::fieldGenTestId, $id));

		case 'editGroupById':
			$id = array_shift($args);
			return self::updateQuery(DbLayout::tableGroups, array(
				DbLayout::fieldGroupName,
				DbLayout::fieldGroupDescription,
				DbLayout::fieldGroupType,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableGroups, DbLayout::fieldGroupId, $id));

		case 'editLectureById':
			$id = array_shift($args);
			return self::updateQuery(DbLayout::tableLectures, array(
				DbLayout::fieldLectureName,
				DbLayout::fieldLectureDescription,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableLectures, DbLayout::fieldLectureId, $id));

		case 'editProblemById':
			$id = array_shift($args);
			return self::updateQuery(DbLayout::tableProblems, array(
				DbLayout::fieldPluginId,
				DbLayout::fieldProblemName,
				DbLayout::fieldProblemDescription,
				DbLayout::fieldProblemPluginArguments,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableProblems, DbLayout::fieldProblemId, $id));

		case 'editQuestionById':
			$id = array_shift($args);
			return self::updateQuery(DbLayout::tableQuestions, array(
				DbLayout::fieldQuestionText,
				DbLayout::fieldQuestionType,
				DbLayout::fieldQuestionOptions,
				DbLayout::fieldQuestionAttachments,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableQuestions, DbLayout::fieldQuestionId, $id));

		case 'editSubscriptionById':
			$id = array_shift($args);
			return self::updateQuery(DbLayout::tableSubscriptions, array(
				DbLayout::fieldSubscriptionStatus,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableSubscriptions, DbLayout::fieldSubscriptionId, $id));

		case 'editUserById':
			$id = array_shift($args);
			return self::updateQuery(DbLayout::tableUsers, array(
				DbLayout::fieldUserName,
				DbLayout::fieldUsertypeId,
				DbLayout::fieldUserPassword,
				DbLayout::fieldUserRealName,
				DbLayout::fieldUserEmail,
                DbLayout::fieldUserEncryptionType,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableUsers, DbLayout::fieldUserId, $id));

        case 'editUserByIdButKeepPassword':
            $id = array_shift($args);
            return self::updateQuery(DbLayout::tableUsers, array(
                DbLayout::fieldUserName,
                DbLayout::fieldUsertypeId,
                DbLayout::fieldUserRealName,
                DbLayout::fieldUserEmail,
            ), $args, self::makeFieldEqualityCondition(DbLayout::tableUsers, DbLayout::fieldUserId, $id));

		case 'editUsertypeById':
			$id = array_shift($args);
			return self::updateQuery(DbLayout::tablePrivileges, array(
				DbLayout::fieldUsertypeName,
				DbLayout::fieldUsertypePrivileges,
			), $args, self::makeFieldEqualityCondition(DbLayout::tablePrivileges, DbLayout::fieldUsertypeId, $id));

		case 'editLastUserLoginById':
			$id = array_shift($args);
			return self::updateQuery(DbLayout::tableUsers, array(
				DbLayout::fieldUserLastAccess,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableUsers, DbLayout::fieldUserId, $id));

		case 'demoteUsersByType':
			return self::updateQuery(DbLayout::tableUsers, array(
				DbLayout::fieldUsertypeId,
			), array(0), self::makeFieldEqualityCondition(DbLayout::tableUsers, DbLayout::fieldUsertypeId, $args[0]));

		case 'activateUsersByCode':
			return self::updateQuery(DbLayout::tableUsers, array(
				DbLayout::fieldUserActivationCode,
			), array(''), self::makeFieldEqualityCondition(DbLayout::tableUsers,
					DbLayout::fieldUserActivationCode, $args[0]));

		case 'confirmSubmissionById':
			$id = array_shift($args);
			return self::updateQuery(DbLayout::tableSubmissions, array(
				DbLayout::fieldSubmissionStatus,
			), array('confirmed'), self::makeFieldEqualityCondition(DbLayout::tableSubmissions, DbLayout::fieldSubmissionId, $id));

		case 'correctSubmissionById':
			$id = array_shift($args);
			array_unshift($args, 'corrected');
			return self::updateQuery(DbLayout::tableSubmissions, array(
				DbLayout::fieldSubmissionStatus,
				DbLayout::fieldSubmissionFulfillment,
				DbLayout::fieldSubmissionDetails,
				DbLayout::fieldSubmissionOutputFile,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableSubmissions, DbLayout::fieldSubmissionId, $id));

		case 'rateSubmissionById':
			$id = array_shift($args);
			array_unshift($args, 'rated');
			return self::updateQuery(DbLayout::tableSubmissions, array(
				DbLayout::fieldSubmissionStatus,
				DbLayout::fieldSubmissionRating,
                DbLayout::fieldSubmissionExplanation,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableSubmissions, DbLayout::fieldSubmissionId, $id));

		case 'confirmSubscriptionById':
			$table = DbLayout::tableSubscriptions;
			return self::updateQuery($table, array(
				DbLayout::fieldSubscriptionStatus,
			), array('subscribed'), self::makeFieldEqualityCondition($table,
					DbLayout::fieldSubscriptionId, array_shift($args)));

		case 'completeTestById':
			$id = array_shift($args);
			array_unshift($args, 'finished');
			return self::updateQuery(DbLayout::tableTests, array(
				DbLayout::fieldTestStatus,
				DbLayout::fieldTestFulfillment,
				DbLayout::fieldTestDetails,
				DbLayout::fieldTestOutput,
			), $args, self::makeFieldEqualityCondition(DbLayout::tableTests, DbLayout::fieldTestId, $id));

		/* --------------- DELETE -----------------*/

		case 'deleteAssignmentById':
			return self::deleteQuery(DbLayout::tableAssignments,
					self::makeFieldEqualityCondition(DbLayout::tableAssignments, DbLayout::fieldAssignmentId, $args[0]));

		case 'deleteAttachmentById':
			return self::deleteQuery(DbLayout::tableAttachments,
					self::makeFieldEqualityCondition(DbLayout::tableAttachments, DbLayout::fieldAttachmentId, $args[0]));

		case 'deleteGenTestById':
			return self::deleteQuery(DbLayout::tableGenTests,
					self::makeFieldEqualityCondition(DbLayout::tableGenTests, DbLayout::fieldGenTestId, $args[0]));

		case 'deleteGroupById':
			return self::deleteQuery(DbLayout::tableGroups,
					self::makeFieldEqualityCondition(DbLayout::tableGroups, DbLayout::fieldGroupId, $args[0]));

		case 'deleteLectureById':
			return self::deleteQuery(DbLayout::tableLectures,
				self::makeFieldEqualityCondition(DbLayout::tableLectures, DbLayout::fieldLectureId, $args[0]));

		case 'deletePluginById':
			return self::deleteQuery(DbLayout::tablePlugins,
				self::makeFieldEqualityCondition(DbLayout::tablePlugins, DbLayout::fieldPluginId, $args[0]));

		case 'deleteUsertypeById':
			if ($args[0] == DbLayout::defaultUsertypeId)
			{
				throw new QueryManagerException('Default usertype cannot be deleted.');
			}
			return self::deleteQuery(DbLayout::tablePrivileges,
				self::makeFieldEqualityCondition(DbLayout::tablePrivileges, DbLayout::fieldUsertypeId, $args[0]));

		case 'deleteProblemById':
			return self::deleteQuery(DbLayout::tableProblems,
				self::makeFieldEqualityCondition(DbLayout::tableProblems, DbLayout::fieldProblemId, $args[0]));

		case 'deleteQuestionById':
			return self::deleteQuery(DbLayout::tableQuestions,
				self::makeFieldEqualityCondition(DbLayout::tableQuestions, DbLayout::fieldQuestionId, $args[0]));


		case 'deleteSubmissionById':
			return self::deleteQuery(DbLayout::tableSubmissions, new Conjunction(
				self::makeFieldEqualityCondition(DbLayout::tableSubmissions, DbLayout::fieldSubmissionId, $args[0]),
				new Disjunction(
					self::makeFieldEqualityCondition(DbLayout::tableSubmissions, DbLayout::fieldSubmissionStatus, 'new'),
					self::makeFieldEqualityCondition(DbLayout::tableSubmissions, DbLayout::fieldSubmissionStatus, 'corrected')
				)));

		case 'deleteSubscriptionById':
			return self::deleteQuery(DbLayout::tableSubscriptions,
				self::makeFieldEqualityCondition(DbLayout::tableSubscriptions, DbLayout::fieldSubscriptionId, $args[0]));

		case 'deleteTestById':
			return self::deleteQuery(DbLayout::tableTests,
				self::makeFieldEqualityCondition(DbLayout::tableTests, DbLayout::fieldTestId, $args[0]));

		case 'deleteUserById':
			return self::deleteQuery(DbLayout::tableUsers,
				self::makeFieldEqualityCondition(DbLayout::tableUsers, DbLayout::fieldUserId, $args[0]));
            /* --------------- NEW -----------------*/
            case 'addEmailNotificationSettings':
               return self::insertQuery(DbLayout::tableEmailNotificationSettings,
                   array(
                       DbLayout::fieldUserId,
                       DbLayout::fieldUserOptionSendEmailOnSubmissionRated,
                       DbLayout::fieldUserOptionSendEmailOnNewAssignment,
                       DbLayout::fieldUserOptionSendEmailOnNewSubmission
                    ), $args);

            case 'editEmailNotificationSettings':
                return self::updateQuery(DbLayout::tableEmailNotificationSettings,
                    array(
                        DbLayout::fieldUserId,
                        DbLayout::fieldUserOptionSendEmailOnSubmissionRated,
                        DbLayout::fieldUserOptionSendEmailOnNewAssignment,
                        DbLayout::fieldUserOptionSendEmailOnNewSubmission
                    ), $args, self::makeFieldEqualityCondition(DbLayout::tableEmailNotificationSettings, DbLayout::fieldUserId, $args[0]));
		}


		throw new QueryManagerException('Database request ' . $requestId . ' doesn\'t exist.');
	}
}

