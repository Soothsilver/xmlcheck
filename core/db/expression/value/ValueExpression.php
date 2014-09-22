<?php

namespace asm\db;

/**
 * Base for expressions that have "value" semantic.
 *
 * Descendants can also have aditional semantic (see Assignment).
 */
abstract class ValueExpression extends AbstractExpression
{
}

?>