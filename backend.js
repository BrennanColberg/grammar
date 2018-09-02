"use strict";
(function() {
	
	window.addEventListener("load", function() {
		
		ajaxGET("backend/info.php?grammar=english&mode=keys", loadKeyOptions);
		
	});
	
	function loadKeyOptions(json) {
		let key = $("key");
		console.log(json);
		let data = JSON.parse(json);
		console.log(data);
		for (let i = 0; i < data.length; i++) {
			let option = ce("option");
			option.value = data[i];
			option.textContent = data[i];
			key.appendChild(option);
		}
	}
	
})();