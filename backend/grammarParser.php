<?php {
	
	function parse_grammar($grammar_name) {
		
		$file = file_get_contents("../grammars/$grammar_name/language.txt");
		$file_lines = explode("\n", $file);
		
		$grammar_rules = array();
		for ($i = 0; $i < count($file_lines); $i++) {
			$line = explode("::=", $file_lines[$i]);
			$term = trim($line[0]);
			$definitions = explode("|", $line[1]);
			$grammar_rules[$term] = array();
			for ($d = 0; $d < count($definitions); $d++) {
				$grammar_rules[$term][] = $definitions[$d];
			}
		}
		
		return $grammar_rules;
		
	}
	
} ?>