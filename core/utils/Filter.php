<?php

namespace asm\utils;

/**
 * Contains methods for input filtering @module.
 */
class Filter
{
	/**
	 * Virtualizes methods isBool, isEmail, isFloat, isInt, isIp, isRegexp, isUrl.
	 *
	 * @anchor isBool
	 * <b>public static function isBool ($value)</b> @n @n
	 * Returns (bool) true if @a $value is boolean or boolean-like string.
	 * @n @n
	 * @anchor isEmail
	 * <b>public static function isEmail ($value)</b> @n @n
	 * Returns (bool) true if @a $value is formatted like valid e-mail address.
	 * @n @n
	 * @anchor isFloat
	 * <b>public static function isFloat ($value)</b> @n @n
	 * Returns (bool) true if @a $value is float or float-like string.
	 * @n @n
	 * @anchor isInt
	 * <b>public static function isInt ($value)</b> @n @n
	 * Returns (bool) true if @a $value is integer or integer-like string.
	 * @n @n
	 * @anchor isIp
	 * <b>public static function isIp ($value)</b> @n @n
	 * Returns (bool) true if @a $value is formatted like valid IP address.
	 * @n @n
	 * @anchor isRegexp
	 * <b>public static function isRegexp ($value)</b> @n @n
	 * Returns (bool) true if @a $value is a valid regular expression.
	 * @n @n
	 * @anchor isUrl
	 * <b>public static function isUrl ($value)</b> @n @n
	 * Returns (bool) true if @a $value is formatted like valid URL.
	 */
	public static function  __callStatic ($name, $arguments)
	{
		$filters = array(
			'isBool' => FILTER_VALIDATE_BOOLEAN,
			'isEmail' => FILTER_VALIDATE_EMAIL,
			'isFloat' => FILTER_VALIDATE_FLOAT,
			'isInt' => FILTER_VALIDATE_INT,
			'isIp' => FILTER_VALIDATE_IP,
			'isRegexp' => FILTER_VALIDATE_REGEXP,
			'isUrl' => FILTER_VALIDATE_URL,
		);
		array_splice($arguments, 1, 0, $filters[$name]);
		if (isset($filters[$name]))
		{
			return (call_user_func_array('filter_var', $arguments) !== false);
		}
		return false;
	}

	/**
	 * @param mixed $value
	 * @return bool true if value is alphanumeric
	 */
	public static function isAlphaNumeric ($value)
	{
		return (bool)preg_match('/[a-zA-Z0-9]*/', $value);
	}


	/**
	 * @param mixed $value
	 * @return bool true if value is a valid date
	 */
	public static function isDate ($value)
	{
		list($year, $month, $day) = explode('-', $value);
		return checkdate($month, $day, $year);
	}

	/**
	 * @param mixed $value
	 * @param array $options
	 *		@arg @c min_length (optional) minimum length
	 *		@arg @c max_length (optional) maximum length
	 * @return bool true if value is a string, possibly with length constrained as specified
	 */
	public static function hasLength ($value, $options)
	{
		return (!isset($options['min_length']) || (strlen($value) >= $options['min_length']))
			&& (!isset($options['max_length']) || (strlen($value) <= $options['max_length']));
	}

	/**
	 * @param mixed $value
	 * @return bool true if value is not an empty string
	 */
	public static function isNotEmpty ($value)
	{
		return (bool)strlen($value);
	}

	/**
	 * @param mixed $value
	 * @return bool true if value is a valid database index
	 */
	public static function isIndex ($value)
	{
		return self::isNonNegativeInt($value);
	}

	/**
	 * @param mixed $value
	 * @return bool true if value is a non-negative integer
	 */
	public static function isNonNegativeInt ($value)
	{
		return (filter_var($value, FILTER_VALIDATE_INT, array('min_range' => 0)) !== false);
	}

	/**
	 * @param mixed $value
	 * @return bool true if value is a valid name (contains only letters and spaces)
	 */
	public static function isName ($value)
	{
		return (bool)preg_match('/[0-9a-zA-Zžščřďťňáéíóúůýě ]*/', $value);
	}

	/**
	 * @param mixed $value
	 * @param array $options
	 * @return bool true if value is one of supplied allowed values
	 */
	public static function isEnum ($value, $options)
	{
		return in_array($value, $options);
	}
}

?>