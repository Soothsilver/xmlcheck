<?php

namespace asm\db;

/**
 * Abstract field set for 'select' database queries.
 * @see SelectQuery
 */
class AbstractQueryFieldSet extends AbstractExpressionSet
{
	/**
	 * Forces set elements to be of AbstractQueryIdentifier class.
	 * @param AbstractExpression $expression expression to be type-checked
	 * @throws MalformedQueryException in case @c $expression is not an
	 *		AbstractQueryIdentifier.
	 */
	protected function forceClass (AbstractExpression $expression)
	{
		if (!is_a($expression, 'asm\db\AbstractQueryIdentifier'))
		{
			throw new MalformedQueryException('Invalid class, must be an AbstractQueryIdentifier');
		}
	}
}

