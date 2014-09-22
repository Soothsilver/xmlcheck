<?php
/*
$archive = new ZipArchive();
$archive->open('a.zip',ZipArchive::CREATE);
$archive->addEmptyDir("../../down");
$archive->close();
*/
echo "A";
$archive2 = new ZipArchive();
$archive2->open('a.zip');
$archive2->extractTo('.');
$archive2->close();
echo "D";