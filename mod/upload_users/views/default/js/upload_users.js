/**
 * Upload users javascript
 */
define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');

	// If importing custom metadata, show a field for entering the metadata name
	$(document).on('change', '#upload-users-map-form select[name^=header]', function() {
		if ($(this).val() == 'custom') {
			$(this).next('input').show();
		} else {
			$(this).next('input').hide();
		}
	}).trigger('change');

	// Notify user that it may take a long time to process the CSV and they
	// should not leave the page until processing has finished.
	// TODO Remove from js and pass as 'confirm' parameter into the input/url view.
	$(document).on('click', '.upload-users-warning', function(e) {
		var confirmText = $(this).attr('rel') || elgg.echo('question:areyousure');
		if (!confirm(confirmText)) {
			e.preventDefault();
		}
	});
});