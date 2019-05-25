<?php
include "PHPAS.php"
$AS=new AutoStyle();
///////////////////////////////////////
print $AS->loadFile("test.php") ."\n";
print $AS->loadString("<?php\nprint 'hi';\n") ."\n";
