<?php

namespace asm\db;

/**
 * Set of field assignments for 'insert' and 'update' database queries.
 * @see InsertQuery
 * @see UpdateQuery
 */
class QueryAssignments extends AbstractExpressionSet
{
	/**
	 * Forces set elements to be of Assignment class.
	 * @param AbstractExpression $expression expression to be type-checked
	 * @throws MalformedQueryException in case @c $expression is not an Assignment.
	 */
	protected function forceClass (AbstractExpression $expression)
	{
		if (!is_a($expression, 'asm\db\Assignment'))
		{
			throw new MalformedQueryException('Invalid class, must be an Assignment');
		}
	}
}

?>