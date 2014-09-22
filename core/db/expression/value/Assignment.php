<?php

namespace asm\db;

/**
 * Expression that adds "assign value of that expression to this variable" semantic
 * to contained expression.
 */
class Assignment extends BinaryExpression
{
	/**
	 * Creates instance from supplied variable indentifier and value expression.
	 * @param IdentifierLiteral $expr1 variable identifier
	 * @param ValueExpression $expr2 value
	 */
	public function __construct (IdentifierLiteral $expr1, ValueExpression $expr2)
	{
		parent::__construct($expr1, $expr2);
	}
}

?>