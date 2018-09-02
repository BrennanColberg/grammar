<?php {
	
#	info.php -- GET used to get info about a grammar
#	> mode -- defining which action to use
#		= list -- returns a JSON array of the specified thing's children
#		= url -- returns the string URL of specified grammar
#	> grammar -- the grammar to get info about
#	> key -- the key to get info about
	
	header('Content-Type: application/json');
	
	$mode = $_GET["mode"];
	$grammar = $_GET["grammar"];
	$key = $_GET["key"];
	
	if ($mode === "url" && $grammar) {
		print(json_encode("../grammars/$grammar/"));
	}
	
	# lists the potential definitions of a key
	else if ($mode === "list" && $grammar && $key) {
		include('grammarParser.php');
		$grammar_rules = parse_grammar($grammar);
		if ($grammar_rules) {	# grammar must be valid
			$definitions = $grammar_rules[$key];
			if ($definitions) {	# key must be valid
				print(json_encode($definitions));
			}
		}
	}
	
	# lists the keys within a grammar
	else if ($mode === "list" && $grammar) {
		include('grammarParser.php');
		$grammar_rules = parse_grammar($grammar);
		if ($grammar_rules) {	# grammar must be valid
			$keys = array_keys($grammar_rules);
			print(json_encode($keys));
		}
	}
	
	# lists all potential grammars
	else if ($mode === "list") {
		$files = scandir("../grammars/");
		$files = array_slice($files, 2);
		print(json_encode($files));
	}
	
} ?>