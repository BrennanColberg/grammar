<?php

/*************************************************************************

DESCRIPTION:
 * This PHP file is used solely by others; it provides the machinations
 * which parse the various files used to define a language.

NO GET REQUEST FORMAT
NO POST REQUEST FORMAT

*************************************************************************/

# Returns a specified grammar in the form of an associative array
# holding its grammatical structure (in JSON). Associative array format:
#	key => array(def0, def1, def2, ...)
#	key2 => array(def0, def1, def2, ...)
#	...
function parse_grammar($grammar) {
	
	# parses the file into an array (with each line as an element)
	$file = parse_file($grammar, "language.txt");
	
	# iterates through each line, looking for a definition and processing
	# said definition into the result
	$result = array();
	for ($i = 0; $i < count($file); $i++) {
		
		# parses out basics (key, raw definitions, etc)
		$line = explode("::=", $file[$i]);
		$key = trim($line[0]);
		$raw_definitions = explode("|", $line[1]);
		
		# independently evaluates each potential definition to see
		# if it is valid (or expandable) or not
		$valid_definitions = array();
		for ($d = 0; $d < count($raw_definitions); $d++) {
			$definition = trim($raw_definitions[$d]);
			
			# if the definition links to a file, that file is opened and
			# each line within it is added as a separate definition
			# to this term's list
			$is_link = $definition[0] === "!";	# format: "!file.txt"
			if ($is_link) {
				# parses the file into lines
				$link = substr($definition, 1);
				$file_lines = parse_file($grammar, $link);
				# each non-null line is added to the definition list
				for ($l = 0; $l < count($file_lines); $l++) {
					$line = trim($file_lines[$l]);
					if ($line) {
						$valid_definitions[] = $line;
					}
				}
			}
			
			# if the definition isn't a link, and it's not null, then
			# it's added to the list of valid definitions
			else if ($definition) {
				$valid_definitions[] = $definition;
			}
		}
		
		# if the key has any definitions, the key and its definitions
		# are added to the produced associative array
		if (count($valid_definitions)) {
			$result[$key] = $valid_definitions;
		}
	}
	
	return $result;
}

# Returns a specified grammar's display options, in display order, in the
# form of an associative array (in JSON). Associative array format:
#	key => "Key"
#	key2 => "Key 2"
#	...
function parse_display($grammar) {
	# parses file to lines
	$file = parse_file($grammar, "display.txt");
	# iterates through each line to fetch a definition
	$result = array();
	for ($i = 0; $i < count($file); $i++) {
		# parses passed line into constituent elements
		$line = explode("=", $file[$i]);
		$key = trim($line[0]);
		$text = trim($line[1]);
		# if both key and text are valid, adds this match to resulting
		# associative array
		if ($key && $text) {
			$result[$key] = $text;
		}
	}
	return $result;
}

# parses a file into its constituent lines for easy addition to a
# definition list in parse_grammar
function parse_file($grammar, $file_name) {
	$file = file_get_contents("../grammars/$grammar/$file_name");
	return explode("\n", $file);
}

?> 