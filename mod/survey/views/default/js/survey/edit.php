elgg.provide('elgg.survey.edit');


// Total number of questions
var qnum = 0;

/**
 * Initialize the survey editing javascript
 */
elgg.survey.edit.init = function() {
	// Note : 'live' event is for jQuery < 1.7, shoud not be used (prefer 'on' or 'delegate')
	// See http://api.jquery.com/live/ for details
	//$('#add-question').live('click', elgg.survey.edit.addQuestion);
	//$('.delete-question').live('click', elgg.survey.edit.deleteQuestion);
	//$('.survey-input-toggle').live('click', elgg.survey.edit.toggleInput);
	
	// Add/remove question
	$(document).on('click', '#add-question', elgg.survey.edit.addQuestion);
	$(document).on('click', '.delete-question', elgg.survey.edit.deleteQuestion);
	qnum = parseInt($('#number-of-questions').val());
	// Hide/show some question edit form options
	$(document).on('click', '.survey-input-toggle', elgg.survey.edit.toggleInput);
	// Show optional fields
	$(document).on('change', '.survey-input-question-input-type', elgg.survey.edit.showOptions);
};


/**
 * Add a new empty question fieldset to the form
 *
 * @param {Object} e The click event
 */
elgg.survey.edit.addQuestion = function(e) {
	// Create a new question fieldset elements, rewritten as JS to include qnum param
	// Question object meta : title, description, input_type, options, empty_value, required
	
	var q_title = '<p class="question_title_' + qnum + '"><label>' + elgg.echo('survey:question:title') + ' <input type="text" class="survey-input-question-title" name="question_title[]" placeholder="' + elgg.echo('survey:question:title:placeholder') + '" /></label></p>';
	
	/*
	var q_description = '<p class="question_description_' + qnum + '"><a href="#" class="survey-input-toggle" data-id="question_description_' + qnum + '">' + elgg.echo('survey:question:toggle') + '</a> <label>' + elgg.echo('survey:question:description') + ' <textarea class="survey-input-question-description" name="question_description[]" style="display:none;"></textarea>';
	*/
	var q_description = '<p class="question_description_' + qnum + '"><label>' + elgg.echo('survey:question:description') + ' <textarea class="survey-input-question-description" name="question_description[]" placeholder="' + elgg.echo('survey:question:description:placeholder') + '"></textarea>';
	
	var q_required = '<p class="question_required_' + qnum + '" style="float:right;"><label>' + elgg.echo('survey:question:required') + ' <select class="survey-input-question-required" name="question_required">' 
			+ '<option value="no">' + elgg.echo('survey:option:no') + '</option>' 
			+ '<option value="yes">' + elgg.echo('survey:option:yes') + '</option>' 
		+ '</select></label></p>';
	
	var q_input_type = '<p class="question_input_type_' + qnum + '"><label>' + elgg.echo('survey:question:input_type') + ' <select class="survey-input-question-input-type" name="question_input_type[]" data-id="' + qnum + '">' 
			+ '<option value="text">' + elgg.echo('survey:type:text') + '</option>' 
			+ '<option value="plaintext">' + elgg.echo('survey:type:plaintext') + '</option>' 
			+ '<option value="pulldown">' + elgg.echo('survey:type:pulldown') + '</option>' 
			+ '<option value="checkboxes">' + elgg.echo('survey:type:checkboxes') + '</option>' 
			+ '<option value="multiselect">' + elgg.echo('survey:type:multiselect') + '</option>' 
			+ '<option value="rating">' + elgg.echo('survey:type:rating') + '</option>' 
			+ '<option value="date">' + elgg.echo('survey:type:date') + '</option>' 
		+ '</select></label>' 
		+ <?php echo json_encode(elgg_view('survey/input/question_type_help')); ?>
		+ '</p>';
	
	var q_options = '<p class="question_options_' + qnum + '" style="display:none;"><label>' + elgg.echo('survey:question:options') + ' <textarea class="survey-input-question-options" name="question_options[]" placeholder="' + elgg.echo('survey:question:options:placeholder') + '"></textarea></label></p>';
	
	var q_empty_value = '<p class="question_empty_value_' + qnum + '" style="display:none;"><label>' + elgg.echo('survey:question:empty_value') + ' <select class="survey-input-question-empty-value" name="question_empty_value[]">' 
			+ '<option value="no">' + elgg.echo('survey:option:no') + '</option>' 
			+ '<option value="yes">' + elgg.echo('survey:option:yes') + '</option>' 
		+ '</select></label></p>';
	
	//var deleteIcon = '<img src="' + elgg.get_site_url() + 'mod/survey/graphics/16-em-cross.png">';
	var deleteLink = '<a href="#" class="delete-question" title="' + elgg.echo('survey:delete_question') + '" data-id="' + qnum + '"><i class="fa fa-trash"></i></a>';
	
	var container = '<div id="question-container-' + qnum + '">' 
			+ '<fieldset class="survey-input-question">' 
				+ '<span style="float:right">' + deleteLink + '</span>' 
				+ q_title 
				+ '<div class="survey-input-question-details">' 
				+ q_required 
				+ q_input_type 
				+ q_options 
				+ q_empty_value 
				+ q_description 
				+ '</div>' 
			+ '</fieldset>' 
		+ '</div>';
	
	$('#new-questions-area').append(container);
	
	// Increment total number of questions
	qnum++;
	$('#number-of-questions').val(qnum);
	
	e.preventDefault();
};


/** Remove a survey question
 * @param {Object} e The click event
 */
elgg.survey.edit.deleteQuestion = function(e) {
	var id = $(this).data('id');
	$('#question-container-' + id).remove();
	e.preventDefault();
}

/** Toggle an input survey question
 * @param {Object} e The click event
 */
elgg.survey.edit.toggleInput = function(e) {
	var id = $(this).data('id');
	$('[name="' + id + '"]').toggle();
	e.preventDefault();
}

/** Show/Hide a survey question input
 * @param {Object} e The change event
 */
elgg.survey.edit.showOptions = function(e) {
	var select = $(e.target);
	var val = select.val();
	var id = $(this).data('id');
	// Show/hide appropriate optional fields
	$('.question_options_' + id).hide();
	$('.question_empty_value_' + id).hide();
	if ((val == "dropdown") || (val == "pulldown") || (val == "checkboxes") || (val == "multiselect") || (val == "rating")) {
		$('.question_options_' + id).show();
		if ((val == "dropdown") || (val == "pulldown") || (val == "rating")) {
			$('.question_empty_value_' + id).show();
		}
	}
	// Show/hide appropriate help text
	$('#question-container-' + id + ' .question-help').hide();
	$('#question-container-' + id + ' .question-' + val).show();
	//return true;
	//e.preventDefault();
}


elgg.register_hook_handler('init', 'system', elgg.survey.edit.init);


