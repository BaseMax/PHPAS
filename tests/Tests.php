<?php
// https://github.com/BaseMax/PHPAS
include "../PHPAS.php";

$dir = './php/';
if($files = opendir($dir)) {
	$index=1;
	while(false !== ($file = readdir($files))) {
		if($file != "." && $file != "..") {
			$AS=new PHPAutoStyle();
			$AS->loadFile($dir . $file);
			$output_filename="output/". $file;
			if(file_exists($output_filename)) {
				$output=file_get_contents($output_filename);
				// $output=trim($output);
				print "-> $index / $file => ";
				file_put_contents($output_filename.".tmp", $AS->result);
				// if(strcmp($AS->result, $output) === 0) {
				if($AS->result == $output) {
					print "TRUE";
				}
				else {
					print "FALSE";
				}
				print "\n";
			}
			else {
				print "-> $output_filename not exists!\n";
			}
			$index++;
		}
	}
	closedir($files);
}
