<?php

namespace asm\db;

/**
 * Literal expression (value or identifier).
 */
abstract class Literal extends ValueExpression
{
	protected $value;	///< value or identifier string

	/**
	 * Creates instance from supplied value.
	 * @param mixed $value
	 */
	public function __construct ($value)
	{
		$this->value = $value;
	}
}

?>