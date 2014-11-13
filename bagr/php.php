<?php
require_once '../vendor/autoload.php';

\asm\core\Config::init('../core/config.ini', '../core/internal.ini');
print_r(\asm\core\Config::get('paths'));