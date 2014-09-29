<?php

namespace asm\db;

/**
 * Base for all binary predicates.
 */
abstract class BinaryPredicate extends Predicate
{
	protected $leftChild;	///< 'left' sub-expression
	protected $rightChild;	///< 'right' sub-expression

	/**
	 * Creates instance from supplied sub-expressions.
	 * @param AbstractExpression $expr1 'left' sub-expression
	 * @param AbstractExpression $expr2 'right' sub-expression
	 */
	public function __construct ($expr1, $expr2)
	{
		$this->leftChild = $expr1;
		$this->rightChild = $expr2;
	}

	public function concretize ($tokens)
	{
		$expr = $this->leftChild->concretize($tokens)
				. $this->getToken($tokens)
				. $this->rightChild->concretize($tokens);
		return $this->wrap($expr, $tokens);
	}
}

