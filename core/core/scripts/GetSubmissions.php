<?php

namespace asm\core;
use asm\utils\ArrayUtils, asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets user's submissions.
 * @n @b Requirements: User::assignmentsSubmit privilege
 * @n @b Arguments: none
 */
final class GetSubmissions extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::assignmentsSubmit))
			return;

        /**
         * @var $submissions \Submission[]
         */
        $submissions = Repositories::getRepository(Repositories::Submission)->findBy(['user'=>User::instance()->getId()]);
        foreach($submissions as $submission)
        {
            if ($submission->getStatus() == \Submission::STATUS_DELETED) { continue; }
            $row =
                [
                    $submission->getId(),
                    $submission->getAssignment()->getProblem()->getName(),
                    $submission->getAssignment()->getDeadline()->format("Y-m-d H:i:s"),
                    $submission->getDate()->format("Y-m-d H:i:s"),
                    $submission->getStatus(),
                    $submission->getSuccess(),
                    $submission->getInfo(),
                    $submission->getRating(),
                    $submission->getExplanation(),
                    ($submission->getOutputfile() != '')
                ];
            $this->addRowToOutput($row);
        }

        /*
		$submissions = Core::sendDbRequest('getSubmissionsByUserId', User::instance()->getId());
		if ($submissions === null)
			$this->stopDb($submissions, ErrorEffect::dbGetAll('submissions'));

		$fields = array(
			DbLayout::fieldSubmissionId,
			DbLayout::fieldProblemName,
			DbLayout::fieldAssignmentDeadline,
			DbLayout::fieldSubmissionDate,
			DbLayout::fieldSubmissionStatus,
			DbLayout::fieldSubmissionFulfillment,
			DbLayout::fieldSubmissionDetails,
			DbLayout::fieldSubmissionRating,
            DbLayout::fieldSubmissionExplanation
		);

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