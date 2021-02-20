messaging = {
	init: function() {
		this.hotspots();
	},
	hotspots: function() {
		var scope = this;

		var hotspots = document.querySelectorAll("a[action]");

		for(var index = 0; index < hotspots.length; index++) {
			hotspots[index].onclick = function(e) {
				switch(e.target.getAttribute("action")) {
					case "open-push-dialog":
						new LightFace({ width: "400px", height: "233px", content: "<section class='push-message'>"
								+ "<span class='message'>Het pushbericht is verstuurd.</span>"
								+ "<textarea style='width: 99%; height: 200px;' placeholder='Pushbericht naar alle teams...' name='push-message'></textarea>"
								+ "<div class='button-wrapper'><a href='#' action='send-push' type='" + e.target.getAttribute("type") + "' class='button'>verzenden <figure><img src='/inc/images/loader.svg' /></figure></a>"
								+ "<a href='#' action='close-dialog' class='button alert'>annuleren</a></div>"
							+ "</section>" }).open();

						document.querySelector("textarea[name='push-message']").focus();

						scope.hotspots();

					break;
					case "close-dialog":
						window.location.reload();

					break;
					case "send-push":
						var textarea = document.querySelector("textarea[name='push-message']");
						var message = document.querySelector("span.message");
						var loader = document.querySelector("a[action='send-push'] figure");

						if(textarea.value != "") {
							var xhttp = new XMLHttpRequest();

							xhttp.open("GET", "/inc/json.php?action=send-push&message=" + textarea.value + "&type=" + e.target.getAttribute("type"));
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

							loader.style.display = "inline-block";
							message.style.display = "inline-block";
							textarea.style.display = "none";
						}
						else {
							textarea.classList.add("error");

							window.setTimeout(function() {
								textarea.classList.remove("error");
							}, 800);
						}

					break;
				}
			}
		}
	}
};

document.addEventListener("DOMContentLoaded", messaging.init());