elgg.provide('elgg.collections.edit');


/** Initialize the collection editing javascript */
elgg.collections.edit.init = function() {
	// Add entity
	$(document).on('click', '#collection-edit-add-entity', elgg.collections.edit.addEntity);
	
	// Remove entity
	$(document).on('click', '.collection-edit-delete-entity', elgg.collections.edit.deleteEntity);
	
	// Add sortable feature
	elgg.collections.edit.addSortable();
	
};


/** Add a new empty entity to the form
 * @param {Object} e The click event
 */
elgg.collections.edit.addEntity = function(e) {
	// Create a new entity element (without editor)
	var new_entity = <?php echo json_encode(elgg_view('collections/input/entity', array($editor = 'plaintext'))); ?>;
	$('.collection-edit-entities').append(new_entity);
	// Refresh the sortable items to be able to sort into the new section
	elgg.collections.edit.addSortable();
	e.preventDefault();
};


/** Removes a entity
 * @param {Object} e The click event
 */
elgg.collections.edit.deleteEntity = function(e) {
	var entity = $(this).parent();
	if (confirm(elgg.echo('collections:edit:deleteentity:confirm'))) { entity.remove(); }
	e.preventDefault();
}


/* Sortable init function
 * @param {Object} e The click event
 */
elgg.collections.edit.addSortable = function() {
	// initialisation de Sortable sur le container parent
	$(".collection-edit-entities").sortable({
		placeholder: 'collection-edit-highlight', // classe du placeholder ajouté lors du déplacement
		connectWith: '.collection-edit-entities', 
		// Custom callback function
		update: function(event, ui) {}
	});
};


elgg.register_hook_handler('init', 'system', elgg.collections.edit.init);

