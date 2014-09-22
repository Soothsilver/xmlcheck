<?php

namespace asm\core;
use asm\utils\Filesystem, asm\db\DbLayout;

/**
 * @ingroup requests
 * Deletes plugin (with problems, assignments, and submissions).
 * @n @b Requirements: User::pluginsRemove privilege
 * @n @b Arguments: 
 * @li @c id plugin ID
 */
final class DeletePlugin extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivs(User::pluginsRemove))
			return;

		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		$id = $this->getParams('id');
		$plugins = Core::sendDbRequest('getPluginById', $id);
		if (!$plugins)
			return $this->stopDb($plugins, ErrorEffect::dbGet('plugin'));

		$pluginFolder = Config::get('paths', 'plugins')
				. $plugins[0][DbLayout::fieldPluginName];
		if (!Filesystem::removeDir($pluginFolder))
			return $this->stop(ErrorCode::removeFolder, 'plugin files cannot be removed');

		if (($error = RemovalManager::deletePluginById($id)))
			return $this->stopRm($error);
	}
}

?>