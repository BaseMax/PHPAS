<?php
/**
*
* @Name : PHPBeautifier/Parser.php
* @Version : 1.0
* @Programmer : Max
* @Date : 2019-05-25
* @Released under : https://github.com/BaseMax/PHPBeautifier/blob/master/LICENSE
* @Repository : https://github.com/BaseMax/PHPBeautifier
*
**/
class parser {
	public $_filename;
	public $_input;
	public $_open_tag=false;

	public $_ident=0;
	public $_idents=[];

	public $_open_string=false;
	public $_open_dblstring=false;
	public $_open_sngstring=false;

	public $_open_comment="";
	public $_open_sngcomment=false;
	public $_open_mltcomment=false;

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

	public function repeat($time, $string) {
		$result="";
		for($index=0;$index<$time;$index++) {
			$result.=$string;
		}
		return $result;
	}

	public function removeLastLine() {
		// $count=substr_count($this->input, "\n");
		$this->result = join("\n", array_slice(explode("\n", $this->result), 0, -1));
	}

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
				if($this->_open_sngcomment === false && $this->_open_mltcomment === false && $this->_open_sngstring === false && $this->_open_dblstring === false) {
					if($this->starts($this->_chars, " ")) { }

					else if($this->starts($this->_chars, "\t")) { }

					else if($this->starts($this->_chars, "\n")) {
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
				else if($this->resultopen_sngstring === true) {
					
				}
				else if($this->_open_dblstring === true) {
					
				}
			}
		}
	}
}
$parser=new parser("test.php");
print $parser->result."\n";
