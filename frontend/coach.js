coach = {
	init: function() {
		(function($) {
			coach.init_actions();
		})(jQuery);
	},
	init_actions: function() {
		(function($) {
			$("a[action]").each(function() {
				$(this).off();

				$(this).on("click", function() {
					switch($(this).attr("action")) {
						case "save-usernote":
								$.ajax({ url: "/inc/json.php?action=save-usernote&notes=" + $(this).closest("tr").find("textarea[name='user_notes']").val() + "&id=" + $(this).closest("tr").attr("note-id") + "&account_id=" + $("input[name='account_id']").val() }).done(function(response) {
									$("table.tabular").find("tr[note-id='" + response.id + "']").find("td.notes").text(response.notes);

									$("table.tabular").find("tr[note-id='" + response.id + "']").find("a[action='save-usernote']").hide();
									$("table.tabular").find("tr[note-id='" + response.id + "']").find("a[action='edit-usernote']").show();
								});

						break;
						case "delete-usernote":
							if(confirm("Notitie verwijderen?")) { 
								var el = $(this).closest("tr");

								$.ajax({ url: "/inc/json.php?action=delete-usernote&id=" + el.attr("note-id") }).done(function(response) {
									var week = el.closest("table").attr("week");

									el.remove();

									if($("table.tabular[week='" + week + "'] tr td").length == 0) {
										$("table.tabular[week='" + week + "']").remove();
										$("h1.crm-title[week='" + week + "']").remove();
									}
								});	
							}

						break;
						case "edit-usernote":
							$(this).closest("tr").find("td.notes").html("<textarea name='user_notes'>" + $(this).closest("tr").find("td.notes").text() + "</textarea>");

							$(this).closest("tr").find("a[action='save-usernote']").show();
							$(this).closest("tr").find("a[action='edit-usernote']").hide();
						break;
						case "add-usernote":
							$("textarea[name='notes']").animate({ height: "-=" + $("textarea[name='notes']").attr("by") }, 200);

							$.ajax({ url: "/inc/json.php?action=add-usernote&notes=" + $("textarea[name='notes']").val() + "&account_id=" + $("input[name='account_id']").val() }).done(function(response) {
								$("textarea[name='notes']").val("");

								if($("table.tabular[week='" + moment().week() + "']").length == 0) {
									$("section.dossier-notes-data").prepend("<h1 class='crm-title' week='" + moment().week() + "'>Week " + moment().week() + "</h1><table week='" + moment().week() + "' class='tabular'><tr><th>Tijdstip</th><th>Notitie</th><th>Gemaakt door</th><th></th></tr></table>");
								}

								$("table.tabular[week='" + moment().week() + "']").append("<tr note-id='" + response.id + "'><td class='created'>" + moment(response.created).format("DD-MM-YYYY HH:mm") + "</td><td style='width: 460px;' class='notes'>" + response.notes + "</td><td class='created_by'>" + response.ua_firstname + " " + response.ua_lastname + "</td><td><a href='#' action='edit-usernote'>Wijzigen</a>&nbsp;<a href='#' action='save-usernote'>Opslaan</a>&nbsp;<a href='#' action='delete-usernote'>Verwijderen</a></td></tr>");
							
								coach.init_actions();
							});

						break;
					}
				});
			});
		})(jQuery);
	}
};