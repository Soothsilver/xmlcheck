<?php

namespace asm\db;

/**
 * Base for all abstract statements consisting of set of expressions separated
 * by custom separator.
 */
abstract class AbstractExpressionSet extends AbstractStatement
{
	protected $expressions;	///< set of contained expressions

	/**
	 * Creates instance with supplied set of expressions.
	 * @param array $expressions expressions must be correctly typed
	 * @see forceClass()
	 */
	public function __construct (array $expressions)
	{
		$this->forceClasses($expressions);
		$this->expressions = $expressions;
	}

	/**
	 * Forces supplied expression to be descendant of particular class.
	 *
	 * This is a workaround to allow for strongly typed arrays. It should be
	 * overridden in descendant forcing more specific expression type. Descendants
	 * can then use forceClasses() method in their constructor to accept only
	 * arrays with correctly typed expressions.
	 * @param AbstractExpression $expr expression to be type-hinted
	 * @see forceClasses()
	 */
	protected abstract function forceClass (AbstractExpression $expr);

	protected function forceClasses (array $expressions)
	{
		foreach ($expressions as $expr)
		{
			$this->forceClass($expr);
		}
	}

	public function concretize ($tokens)
	{
		$expressions = array();
		foreach ($this->expressions as $expression)
		{
			$expressions[] = $expression->concretize($tokens);
		}
		return implode($this->getToken($tokens), $expressions);
	}
}

