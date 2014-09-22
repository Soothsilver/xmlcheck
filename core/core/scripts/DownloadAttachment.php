<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets an attachment file.
 * @n @b Requirements: must be able to access the attachment
 * @n @b Arguments:
 * @li @c id attachment ID
 */
final class DownloadAttachment extends DownloadScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');

		if (!($attachments = Core::sendDbRequest('getAttachmentById', $id)))
			return $this->stopDb($attachments, ErrorEffect::dbGet('attachment'));

		$attachment = $attachments[0];
		list($file, $lectureId) = array(
			$attachment[DbLayout::fieldAttachmentFile],
			$attachment[DbLayout::fieldLectureId],
		);

		if (!($lectures = Core::sendDbRequest('getLectureById', $lectureId)))
			return $this->stopDb($lectures, ErrorEffect::dbGet('lecture'));

		$user = User::instance();
		if (!$user->hasPrivileges(User::lecturesManageAll)
				&& (!$user->hasPrivileges(User::lecturesManageOwn)
					|| ($lectures[0][DbLayout::fieldUserId] != $user->getId())))
			return $this->stop(ErrorCode::lowPrivileges);

		$this->doNotAttach();
		$this->setOutput(Config::get('paths', 'attachments') . $file);
	}
}

?>