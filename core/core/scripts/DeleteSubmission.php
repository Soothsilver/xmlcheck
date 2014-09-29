<?php

namespace asm\core;
use asm\utils\Filesystem, asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes unconfirmed submission.
 * @n @b Requirements: must be the owner (creator) of the submission
 * @n @b Arguments:
 * @li @c id submission ID
 */
class DeleteSubmission extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputSet(array('id')))
			return;

		$id = $this->getParams('id');

		if (!$submissions = Core::sendDbRequest('getSubmissionById', $id))
			return $this->stopDb($submissions, ErrorEffect::dbGet('submission'));

		$submission = $submissions[0];

		if ($submission[DbLayout::fieldUserId] != User::instance()->getId())
			return $this->stop(ErrorCause::notOwned('submission'));

		$status = $submission[DbLayout::fieldSubmissionStatus];
		if (($status == 'confirmed') || ($status == 'rated'))
			return $this->stop('cannot delete confirmed submission');

		Filesystem::removeFile(Config::get('paths', 'submissions') . $submission[DbLayout::fieldSubmissionFile]);
		if ($submission[DbLayout::fieldSubmissionOutputFile])
		{
			Filesystem::removeFile($submission[DbLayout::fieldSubmissionOutputFile]);
		}

		if (!Core::sendDbRequest('hideSubmissionById', $id))
			return $this->stopDb(false, ErrorEffect::dbRemove('submission'));
	}
}

