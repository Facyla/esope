define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	$('#searchForm').on('submit', function() {
		if ($('#searchForm input[name="search"]').val() != "") {
			$('#result').hide();
			$('#waiting').show();
			$('#result').html('');

			$.post(elgg.get_site_url() + 'action/faq/search', $('#searchForm').serialize(), function(data) {
				$('#result').html(data);
				$('#waiting').hide();
				$('#result').show();
			});
		}

		return false;
	});
});
