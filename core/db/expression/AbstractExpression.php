<?php

namespace asm\db;
use asm\utils\StringUtils;

/**
 * Base for all abstract expressions.
 *
 * Provides convenience methods for conversion to real expression strings, but
 * conversion itself must be implemented in descendants (in concretize() method).
 * Descendants should use getToken() for getting their individual tokens (or
 * token sets). Conversion should then be done by supplying set of tokens to
 * concretize().
 */
abstract class AbstractExpression
{
	const defaultWrapperOpen = '( ';		///< default opening token for sub-expression wrapping
	const defaultWrapperClose = ' )';	///< default closing token for sub-expression wrapping
	const defaultSpace = ' ';				///< default token for separating sub-expressions

	/**
	 * Gets special 'space token' (for sub-expression separation).
	 * @param array $tokens conversion tokens
	 * @return string string to be used for separating sub-expressions
	 */
	protected final function space ($tokens)
	{
		return isset($tokens['space']) ? $tokens['space'] : self::defaultSpace;
	}

	/**
	 * Wraps supplied sub-expression string.
	 * @param string $string
	 * @param array $tokens conversion tokens
	 * @return string @c $string enclosed in custom or default brackets
	 */
	protected final function wrap ($string, $tokens)
	{
		$wrapperOpen = isset($tokens['wrapperOpen']) ? $tokens['wrapperOpen'] : self::defaultWrapperOpen;
		$wrapperClose = isset($tokens['wrapperClose']) ? $tokens['wrapperClose'] : self::defaultWrapperClose;
		return $wrapperOpen . $string . $wrapperClose;
	}

	/**
	 * Gets conversion token(s) belonging to this expression class (virtual).
	 * @param array $tokens conversion tokens
	 * @return mixed single conversion token (string) or array of tokens if
	 *		this class (virtual) uses more than one
	 */
	protected final function getToken ($tokens)
	{
		$className = StringUtils::stripNamespace(get_class($this));
		if (isset($tokens[$className]))
		{
			return $tokens[$className];
		}
		return '';
	}

	/**
	 * Converts this abstract expression to string using supplied tokens.
	 * @param array $tokens conversion tokens
	 * @return string string format depends on @c $tokens
	 */
	public abstract function concretize ($tokens);
}

?>