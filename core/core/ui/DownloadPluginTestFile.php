<?php

namespace asm\core;

/**
 * Implements handler logic for download of plugin test input or output.
 */
abstract class DownloadPluginTestFile extends DownloadScript
{
	protected $parentPathId = '';	///< Config key of path to folder in which output file is stored (to be overriden)
	protected $filenameFieldId;	///< DbLayout field id of field containing filename
	protected $defaultFilenameId;

	protected final function body ()
	{
		if (!$this->userHasPrivs(User::pluginsTest))
			return;

		if (!$this->isInputValid(array('id' => 'isIndex')))
			return;

		if (!($tests = Core::sendDbRequest('getTestById', $this->getParams('id'))))
			return $this->stopDb($tests, ErrorEffect::dbGet('plugin test'));

		$this->setOutput(Config::get('paths', $this->parentPathId) . $tests[0][$this->filenameFieldId],
				Config::get('defaults', $this->defaultFilenameId) . '.zip');
	}
}

?>