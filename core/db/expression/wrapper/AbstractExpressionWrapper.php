<?php

namespace asm\db;

/**
 * Base for all abstract expression wrappers (to give special semantic to other
 * expressions).
 *
 * Wrapping has no effect on expression concretization.
 */
abstract class AbstractExpressionWrapper extends AbstractExpression
{
	protected $expression;	///< contained abstract expression

	/**
	 * Wraps supplied expression in an instance of this class, giving it new semantic.
	 *
	 * To be overriden and made public or used in factory methods of descendants
	 * (Type Hinting should be used in those methods to force correct type of
	 * supplied expression).
	 * @param AbstractExpression $expression
	 */
	protected function __construct (AbstractExpression $expression)
	{
		$this->expression = $expression;
	}

	public function concretize ($tokens)
	{
		return $this->expression->concretize($tokens);
	}
}

