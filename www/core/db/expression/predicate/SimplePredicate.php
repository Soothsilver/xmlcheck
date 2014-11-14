<?php

namespace asm\db;

/**
 * Base for predicates with explicit "true" or "false" semantic.
 */
abstract class SimplePredicate extends Predicate
{
	public function concretize ($tokens)
	{
		return $this->getToken($tokens);
	}
}

