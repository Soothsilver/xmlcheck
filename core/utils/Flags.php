<?php

namespace asm\utils;

/**
 * Provides convenience transformation methods for set of named flags and static
 * flag matching function.
 *
 * Transformation methods work only for flag sets of size 31 or smaller.
 */
class Flags
{
	/**
	 * Checks whether supplied set of flags matches at least one of required sets.
	 *
	 * Sample use:
	 * @code
	 * if (!Flags::match($usersPrivileges, PRIV_1 | PRIV_2, PRIV_3))
	 *		throw new \Exception('User doesn\'t have privileges required for this action');
	 * @endcode
	 * In this case exception is thrown if neither both @c PRIV_1 and @c PRIV_2
	 * flags nor @c PRIV_3 flag are contained in $usersPrivileges.
	 * @param int $set set to match against requirements
	 * @param int [...] requirements
	 * @return bool true if @c $set matches at least one set of supplied requirements
	 *		or if no requirements were supplied
	 */
	public static function match ($set)
	{
		$args = func_get_args();
		array_shift($args);

		$matched = empty($args);
		foreach ($args as $flags)
		{
			if (($set & $flags) === $flags)
			{
				$matched = true;
			}
		}
		return $matched;
	}

	protected $flags = array();	///< array with flags {\<flag name\> => bool, ...}

	/**
	 * Cuts flag names to 31 and sets their flag values (1, 2, 4, 8, etc).
	 *
	 * Sample use:
	 * @code
	 * $privs = new Flags(array(
	 *		'can do something',
	 *		'can do something else',
	 *		'and this as well',
	 * ));
	 * @endcode
	 * produces Flags instance with flags
	 * @li <tt>can do something</tt> ... 1
	 * @li <tt>can do something else</tt> ... 2
	 * @li <tt>and this as well</tt> ... 4
	 * 
	 * @param array $flagNames flag names
	 */
	public function __construct (array $flagNames)
	{
		// h4ck: no more than 31 privileges (bitwise shift only works on 32-bit integers)
		array_splice($flagNames, 31);

		$flag = 1;
		foreach ($flagNames as $name)
		{
			$this->flags[$name] = $flag;
			$flag = $flag << 1;
		}
	}

	/**
	 * Gets flag value for supplied flag name.
	 * @param string $name flag name
	 * @return int flag value if flag name exists, zero otherwise
	 */
	public function getFlag ($name)
	{
		return (isset($this->flags[$name]) ? $this->flags[$name] : 0);
	}

	/**
	 * Turns supplied flag set to flag array.
	 *
	 * Sample use (continuing example from __construct()):
	 * @code
	 * $privs->toArray($privs->getFlag('can do something') | $privs->getFlag('and this as well'));
	 * @endcode
	 * will yield
	 * @code
	 * array(
	 *		'can do something' => true,
	 *		'can do something else' => false,
	 *		'and this as well' => true,
	 * );
	 * @endcode
	 * @param int $flags flag set
	 * @return array array with boolean flags indexed by their names
	 */
	public function toArray ($flags)
	{
		$array = array();
		foreach ($this->flags as $name => $flag)
		{
			$array[$name] = self::match($flags, $flag);
		}
		return $array;
	}

	/**
	 * Turns supplied flag array to flag set.
	 * @param array $array flag array (as returned from toArray())
	 * @return int flag set (binary union of flag values)
	 */
	public function toFlags ($array)
	{
		$flags = 0;
		foreach ($array as $name => $isSet)
		{
			if ($isSet)
			{
				$flags = $flags | $this->getFlag($name);
			}
		}
		return $flags;
	}
}

?>