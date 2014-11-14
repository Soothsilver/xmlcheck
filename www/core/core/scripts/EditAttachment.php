<?php

namespace asm\core;
use asm\db\DbLayout, asm\utils\Filesystem;

/**
 * @ingroup requests
 * Creates or edits attachment.
 * @n @b Requirements: either User::lecturesManageAll privilege, or User::lecturesManageOwn
 *		privilege and be the owner of the lecture this attachment belongs to
 * @n @b Arguments:
 * @li @c id @optional attachment ID (required for edit)
 * @li @c lecture @optional lecture ID (required for add, not editable)
 * @li @c name attachment name (must match attachment ID for edit)
 * @li @c type attachment type
 * @li @c file attachment file
 */
final class EditAttachment extends LectureScript
{
	protected function body ()
	{
		$inputs = array(
			'lecture' => 'isIndex',
			'name' => array(
				'isName',
				'hasLength' => array(
					'min_length' => 5,
					'max_length' => 20,
				),
			),
			'type' => array('isEnum' => array('text', 'code', 'image'))
		);
		if (!$this->isInputValid($inputs))
			return;

		extract($this->getParams(array_keys($inputs)));
		$id = $this->getParams('id');
		$isIdSet = (($id !== null) && ($id !== ''));

		if (!($originalName = $this->getUploadedFileName('file')))
			return;

		$extensionStart = strrpos($originalName, '.');
		$extension = ($extensionStart === false) ? '' :
				substr($originalName, strrpos($originalName, '.'));

		if (!$this->checkGenTestPrivs($lecture))
			return;

		$attachments = Core::sendDbRequest('getAttachmentByNameAndLectureId', $name, $lecture);
		if ($attachments === false)
			return $this->stopDb($attachments, ErrorEffect::dbGet('attachment', 'name'));

		$attachmentFolder = Config::get('paths', 'attachments');
		$filename = $lecture . '_' . $name . $extension;
		if (!$this->saveUploadedFile('file', $attachmentFolder . $filename))
			return;

		if (!$attachments)
		{
			if ($isIdSet) {
				return $this->stop("attachment with ID '$id' not found");
			} else {
				if (!Core::sendDbRequest('addAttachment', $lecture, $name, $type, $filename))
					return $this->stopDb(false, ErrorEffect::dbAdd('attachment'));
			}
		}
		elseif ($isIdSet)
		{
			$attachment = $attachments[0];
			if (($id != $attachment[DbLayout::fieldAttachmentId]))
				return $this->stop(ErrorCause::dataMismatch('attachment'));

			if (!Core::sendDbRequest('editAttachmentById', $id, $type, $filename))
				return $this->stopDb(false, ErrorEffect::dbEdit('problem'));

			$oldFilename = $attachment[DbLayout::fieldAttachmentFile];
			if ($filename != $oldFilename)
				Filesystem::removeFile($attachmentFolder . $oldFilename);
		}
		else
		{
			return $this->stop(ErrorCause::nameTaken('attachment', $name));
		}
	}
}

