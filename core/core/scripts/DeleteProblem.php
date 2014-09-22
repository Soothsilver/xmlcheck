<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes problem (with assignments & submissions).
 * @n @b Requirements: either User::lecturesManageAll, or User::lecturesManageOwn and
 *		be the owner of the lecture this problem belongs to
 * @n @b Arguments:
 * @li @c id problem ID
 */
final class DeleteProblem extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');

		if (!($problems = Core::sendDbRequest('getProblemById', $id)))
			return $this->stopDb($problems, ErrorEffect::dbGet('problem'));

		if (!($lectures = Core::sendDbRequest('getLectureById', $problems[0][DbLayout::fieldLectureId])))
			return $this->stopDb($lectures, ErrorEffect::dbGet('lecture'));

		$user = User::instance();
		if (!$user->hasPrivileges(User::lecturesManageAll) && (!$user->hasPrivileges(User::lecturesManageOwn)
				|| ($user->getId() != $lectures[0][DbLayout::fieldUserId])))
			return $this->stop(ErrorCode::lowPrivileges);

		if (($error = RemovalManager::deleteProblemById($id)))
			return $this->stopRm($error);
	}
}

?>