elgg.provide('elgg.survey.edit');


// Total number of questions
var qnum = 0;

/**
 * Initialize the survey editing javascript
 */
elgg.survey.edit.init = function() {
	$('#add-question').live('click', elgg.survey.edit.addQuestion);
	$('.delete-question').live('click', elgg.survey.edit.deleteQuestion);
	qnum = parseInt($('#number-of-questions').val());
};


/**
 * Add a new empty question fieldset to the form
 *
 * @param {Object} e The click event
 */
elgg.survey.edit.addQuestion = function(e) {
	// Create a new question fieldset elements, rewritten as JS to include qnum param
	// Question object meta : title, description, input_type, options, empty_value, required
	
	var q_title = '<p><label>' + elgg.echo('survey:question:title') + ' <input type="text" class="survey_input-question-title" name="question_title_' + qnum + '" /></label></p>';
	
	var q_description = '<p><label>' + elgg.echo('survey:question:description') + ' <textarea class="survey_input-question-description" name="question_description_' + qnum + '"></textarea>';
	
	var q_input_type = '<p><label>' + elgg.echo('survey:question:input_type') + ' <select class="survey_input-question-input-type" name="question_input_type_' + qnum + '">' 
			+ '<option value="text">' + elgg.echo('survey:type:text') + '</option>' 
			+ '<option value="plaintext">' + elgg.echo('survey:type:plaintext') + '</option>' 
			+ '<option value="dropdown">' + elgg.echo('survey:type:dropdown') + '</option>' 
			+ '<option value="checkboxes">' + elgg.echo('survey:type:checkboxes') + '</option>' 
			+ '<option value="multiselect">' + elgg.echo('survey:type:multiselect') + '</option>' 
			+ '<option value="rating">' + elgg.echo('survey:type:rating') + '</option>' 
			+ '<option value="date">' + elgg.echo('survey:type:date') + '</option>' 
		+ '</select></label></p>';
	
	var q_options = '<p><label>' + elgg.echo('survey:question:options') + ' <textarea class="survey_input-question-options" name="question_options_' + qnum + '"></textarea></label></p>';
	
	var q_empty_value = '<p><label>' + elgg.echo('survey:question:empty_value') + ' <select class="survey_input-question-empty-value" name="question_empty_value_' + qnum + '">' 
			+ '<option value="yes">' + elgg.echo('survey:option:yes') + '</option>' 
			+ '<option value="no">' + elgg.echo('survey:option:no') + '</option>' 
		+ '</select></label></p>';
	
	var q_required = '<p><label>' + elgg.echo('survey:question:required') + ' <select class="survey_input-question-required" name="question_required_' + qnum + '">' 
			+ '<option value="yes">' + elgg.echo('survey:option:yes') + '</option>' 
			+ '<option value="no">' + elgg.echo('survey:option:no') + '</option>' 
		+ '</select></label></p>';
	
	var deleteIcon = '<img src="' + elgg.get_site_url() + 'mod/survey/graphics/16-em-cross.png">';
	var deleteLink = '<a href="#" class="delete-choice" title="' + elgg.echo('survey:delete_choice') + '" data-id="' + qnum + '">' + deleteIcon + '</a>';
	
	var container = '<div id="question-container-' + qnum + '">' 
			+ '<fieldset class="survey_input-question">' 
				+ '<span style="float:right">' + deleteLink + '</span>' 
				+ q_title 
				+ q_description 
				+ q_input_type 
				+ q_options 
				+ q_empty_value 
				+ q_required 
			+ '</fieldset>' 
		+ '</div>';
	
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
elgg.survey.edit.deleteQuestion = function(e) {
	var id = $(this).data('id');
	$('#question-container-' + id).remove();
	e.preventDefault();
}

elgg.register_hook_handler('init', 'system', elgg.survey.edit.init);


