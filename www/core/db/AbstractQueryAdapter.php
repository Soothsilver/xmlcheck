<?php

namespace asm\db;

/**
 * Parent for AbstractQuery adapters (for abstract query -> real query string
 * conversion).
 *
 * Contains adapter implementation (descendants must only assign appropriate
 * value to @ref $tokens member.
 */
abstract class AbstractQueryAdapter
{
	protected $tokens;	///< string tokens used in expression realization
	private $expression;	///< abstract expression to be realized

	/**
	 * Creates adapter on top of supplied abstract expression.
	 */
	public function __construct (AbstractExpression $expr)
	{
		$this->expression = $expr;
	}

	/**
	 * Turns contained abstract expression to usable query string using contained
	 * tokens.
	 */
	public function __toString ()
	{
		return $this->expression->concretize($this->tokens);
	}
}

