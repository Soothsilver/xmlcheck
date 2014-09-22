<?php

namespace asm\db;

/**
 * Base for all predicates made by comparing two 'comparable expressions'.
 *
 * Comparable expressions can be values or variable indentifiers (meaning that
 * the predicate gains 'value' only when those variables are substituted with
 * their values).
 * @see ComparableExpression
 */
abstract class Comparison extends BinaryPredicate
{
	/**
	 * Creates instance from supplied comparable sub-expressions.
	 * @param ComparableExpression $expr1 'left' sub-expression
	 * @param ComparableExpression $expr2 'right' sub-expression
	 */
	public function __construct (ComparableExpression $expr1, ComparableExpression $expr2)
	{
		parent::__construct($expr1, $expr2);
	}
}

?>