<?php

namespace asm\core;
use asm\utils\ArrayUtils, asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets all submissions for assignments belonging to user (-> correctible by user).
 * @n @b Requirements: User::submissionsCorrect privilege
 * @n @b Arguments: none
 */
final class GetTeacherSubmissions extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::submissionsCorrect))
			return;

		$requestId = $this->getParams('rated') ? 'getSubmissionsCorrectedByUserId' :
				'getSubmissionsCorrectibleByUserId';
		$submissions = Core::sendDbRequest($requestId, User::instance()->getId());
		if ($submissions === false)
			return $this->stopDb($submissions, ErrorEffect::dbGetAll('submissions for correction'));

		$fields = array(
			DbLayout::fieldSubmissionId,
			DbLayout::fieldProblemName,
			DbLayout::fieldGroupName,
			DbLayout::fieldSubmissionDate,
			DbLayout::fieldSubmissionFulfillment,
			DbLayout::fieldSubmissionDetails,
			DbLayout::fieldSubmissionRating,
            DbLayout::fieldSubmissionExplanation,
			DbLayout::fieldAssignmentReward,
            DbLayout::fieldAssignmentDeadline
		);
		if (User::instance()->hasPrivileges(User::submissionsViewAuthors))
		{
			array_push($fields, DbLayout::fieldSpecialSecondaryId);
			array_push($fields, DbLayout::fieldUserRealName);
		}


        $submissions = ArrayUtils::map(function ($submission, $fields) {
            $hasOutput = ($submission[DbLayout::fieldSubmissionOutputFile] != '');
            $submission = ArrayUtils::filterByKeys($submission, $fields);
            $submission['hasOutput'] = $hasOutput;
            return $submission;
        }, $submissions, $fields);

		$submissions = ArrayUtils::map(array('asm\utils\ArrayUtils', 'sortByKeys'), $submissions, $fields);
		
		$this->setOutputTable($submissions);
	}
}

?>