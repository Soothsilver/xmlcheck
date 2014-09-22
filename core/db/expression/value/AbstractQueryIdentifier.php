<?php

namespace asm\db;

/**
 * Identifier for abstract query field names.
 * @see AbstractQuery
 */
class AbstractQueryIdentifier extends IdentifierLiteral
{
	public function concretize ($tokens)
	{
		$wrapper = $this->getToken($tokens);
		return $wrapper . $this->value . $wrapper;
	}
}

?>