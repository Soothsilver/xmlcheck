<?php

namespace asm\core;

/**
 * @ingroup requests
 * Postpones timeout of current user session.
 * @n @b Requirements: user has to be logged in
 * @n @b Arguments: none
 * @see User
 */
final class RefreshSession extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivileges())
			return;

		$user = User::instance();
		$user->refresh();
		$this->setOutput('timeout', $user->getTimeout());
	}
}

