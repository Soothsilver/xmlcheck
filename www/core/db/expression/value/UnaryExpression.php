<?php

namespace asm\db;

/**
 * Base for expressions created by altering single @ref ValueExpression "value sub-expression".
 */
abstract class UnaryExpression extends ValueExpression
{
	protected $child;	///< contained sub-expression

	/**
	 * Creates instance from supplied sub-expression.
	 * @param ValueExpression $expr
	 */
	public function __construct (ValueExpression $expr)
	{
		$this->child = $expr;
	}

	public abstract function concretize ($tokens)
	{
		return $this->getToken($tokens) . $this->wrap($this->child->concretize($tokens), $tokens);
	}
}

