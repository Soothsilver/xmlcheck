<?php

namespace asm\core;
use asm\utils\ShellUtils;

/**
 * @ref ILauncher "Launcher" of programs in Java.
 */
class JavaLauncher implements ILauncher
{
	public function launch ($file, array $arguments, &$output)
	{
		/// Supplied file path must point to JAR archive with defined main class.

		if (!file_exists($file))
		{
			return 'File ' . $file . ' doesn\'t exist or cannot be read';
		}

		$java = Config::get('bin', 'java');
		$arguments = ShellUtils::makeShellArguments($arguments);
		$output = `"$java" -jar "$file" $arguments`;

		return false;
	}
}

?>