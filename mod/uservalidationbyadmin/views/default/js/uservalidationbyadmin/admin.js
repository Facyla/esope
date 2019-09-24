define(['jquery', 'elgg'], function($, elgg) {
	elgg.provide("elgg.uservalidationbyadmin");
	
	elgg.uservalidationbyadmin.check_all = function() {
		if ($(this).prop("checked")) {
			// so check everything
			$("#uservalidationbyadmin-wrapper input[type='checkbox'][name='user_guids[]']").prop("checked", true);
		} else {
			// uncheck everything
			$("#uservalidationbyadmin-wrapper input[type='checkbox'][name='user_guids[]']").prop("checked", false);
		}
	};
	
	elgg.uservalidationbyadmin.bulk_action = function() {
		var $checked = $("#uservalidationbyadmin-wrapper input[type='checkbox'][name='user_guids[]']:checked");
	
		if ($checked.length > 0) {
			var $href = $(this).attr("href");
			$href = $href + "&" + $checked.serialize();
	
			$(this).attr("href", $href);
		} else {
			alert(elgg.echo("uservalidationbyadmin:bulk_action:select"));
			return false;
		}
		
		return undefined;
	};
	
	elgg.uservalidationbyadmin.init = function() {
		// (un)check all users
		$(document).on("click", "#uservalidationbyadmin-check-all", elgg.uservalidationbyadmin.check_all);
	
		// bulk actions
		$(document).on("click", "#uservalidationbyadmin-bulk-validate", elgg.uservalidationbyadmin.bulk_action);
		$(document).on("click", "#uservalidationbyadmin-bulk-delete", elgg.uservalidationbyadmin.bulk_action);
	};
	
	elgg.register_hook_handler("init", "system", elgg.uservalidationbyadmin.init);
});
