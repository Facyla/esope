define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	$(document).on('click', '.qID', function() {
		var faqguid = $(this).data('faqguid');
		$('#aID' + faqguid).toggle();
	});
	
	$(document).on('click', '.faqedit', function() {
		var faqguid = $(this).data('faqguid');
		document.location.href= elgg.get_site_url() + "faq/edit?id=" + faqguid;
	});

	$(document).on('click', '.delForm', function() {
		var faqguid = $(this).data('faqguid');

		if (confirm(elgg.echo("faq:delete:confirm"))) {
			elgg.action('faq/delete', {
				data: {guid: faqguid},
				success: function(res) {
					var success = res.success;
					var msg = res.message;
					if (!success) {
						elgg.register_error(msg, 2000);
					} else {
						elgg.system_message(msg, 2000);
						document.location.reload(true);
					}
				}
			});
		}
	});
});
