//elgg.provide('elgg.survey.survey');
define(function(require) {
	var $ = require('jquery');
	
	/**
	 * Initialize the survey editing javascript
	 */
	var moduleInit = function() {
		$('.survey-show-link').on('click', toggleResults);

		$('.survey-response-button').on('click', function(e) {
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
	var toggleResults = function(e) {
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


	// Init module
	elgg.register_hook_handler('init', 'system', moduleInit);
	
	
	// return a module (can be used as slider.switchMode)
	return {
		/*
		editMode: editMode,
		switchMode: switchMode,
		addSlide: addSlide
		*/
	};
});


