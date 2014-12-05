<?php
readfile($argv[1]);
die();

/**
 * @file
 * Command-line script for transforming PHP source file with asm::docs::PhpInputFilter.
 * Accepts single argument (path to source file).
 */

use asm\utils\Autoload, asm\docs\InputFilterScript, asm\docs\PhpInputFilter;

require_once '../core/utils/Autoload.php';
Autoload::setIncludePath('filter', './');
Autoload::register();

$script = new InputFilterScript(new PhpInputFilter());
$script->run($argc, $argv);

?>