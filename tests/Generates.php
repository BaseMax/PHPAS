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
			// print_r($AS->result);
			file_put_contents($output_filename, $AS->result);
			print "[$index]=> $output_filename created!\n";
			$index++;
		}
	}
	closedir($files);
}
