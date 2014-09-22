<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets plugin test input file.
 * @n @b Requirements: User::pluginsTest privilege
 * @n @b Arguments:
 * @li @c id plugin test ID
 */
final class DownloadPluginTestInput extends DownloadPluginTestFile
{
	protected $parentPathId = 'tests';
	protected $filenameFieldId = DbLayout::fieldTestInput;
	protected $defaultFilenameId = 'pluginTestFileName';
}

?>