<?php

namespace asm\core;
use asm\utils\ArrayUtils;

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
		if (!$this->userHasPrivs(User::pluginsTest))
			return;

		$tests = Core::sendDbRequest('getTests');
		if ($tests === false)
			$this->stopDb($tests, ErrorEffect::dbGetAll('tests'));

		$this->setOutputTable($tests);
	}
}

?>