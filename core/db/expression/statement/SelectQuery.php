<?php

namespace asm\db;

/**
 * 'Select' database query.
 */
class SelectQuery extends AbstractQuery
{
	protected $source;
	protected $fields;
	protected $conditions;

	/**
	 * Creates instance from supplied source, fields names, and conditions.
	 *
	 * Created instance has following semantic: "Get @c $fields from @c $table
	 * from lines that satisfy @c $conditions ".
	 * @param AbstractQuerySource $source selection source (table or another select query)
	 * @param QueryFields $fields names of fields to be selected (or 'select all fields' token)
	 * @param Predicate $conditions selection-filtering conditions
	 */
	public function __construct (AbstractQuerySource $source,
			QueryFields $fields, Predicate $conditions)
	{
		$this->source = $source;
		$this->fields = $fields;
		$this->conditions = $conditions;

	}

	public function concretize ($tokens)
	{
		return $this->fillQueryToken($this->getToken($tokens), array(
			'source' => $this->source->concretize($tokens),
			'fields' => $this->fields->concretize($tokens),
			'conditions' => $this->conditions->concretize($tokens),
		));
	}
}

?>