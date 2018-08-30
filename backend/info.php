<?php {
	
#	info.php -- GET used to get info about a grammar
#	> mode -- defining which action to use
#		= exists -- returns boolean value about the grammar existing
#		= keys -- returns a JSON array of the grammar's keys, in strings
#		= define -- returns JSON array of the key's definitions
#	> grammar -- the grammar to get info about
#	> key -- the key to get info about
	
	$mode = $_GET["mode"];
	$grammar = $_GET["grammar"];
	$key = $_GET["key"];
	
	if ($mode === "exists" && $grammar) {
		
		
	} else if ($mode === "url" && $grammar) {
		
		
	} else if ($mode === "keys" && $grammar) {
		include('grammarParser.php');
		header('Content-Type: application/json');
		$grammar_rules = parse_grammar($grammar);
		if ($grammar_rules) {	# grammar must be valid
			$keys = array_keys($grammar_rules);
			print(json_encode($keys));
		}
	} else if ($mode === "define" && $grammar && $key) {
		include('grammarParser.php');
		header('Content-Type: application/json');
		$grammar_rules = parse_grammar($grammar);
		if ($grammar_rules) {	# grammar must be valid
			$definitions = $grammar_rules[$key];
			if ($definitions) {	# key must be valid
				print(json_encode($definitions));
			}
		}
	}
	
} ?>