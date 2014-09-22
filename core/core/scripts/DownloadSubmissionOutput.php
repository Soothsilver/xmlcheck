<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets submission output file.
 * @n @b Requirements: must be the either the creator of the submission or the owner
 *		of the group this submission's assignment belongs to
 * @n @b Arguments:
 * @li @c id submission ID
 */
final class DownloadSubmissionOutput extends DownloadSubmissionFile
{
	protected function body ()
	{
		if (!$this->isInputSet(array('id')))
			return;

		if (!($submission = $this->findAccessibleSubmissionById($this->getParams('id'))))
			return;

		$this->setOutput($submission[DbLayout::fieldSubmissionOutputFile],
				Config::get('defaults', 'pluginOutputFileName') . '.zip');
	}
}

?>