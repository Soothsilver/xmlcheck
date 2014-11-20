<?php

namespace asm\core;
use asm\db\DbLayout, asm\utils\Filesystem;

/**
 * @ingroup requests
 * Deletes attachment (with questions).
 * @n @b Requirements: either User::lecturesManageAll, or User::lecturesManageOwn and
 *		be the owner of the lecture this attachment belongs to
 * @n @b Arguments:
 * @li @c id attachment ID
 */
final class DeleteAttachment extends LectureScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');

		if (!($attachments = Core::sendDbRequest('getAttachmentById', $id)))
			return $this->stopDb($attachments, ErrorEffect::dbGet('attachment'));

		$attachment = $attachments[0];

		if (!$this->checkTestGenerationPrivileges($attachment[DbLayout::fieldLectureId]))
			return;

		$folder = Config::get('paths', 'attachments');
		$file = $attachment[DbLayout::fieldAttachmentFile];

		if (($error = RemovalManager::deleteAttachmentById($id)))
			return $this->stopRm($error);

		Filesystem::removeFile($folder . $file);
	}
}

