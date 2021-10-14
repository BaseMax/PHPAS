<?php
/* Include Class */
require "PHPAS.php";

/* Create Class Instance with default options */
$AS = new PHPAutoStyle();

/* or with optional configuratoin */
$options = [
	'identation' => '    ' // 4 spaces (default Tab)
];

print $AS->loadFile("input.test.php") ."\n";
