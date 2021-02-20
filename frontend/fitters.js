loans = {
	init: function() {
		this.hotspots();
	},
	hotspots: function() {
		var hotspots = document.querySelectorAll("a[action]");

		for(var index = 0; index < hotspots.length; index++) {
			hotspots[index].onclick = function(e) {
				switch(e.target.getAttribute("action")) {
					case "add-budget":
						var xhttp = new XMLHttpRequest();

						xhttp.open("GET", "/inc/json.php?action=add-budget&budget=" + textarea.value + "&type=" + e.target.getAttribute("type"));
						xhttp.send();

						xhttp.onload = function() {
							loader.style.display = "none";
						
							window.setTimeout(function() {
								message.style.display = "none";
								textarea.style.display = "inline-block";
								textarea.value = "";
								textarea.focus();	
							}, 800);
						}

					break;
				}
			}
		}
	}
};

document.addEventListener("DOMContentLoaded", loans.init());