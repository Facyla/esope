/**
 * @module language_selector/default
 */
define(function (require) {

	var elgg = require('elgg');
	var $ = require('jquery');

	$(document).on('click', '.language-selector-toggle', function(e) {
		var $elem = $(this);
		if ($elem.is('.elgg-state-selected')) {
			// do not change current language
			return false;
		}

		$elem.siblings().andSelf().removeClass('elgg-state-selected');
		$elem.addClass('elgg-state-selected');

		if (!elgg.is_logged_in()) {
			e.preventDefault();
			elgg.session.cookie('client_language', $elem.data('language'), {expires: 30});
			elgg.forward(document.location.href);
		}
	});

});