//<script>
elgg.provide('elgg.directory.directory');


/** Initialize the directory editing javascript */
elgg.directory.directory.init = function() {
	// Add entity
	$(document).on('click', '#directory-edit-add-entity', elgg.directory.directory.addEntity);
	
	// Remove entity
	$(document).on('click', '.directory-edit-delete-entity', elgg.directory.directory.deleteEntity);
	
	// Add sortable feature
	elgg.directory.directory.addSortable();
	
	// Load entity search inside lightbox
	$("#directory-embed-search").live("submit", elgg.directory.directory.submitSearch);
	
	$("#directory-embed-pagination a").live("click", elgg.directory.directory.embedForward);
	
	$("#directory-embed-list li").live("click", function(event) {
		elgg.directory.directory.embedFormat(this);
		event.preventDefault();
	});
	
	$("select[name=category]").live("change", elgg.directory.directory.searchFields);
	
	// Action tabs (permalink, embed, share...)
	$("#directory-action-tabs a").live("click", elgg.directory.directory.selectTab);
	
};


/** Add a new empty entity to the form
 * @param {Object} e The click event
 */
elgg.directory.directory.addEntity = function(e) {
	// Count entities (for input id)
	var guid = $('#directory-edit-form input[name=guid]').val();
	var count = $('.directory-edit-entity').length;
	// Create a new entity element (without editor)
	var new_entity = <?php echo json_encode(elgg_view('directory/input/entity', array('editor' => 'plaintext'))); ?>;
	$('.directory-edit-entities').append(new_entity);
	// Set new id (input)
	$('.directory-edit-entities div.directory-edit-entity:last-child input').attr('id', 'directory-embed-' + guid + '-' + count);
	// Set new id (details)
	$('.directory-edit-entities div.directory-edit-entity:last-child blockquote').attr('id', 'directory-embed-details-' + guid + '-' + count);
	// Update embed link URL (set )
	$('.directory-edit-entities div.directory-edit-entity:last-child a.elgg-lightbox').attr('href', '<?php echo elgg_get_site_url(); ?>directory/embed/' + guid + '-' + count);
	// Refresh the sortable items to be able to sort into the new section
	elgg.directory.directory.addSortable();
	e.preventDefault();
};


/** Removes a entity
 * @param {Object} e The click event
 */
elgg.directory.directory.deleteEntity = function(e) {
	var entity = $(this).parent();
	if (confirm(elgg.echo('directory:edit:deleteentity:confirm'))) { entity.remove(); }
	e.preventDefault();
}


/* Sortable init function
 * @param {Object} e The click event
 */
elgg.directory.directory.addSortable = function() {
	// initialisation de Sortable sur le container parent
	$(".directory-edit-entities").sortable({
		placeholder: 'directory-edit-highlight', // classe du placeholder ajouté lors du déplacement
		connectWith: '.directory-edit-entities', 
		// Custom callback function
		update: function(event, ui) {}
	});
};


// Conditionnal field on embed search lightbox
elgg.directory.directory.searchFields = function(event) {
	var category = $("select[name='category']").val();
	$(".transitions-embed-search-actortype").addClass('hidden');
	if (category == 'actor') {
		$(".transitions-embed-search-actortype").removeClass('hidden');
	}
	$.colorbox.resize({'width':'80%'});
}

// Load search into lightbox
elgg.directory.directory.submitSearch = function(event) {
	event.preventDefault();
	var query = $(this).serialize();
	var url = $(this).attr("action");
	//$(this).parent().parent().load(url, query, function() {
	$(this).parent().load(url, query, function() {
		$.colorbox.resize();
	});
};


// Load search content into lightbox
elgg.directory.directory.embedForward = function(event) {
	var url = $(this).attr("href");
	//url = elgg.embed.addContainerGUID(url);
	$("#directory-embed-pagination").parent().load(url);
	event.preventDefault();
};


// Embeds content into field
elgg.directory.directory.embedFormat = function(elem) {
	var guid = $(elem).find(".directory-embed-item-content").html();
	var details = $(elem).find(".directory-embed-item-details").html();
	var fieldId = $('#directory-embed-search').find("input[name=field_id]").val();
	
	if (!guid) { return false; }
	
	$('#directory-embed-'+fieldId).val(guid);
	$('#directory-embed-details-'+fieldId).html(details);
	
	$.colorbox.resize();
	elgg.ui.lightbox.close();
	//event.preventDefault();
};


// Switch action tab
elgg.directory.directory.selectTab = function(event) {
	var tabID = $(this).attr("href");
	$('.directory-tab-content').hide();
	$('#directory-action-tabs li').removeClass('elgg-state-selected');
	$(this).parent().addClass('elgg-state-selected');
	$(tabID).toggle();
	event.preventDefault();
};


elgg.register_hook_handler('init', 'system', elgg.directory.directory.init);

