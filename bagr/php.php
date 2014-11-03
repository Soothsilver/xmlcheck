<?php
require_once '../vendor/autoload.php';
//require_once '../vendor/soothsilver/dtd-parser/SoothsilverDtdParser.php';
$dtd = Soothsilver\DtdParser\DTD::parseText('<!ELEMENT e EMPTY>');
echo $dtd->elements['e']->type;