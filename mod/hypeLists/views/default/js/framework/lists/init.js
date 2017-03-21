define(function (require) {

	var $ = require('jquery');

	$(document).on('initialize', '.elgg-list,.elgg-gallery,.elgg-no-results', function () {
		var $list = $(this);
		var $container = $list.parent('.elgg-list-container:not(.elgg-state-ready)');
		if (!$container.length) {
			return;
		}

		var options = $container.data();
		require(['hypeList'], function () {
			$list.hypeList(options);
			$container.addClass('elgg-state-ready');
		});
	});

	$(document).on('showLoader.spinner', '.elgg-list,.elgg-gallery', function () {
		if (require.defined('elgg/spinner')) {
			require(['elgg/spinner'], function (spinner) {
				spinner.start();
			});
		} else {
			var cl = $(this).data('classLoading') || 'elgg-state-loading';
			$('body').addClass(cl);
		}
	}).on('hideLoader.spinner', '.elgg-list,.elgg-gallery', function () {
		if (require.defined('elgg/spinner')) {
			require(['elgg/spinner'], function (spinner) {
				spinner.stop();
			});
		} else {
			var cl = $(this).data('classLoading') || 'elgg-state-loading';
			$('body').removeClass(cl);
		}
	});
});
