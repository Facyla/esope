elgg.provide('elgg.collections.edit');


/** Initialize the collection editing javascript */
elgg.collections.edit.init = function() {
	// Add slide
	$(document).on('click', '#collection-edit-add-slide', elgg.collections.edit.addSlide);
	
	// Remove slide
	$(document).on('click', '.collection-edit-delete-slide', elgg.collections.edit.deleteSlide);
	
	// Add sortable feature
	elgg.collections.edit.addSortable();
	
};


/** Add a new empty slide to the form
 * @param {Object} e The click event
 */
elgg.collections.edit.addSlide = function(e) {
	// Create a new slide element (without editor)
	var new_slide = <?php echo json_encode(elgg_view('collections/input/slide', array($editor = 'plaintext'))); ?>;
	$('.collection-edit-slides').append(new_slide);
	// Refresh the sortable items to be able to sort into the new section
	elgg.collections.edit.addSortable();
	e.preventDefault();
};


/** Removes a slide
 * @param {Object} e The click event
 */
elgg.collections.edit.deleteSlide = function(e) {
	var slide = $(this).parent();
	if (confirm(elgg.echo('collections:edit:deleteslide:confirm'))) { slide.remove(); }
	e.preventDefault();
}


/* Sortable init function
 * @param {Object} e The click event
 */
elgg.collections.edit.addSortable = function() {
	// initialisation de Sortable sur le container parent
	$(".collection-edit-slides").sortable({
		placeholder: 'collection-edit-highlight', // classe du placeholder ajouté lors du déplacement
		connectWith: '.collection-edit-slides', 
		// Custom callback function
		update: function(event, ui) {}
	});
};


elgg.register_hook_handler('init', 'system', elgg.collections.edit.init);

