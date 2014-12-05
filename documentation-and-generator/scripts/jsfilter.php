<?php
readfile($argv[1]);
die();

/**
 * @file
 * Command-line script for transforming JavaScript source file with asm::docs::JsInputFilter.
 * Accepts single argument (path to source file).
 */

use asm\utils\Autoload, asm\docs\InputFilterScript, asm\docs\InputFilterSet,
	asm\docs\BaseJsInputFilter, asm\docs\ExtensionJsInputFilter,
	asm\docs\WidgetJsInputFilter;

require_once '../core/utils/Autoload.php';
Autoload::setIncludePath('filter', './');
Autoload::register();

$script = new InputFilterScript(new InputFilterSet(new BaseJsInputFilter,
		new ExtensionJsInputFilter, new WidgetJsInputFilter));
$script->run($argc, $argv);

?>