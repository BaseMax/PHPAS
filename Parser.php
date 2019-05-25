<?php
// startsWith
function starts($input, $need) {
	$length=strlen($need);
	return(substr($input, 0, $length) === $need);
}
// endsWith
function ends($input, $need) {
	$length = strlen($need);
	if($length == 0) {
		return true;
	}
	return (substr($input, -$length) === $need);
}
$filename="test.php";
$input=file_get_contents($filename);
$_open_tag=false;
$_open_dblstring=false;
$_open_sngstring=false;
$_open_sngcomment=false;
$_open_mltcomment=false;
$_index=0;
$_length=mb_strlen($input);
$result="";
for($_index;$_index<$_length;$_index++) {
	$_chars=mb_substr($input, $_index, 5);
	$_char_length=mb_strlen($_chars);
	$_char_next_next_next_next=null;
	if($_char_length == 5) {
		$_char_next_next_next_next=$_chars[4];
	}
	$_char_next_next_next=null;
	if($_char_length == 4) {
		$_char_next_next_next=$_chars[3];
	}
	$_char_next_next=null;
	if($_char_length == 3) {
		$_char_next_next=$_chars[2];
	}
	$_char_next=null;
	if($_char_length == 2) {
		$_char_next=$_chars[1];
	}
	$_char=$_chars[0];
	if($_open_tag === false) {
		// if($_chars == "<?php" || starts($_chars,"<?")) {
		if(starts($_chars,"<?=")) {
			$result.="<?=";
			$_open_tag=true;
			$_index+=2;
		}
		else if($_chars == "<?php") {
			$result.="<?php";
			$_open_tag=true;
			$_index+=4;
		}
		else if(starts($_chars,"<?")) {
			$result.="<?";
			$_open_tag=true;
			$_index+=1;
		}
	}
	else {
		if($_open_sngcomment === false && $_open_mltcomment === false && $_open_sngstring === false && $_open_dblstring === false) {
			if(starts($_chars, " ")) { }
			else if(starts($_chars, "\t")) { }
			// else if(starts($_chars, "\n")) { }
			else if(starts($_chars, "//")) {
				$_open_sngcomment=true;
				$_index+=1;
			}
			else if(starts($_chars, "/*")) {
				$_open_mltcomment=true;
				$_index+=1;
			}
			else if(starts($_chars, "{")) {
				$result.=" {";
			}
			else {
				$result.=$_char;
			}
		}
		else if($_open_sngcomment === true) {
			if(starts($_chars, "\n")) {
				$_open_sngcomment=false;
			}
		}
		else if($_open_mltcomment === true) {
			if(starts($_chars, "*/\n")) {
				$_index+=2;
				$_open_mltcomment=false;
			}
			else if(starts($_chars, "*/")) {
				$_index+=1;
				$_open_mltcomment=false;
			}
		}
		else if($_open_sngstring === true) {
			
		}
		else if($_open_dblstring === true) {
			
		}
	}
}
print $result."\n";