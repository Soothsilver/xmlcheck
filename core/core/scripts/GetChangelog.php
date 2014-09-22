<?php

namespace asm\core;
use asm\utils\ArrayUtils, asm\db\DbLayout;

final class GetChangelog extends DataScript
{
	protected function body ()
	{
         $contents = file_get_contents(Config::get('paths', 'changelog'));
        $contents = str_replace("\n", "<br>", $contents);
        $this->addOutput("changelog", $contents);
	}
}

?>