<?php
include "PHPAS.php";
if($files = opendir('./tests/php/')) {
	$index=1;
	while(false !== ($file = readdir($files))) {
		if($file != "." && $file != "..") {
			$AS=new PHPAutoStyle($file);
			$output_filename="tests/output/". $file;
			if(file_exists($output_filename)) {
				$output=file_get_contents($output_filename);
				// $output=trim($output);
				print "-> $index / $file => ";
				// Maybe it displays false, because GitHub change the indent, tab style...
				if($AS->result == $output) {
					print "TRUE";
				}
				else {
					print "FALSE";
				}
				print "\n";
			}
			$index++;
		}
	}
	closedir($files);
}
