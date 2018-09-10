<?php

/**
 * This PHP file is used by backend.js, by GET request, to generate values
 * from a grammar and specified key. It uses a grammar model created by
 * grammarParser.php to recursively replace keys with appropriate
 * definitions, thereby generating interesting results in a very
 * optimized fashion.
**/

header('Content-Type: text/html');
include("grammarParser.php");

# loading GET inputs
$grammar = parse_grammar($_GET["grammar"]);
$string = $_GET["string"];
$quantity = $_GET["quantity"];
$format = $_GET["format"]; # hella vulnerable to HTML injection

# checking that the grammar exists
if (!$grammar) exit();
# checks that a quantity has been specified, defaulting to 1
if (!$quantity || $quantity < 0) $quantity = 1;
# checks that a format has been specified, defaulting to "p" (<p>)
if (!$format) $format = "p";

# iterates calculation and output of the appropriately generated value
for ($i = 0; $i < $quantity; $i++) {
	print("<$format>");	# starting HTML tag for each value
	print(fulfill_keys($string, $grammar)); # generated HTML content
	print("</$format>\n");	# ending HTML tag for each value
}

# recursive function that takes in a string and continually replaces
# each valid grammatical key with one of its definitions at random until
# all keys have been fulfilled
function fulfill_keys($string, $grammar) {
	# iterates through each key in the grammar
	for ($i = 0; $i < count(array_keys($grammar)); $i++) {
		$key = array_keys($grammar)[$i];
		# every time there's an instance of the key in the string...
		while (strpos($string, $key) !== false) {
			
			### SELECTS VALID DEFINITION ###
			# chooses one of the key's definitions at random
			$definition_index = mt_rand(0, count($grammar[$key]) - 1);
			$definition = $grammar[$key][$definition_index];
			# recursively replaces any keys within the new definition
			# with their definitions, before moving on to use it in
			# the final resulting string
			$definition = fulfill_keys($definition, $grammar);
			
			### REPLACES KEY WITH DEFINITION ###
			# finds the index where the key exists in the string
			$key_index = strpos($string, $key);
			# separates out the parts of the string before and after the
			# key's first instance
			$prior_string = substr($string, 0, $key_index);
			$latter_string = substr($string, $key_index + strlen($key),
					strlen($string) - strlen($key));
			# inserts definition in the key's old place
			$string = $prior_string . $definition . $latter_string;
			
		}
	}
	return $string;
}

?>