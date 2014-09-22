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
	}
}

?>