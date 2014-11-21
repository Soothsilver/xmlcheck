<?php

namespace asm\core;


/**
 * @ingroup requests
 * Gets all plugin tests.
 * @n @b Requirements: User::pluginsTest privilege
 * @n @b Arguments: none
 */
final class GetPluginTests extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivileges(User::pluginsTest))
			return;

		$tests = Core::sendDbRequest('getTests');
		if ($tests === false)
			$this->stopDb($tests, ErrorEffect::dbGetAll('tests'));

		$this->setOutputTable($tests);
	}
}

