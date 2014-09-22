<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes a test question.
 * @n @b Requirements: either User::lecturesManageAll, or User::lecturesManageOwn and
 *		be the owner of the lecture this test question belongs to
 * @n @b Arguments:
 * @li @c id question ID
 */
final class DeleteQuestion extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');

		if (!($questions = Core::sendDbRequest('getQuestionById', $id)))
			return $this->stopDb($questions, ErrorEffect::dbGet('question'));

		if (!($lectures = Core::sendDbRequest('getLectureById', $questions[0][DbLayout::fieldLectureId])))
			return $this->stopDb($lectures, ErrorEffect::dbGet('lecture'));

		$user = User::instance();
		if (!$user->hasPrivileges(User::lecturesManageAll) && (!$user->hasPrivileges(User::lecturesManageOwn)
				|| ($user->getId() != $lectures[0][DbLayout::fieldUserId])))
			return $this->stop(ErrorCode::lowPrivileges);

		if (!Core::sendDbRequest('deleteQuestionById', $id))
			return $this->stopDb(false, ErrorEffect::dbRemove('question'));
	}
}

?>