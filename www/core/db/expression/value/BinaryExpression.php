<?php

namespace asm\db;

/**
 * Base for expressions created by joining two @ref ValueExpression "value sub-expressions".
 */
abstract class BinaryExpression extends ValueExpression
{
	protected $leftChild;	///< 'left' sub-expression
	protected $rightChild;	///< 'right' sub-expression

	/**
	 * Creates instance from supplied sub-expressions.
	 * @param ValueExpression $expr1 'left' sub-expression
	 * @param ValueExpression $expr2 'right' sub-expression
	 */
	public function __construct (ValueExpression $expr1, ValueExpression $expr2)
	{
		$this->leftChild = $expr1;
		$this->rightChild = $expr2;
	}

	public function concretize ($tokens)
	{
		return $this->leftChild->concretize($tokens)
				. $this->getToken($tokens)
				. $this->rightChild->concretize($tokens);
	}
}

