<?php

namespace asm\core;

/**
 * Implements handler logic for download of plugin test input or output.
 */
abstract class DownloadPluginTestFile extends DownloadScript
{
	protected $parentPathId = '';	///< Config key of path to folder in which output file is stored (to be overridden)
	protected $filenameFieldId;	///< DbLayout field id of field containing filename
	protected $defaultFilenameId;

	protected final function body ()
	{
		if (!$this->userHasPrivileges(User::pluginsTest))
			return false;

		if (!$this->isInputValid(array('id' => 'isIndex')))
			return false;

		if (!($tests = Core::sendDbRequest('getTestById', $this->getParams('id'))))
			return $this->stopDb($tests, ErrorEffect::dbGet('plugin test'));

		$this->setOutput(Config::get('paths', $this->parentPathId) . $tests[0][$this->filenameFieldId],
				Config::get('defaults', $this->defaultFilenameId) . '.zip');
		return true;
	}
}

