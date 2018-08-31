<?php {
	
#	generate.php -- GET used to generate phrases
#		> grammar -- the grammar to use, corresponding to a folder within 	\"grammars" in the file navigator [math, japanese]
#		> key -- the tag within the language with which to generate phrases
#		> format -- the HTML tag within which to embed each phrase [p, a, div, section, li, ...] (if none, it won't be within a tag)
#		> quantity -- the number of phrases to generate
	
	include("grammarParser.php");
	
	# loading the specified grammar into $grammar
	$grammar = parse_grammar($_GET["grammar"]);
	
	# getting the key and validating that the grammar contains it
	$key = $_GET["key"];
	if (in_array($key, array_keys($grammar))) {
		$definitions = $grammar[$key];
	} else {
		exit();
	}
	
	# HTML format within which to output calculated value
	$format = $_GET["format"];
	$start_tag = $format ? "<$format>" : "";
	$end_tag = $format ? "</$format>\n" : "";
	
	# number of times to calculate and output a new value
	$quantity = $_GET["quantity"];
	if (!$quantity) $quantity = 1;
	
	# iterates calculation and output of the appropriately generated value
	for ($i = 0; $i < $quantity; $i++) {
		print($start_tag);	# starting HTML tag for each value
		
		# PLACEHOLDER -- prints out calculated grammar strucutre from the
		# function parse_grammar in grammarParser.php
		# print_r($grammar);

		$string = fulfill_tags($key, $grammar);
		print($string);
		
		print($end_tag);	# ending HTML tag for each value
	}
	
	function fulfill_tags($string, $grammar) {
		$result = $string;
		for ($i = 0; $i < count(array_keys($grammar)); $i++) {
			$key = array_keys($grammar)[$i];
			$strpos = strpos($string, $key);
			if (strpos($result, $key) !== false) {
				print("wow there's a $key!\n");
				$chosen_index = mt_rand(0, count($grammar[$key]) - 1);
				$chosen_definition = $grammar[$key][$chosen_index];
				print("replacing it with '$chosen_definition'...\n");
				$result = str_replace($key, $chosen_definition, $result);
				print("...and now it reads '$result'!\n\n");
				$result = fulfill_tags($result, $grammar);
			}
		}
		return $result;
	}
	
} ?>