<?php

namespace asm\core;
use asm\utils\ArrayUtils;

/**
 * @ingroup requests
 * Gets all plugins.
 * @n @b Requirements: one of following privileges: User::pluginsExplore,
 *		User::lecturesManageOwn, User::lecturesManageAll
 * @n @b Arguments: none
 */
final class GetPlugins extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::pluginsExplore, User::lecturesManageOwn, User::lecturesManageAll))
			return;

		$plugins = Core::sendDbRequest('getPlugins');
		if ($plugins === false)
			$this->stopDb($plugins, ErrorEffect::dbGetAll('plugins'));

		$this->setOutputTable($plugins);
	}
}

?>