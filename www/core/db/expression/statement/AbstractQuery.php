<?php

namespace asm\db;

/**
 * Base for all abstract database queries.
 */
abstract class AbstractQuery extends AbstractStatement
{
	/**
	 * Replaces supplied set of placeholders in supplied string with their values.
	 *
	 * @c $token contains placeholders in format @c ${PLACEHOLDER_NAME}. Sample
	 * use in descendant methods:
	 * @code
	 *	$this->fillQueryToken("${foo} is better than ${bar}.", array(
	 *		'foo' => 'Firefox',
	 *		'bar' => 'Internet Explorer',
	 * ));
	 * @endcode
	 * yields
	 * @code
	 * Firefox is better than Internet Explorer.
	 * @endcode
	 * @param string $token string containing placeholders
	 * @param array $parts associative array indexed with placeholder names
	 * @return string @c $token with placeholders replaced with their values
	 */
	protected final function fillQueryToken ($token, array $parts)
	{
		$queryString = $token;
		foreach ($parts as $key => $val)
		{
			$queryString = str_replace('${' . $key . '}', $val, $queryString);
		}
		return $queryString;
	}
}

