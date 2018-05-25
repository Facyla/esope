<?php
/* Méthodes qui fonctionnent hors requireJS
If you want to change the value of one of the options after you've already initialized the widget then you would need to use this api:
$('#datepicker').datepicker('option', 'onSelect', function() {  });

Or alternatively, you could attach a handler using jQuery's bind function:
$('#datepicker').bind('onSelect', function() {  });

$('#datepicker').datepicker('option', {onClose: function() {...}});

// Important : inutile de créer des variables, comme on utilise des handlers il faudrait les réécrire dans chacun
*/
?>

/* Event_calendar
 * If start date >= end date : force end date to start date and set minimum date
 * Also adjust times
 */

$(document).ready(function() {
	
	// Set min end date == start date
	$('input[name="end_date"]').on('focusin', function(e) {
		$('input[name="end_date"]').datepicker('option', 'minDate', $('input[name="start_date"]').datepicker('getDate'));
	});
	
	//alert($('select[name="start_time_hour"]').val() + " > " + $('select[name="end_time_hour"]').val() + " vs " + Number($('select[name="start_time_hour"]').val())  + " > " + Number($('select[name="end_time_hour"]').val()) );
	//alert(typeof $('select[name="start_time_hour"]').val() + " > " + typeof $('select[name="end_time_hour"]').val() + " vs " + typeof Number($('select[name="start_time_hour"]').val())  + " > " + typeof Number($('select[name="end_time_hour"]').val()) );
	
	// Force end time if same date
	$('select[name="start_time_hour"]').on('change', function(e) {
		if ($('input[name="end_date"]').datepicker('getDate') <= $('input[name="start_date"]').datepicker('getDate')) {
			// Adjust hours
			if (Number($('select[name="start_time_hour"]').val()) > Number($('select[name="end_time_hour"]').val())) {
				$('select[name="end_time_hour"]').val($('select[name="start_time_hour"]').val());
				// Also adjust minutes
				$('select[name="end_time_minute"]').val($('select[name="start_time_minute"]').val());
			}
		}
	});
	$('select[name="end_time_hour"]').on('change', function(e) {
		if ($('input[name="end_date"]').datepicker('getDate') <= $('input[name="start_date"]').datepicker('getDate')) {
			// Adjust hours
			if (Number($('select[name="start_time_hour"]').val()) > Number($('select[name="end_time_hour"]').val())) {
				$('select[name="end_time_hour"]').val($('select[name="start_time_hour"]').val());
				// Also adjust minutes
				if (Number($('select[name="start_time_minute"]').val()) > Number($('select[name="end_time_minute"]').val())) {
					$('select[name="end_time_minute"]').val($('select[name="start_time_minute"]').val());
				}
			}
		}
	});
	// Adjust minutes if same date and hour
	$('select[name="start_time_minute"]').on('change', function(e) {
		if ($('input[name="end_date"]').datepicker('getDate') <= $('input[name="start_date"]').datepicker('getDate')) {
			if (Number($('select[name="start_time_hour"]').val()) >= Number($('select[name="end_time_hour"]').val())) {
				if (Number($('select[name="start_time_minute"]').val()) > Number($('select[name="end_time_minute"]').val())) {
					$('select[name="end_time_minute"]').val($('select[name="start_time_minute"]').val());
				}
			}
		}
	});
	$('select[name="end_time_minute"]').on('change', function(e) {
		if ($('input[name="end_date"]').datepicker('getDate') <= $('input[name="start_date"]').datepicker('getDate')) {
			if (Number($('select[name="start_time_hour"]').val()) >= Number($('select[name="end_time_hour"]').val())) {
				if (Number($('select[name="start_time_minute"]').val()) > Number($('select[name="end_time_minute"]').val())) {
					$('select[name="end_time_minute"]').val($('select[name="start_time_minute"]').val());
				}
			}
		}
	});
	
	// Note : use code from {core}/js/ui.js and add custom behaviour here
	$('input[name="start_date"]').datepicker({
		dateFormat: 'yy-mm-dd',
		onSelect: function(dateText) {
			var start = $('input[name="start_date"]').datepicker('getDate');
			var end = $('input[name="end_date"]').datepicker('getDate');
			
			// ESOPE : custom behaviour
			// Set end date and time to start date and time
			if (start >= end) {
				$('input[name="end_date"]').datepicker('setDate', start);
				//console.log($('select[name="start_time_hour"]').val() + " / " +  $('select[name="start_time_minute"]').val() + " // " + $('select[name="end_time_hour"]').val() + " / " +  $('select[name="end_time_minute"]').val());
				// Adjust hours
				if (Number($('select[name="start_time_hour"]').val()) > Number($('select[name="end_time_hour"]').val())) {
					$('select[name="end_time_hour"]').val($('select[name="start_time_hour"]').val());
				}
				// Adjust minutes
				if (Number($('select[name="start_time_minute"]').val()) > Number($('select[name="end_time_minute"]').val())) {
					$('select[name="end_time_minute"]').val($('select[name="start_time_minute"]').val());
				}
			}
			
			if ($(this).is('.elgg-input-timestamp')) {
				// convert to unix timestamp
				var dateParts = dateText.split("-");
				var timestamp = Date.UTC(dateParts[0], dateParts[1] - 1, dateParts[2]);
				timestamp = timestamp / 1000;

				var id = $(this).attr('id');
				$('input[name="' + id + '"]').val(timestamp);
			}
		},
		nextText: '&#xBB;',
		prevText: '&#xAB;',
		changeMonth: true,
	});
	
	// Sync time if greater than start time
	$('input[name="end_date"]').datepicker({
		dateFormat: 'yy-mm-dd',
		onSelect: function(dateText) {
			var start = $('input[name="start_date"]').datepicker('getDate');
			var end = $('input[name="end_date"]').datepicker('getDate');
			
			// ESOPE : custom behaviour
			// Set end date and time to start date and time
			if (end <= start) {
				//console.log($('select[name="start_time_hour"]').val() + " / " +  $('select[name="start_time_minute"]').val() + " // " + $('select[name="end_time_hour"]').val() + " / " +  $('select[name="end_time_minute"]').val());
				$('input[name="end_date"]').datepicker('setDate', start);
				// Adjust hours
				if (Number($('select[name="start_time_hour"]').val()) > Number($('select[name="end_time_hour"]').val())) {
					$('select[name="end_time_hour"]').val($('select[name="start_time_hour"]').val());
				}
				// Adjust minutes
				if (Number($('select[name="start_time_minute"]').val()) > Number($('select[name="end_time_minute"]').val())) {
					$('select[name="end_time_minute"]').val($('select[name="start_time_minute"]').val());
				}
			}
			
			if ($(this).is('.elgg-input-timestamp')) {
				// convert to unix timestamp
				var dateParts = dateText.split("-");
				var timestamp = Date.UTC(dateParts[0], dateParts[1] - 1, dateParts[2]);
				timestamp = timestamp / 1000;

				var id = $(this).attr('id');
				$('input[name="' + id + '"]').val(timestamp);
			}
		},
		nextText: '&#xBB;',
		prevText: '&#xAB;',
		changeMonth: true,
	});
	
});

