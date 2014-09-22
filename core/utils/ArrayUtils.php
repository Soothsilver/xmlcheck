<?php

namespace asm\utils;

/**
 * Array-oriented utility functions @module.
 */
class ArrayUtils
{
	/**
	 * Strip keys from array (recursive).
	 * @param mixed $array array to be stripped or simple value
	 * @return array @c $array recursively stripped of keys
	 */
	public static function stripKeys ($array)
	{
		if (is_array($array))
		{
			foreach ($array as $key => $val)
			{
				$array[$key] = self::stripKeys($val);
			}
			return array_values($array);
		}
		return $array;
	}

	/**
	 * %Filter array by keys.
	 *
	 * Sample use:
	 * @code
	 * ArrayUtils::filterArrayByKeys(
	 *		array('a', 'b', 'c', 'd' => 'e', 'f' => 'g', 'h' => 'i'),
	 *		array(0, 2, 'f'),
	 *		false);
	 * @endcode
	 * yields
	 * @code
	 * Array(
	 *		[1] => b
	 *		[d] => e
	 *		[h] => i
	 * )
	 * @endcode
	 * @param array $array
	 * @param array $keys keys to be filtered
	 * @param bool $include set to false to exclude keys instead of including them
	 * @return array only those key-value pairs from @c $array whose keys are
	 *		in @c $keys (or are not, depending on @c $include)
	 */
	public static function filterByKeys (array $array, array $keys, $include = true)
	{
		$filtered = array();
		foreach ($array as $key => $val)
		{
			$filter = in_array($key, $keys);
			if (($include && $filter) || (!$include && !$filter))
			{
				$filtered[$key] = $val;
			}
		}
		return $filtered;
	}

	/**
	 * Puts selected keys at the beginning of array.
	 *
	 * Sample use:
	 * @code
	 * ArrayUtils::sortByKeys(
	 *		array('a', 'b', 'c', 'd' => 'e', 'f' => 'g', 'h' => 'i'),
	 *		array(2, 'f', 1));
	 * @endcode
	 * yields
	 * @code
	 * Array(
	 *		[2] => c
	 *		[f] => g
	 *		[1] => b
	 *		[0] => a
	 *		[d] => e
	 *		[h] => i
	 * )
	 * @endcode
	 * Function changes all array keys to strings.
	 * @param array $array
	 * @param array $keys keys to be moved to array beginning
	 * @return array transformed array
	 */
	public static function sortByKeys (array $array, array $keys)
	{
		$sorted = array();
		foreach ($keys as $key)
		{
			if (isset($array[$key]))
			{
				$sorted["$key"] = $array[$key];
				unset($array[$key]);
			}
		}
		foreach ($array as $key => $value)
		{
			$sorted["$key"] = $value;
		}
		return $sorted;
	}

	/**
	 * Calls supplied callback on all array elements.
	 *
	 * Sample use:
	 * @code
	 * ArrayUtils::map('str_repeat', array('foo', 'bar' => 'baz'), 3);
	 * @endcode
	 * yields
	 * @code
	 * Array(
	 *		[0] => foofoofoo
	 *		[bar] => bazbazbaz
	 * )
	 * @endcode
	 * @param callback $callback must accept array element as first argument and
	 *		return something
	 * @param array $array
	 * @param mixed [...] additional arguments passes to callback
	 * @return array values returned by @c $callback called on @c $array elements
	 */
	public static function map ($callback, $array)
	{
		$mapped = array();
		$args = array_slice(func_get_args(), 2);
		foreach ($array as $key => $value)
		{
			array_unshift($args, $value);
			$mapped[$key] = call_user_func_array($callback, $args);
			array_shift($args);
		}
		return $mapped;
	}
}

?>