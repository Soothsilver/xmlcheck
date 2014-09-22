<?php

namespace asm\db;

/**
 * Negation of contained predicate.
 */
final class Negation extends Predicate
{
	protected $child;	///< contained predicate

	/**
	 * Creates instance from supplied predicate.
	 * @param Predicate $expr predicate to be negated
	 */
	public function __construct (Predicate $expr)
	{
		$this->child = $expr;
	}

	public function concretize ($tokens)
	{
		return $this->getToken($tokens) . $this->wrap($this->child, $tokens);
	}
}

?>