<?php
require_once '../vendor/autoload.php';
\asm\utils\ErrorHandler::register();
\asm\utils\ErrorHandler::bind(function() { echo "CAUGHT"; });

echo "BEGIN";

throw new Exception("sth");

echo "END";
