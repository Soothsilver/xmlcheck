<?php

namespace asm\db;

/**
 * 'Delete' database query.
 */
class DeleteQuery extends AbstractQuery
{
	protected $table;			///< table to perform query on
	protected $conditions;	///< filtering conditions

	/**
	 * Creates instance from supplied table and conditions.
	 *
	 * Created instance has following semantic: "Delete all lines from @c $table
	 * that satisfy @c $conditions ".
	 * @param AbstractQueryTable $table table to perform query on
	 * @param Predicate $conditions conditions filtering entries to be deleted
	 */
	public function __construct (AbstractQueryTable $table, Predicate $conditions)
	{
		$this->table = $table;
		$this->conditions = $conditions;
	}

	public function concretize ($tokens)
	{
		return $this->fillQueryToken($this->getToken($tokens), array(
			'table' => $this->table->concretize($tokens),
			'conditions' => $this->conditions->concretize($tokens),
		));
	}
}

?>