<?php

namespace asm\db;

/**
 * 'Insert' database query.
 */
class InsertQuery extends AbstractQuery
{
	protected $table;			///< table to perform query on
	protected $assignments;	///< set of field assignments

	/**
	 * Creates instance from supplied table and assignments.
	 *
	 * Created instance has following semantic: "Add new line to @c $table with
	 * field values from @c $assignments ".
	 * @param AbstractQueryTable $table table to perform query on
	 * @param QueryAssignments $assignments field value assignments
	 */
	public function __construct (AbstractQueryTable $table, QueryAssignments $assignments)
	{
		$this->table = $table;
		$this->assignments = $assignments;
	}

	public function concretize ($tokens)
	{
		return $this->fillQueryToken($this->getToken($tokens), array(
			'table' => $this->table->concretize($tokens),
			'assignments' => $this->assignments->concretize($tokens),
		));
	}
}

