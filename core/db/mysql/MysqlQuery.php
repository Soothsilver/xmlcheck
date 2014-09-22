<?php

namespace asm\db;

/**
 * AbstractQuery -> MySQL query string @adapter.
 */
class MysqlQuery extends AbstractQueryAdapter
{
	protected $tokens = array(
		'AbstractQueryFieldSet' => ',',
		'Asterisk' => '*',
		'Assignment' => '=',
		'Conjunction' => ' AND ',
		'DeleteQuery' => 'DELETE FROM ${table} WHERE ${conditions}',
		'Disjunction' => ' OR ',
		'Equality' => '=',
        'GreaterThan' => '>',
		'FalsePredicate' => 'FALSE',
		'InsertQuery' => 'INSERT INTO ${table} SET ${assignments}',
		'AbstractQueryIdentifier' => '`',
		'Negation' => 'NOT ',
		'QueryAssignments' => ',',
		'SelectQuery' => 'SELECT ${fields} FROM ${source} WHERE ${conditions}',
		'StringLiteral' => array(
			'wrapper' => '\'',
			'escape' => 'addslashes',
		),
		'TruePredicate' => 'TRUE',
		'UpdateQuery' => 'UPDATE ${table} SET ${assignments} WHERE ${conditions}',
	);
}

?>