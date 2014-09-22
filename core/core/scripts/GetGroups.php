<?php

namespace asm\core;
use asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets groups managable by user.
 * @n @b Requirements: one of following privileges: User::groupsAdd, User::groupsManageAll,
 *		User::groupsManageOwn
 * @n @b Arguments: none
 */
final class GetGroups extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::groupsAdd, User::groupsManageAll, User::groupsManageOwn))
			return;

		$user = User::instance();
		$displayAll = $user->hasPrivileges(User::groupsManageAll);
		$groups = Core::sendDbRequest('getGroupsVisibleByUserId', $user->getId(), $displayAll);
		if ($groups === false)
			return $this->stopDb(false, ErrorEffect::dbGetAll('groups'));

		$this->setOutputTable($groups);
	}
}
?>
