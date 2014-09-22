<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes assignment (with submissions).
 * @n @b Requirements: either User::groupsManageAll privilege, or User::groupsManageOwn
 *		and be the owner of the group this assignment belongs to
 * @n @b Arguments:
 * @li @c id assignment ID
 */
final class DeleteAssignment extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');

		if (!($assignments = Core::sendDbRequest('getAssignmentById', $id)))
			return $this->stopDb($assignments, ErrorEffect::dbGet('assignment'));

		$user = User::instance();
		if (!$user->hasPrivileges(User::groupsManageAll) && (!$user->hasPrivileges(User::groupsManageOwn)
				|| ($user->getId() != $assignments[0][DbLayout::fieldUserId])))
			return $this->stop(ErrorCode::lowPrivileges);

		if (($error = RemovalManager::deleteAssignmentById($id)))
			return $this->stopRm($error);
	}
}

?>