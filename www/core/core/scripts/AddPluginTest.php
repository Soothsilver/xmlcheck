<?php

namespace asm\core;
use asm\utils\StringUtils, asm\utils\Filesystem, asm\db\DbLayout;

/**
 * @ingroup requests
 * Creates and runs new plugin test.
 * @n @b Requirements: User::pluginsTest privilege
 * @n @b Arguments:
 * @li @c description plugin test description
 * @li @c plugin plugin ID
 * @li @c config plugin configuration used for this test
 */
final class AddPluginTest extends DataScript
{
	protected function body ()
	{
		if (!$this->userHasPrivileges(User::pluginsTest))
			return;

		$inputs = array(
			'description' => 'isNotEmpty',
			'plugin' => 'isIndex',
			'config' => null,
		);

		if (!$this->isInputValid($inputs))
			return;

		extract($this->getParams(array_keys($inputs)));

		$testFolder = Config::get('paths', 'tests');
		$inputFile = date('Y-m-d_H-i-s_') . StringUtils::randomString(10) . '.zip';
		if (!$this->saveUploadedFile('input', $testFolder . $inputFile))
			return;

		if (!Core::sendDbRequest('addTest', $plugin, $description, $config, $inputFile))
		{
			$this->stopDb(false, 'cannot store new test data');
			goto removeInputFile;
		}

		$tests = Core::sendDbRequest('getTestByFilename', $inputFile);
		if (!$tests)
		{
			$this->stopDb($tests, 'cannot retrieve test id');
			goto removeInputFile;
		}

		$test = $tests[0];
		$id = $test[DbLayout::fieldTestId];

		$pluginArguments = empty($test[DbLayout::fieldTestConfig])
				? array() : explode(';', $test[DbLayout::fieldTestConfig]);
		Core::launchPlugin($test[DbLayout::fieldPluginType],
				Config::get('paths', 'plugins') . $test[DbLayout::fieldPluginMainFile],
				$testFolder . $test[DbLayout::fieldTestInput],
				true,
				$id,
				$pluginArguments);

		return;

removeInputFile:
		Filesystem::removeFile($testFolder . $inputFile);
	}
}

