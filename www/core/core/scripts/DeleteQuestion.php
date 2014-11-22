<?php

namespace asm\core;
use asm\core\lang\StringID;


/**
 * @ingroup requests
 * Deletes a test question.
 * @n @b Requirements: either User::lecturesManageAll, or User::lecturesManageOwn and
 *		be the owner of the lecture this test question belongs to
 * @n @b Arguments:
 * @li @c id question ID
 */
final class DeleteQuestion extends LectureScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return false;

		$id = $this->getParams('id');
		/**
		 * @var $question \Question
		 */
		$question = Repositories::findEntity(Repositories::Question, $id);

		if (!$this->authorizedToManageLecture($question->getLecture()))
		{
			return $this->death(StringID::InsufficientPrivileges);
		}
		// TODO What if some tests refer to this question?
		// Then those tests should have this question removed from their list, or, better yet, the question deletion should be denied.
		Repositories::remove($question);
		return true;
	}
}

