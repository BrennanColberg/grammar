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
		$definition = $grammar[$key];
	} else if (in_array(word_to_key($key), array_keys($grammar))) {
		$definition = $grammar[word_to_key($key)];
	} else {
		print("yo wtf that's an invalid input dumbass");
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
		print($start_tag);
		
		print_r($grammar);
		
		print($end_tag);
	}
	
} ?>