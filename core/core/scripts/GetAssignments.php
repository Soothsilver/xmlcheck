<?php

namespace asm\core;
use asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets assignments managable by user.
 * @n @b Requirements: one of following privileges: User::groupsManageAll, User::groupsManageOwn
 * @n @b Arguments: none
 */
final class GetAssignments extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::groupsManageAll, User::groupsManageOwn))
			return;

		$user = User::instance();
		$displayAll = $user->hasPrivileges(User::groupsManageAll);
		$assignments = Core::sendDbRequest('getAssignmentsVisibleByUserId', $user->getId(), $displayAll);
		if ($assignments === false)
			return $this->stopDb($assignments, ErrorEffect::dbGetAll('assignments'));

		$this->setOutputTable($assignments);
	}
}

?>