<?php

namespace asm\db;

/**
 * Wraps AbstractQueryIdentifier to be used as table name.
 */
class AbstractQueryTable extends AbstractExpressionWrapper
{
	/**
	 * Wraps AbstractQueryIdentifier to be used as table name.
	 * @param AbstractQueryIdentifier $table
	 */
	public function __construct (AbstractQueryIdentifier $table)
	{
		parent::__construct($table);
	}
}

?>