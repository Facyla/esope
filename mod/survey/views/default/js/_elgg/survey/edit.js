/**
 * Poll editing javascript
 */
/* for Elgg 1.10
define(function(require) {
	var $ = require('jquery');
	var elgg = require('elgg');
*/

	// Total number of choices
	//var cnum = 0;
	// Total number of questions
	var qnum = 0;

	/**
	 * Initialize the survey editing javascript
	 */
	//init = function() { // Elgg 1.10
elgg.provide('elgg.poll');
elgg.poll.init = function() {
		//$('#add-choice').live('click', addChoice);
		//$('.delete-choice').live('click', deleteChoice);
		//cnum = parseInt($('#number-of-choices').val());

		$('#add-question').live('click', addQuestion);
		$('.delete-question').live('click', deleteQuestion);
		qnum = parseInt($('#number-of-questions').val());

	};

	/**
	 * Add a new empty text field to the form
	 *
 	 * @param {Object} e The click event
	 */
	/*
	var addChoice = function(e) {
		// Create a new input element
		var input = '<input type="text" class="survey_input-survey-choice" name="choice_text_' + cnum + '"> ';
		var deleteIcon = '<img src="' + elgg.get_site_url() + 'mod/survey/graphics/16-em-cross.png">';
		var deleteLink = '<a href="#" class="delete-choice" title="' + elgg.echo('survey:delete_choice') + '" data-id="' + cnum + '">' + deleteIcon + '</a>';
		var container = '<div id="choice-container-' + cnum + '">' + input + deleteLink + '</div>';
		$('#new-choices-area').append(container);
		// Increment total number of choices
		cnum++;
		$('#number-of-choices').val(cnum);
		e.preventDefault();
	};
	*/

	/**
	 * Remove a survey choice
	 *
 	 * @param {Object} e The click event
	 */
	/*
	function deleteChoice(e) {
		var id = $(this).data('id');
		$('#choice-container-' + id).remove();
		e.preventDefault();
	}
	*/
	
	
	/**
	 * Add a new empty question fieldset to the form
	 *
 	 * @param {Object} e The click event
	 */
	//var addQuestion = function(e) { // Elgg 1.10
	elgg.poll.toggleResults = function(e) {
		// Create a new input element
		// @TODO replace input by the content of the view 'survey/input/question', rewritten as JS to include qnum param
		var fieldset = '<input type="text" class="survey_input-survey-question" name="choice_text_' + qnum + '"> ';
		var deleteIcon = '<img src="' + elgg.get_site_url() + 'mod/survey/graphics/16-em-cross.png">';
		var deleteLink = '<a href="#" class="delete-choice" title="' + elgg.echo('survey:delete_choice') + '" data-id="' + qnum + '">' + deleteIcon + '</a>';
		var container = '<div id="question-container-' + qnum + '">' + fieldset + deleteLink + '</div>';
		$('#new-questions-area').append(container);
		// Increment total number of questions
		qnum++;
		$('#number-of-questions').val(qnum);
		e.preventDefault();
	};


	/**
	 * Remove a survey question
	 *
 	 * @param {Object} e The click event
	 */
	//function deleteQuestion(e) { // Elgg 1.10
	elgg.poll.deleteQuestion = function(e) {
		var id = $(this).data('id');
		$('#question-container-' + id).remove();
		e.preventDefault();
	}

	elgg.register_hook_handler('init', 'system', init);
//}); // Elgg 1.10


