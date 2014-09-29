<?php

namespace asm\core;
use asm\utils\Filesystem, asm\db\DbLayout;

/**
 * Methods for removal of various item types from database with dependencies @module.
 */
class RemovalManager
{
    /**
     * @param $group \Group
     */
    public static function hideGroupAndItsAssignments($group)
    {
        $group->setDeleted(true);
        foreach($group->getAssignments() as $assignment)
        {
            $assignment->setDeleted(true);
            Repositories::getEntityManager()->persist($assignment);
        }
        Repositories::flushAll();
    }

    /**
     * @param $problem \Problem
     */
    public static function hideProblemAndItsAssignments($problem)
    {
        $problem->setDeleted(true);
        foreach($problem->getAssignments() as $assignment)
        {
            $assignment->setDeleted(true);
            Repositories::getEntityManager()->persist($assignment);
        }
        Repositories::flushAll();
    }

    /**
     * @param $lecture \Lecture
     */
    public static function hideLectureItsProblemsAndGroups($lecture)
    {
        $lecture->setDeleted(true);
        foreach($lecture->getProblems() as $problem)
        {
            self::hideProblemAndItsAssignments($problem);
        }
        foreach($lecture->getGroups() as $group)
        {
            self::hideGroupAndItsAssignments($group);
        }
        Repositories::persistAndFlush($lecture);
    }




	/**
	 * Deletes attachment with supplied ID (with questions+).
	 * @param int $id attachment ID
	 * @return array error properties provided by removalError() or retrievalError(),
	 * or false in case of success
	 */
	public static function deleteAttachmentById ($id)
	{
		if (($questions = Core::sendDbRequest('getQuestionsVisibleByUserId', User::instance()->getId())) === false)
			return self::retrievalError($questions, 'question', 'owner', $id);

		foreach ($questions as $question)
		{
			$attachmentIds = array();
			// TODO
		}

		if (!Core::sendDbRequest('deleteAttachmentById', $id))
			return self::removalError('attachment', $id);

		return false;
	}

	/**
	 * Deletes plugin with supplied ID (with tests, problems+).
	 * @param int $id plugin ID
	 * @return array error properties provided by removalError() or retrievalError(),
	 * or false in case of success
	 */
	public static function deletePluginById ($id)
	{
		if (($tests = Core::sendDbRequest('getTestsByPluginId', $id)) === false)
			return self::retrievalError($tests, 'test', 'plugin', $id);

		foreach ($tests as $test)
		{
			$testId = $test[DbLayout::fieldTestId];
			if (($error = self::deleteTestById($testId)))
				return $error;
		}

		if (($problems = Core::sendDbRequest('getProblemsByPluginId', $id)) === false)
			return self::retrievalError($problems, 'problem', 'plugin', $id);

		foreach ($problems as $problem)
		{
			$problemId = $problem[DbLayout::fieldProblemId];
			if (($error = self::deleteProblemById($problemId)))
				return $error;
		}

		if (!Core::sendDbRequest('deletePluginById', $id))
			return self::removalError('plugin', $id);

		return false;
	}

	/**
	 * Deletes test with supplied ID (with input & output files).
	 * @param int $id test ID
	 * @return array error properties provided by removalError() or retrievalError(),
	 * or false in case of success
	 */
	public static function deleteTestById ($id)
	{
		if (!($tests = Core::sendDbRequest('getTestById', $id)))
			return "test $id not found";

		$test = $tests[0];
		$fields = array(
			DbLayout::fieldTestInput => 'test input file',
			DbLayout::fieldTestOutput => 'test output file',
		);
		$testFolder = Config::get('paths', 'tests');
		foreach ($fields as $fieldName => $item)
		{
			if (is_file($testFolder . $test[$fieldName]))
			{
				if (!Filesystem::removeFile($testFolder . $test[$fieldName]))
					return "could not remove $item";
			}
		}

		if (!Core::sendDbRequest('deleteTestById', $id))
			return self::removalError('test', $id);

		return false;
	}
	
	/**
	 * Deletes lecture with supplied ID (with groups+, problems).
	 * @param int $id lecture ID
	 * @return array error properties provided by removalError() or retrievalError(),
	 * or false in case of success
	 */
	public static function deleteLectureById ($id)
	{
		if (($groups = Core::sendDbRequest('getGroupsByLectureId', $id)) === false)
			return self::retrievalError($groups, 'group', 'lecture', $id);

		foreach ($groups as $group)
		{
			$groupId = $group[DbLayout::fieldGroupId];
			if (($error = self::deleteGroupById($groupId)))
				return $error;
		}

		if (($problems = Core::sendDbRequest('getProblemsByLectureId', $id)) === false)
			return self::retrievalError($problems, 'problem', 'lecture', $id);

		foreach ($problems as $problem)
		{
			$problemId = $problem[DbLayout::fieldProblemId];
			if (!Core::sendDbRequest('deleteProblemById', $problemId))
				return self::removalError('problem', $problemId);
		}

		if (!Core::sendDbRequest('deleteLectureById', $id))
			return self::removalError('lecture', $id);

		return false;
	}

	/**
	 * Deletes problem with supplied ID (with assignments+).
	 * @param int $id problem ID
	 * @return array error properties provided by removalError() or retrievalError(),
	 * or false in case of success
	 */
	public static function deleteProblemById ($id)
	{
		if (($assignments = Core::sendDbRequest('getAssignmentsByProblemId', $id)) === false)
			return self::retrievalError($assignments, 'assignment', 'problem', $id);

		foreach ($assignments as $assignment)
		{
			$assignmentId = $assignment[DbLayout::fieldAssignmentId];
			if (($error = self::deleteAssignmentById($assignmentId)))
				return $error;
		}

		if (!Core::sendDbRequest('deleteProblemById', $id))
			return self::removalError('problem', $id);

		return false;
	}

	/**
	 * Deletes group with supplied ID (with assignments+, subscriptions).
	 * @param int $id group ID
	 * @return array error properties provided by removalError() or retrievalError(),
	 * or false in case of success
	 */
	public static function deleteGroupById ($id)
	{
		if (($assignments = Core::sendDbRequest('getAssignmentsByGroupId', $id)) === false)
			return self::retrievalError($assignments, 'assignment', 'group', $id);

		foreach ($assignments as $assignment)
		{
			$assignmentId = $assignment[DbLayout::fieldAssignmentId];
			if (($error = self::deleteAssignmentById($assignmentId)))
				return $error;
		}

		if (($subscriptions = Core::sendDbRequest('getSubscriptionsByGroupId', $id)) === false)
			return self::retrievalError($subscriptions, 'subscription', 'group', $id);

		foreach ($subscriptions as $subscription)
		{
			$subscriptionId = $subscription[DbLayout::fieldSubscriptionId];
			if (!Core::sendDbRequest('deleteSubscriptionById', $subscriptionId))
				return self::removalError('subscription', $subscriptionId);
		}

		if (!Core::sendDbRequest('deleteGroupById', $id))
			return self::removalError('group', $id);

		return false;
	}

	/**
	 * Deletes assignment with supplied ID (with submissions).
	 * @param int $id assignment ID
	 * @return array error properties provided by removalError() or retrievalError(),
	 * or false in case of success
	 */
	public static function deleteAssignmentById ($id)
	{
		if (($submissions = Core::sendDbRequest('getSubmissionsByAssignmentId', $id)) === false)
			return self::retrievalError($submissions, 'submission', 'assignment', $id);

		foreach ($submissions as $submission)
		{
			$submissionId = $submission[DbLayout::fieldSubmissionId];
			if (!Core::sendDbRequest('hideSubmissionById', $submissionId))
				return self::removalError('submission', $submissionId);
		}

		if (!Core::sendDbRequest('deleteAssignmentById', $id))
			return self::removalError('assignment', $id);

		return false;
	}

	/**
	 * Creates unified error properties array for removal error.
	 * @param string $subject type of subject that could not be removed
	 * @param int $id subject ID
	 * @return array {false, error message}
	 */
	protected static function removalError ($subject, $id)
	{
		return array(false, "$subject $id could not be deleted");
	}

	/**
	 * Creates unified error properties array for retrieval error.
	 * @param mixed $result result of retrieval request
	 * @param string $subject type of subject that could not be retrieved
	 * @param string $object type of object on which subjects depend
	 * @param int $id object ID
	 * @return array {retrieval request result, error message}
	 */
	protected static function retrievalError ($result, $subject, $object, $id)
	{
		return array($result, "could not retrieve {$subject}s for {$object} $id");
	}
}

