"use strict";
(function() {
	
	window.addEventListener("load", function() {
		$("grammar").onchange = selectGrammar;
		$("key").onchange = generate;
		$("generate").onclick = generate;
		ajaxGET("backend/info.php?mode=list", loadGrammarOptions);
	});
	
	function selectGrammar() {
		ajaxGET("backend/info.php?mode=list&grammar=" + this.value, loadKeyOptions);
	}
	
	function generate() {
		let grammar = $("grammar").value;
		console.log("grammar is " + grammar);
		let key = $("key").value;
		console.log("key is " + key);
		let quantity = $("quantity").value;
		console.log("quantity is " + quantity);
		ajaxGET("backend/generate.php?format=p&grammar=" + grammar + "&key=" + key + "&quantity=" + quantity, function(html) {
			$("output").innerHTML = html;
		});
	}
	
	function loadGrammarOptions(json) {
		let select = $("grammar");
		while (select.firstChild) {
			select.removeChild(select.firstChild);
		}
		let data = JSON.parse(json);
		for (let i = 0; i < data.length; i++) {
			let option = ce("option");
			option.value = data[i];
			option.textContent = data[i];
			select.appendChild(option);
		}
		ajaxGET("backend/info.php?mode=list&grammar=" + $("grammar").value, loadKeyOptions);
	}
	
	function loadKeyOptions(json) {
		let select = $("key");
		while (select.firstChild) {
			select.removeChild(select.firstChild);
		}
		let data = JSON.parse(json);
		for (let i = 0; i < data.length; i++) {
			let option = ce("option");
			option.value = data[i]["key"];
			option.textContent = data[i]["name"];
			select.appendChild(option);
		}
	}
	
})();