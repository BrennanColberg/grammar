<?php

/*************************************************************************

DESCRIPTION:
 * This file is used by backend.js to know which options to display to
 * the user about available grammars (and keys within those grammars).
 * Always outputting in JSON format, it is easily queriable, and adapts
 * its output (without need for "mode"s) to return the appropriate result
 * for each set of arguments.
 
GET REQUEST FORMAT:
 * "info.php" -- returns displayable list of grammars
 * "info.php?grammar=name" -- returns JSON of a displayable list of keys
 *		within the specified list
 * "info.php?grammar=name&key=$k" -- returns JSON array of the potential
 *		coded definitions for the given key within the given grammar
NO POST REQUEST FORMAT
 
*************************************************************************/

header('Content-Type: application/json');
include('grammarParser.php');

# getting input from GET request
$grammar = $_GET["grammar"];
$key = $_GET["key"];

# prints a JSON-format array of the potential definitions for a
# specified key within a specified grammar, each in string form
if ($grammar && $key) {
	$grammar_rules = parse_grammar($grammar);
	if ($grammar_rules) {	# grammar must be valid
		$definitions = $grammar_rules[$key];
		if ($definitions) {	# key must be valid
			print(json_encode($definitions));
		}
	}
}

# prints a JSON-format array of the selectable keys that exist
# within a specified grammar (each: "key" => "Key", "name" => text,
# in display order)
else if ($grammar) {
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

# prints a JSON-format associative array of all valid grammars, used
# to display (each: "key" => "Key", "name" => text, in display order)
else {
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

?>