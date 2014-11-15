<?php

namespace asm\core;
use asm\core\lang\StringID;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Creates or edits a test question.
 * @n @b Requirements: either User::lecturesManageAll privilege, or User::lecturesManageOwn
 *		privilege and be the owner of the lecture this question belongs to
 * @n @b Arguments:
 * @li @c id @optional question ID (required for edit)
 * @li @c lecture @optional lecture ID (required for add, not editable)
 * @li @c text question text
 * @li @c type question type (must be one of 'text', 'choice', 'multi')
 * @li @c options @optional a set of options for certain question types
 */
final class EditQuestion extends LectureScript
{
	protected function body ()
	{
		$inputs = array(
			'lecture' => 'isIndex',
			'text' => 'isNotEmpty',
			'type' => array('isEnum' => array('text', 'choice', 'multi')),
		);
		if (!$this->isInputValid($inputs))
			return;

		extract($this->getParams(array_keys($inputs)));
		$id = $this->getParams('id');
		$isIdSet = (($id !== null) && ($id !== ''));

		$options = $this->getParams('options') . '';
		$attachments = $this->getParams('attachments') . '';

		if (!$this->checkGenTestPrivs($lecture))
			return;


		$user = User::instance();
        $userId = $user->getId();
        $visibleAttachments = Core::sendDbRequest('getAttachmentsVisibleByUserId', $userId, $this->userHasPrivs(User::lecturesManageAll) );

		if ($visibleAttachments === false)
			return $this->stopDb(false, ErrorEffect::dbGetAll('attachments'));

		$attTmp = $attachments ? explode(';', $attachments) : array();
		foreach ($visibleAttachments as $va)
		{
			$aId = $va[DbLayout::fieldAttachmentId];
			$index = array_search($aId, $attTmp);
			if ($index !== false)
			{
				array_splice($attTmp, $index, 1);
				if ($va[DbLayout::fieldLectureId] != $lecture)
					return $this->death(StringID::AttachmentBelongsToAnotherLecture);
			}
		}
		if (count($attTmp))
		{
			return $this->stop(ErrorCause::invalidInput('Following attachment IDs are invalid or inaccessible: ' .
					implode(', ', $attTmp) . '.', 'attachments'));
		}


		if (!$isIdSet)
		{
			if (!Core::sendDbRequest('addQuestion', $lecture, $text, $type, $options, $attachments))
				return $this->stopDb(false, ErrorEffect::dbAdd('question'));
		}
		else
		{
			$questions = Core::sendDbRequest('getQuestionById', $id);
			if ($questions === false)
				return $this->stopDb($questions, ErrorEffect::dbGet('question'));

			if ($lecture != $questions[0][DbLayout::fieldLectureId])
				return $this->stop(ErrorCause::dataMismatch ('question', 'id', 'lecture'));

			if (!Core::sendDbRequest('editQuestionById', $id, $text, $type, $options, $attachments))
				return $this->stopDb(false, ErrorEffect::dbEdit('question'));
		}
	}
}

