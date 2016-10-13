//<script>
elgg.provide('elgg.rate');

elgg.rate.init = function() {
	var form = $('.elgg-form-rate-rate');
	form.find('input[type=submit]').live('click', elgg.rate.submit);
};

elgg.rate.submit = function(e) {
	var form = $(this).parents('form');
	var data = form.serialize();
	elgg.action('rate/rate', {
		data: data + "&ajax=1",
		success: function(json) {
			var html = json.output;
			form.html(html);
		}
	});
	e.preventDefault();
};

elgg.register_hook_handler('init', 'system', elgg.rate.init);