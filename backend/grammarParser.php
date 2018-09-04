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
		$file = parse_file($grammar, "language.txt");
		$grammar_rules = array();
		for ($i = 0; $i < count($file); $i++) {
			$line = explode("::=", $file[$i]);
			$term = trim($line[0]);
			$definitions = explode("|", $line[1]);
			$term_array = array();
			for ($d = 0; $d < count($definitions); $d++) {
				$definition = trim($definitions[$d]);
				# testing to see if there's a file in format "!file.txt"
				$is_link = $definition[0] === "!";
				if ($is_link) {
					$link = substr($definition, 1);
					$definition_list = parse_file($grammar, $link);
					for ($l = 0; $l < count($definition_list); $l++) {
						if ($definition_list[$l]) { # definition must be non-null
							$grammar_rules[$term][] = $definition_list[$l];
						}
					}
				} else if ($definition) {	# definition must be non-null
					$grammar_rules[$term][] = $definition;
				}
			}
			if (count($term_array)) {	# term array non-empty
				$grammar_rules[$term] = $term_array;
			}
		}
		return $grammar_rules;
	}
	
	# parses a "display" file to find the display names for each
	# tag in a language, etc
	function parse_display($grammar) {
		$file = parse_file($grammar, "display.txt");
		$grammar_display = array();
		for ($i = 0; $i < count($file); $i++) {
			$line = explode("=", $file[$i]);
			$term = trim($line[0]);
			$display = trim($line[1]);
			if ($display) {
				$grammar_display[$term] = $display;
			}
		}
		return $grammar_display;
	}
	
	# parses a file into its constituent lines for easy addition to a
	# definition list in parse_grammar
	function parse_file($grammar, $file_name) {
		$file = file_get_contents("../grammars/$grammar/$file_name");
		return explode("\n", $file);
	}
	
} ?> 