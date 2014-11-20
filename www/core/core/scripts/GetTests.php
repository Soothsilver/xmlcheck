<?php

namespace asm\core;
use asm\utils\ArrayUtils, asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets all tests managable by user.
 * @n @b Requirements: one of following privileges: User::lecturesManageAll,
 *		User::lecturesManageOwn
 * @n @b Arguments: none
 */
final class GetTests extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivileges(User::lecturesManageAll, User::lecturesManageOwn))
			return;

		$user = User::instance();
		$displayAll = $user->hasPrivileges(User::lecturesManageAll);
		$tests = Core::sendDbRequest('getGenTestsVisibleByUserId', $user->getId(), $displayAll);
		if ($tests === false)
			return $this->stopDb($tests, ErrorEffect::dbGetAll('tests'));

		$this->setOutputTable($tests);
	}
}

