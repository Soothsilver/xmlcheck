<?php

namespace asm\core;
use asm\db\DbLayout;

/**
 * @ingroup requests
 * Gets plugin test output file.
 * @n @b Requirements: User::pluginsTest privilege
 * @n @b Arguments:
 * @li @c id plugin test ID
 */
final class DownloadPluginTestOutput extends DownloadPluginTestFile
{
	protected $filenameFieldId = DbLayout::fieldTestOutput;
	protected $defaultFilenameId = 'pluginOutputFileName';
}

