<?php {
	
	# formats a certain word into the key notation format for easy adaptation
	#	@sam-masaki edit this to match your personal chosen data format
	function word_to_key($word) {
		return "\$$word";
	}
	
	# Parses a "language.txt" file into an associative array representing
	# a grammatical structure. Associative array format:
	#		key => array(def0, def1, def2, ...)
	function parse_grammar($grammar) {
		
		$file = file_get_contents("../grammars/$grammar/language.txt");
		$file_lines = explode("\n", $file);
		
		$grammar_rules = array();
		for ($i = 0; $i < count($file_lines); $i++) {
			$line = explode("::=", $file_lines[$i]);
			$term = trim($line[0]);
			$definitions = explode("|", $line[1]);
			$grammar_rules[$term] = array();
			for ($d = 0; $d < count($definitions); $d++) {
				$definition = trim($definitions[$d]);
				# testing to see if there's a file in format "!file.txt"
				$is_link = $definition[0] === "!";
				if ($is_link) {
					$link = substr($definition, 1);
					$definition_list = parse_file($grammar, $link);
					for ($l = 0; $l < count($definition_list); $l++) {
						$grammar_rules[$term][] = $definition_list[$l];
					}
				} else {
					$grammar_rules[$term][] = $definition;
				}
			}
		}
		
		return $grammar_rules;
		
	}
	
	# parses a file into its constituent lines for easy addition to a
	# definition list in parse_grammar
	function parse_file($grammar, $file_name) {
		$file = file_get_contents("../grammars/$grammar/$file_name");
		return explode("\n", $file);
	}
	
} ?>