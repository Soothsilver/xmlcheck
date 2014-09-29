<?php

namespace asm\core;
use asm\core\lang\Language;
use asm\core\lang\StringID;
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

        $canViewAuthors = User::instance()->hasPrivileges(User::submissionsViewAuthors);
        $rated = $this->getParams('rated') ? true : false;
        $all = $this->getParams('all') ? true : false;
        $userId = User::instance()->getId();


        /**
         * @var $submissions \Submission[]
         */
        // group is a DQL reserved word, so we must use _group
        $submissions = Repositories::makeDqlQuery("SELECT submission, user, assignment, problem, _group FROM \Submission submission JOIN submission.assignment assignment JOIN assignment.problem problem JOIN submission.user user JOIN assignment.group _group WHERE _group.owner = :submissionCorrector AND (submission.status = 'graded' OR submission.status = 'latest' OR submission.status = 'handsoff')")->setParameter('submissionCorrector', $userId)->getResult();

        foreach($submissions as $submission)
        {
            if (!$all)
            {
                if ($rated && $submission->getStatus() !== \Submission::STATUS_GRADED)
                {
                    continue;
                }
                if (!$rated && $submission->getStatus() === \Submission::STATUS_GRADED)
                {
                    continue;
                }
            }
            $row = [
                $submission->getId(),
                $submission->getAssignment()->getProblem()->getName(),
                $submission->getAssignment()->getGroup()->getName(),
                $submission->getDate()->format("Y-m-d H:i:s"),
                $submission->getSuccess(),
                $submission->getInfo(),
                $submission->getRating(),
                $submission->getExplanation(),
                $submission->getAssignment()->getReward(),
                $submission->getAssignment()->getDeadline()->format("Y-m-d H:i:s"),
                ($canViewAuthors ? $submission->getUser()->getId() : 0),
                ($canViewAuthors ? $submission->getUser()->getRealname(): Language::get(StringID::NotAuthorizedForName)),
                ($submission->getOutputfile() != '')
            ];
            $this->addRowToOutput($row);
        }

        /*
		$requestId = $this->getParams('rated') ? 'getSubmissionsCorrectedByUserId' :
				'getSubmissionsCorrectibleByUserId';
		$submissions = Core::sendDbRequest($requestId, User::instance()->getId());
		if ($submissions === false)
			return $this->stopDb($submissions, ErrorEffect::dbGetAll('submissions for correction'));
        die ($submissions);

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
        */
	}
}

?>