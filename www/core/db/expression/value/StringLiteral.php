<?php

namespace asm\db;

class StringLiteral extends Literal
{
	public function concretize ($tokens)
	{
		$escapeFn = '';
		$wrapper = $this->getToken($tokens);
		if (is_array($wrapper))
		{
			$escapeFn = $wrapper['escape'];
			$wrapper = $wrapper['wrapper'];
		}
		$value = (is_callable($escapeFn)) ? call_user_func($escapeFn, $this->value)
				: $this->value;
		return $wrapper . $value . $wrapper;
	}
}

