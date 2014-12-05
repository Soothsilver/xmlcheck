<?php

namespace asm\docs;

/**
 * Transforms "typed" phpDoc/doxy hybrid documentation to valid doxygen.
 * Performs following transformations:
 * @li <tt>\@param type $name comment</tt> -> <tt>\@param $name (type) comment</tt>
 * @li <tt>\@param type [...] comment</tt> -> <tt>\@param [...] (type) comment</tt>
 */
class PhpInputFilter implements IInputFilter
{
	public function apply ($code)
	{
		$code = preg_replace('/(\*\s@param(\[(in|out|in,out)\])?\s)([^$&[][a-zA-Z0-9]*)(\s)(&?\$[a-zA-Z0-9]+|\[\.\.\.\])/', '$1$6$5($4)', $code);
		$code = preg_replace('/(@return\s)([a-zA-Z]+)(\s)/', '$1($2)$3', $code);
		$code = preg_replace('/^\s*use\s+[a-zA-Z0-9_\\\\]+(\s*,\s*[a-zA-Z0-9_\\\\]+)*;\s*$/m', '', $code);
		return $code;
	}
}

?>