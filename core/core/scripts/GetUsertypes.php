<?php

namespace asm\core;
use asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets all user types.
 * @n @b Requirements: one of following privileges: User::usersAdd, User::usersManage,
 *		User::usersPrivPresets
 * @n @b Arguments: none
 */
class GetUsertypes extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::usersAdd, User::usersManage, User::usersPrivPresets))
			return;

		if (!($userTypes = Core::sendDbRequest('getUsertypes')))
			$this->stopDb($userTypes);

		$userTypes = ArrayUtils::stripKeys($userTypes);
		foreach ($userTypes as $index => $type)
		{
			$userTypes[$index][2] = User::instance()->unpackPrivileges($type[2]);
		}
		$this->setOutput($userTypes);
	}
}

?>