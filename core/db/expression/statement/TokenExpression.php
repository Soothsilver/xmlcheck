<?php

namespace asm\db;

/**
 * Base for statements consisting of nothing but custom string.
 */
abstract class TokenExpression extends AbstractStatement
{
	public function __construct () {}

	public function concretize ($tokens)
	{
		return $this->getToken($tokens);
	}
}

?>