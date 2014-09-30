<?php

namespace asm\utils;
use InvalidArgumentException, ErrorException;

/**
 * Utility functions not fitting in any subcategory @module.
 * @see ArrayUtils
 * @see ShellUtils
 * @see StringUtils
 */
class Utils
{
	/**
	 * Throws ErrorException created from supplied arguments.
	 * @param int $errno one of predefined ERROR_* constants
	 * @param string $errstr error message
	 * @param string $errfile file in which the error was triggered
	 * @param int $errline line on which the error was triggered
	 * @throws ErrorException always
	 */
	public static function turnErrorToException ($errno, $errstr, $errfile, $errline)
	{
		throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	}

	/**
	 * Turns supplied value to boolean (works for boolean-like strings).
     *
     * Note: This is used when parsing XML passed by Java and EXE plugins.
	 * @param mixed $val
	 * @return bool true if @a $val is equal to 'true', 'yes', or 'y', false if
	 *		it's equal to 'false', 'no', 'n', '0', '', or isn't a string, null otherwise
	 */
	public static function parseBool ($val)
	{
		if (is_string($val))
		{
			switch (strtolower($val))
			{
				case 'true': case 'yes': case 'y':
					return true;
				case 'false': case 'no': case 'n': case '0': case '':
					return false;
				default:
					return null;
			}
		}

		return (bool)$val;
	}
}

