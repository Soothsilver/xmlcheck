<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets submission input file.
 * @n @b Requirements: must be the either the creator of the submission or the owner
 *		of the group this submission's assignment belongs to
 * @n @b Arguments:
 * @li @c id submission ID
 */
final class DownloadSubmissionInput extends DownloadSubmissionFile
{
	protected function body ()
	{
		if (!$this->isInputSet(array('id')))
			return;

		if (!($submission = $this->findAccessibleSubmissionById($this->getParams('id'))))
			return;

		$this->setOutput(Config::get('paths', 'submissions')
				. $submission[DbLayout::fieldSubmissionFile],
				Config::get('defaults', 'submissionFileName') . '.zip');
	}
}

