/*************************************************************************
 * This JavaScript file interfaces between the PHP-built backend and the
 * HTML/CSS website frontend. It serves to populate this interface with
 * accurate and functional selection and generation options, allowing
 * the user to request generated grammatical structures with whatever
 * specifications they like.
*************************************************************************/

"use strict";
(function() {
	
	// shortened DOM manipulation methods
	function $(id) { return document.getElementById(id); }
	function ce(tag) { return document.createElement(tag); }
	// generic AJAX GET method, adapted from my code hosted online at
	// https://brennancolberg.github.io/abbr/js/ajax.js
	function ajaxGET(url, onSuccess) {
		fetch(url, { credentials: "include" })
			.then(function(r) { 
				if (r.status >= 200 && r.status < 300) {
					return r.text();
				}
			})
			.then(onSuccess)
			.catch(function(e) { 
				console.log(e);
			});
	}
	
	window.addEventListener("load", function() {
		// loads all of the valid "grammars" from backend
		loadGrammarOptions();
		// sets each input's functionality
		$("grammar").onchange = loadKeyOptions;
		$("key").onchange = generate;
		$("quantity").onchange = generate;
		$("generate").onclick = generate;
	});
	
	// refreshes the output by generating a new set of values
	// called when the "generate" button is clicked, or whenever
	// relevant inputs are updated
	function generate() {
		// gets input values
		let grammar = $("grammar").value;
		let key = $("key").value;
		let quantity = $("quantity").value;
		// queries generate.php for random output based ocnvalues
		ajaxGET("backend/generate.php?grammar=" + grammar + "&string=" +
				key + "&quantity=" + quantity, function(html) {
			$("output").innerHTML = html;
		});
	}
	
	// populates the "grammar" selector with valid options, obtained
	// from backend/info.php in JSON format
	function loadGrammarOptions() {
		ajaxGET("backend/info.php", function(json) {
			loadOptionsJSON($("grammar"), json);
			loadKeyOptions();
		});
	}
	
	// populates the "key" selector with valid options, obtained from
	// backend/info.php in JSON format
	function loadKeyOptions() {
		let grammar = $("grammar").value;
		ajaxGET("backend/info.php?grammar=" + grammar, function(json) {
			loadOptionsJSON($("key"), json);
			generate();
		});
	}
	
	// abstracted method to load JSON options into a given DOM element
	// used to load both "grammar" and "key" selector options
	function loadOptionsJSON(select, json) {
		// clears all prior options
		while (select.firstChild) {
			select.removeChild(select.firstChild);
		}
		// iterates through JSON for option attributes to put in
		// based on the format in each display.txt, parsed through
		// info.php
		let data = JSON.parse(json);
		for (let i = 0; i < data.length; i++) {
			let option = ce("option");
			option.value = data[i]["key"];
			option.textContent = data[i]["name"];
			select.appendChild(option);
		}
	}
	
})();