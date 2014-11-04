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
    public static function hideLectureItsProblemsGroupsQuestionsAttachmentsAndXtests($lecture)
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
        foreach($lecture->getXtests() as $xtest)
        {
            Repositories::remove($xtest);
        }
        foreach ($lecture->getQuestions() as $question)
        {
            Repositories::remove($question);
        }
        foreach ($lecture->getAttachments() as $attachment)
        {
            Repositories::remove($attachment);
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
        $attachment = Repositories::findEntity(Repositories::Attachment, $id);
        $questions = CommonQueries::getQuestionsVisibleToActiveUser();
        foreach($questions as $question)
        {
            $modificationMade = false;
            $attachments = explode(';', $question->getAttachments());
            for ($i = 0; $i < count($attachments); $i++)
            {
                if ($attachments[$i] === (string)$id)
                {
                    unset($attachments[$i]);
                    $modificationMade = true;
                }
            }
            if ($modificationMade)
            {
                $question->setAttachments(implode(';', $attachments));
                Repositories::persistAndFlush($question);
            }
        }
        Repositories::remove($attachment);
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
        // TODO zmenit,prostě jen u problémů nastavit opravovadlo na "no corrective plugin" = NULL
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

}

