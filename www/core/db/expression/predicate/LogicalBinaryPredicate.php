<?php

namespace asm\db;

/**
 * Base for binary predicates made by joining other predicates.
 */
abstract class LogicalBinaryPredicate extends BinaryPredicate
{
	/**
	 * Creates instance by joining supplied predicates.
	 * @param Predicate $expr1 'left' predicate
	 * @param Predicate $expr2 'right' predicate
	 */
	public function __construct (Predicate $expr1, Predicate $expr2)
	{
		parent::__construct($expr1, $expr2);
	}
}

