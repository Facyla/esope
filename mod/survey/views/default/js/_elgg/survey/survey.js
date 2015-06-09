/**
 * Poll javascript
 */
define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');

	/**
	 * Initialize the plugin javascript
	 */
	init = function() {
		$('.survey-show-link').live('click', toggleResults);

		$('.survey-response-button').live('click', function(e) {
			var guid = $(this).attr("rel");

			// submit the response and display the response when it arrives
			elgg.action('action/survey/response', {
				data: $('#survey-response-form-' + guid).serialize(),
				success: function(response) {
					if (response.output) {
						$('#survey-container-' + guid).html(response.output);
					}
				}
			});

			e.preventDefault();
		});
	};

	/**
	 * Toggle between survey voting form and the results
	 *
	 * @param {Object} e The click event
	 */
	toggleResults = function(e) {
		var guid = $(this).data('guid');

		if ($("#survey-response-form-" + guid).is(":visible")) {
			$(this).html(elgg.echo('survey:show_survey'));
		} else {
			$(this).html(elgg.echo('survey:show_results'));
		}

		$("#survey-response-form-" + guid).toggle();
		$("#survey-post-body-" + guid).toggle();

		e.preventDefault();
	};

	elgg.register_hook_handler('init', 'system', init);
});
