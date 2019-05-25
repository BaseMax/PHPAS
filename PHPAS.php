<?php
/**
*
* @Name : PHPAS/PHPAS.php (PHP Beautifier)
* @Version : 1.0
* @Programmer : Max
* @Date : 2019-05-25
* @Released under : https://github.com/BaseMax/PHPAS/blob/master/LICENSE
* @Repository : https://github.com/BaseMax/PHPAS
*
**/
class AutoStyle {
	public $_filename;
	public $_input;
	public $_open_tag=false;

	public $_ident=0;
	public $_idents=[];

	public $_open_string="";
	public $_open_dblstring=false;
	public $_open_sngstring=false;

	public $_open_comment="";
	public $_open_sngcomment=false;
	public $_open_mltcomment=false;

	public $_open_for=false;
	public $_open_for_code="";

	public $_index=0;
	public $result="";

	public $_char=null;
	public $_chars=null;
	public $_char_next_next_next_next=null;
	public $_char_next_next_next=null;
	public $_char_next_next=null;
	public $_char_next=null;

	// startsWith
	public function starts($input, $need) {
		$length=strlen($need);
		return(substr($input, 0, $length) === $need);
	}

	// endsWith
	public function ends($input, $need) {
		$length = strlen($need);
		if($length == 0) {
			return true;
		}
		return (substr($input, -$length) === $need);
	}

	// construct
	public function __construct($filename) {
		$this->_filename=$filename;
		$this->_input=file_get_contents($this->_filename);
		$this->_length=mb_strlen($this->_input);
		$this->parse();
		// $this->solve();
	}

	// getLastCharacter
	private function getLastCharacter($input) {
		return mb_substr($input, -1);
	}

	// solve
	private function solve() {
		$this->result=str_replace("\n\n\n", "\n", $this->result);
		$this->result=str_replace("\n\n", "\n", $this->result);
		$this->result=str_replace("\n\n", "\n", $this->result);
		// $count=substr_count($this->input, "\n");
	}
	// update
	private function update() {
		$this->_chars=null;
		$this->_char_next_next_next_next=null;
		$this->_char_next_next_next=null;
		$this->_char_next_next=null;
		$this->_char_next=null;

		$this->_chars=mb_substr($this->_input, $this->_index, 5);
		$this->_char_length=mb_strlen($this->_chars);
		if($this->_char_length == 5) {
			$this->_char_next_next_next_next=$this->_chars[4];
		}
		if($this->_char_length >= 4) {
			$this->_char_next_next_next=$this->_chars[3];
		}
		if($this->_char_length >= 3) {
			$this->_char_next_next=$this->_chars[2];
		}
		if($this->_char_length >= 2) {
			$this->_char_next=$this->_chars[1];
		}
		if($this->_char_length >= 1) {
			$this->_char=$this->_chars[0];
		}
	}

	// repeat
	public function repeat($time, $string) {
		$result="";
		for($index=0;$index<$time;$index++) {
			$result.=$string;
		}
		return $result;
	}

	// removeLastLine
	public function removeLastLine() {
		// $count=substr_count($this->input, "\n");
		$this->result = join("\n", array_slice(explode("\n", $this->result), 0, -1));
	}

	// parse
	public function parse() {
		for(;$this->_index<$this->_length;$this->_index++) {
			$this->update();
			if($this->_open_tag === false) {
				// if($this->_chars == "<?php" || $this->starts($this->_chars,"<?")) {
				if($this->starts($this->_chars,"<?=")) {
					$this->result.="<?=";
					$this->_open_tag=true;
					$this->_index+=2;
				}
				else if($this->_chars == "<?php") {
					$this->result.="<?php";
					$this->_open_tag=true;
					$this->_index+=4;
				}
				else if($this->starts($this->_chars,"<?")) {
					$this->result.="<?";
					$this->_open_tag=true;
					$this->_index+=1;
				}
				else {
					$this->result.=$this->_char;
				}
			}
			else {
				if($this->_open_sngcomment === false && $this->_open_mltcomment === false && $this->_open_sngstring === false && $this->_open_dblstring === false && $this->_open_for === false) {
					if($this->starts($this->_chars, " ")) { }

					else if($this->starts($this->_chars, "\"")) {
						$this->_open_dblstring=true;
						$this->_open_string="";
					}
	
					else if($this->starts($this->_chars, "'")) {
						$this->_open_sngstring=true;
						$this->_open_string="";
					}

					else if($this->starts($this->_chars, "for")) {
						$temp=$this->_index;
						$this->_index+=3;
						$this->update();
						// Skip whitespace...
						while($this->starts($this->_chars, " ") === true || $this->starts($this->_chars, "\t") === true || $this->starts($this->_chars, "\n") === true) {
							// print "Skip...\n";
							$this->_index++;
							$this->update();
						}
						if($this->_char == '(') {
							$this->_open_for=true;
							$this->_open_for_code="";
							// $this->_index--;
						}
						else {
							$this->_index=$temp;
							$this->update();
							$this->result.=$this->_char;
						}
					}

					else if($this->starts($this->_chars, ",")) {
						$this->result.=", ";
					}

					// We can not check it without parse the all identifier php scanner...
					// 		$a=1; $b=2; => $a=1;\n$b=2;
					// 		for($a=1;$a<4;$a++) => for($a=1; $a<4; $a++)

					else if($this->starts($this->_chars, ";")) {
						$this->result.=";";
						if($this->_char_next != "\n") {
							$this->result.="\n";
							$this->result.=$this->repeat($this->_ident, "\t");
						}
					}

					else if($this->starts($this->_chars, "\t")) { }

					else if($this->starts($this->_chars, "\n")) {
						if($this->getLastCharacter($this->result) != "\n") {
							// continue;
						}
						$this->result.="\n";
						$this->result.=$this->repeat($this->_ident, "\t");
					}

					else if($this->starts($this->_chars, "//")) {
						$this->_open_sngcomment=true;
						$this->_index+=1;
						$this->_open_comment="";
					}

					else if($this->starts($this->_chars, "/*")) {
						$this->_open_mltcomment=true;
						$this->_index+=1;
						$this->_open_comment="";
					}

					else if($this->starts($this->_chars, "{")) {
						$this->_idents[]="{";
						$this->_ident++;
						while($this->starts($this->_chars, " ") === true || $this->starts($this->_chars, "\t") === true || $this->starts($this->_chars, "\n") === true) {
							$this->_index++;
							$this->update();
						}
						$this->_index++;
						$this->result.=" {\n";
						// $this->result.="...";
						$this->result.=$this->repeat($this->_ident, "\t");
					}

					else if($this->starts($this->_chars, "}")) {
						$this->_idents[]="}";
						$this->_ident--;
						while($this->starts($this->_chars, " ") === true || $this->starts($this->_chars, "\t") === true || $this->starts($this->_chars, "\n") === true) {
							$this->_index++;
							$this->update();
						}
						$this->removeLastLine();
						$this->result.="\n";
						$this->result.=$this->repeat($this->_ident, "\t");
						$this->result.="}\n";
					}

					else {
						$this->result.=$this->_char;
					}
				}
				else if($this->_open_dblstring === true) {
					while($this->_char !="\"") {
						$this->_open_string.=$this->_char;
						$this->_index++;
						if($this->_char == "\\" && $this->_char_next == "\"") {
							$this->_index++;
							$this->_open_string.=$this->_char_next;
						}
						$this->update();
					}
					$this->result.="\"";
					$this->result.=$this->_open_string;
					$this->result.="\"";
					$this->_open_dblstring=false;
				}
				else if($this->_open_sngcomment === true) {
					if($this->starts($this->_chars, "\n")) {
						$this->_open_sngcomment=false;
						$this->_open_comment=trim($this->_open_comment);
						if($this->_open_comment != "") {
							$this->result.="// ";
							$this->result.=$this->_open_comment;
							$this->result.="\n";
						}
					}
					else {
						$this->_open_comment.=$this->_char;
					}
				}
				else if($this->_open_mltcomment === true) {
					$this->_do=false;
					if($this->starts($this->_chars, "*/\n")) {
						$this->_do=true;
						$this->_index+=2;
					}
					else if($this->starts($this->_chars, "*/")) {
						$this->_do=true;
						$this->_index+=1;
					}
					else {
						$this->_open_comment.=$this->_char;
					}
					if($this->_do === true) {
						$this->_open_mltcomment=false;
						$this->_open_comment=trim($this->_open_comment);
						if($this->_open_comment != "") {
							$this->_comment_lines=substr_count($this->_open_comment, "\n");
							if($this->_comment_lines > 0) {
								$this->result.="/*\n";
								$this->result.=$this->_open_comment;
								$this->result.="*/\n";
							}
							else {
								$this->result.="/* ";
								$this->result.=$this->_open_comment;
								$this->result.=" */\n";
							}
						}
					}
				}
				else if($this->_open_sngstring === true) {
					while($this->_char !="\'") {
						$this->_open_string.=$this->_char;
						$this->_index++;
						if($this->_char == "\\" && $this->_char_next == "'") {
							$this->_index++;
							$this->_open_string.=$this->_char_next;
						}
						$this->update();
					}
					$this->result.="'";
					$this->result.=$this->_open_string;
					$this->result.="'";
					$this->_open_sngstring=false;
				}
				else if($this->_open_for === true) {
					$this->result.="for(";
					/*
					 * BUG:
					 	for ($k = 3;$k <= ((floor($v - 1/2)+1);
					 		$k++) {

					 * Solved...
					*/
					while($this->_char !== "{") {
						$this->_open_for_code.=$this->_char;
						$this->_index++;
						$this->update();
					}
					$this->_open_for_code=trim($this->_open_for_code);
					$this->result.=$this->_open_for_code;
					$this->result.=" {\n";
					$this->_ident++;
					$this->_idents[]="{";
					$this->result.=$this->repeat($this->_ident, "\t");
					$this->_open_for=false;
				}
			}
		}
	}
}
