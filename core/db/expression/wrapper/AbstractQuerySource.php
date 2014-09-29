<?php

namespace asm\db;

/**
 * Wraps AbstractQueryTable to be used as query source.
 */
final class AbstractQuerySource extends AbstractExpressionWrapper
{
	/**
	 * Wraps AbstractQueryTable to be used as query source.
	 * @param AbstractQueryTable $table
	 * @return AbstractQuerySource instance
	 */
	public static function fromTable (AbstractQueryTable $table)
	{
		return new self($table);
	}
}

