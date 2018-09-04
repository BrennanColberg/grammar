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
		$grammar_display = parse_display($grammar);
		if ($grammar_rules && $grammar_display) { # needs definition
			$result = array();
			$rule_keys = array_keys($grammar_rules);
			$display_keys = array_keys($grammar_display);
			for ($i = 0; $i < count($display_keys); $i++) {
				$key = $display_keys[$i];
				if (in_array($key, $rule_keys)) {
					$item = array();
					$item["key"] = $key;
					$item["name"] = $grammar_display[$key];
					$result[] = $item;
				}
			}
			print(json_encode($result));
		}
	}
	
	# lists all potential grammars
	else if ($mode === "list") {
		include('grammarParser.php');
		$grammars = scandir("../grammars/");
		$grammars = array_slice($grammars, 3);
		$display = parse_display(".");
		if ($grammars && $display) {
			$result = array();
			$keys = array_keys($display);
			for ($i = 0; $i < count($keys); $i++) {
				$key = $keys[$i];
				if (in_array($key, $grammars)) {
					$item = array();
					$item["key"] = $key;
					$item["name"] = $display[$key];
					$result[] = $item;
				}
			}
			print(json_encode($result));
		}
	}
	
} ?>