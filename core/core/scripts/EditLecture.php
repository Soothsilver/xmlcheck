<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Creates or edits lecture.
 * @n @b Requirements: User::lecturesAdd privilege for add; either User::lecturesManageAll
 *		privilege or User::lecturesManageOwn privilege and be the lecture's owner (creator)
 * @n @b Arguments:
 * @li @c id @optional lecture ID (required for edit)
 * @li @c name lecture name (not editable, must match lecture ID for edit)
 * @li @c description lecture description
 */
final class EditLecture extends DataScript
{
	protected function body ()
	{
		$inputs = array(
			'name' => array(
				'isName',
				'hasLength' => array(
					'min_length' => 3,
					'max_length' => 20,
				),
			),
			'description' => 'isNotEmpty',
		);
		if (!$this->isInputValid($inputs))
			return;

		extract($this->getParams(array_keys($inputs)));
		$id = $this->getParams('id');
		$isIdSet = (($id !== null) && ($id !== ''));

		$lectures = Core::sendDbRequest('getLectureByName', $name);

		$user = User::instance();
		$userId = $user->getId();

		if (!$lectures)
		{
			if (!$this->userHasPrivs(User::lecturesAdd))
				return;
			
			if (!Core::sendDbRequest('addLecture', $userId, $name, $description))
				return $this->stopDb(false, ErrorEffect::dbAdd('lecture'));
		}
		else if ($isIdSet)
		{
			$lecture = $lectures[0];
			if ($id != $lecture[DbLayout::fieldLectureId])
				return $this->stop(ErrorCause::dataMismatch('lecture'));

			if (!$user->hasPrivileges(User::lecturesManageAll)
					&& (!$user->hasPrivileges(User::lecturesManageOwn)
						|| ($lecture[DbLayout::fieldUserId] != $userId)))
				return $this->stop(ErrorCode::lowPrivileges);

			if (!Core::sendDbRequest('editLectureById', $id, $name, $description))
				return $this->stopDb(false, ErrorEffect::dbEdit('lecture'));
		}
		else
		{
			return $this->stop(ErrorCause::nameTaken('lecture', $name));
		}
	}
}

?>