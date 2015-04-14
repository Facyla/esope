elgg.provide('elgg.slider.edit');


/** Initialize the slider editing javascript */
elgg.slider.edit.init = function() {
	// Add slide
	$(document).on('click', '#slider-edit-add-slide', elgg.slider.edit.addSlide);
	
	// Remove slide
	$(document).on('click', '.slider-edit-delete-slide', elgg.slider.edit.deleteSlide);
	
	// Add sortable feature
	elgg.slider.edit.addSortable();
	
};


/** Add a new empty slide to the form
 * @param {Object} e The click event
 */
elgg.slider.edit.addSlide = function(e) {
	// Create a new slide element
	var new_slide = <?php echo json_encode(elgg_view('slider/input/slide')); ?>;
	$('.slider-edit-slides').append(new_slide);
	// Refresh the sortable items to be able to sort into the new section
	elgg.slider.edit.addSortable();
	e.preventDefault();
};


/** Removes a slide
 * @param {Object} e The click event
 */
elgg.slider.edit.deleteSlide = function(e) {
	var slide = $(this).parent();
	if (confirm(elgg.echo('slider:edit:deleteslide:confirm'))) { slide.remove(); }
	e.preventDefault();
}


/* Sortable init function
 * @param {Object} e The click event
 */
elgg.slider.edit.addSortable = function() {
	// initialisation de Sortable sur le container parent
	$(".slider-edit-slides").sortable({
		placeholder: 'slider-edit-highlight', // classe du placeholder ajouté lors du déplacement
		connectWith: '.slider-edit-slides', 
		// Custom callback function
		update: function(event, ui) {}
	});
};


elgg.register_hook_handler('init', 'system', elgg.slider.edit.init);

