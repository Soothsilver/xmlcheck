<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes group (with subscriptions, assignments, submissions).
 * @n @b Requirements: either User::groupsManageAll, or User::groupsManageOwn and be
 *		the group's owner (creator)
 * @n @b Arguments:
 * @li @c id group ID
 */
final class DeleteGroup extends DataScript
{
	protected function body ()
	{
		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');

		if (!($groups = Core::sendDbRequest('getGroupById', $id)))
			return $this->stopDb($groups, ErrorEffect::dbGet('group'));

		$user = User::instance();
		if (!$user->hasPrivileges(User::groupsManageAll) && (!$user->hasPrivileges(User::groupsManageOwn)
				|| ($user->getId() != $groups[0][DbLayout::fieldUserId])))
			return $this->stop(ErrorCode::lowPrivileges);


		if (($error = RemovalManager::deleteGroupById($id)))
			return $this->stopRm($error);
	}
}

?>