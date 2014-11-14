<?php
$arg = escapeshellarg('echo "hello";');
echo `php -r $arg`;