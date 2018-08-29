<?php {
	
	function parse_grammar($grammar_name) {
		
		$file = file_get_contents("../grammars/$grammar_name/language.txt");
		$file_lines = explode("\n", $file);
		
		$grammar_rules = array();
		for ($i = 0; $i < count($file_lines); $i++) {
			$line = explode("::=", $file_lines[$i]);
			$term = trim($line[0]);
			$definition = trim($line[1]);
			$grammar_rules[$term] = $definition;
		}
		
		return $grammar_rules;
		
	}
	
} ?>