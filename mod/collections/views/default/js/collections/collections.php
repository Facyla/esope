//<script>
elgg.provide('elgg.collections.collections');


/** Initialize the collection editing javascript */
elgg.collections.collections.init = function() {
	// Add entity
	$(document).on('click', '#collection-edit-add-entity', elgg.collections.collections.addEntity);
	
	// Remove entity
	$(document).on('click', '.collection-edit-delete-entity', elgg.collections.collections.deleteEntity);
	
	// Add sortable feature
	elgg.collections.collections.addSortable();
	
	// Load entity search inside lightbox
	$("#collections-embed-search").live("submit", elgg.collections.collections.submitSearch);
	
	$("#collections-embed-pagination a").live("click", elgg.collections.collections.embedForward);
	
	$("#collections-embed-list li").live("click", function(event) {
		elgg.collections.collections.embedFormat(this);
		event.preventDefault();
	});
	
	// Update available search fields based on selected category
	$("select[name=category]").live("change", elgg.collections.collections.searchFields);
	
	// Action tabs (permalink, embed, share...)
	$("#collections-action-tabs a").live("click", elgg.collections.collections.selectTab);
	
	// Enable explanation input and submit button after an entity has been selected to be added to a collection
	//$(".collection-addentity input[name=entity_guid]").live("change", elgg.collections.collections.addEntityFields);
	
};


/** Add a new empty entity to the form
 * @param {Object} e The click event
 */
elgg.collections.collections.addEntity = function(e) {
	// Count entities (for input id)
	var guid = $('#collection-edit-form input[name=guid]').val();
	var count = $('.collection-edit-entity').length;
	// Create a new entity element (without editor)
	var new_entity = <?php echo json_encode(elgg_view('collections/input/entity', array('editor' => 'plaintext'))); ?>;
	$('.collection-edit-entities').append(new_entity);
	// Set new id (input)
	$('.collection-edit-entities div.collection-edit-entity:last-child input').attr('id', 'collections-embed-' + guid + '-' + count);
	// Set new id (details)
	$('.collection-edit-entities div.collection-edit-entity:last-child blockquote').attr('id', 'collections-embed-details-' + guid + '-' + count);
	// Update embed link URL (set )
	$('.collection-edit-entities div.collection-edit-entity:last-child a.elgg-lightbox').attr('href', '<?php echo elgg_get_site_url(); ?>collection/embed/' + guid + '-' + count);
	// Refresh the sortable items to be able to sort into the new section
	elgg.collections.collections.addSortable();
	e.preventDefault();
};


/** Removes a entity
 * @param {Object} e The click event
 */
elgg.collections.collections.deleteEntity = function(e) {
	var entity = $(this).parent();
	if (confirm(elgg.echo('collections:edit:deleteentity:confirm'))) { entity.remove(); }
	e.preventDefault();
}


/* Sortable init function
 * @param {Object} e The click event
 */
elgg.collections.collections.addSortable = function() {
	// initialisation de Sortable sur le container parent
	$(".collection-edit-entities").sortable({
		placeholder: 'collection-edit-highlight', // classe du placeholder ajouté lors du déplacement
		connectWith: '.collection-edit-entities', 
		// Custom callback function
		update: function(event, ui) {}
	});
};


// Load search into lightbox
elgg.collections.collections.submitSearch = function(event) {
	event.preventDefault();
	var query = $(this).serialize();
	var url = $(this).attr("action");
	//$(this).parent().parent().load(url, query, function() {
	$(this).parent().load(url, query, function() {
		$.colorbox.resize();
	});
};


// Load search content into lightbox
elgg.collections.collections.embedForward = function(event) {
	var url = $(this).attr("href");
	//url = elgg.embed.addContainerGUID(url);
	$("#collections-embed-pagination").parent().load(url);
	event.preventDefault();
};


// Embeds content into field
elgg.collections.collections.embedFormat = function(elem) {
	var guid = $(elem).find(".collections-embed-item-content").html();
	var details = $(elem).find(".collections-embed-item-details").html();
	var fieldId = $('#collections-embed-search').find("input[name=field_id]").val();
	
	if (!guid) { return false; }
	
	$('#collections-embed-'+fieldId).val(guid);
	$('#collections-embed-details-'+fieldId).html(details);
	
	$.colorbox.resize();
	elgg.ui.lightbox.close();
	//event.preventDefault();
	
	// Reveal hidden fields (when using addentity form)
	$(".elgg-form-collection-addentity .entity_comment").removeClass('hidden');
	$(".elgg-form-collection-addentity input[type=submit]").removeClass('hidden');
	
};


// Conditionnal field on embed search lightbox
elgg.collections.collections.searchFields = function(event) {
	var category = $("select[name='category']").val();
	$(".transitions-embed-search-actortype").addClass('hidden');
	if (category == 'actor') {
		$(".transitions-embed-search-actortype").removeClass('hidden');
	}
	$.colorbox.resize({'width':'80%'});
}


// Switch action tab
elgg.collections.collections.selectTab = function(event) {
	var tabID = $(this).attr("href");
	$('.collections-tab-content').hide();
	$('#collections-action-tabs li').removeClass('elgg-state-selected');
	$(this).parent().addClass('elgg-state-selected');
	$(tabID).toggle();
	event.preventDefault();
};


// Conditionnal field on embed search lightbox
/*
elgg.collections.collections.addEntityFields = function(event) {
	var guid = $(".collection-addentity input[name='entity_guid']").val();
	if (guid != '') {
		$(".collection-addentity .entity_comment").removeClass('hidden');
		$(".collection-addentity input[type=submit]").removeClass('hidden');
	}
}
*/


elgg.register_hook_handler('init', 'system', elgg.collections.collections.init);

