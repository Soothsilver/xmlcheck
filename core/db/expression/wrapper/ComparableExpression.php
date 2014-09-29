<?php

namespace asm\db;

/**
 * Wraps IdentifierLiteral, ValueExpression or Predicate to be used in Comparison.
 */
class ComparableExpression extends AbstractExpressionWrapper
{
	/**
	 * Wraps IdentifierLiteral to be used in Comparison.
	 * @param IdentifierLiteral $ident
	 * @return ComparableExpression instance
	 */
	public static function identifier (IdentifierLiteral $ident)
	{
		return new self($ident);
	}

	/**
	 * Wraps ValueExpression to be used in Comparison.
	 * @param ValueExpression $value
	 * @return ComparableExpression instance
	 */
	public static function value (ValueExpression $value)
	{
		return new self($value);
	}

	/**
	 * Wraps Predicate to be used in Comparison.
	 * @param Predicate $predicate
	 * @return ComparableExpression instance
	 */
	public static function predicate (Predicate $predicate)
	{
		return new self($predicate);
	}
}

