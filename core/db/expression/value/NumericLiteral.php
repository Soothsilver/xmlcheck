<?php

namespace asm\db;

class NumericLiteral extends Literal
{
	public function concretize ($tokens)
	{
		return (string)$this->value;
	}
}

?>