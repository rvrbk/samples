base.figuratief = ({
	drag: false,
	interval: null,
	piecedimensions: false,
	speed: 20,
	moveby: 1,
	Init: function() {
		var scope = this;
		
		base.core.Include("/mbrouwers/client/tools/mousewheel.js");
		
		$(".overview").on("mousewheel", function(event) {
			$(".overview").find("ul").each(function(index) {
				if(index == 1) {
					$(this).css("margin-top", "-=" + (10 *event.deltaFactor) + "px");
				}
				else {
					$(this).css("margin-top", "+=" + (10 *event.deltaFactor) + "px");
				}
			});
		});

		$(".overview").on("mouseover", "li", function() {
			window.clearInterval(scope.interval);
		});
		
		$(".overview").on("mouseleave", "li", function() {
			scope.initListMove();
		});
		
		$("aside.controls").each(function() {
			$(this).find(".play").click(function(e) {
				e.preventDefault();
				
				scope.initListMove();
			});
			
			$(this).find(".pause").click(function(e) {
				e.preventDefault();
				
				window.clearInterval(scope.interval);
			});
		});
		
		var index = 1;
		
		if(!$(".overview").find("ul:eq(1)").is(":hidden")) {
			$(".overview").find("ul:eq(0)").each(function() {
				$(this).find("li").each(function() {
					var tilebottomoffset = ($(this).offset().top + $(this).height());
					var screenheight = $(window).height();
					
					if(tilebottomoffset > screenheight) {
						index = parseInt($(this).attr("seq"));
						
						return false;
					}
					
					index++;
				});
				
				var topcss = 0;
				
				if($(".overview").find("ul:eq(0)").find("li:eq(" + index + ")").position() != undefined) {
					topcss = $(".overview").find("ul:eq(0)").find("li:eq(" + index + ")").position().top;
				}
				
				$(".overview").find("ul:eq(1)").css("top", "-" + topcss + "px");
			});
		}
		
		var index = 1;
		
		if(!$(".overview").find("ul:eq(2)").is(":hidden")) {
			$(".overview").find("ul:eq(1)").each(function() {
				$(this).find("li").each(function() {
					var tilebottomoffset = ($(this).offset().top + $(this).height());
					var screenheight = $(window).height();
					
					if(tilebottomoffset > screenheight) {
						index = parseInt($(this).attr("seq"));
						
						return false;
					}
					
					index++;
				});
				
				var topcss = 0;
				
				if($(".overview").find("ul:eq(1)").find("li:eq(" + index + ")").position() != undefined) {
					topcss = $(".overview").find("ul:eq(1)").find("li:eq(" + index + ")").position().top;
				}
				
				$(".overview").find("ul:eq(2)").css("top", "-" + topcss + "px");
			});
		}
		
		base.core.Ajax({
			model: "ViewHelper",
			action: "getViewColumnByModuleCode",
			params: {
				modulecode: "GENERAL",
				locale: "nl/NL",
				name: "speedometer"
			},
			callback: function(response) {
				if(response) {
					switch(response) {
						case "Snel":
							scope.speed = 30;
							scope.moveby = 3;
													
						break;
						case "Normaal":
							scope.speed = 50;
							scope.moveby = 2;
													
						break;
						case "Langzaam":
							scope.speed = 70;
							scope.moveby = 1;
													
						break;
					}
				}
				
				scope.initListMove();
			}
		});
		
		this.initTileAppend();
	},
	initTileAppend: function() {
		var scope = this;
		
		var interval = window.setInterval(function() {
			$(".overview").find("ul").each(function(index) {
				var ul = $(this);
				
				switch(index) {
					case 0:
					case 2:
						if($(this).find("li:first").offset().top > -($(this).find("li:first").outerHeight() +27)) {								
							var e = $(this).find("li:last").clone();
							var height = $(this).find("li:last").outerHeight();
				
							$(this).prepend("<li>" + e.html() + "</li>");
							$(this).find("li:last").remove();
							
							$(this).css("margin-top", "-=" + (height +27) + "px");
						}
						
					break;
					case 1:
						if($(this).find("li:first").offset().top < -($(this).find("li:first").outerHeight() +27)) {								
							var e = $(this).find("li:first").clone();
							var height = $(this).find("li:first").outerHeight();
				
							$(this).append("<li>" + e.html() + "</li>");
							$(this).find("li:first").remove();
							
							$(this).css("margin-top", "+=" + (height +27) + "px");
						}
					
					break;
				}
			});
		}, 100);
	},
	initListMove: function() {
		var scope = this;

		scope.interval = window.setInterval(function() {
			$(".overview").each(function() {
				$(this).find("ul").each(function(index) {
					switch(index) {
						case 0:
						case 2:
							$(this).animate({
								"top": "+=" + scope.moveby + "px"
							}, scope.speed, "linear");
						
						break;
						case 1:
							$(this).animate({
								"top": "-=" + scope.moveby + "px"
							}, scope.speed, "linear");
							
						break;
					}	
				});
			});
		}, scope.speed);
	}
});
