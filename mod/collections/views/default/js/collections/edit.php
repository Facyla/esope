//<script>
elgg.provide('elgg.collections.edit');


/** Initialize the collection editing javascript */
elgg.collections.edit.init = function() {
	// Add entity
	$(document).on('click', '#collection-edit-add-entity', elgg.collections.edit.addEntity);
	
	// Remove entity
	$(document).on('click', '.collection-edit-delete-entity', elgg.collections.edit.deleteEntity);
	
	// Add sortable feature
	elgg.collections.edit.addSortable();
	
	// Load entity search inside lightbox
	$("#collections-embed-search").live("submit", elgg.collections.edit.submitSearch);
	
	$("#collections-embed-pagination a").live("click", elgg.collections.edit.embedForward);
	
	$("#collections-embed-list li").live("click", function(event) {
		elgg.collections.edit.embedFormat(this);
		event.preventDefault();
	});
	
	$("select[name=category]").live("change", elgg.collections.edit.searchFields);
	
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


// @TODO
elgg.collections.edit.searchFields = function(event) {
	var category = $("select[name='category']").val();
	$(".transitions-embed-search-actortype").addClass('hidden');
	if (category == 'actor') {
		$(".transitions-embed-search-actortype").removeClass('hidden');
	}
	$.colorbox.resize({'width':'80%'});
}

// Load search into lightbox
elgg.collections.edit.submitSearch = function(event) {
	event.preventDefault();
	var query = $(this).serialize();
	var url = $(this).attr("action");
	//$(this).parent().parent().load(url, query, function() {
	$(this).parent().load(url, query, function() {
		$.colorbox.resize();
	});
};

elgg.collections.edit.embedForward = function(event) {
	var url = $(this).attr("href");
	//url = elgg.embed.addContainerGUID(url);
	$("#collections-embed-pagination").parent().load(url);
	event.preventDefault();
};


elgg.collections.edit.embedFormat = function(elem) {
	var guid = $(elem).find(".collections-embed-item-content").html();
	var details = $(elem).find(".collections-embed-item-details").html();
	var fieldId = $('#collections-embed-search').find("input[name=field_id]").val();
	
	if (!guid) { return false; }
	
	$('#collections-embed-'+fieldId).val(guid);
	$('#collections-embed-details-'+fieldId).html(details);
	console.log('GUID : '+guid + ' / field_id = ' + fieldId);
	
	$.colorbox.resize();
	elgg.ui.lightbox.close();
	//event.preventDefault();
};



elgg.register_hook_handler('init', 'system', elgg.collections.edit.init);

