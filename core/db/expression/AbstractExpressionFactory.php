<?php

namespace asm\db;

/**
 * Contains convenience methods for creation of some basic abstract expression
 * types @module.
 */
class AbstractExpressionFactory
{
	/**
	 * Turns supplied array of expressions or values to abstract predicate.
	 * @param array $array expressions or values (will be coerced to literal expressions)
	 * @param bool $cnf whether to produce conjunction (by default) or disjunction
	 *		(set to false) of expressions in @c $array
	 * @return LogicalBinaryPredicate
	 */
	protected static function predicate (array $array, $cnf = true)
	{
		$rightExpr = self::expression(array_pop($array), !$cnf);
		while (count($array))
		{
			$rightExpr = $cnf
					? new Conjunction(self::expression(array_pop($array), !$cnf), $rightExpr)
					: new Disjunction(self::expression(array_pop($array), !$cnf), $rightExpr);
		}
		return $rightExpr;
	}

	/**
	 * Wraps supplied value in appropriate abstract expression class.
	 *
	 * Value is coerced in following way:
	 * @li boolean -> SimplePredicate
	 * @li integer -> NumericLiteral
	 * @li array -> LogicalBinaryPredicate with elements coerced recursively first
	 * @li AbstractExpression descendant or null is returned unchanged
	 * @li anything else is cast to string and coerced to StringLiteral
	 * 
	 * @param mixed $var value to be wrapped
	 * @param bool $cnf if @c $var is an array, this denotes whether it's in
	 *		'conjunctive normal form' (by default) or 'disjunctive normal form'
	 *		(set to false)
	 * @return AbstractExpression literal with same semantic or predicate
	 */
	public static function expression ($var, $cnf = true)
	{
		if (is_null($var))
		{
			return null;
		}
		elseif (is_bool($var))
		{
			return $var ? new TruePredicate() : new FalsePredicate();
		}
		elseif (is_int($var))
		{
			return new NumericLiteral();
		}
		elseif (is_array($var) && (count($var) > 1))
		{
			return self::predicate($var, $cnf);
		}
		elseif (is_a($var, 'asm\db\AbstractExpression'))
		{
			return $var;
		}
		return new StringLiteral((string)$var);
	}
}

?>