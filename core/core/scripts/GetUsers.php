<?php

namespace asm\core;
use asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets all users.
 * @n @b Requirements: User::usersExplore privilege
 * @n @b Arguments: none
 */
class GetUsers extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::usersExplore))
			return;

		$users = Core::sendDbRequest('getUsers');
		if (!$users)
			$this->stopDb($users, ErrorEffect::dbGetAll('users'));

		$this->setOutputTable($users);
	}
}

?>