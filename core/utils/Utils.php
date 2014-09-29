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
	 * Turns positive integer into ordinal string.
	 * @param int $n
	 * @return string ordinal string
	 * @throws InvalidArgumentException in case @a $n is not an integer
	 */
	public static function ordinalize ($n)
	{
		$n = (int)$n;
		if ($n <= 0)
		{
			throw new InvalidArgumentException('Number must be a positive integer');
		}


		if (in_array(($n  % 100), range(11, 13)))
		{
			return $n . 'th';
		}
		else
		{
			switch (($n % 10))
			{
			case 1:
				return $n . 'st';
			case 2:
				return $n . 'nd';
			case 3:
				return $n . 'rd';
			default:
				return $n . 'th';
			}
		}
	}

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

