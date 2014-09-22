<?php

namespace asm\db;

/**
 * 'Update' (edit) database query.
 */
class UpdateQuery extends AbstractQuery
{
	protected $table;			///< table to perform query on
	protected $assignments;	///< field value assignments
	protected $conditions;	///< conditions filtering lines to be updated

	/**
	 * Creates instance from supplied table, assignments, and conditions.
	 *
	 * Created instance has following semantic: "Update lines in @c $table that
	 * satisfy @c $conditions with values from @c $assignments ".
	 * @param AbstractQueryTable $table table to perform query on
	 * @param QueryAssignments $assignments field values to be assigned
	 * @param Predicate $conditions conditions filtering lines to be updated
	 */
	public function __construct (AbstractQueryTable $table,
			QueryAssignments $assignments, Predicate $conditions)
	{
		$this->table = $table;
		$this->assignments = $assignments;
		$this->conditions = $conditions;
	}

	public function concretize ($tokens)
	{
		return $this->fillQueryToken($this->getToken($tokens), array(
			'table' => $this->table->concretize($tokens),
			'assignments' => $this->assignments->concretize($tokens),
			'conditions' => $this->conditions->concretize($tokens),
		));
	}
}

?>