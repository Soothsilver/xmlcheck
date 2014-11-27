<?php

namespace asm\db;

class SqlPredicate extends Predicate
{
	protected $sql;

	public function __construct ($sql)
	{
		$this->sql = $sql;
	}

	public function concretize ($tokens)
	{
		return $this->wrap($this->sql, $tokens);
	}
}

