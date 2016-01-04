define(function(require) {
	var elgg = require("elgg");
	var $ = require("jquery");

	$(document).ready(function() {
		var hash=location.hash;
		if (hash) {
			var aID = '#aID' + hash.substring(4);
			$(aID).show();
		}
	});
});
