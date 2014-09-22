<?php

namespace asm\db;

/**
 * Wraps types used as query field set specification.
 */
class QueryFields extends AbstractExpressionWrapper
{
	/**
	 * Wraps AbstractQueryFieldSet to be used as query field set specification.
	 * @param AbstractQueryFieldSet $fields
	 * @return QueryFields instance
	 */
	public static function fieldSet (AbstractQueryFieldSet $fields)
	{
		return new self($fields);
	}

	/**
	 * Creates and wraps Asterisk instance to be used as 'all fields' query field
	 * set specification.
	 * @return QueryFields instance
	 */
	public static function allFields ()
	{
		return new self(new Asterisk());
	}
}

?>