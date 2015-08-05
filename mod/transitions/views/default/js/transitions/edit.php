//<script>
elgg.provide('elgg.transitions.edit');


/** Initialize the collection editing javascript */
elgg.transitions.edit.init = function() {
	// Load entity search inside lightbox
	$("#transitions-embed-search").live("submit", elgg.transitions.edit.submitSearch);
	
	$("#transitions-embed-pagination a").live("click", elgg.transitions.edit.embedForward);
	
	$("#transitions-embed-list li").live("click", function(event) {
		elgg.transitions.edit.embedFormat(this);
		event.preventDefault();
	});
	
	$("select[name=category]").live("change", elgg.transitions.edit.searchFields);
	
};


// Toggles optional 'actor_type' field
elgg.transitions.edit.searchFields = function(event) {
	var category = $("select[name='category']").val();
	$(".transitions-embed-search-actortype").addClass('hidden');
	if (category == 'actor') {
		$(".transitions-embed-search-actortype").removeClass('hidden');
	}
	$.colorbox.resize({'width':'80%'});
}


// Load search into lightbox
elgg.transitions.edit.submitSearch = function(event) {
	event.preventDefault();
	var query = $(this).serialize();
	var url = $(this).attr("action");
	//$(this).parent().parent().load(url, query, function() {
	$(this).parent().load(url, query, function() {
		$.colorbox.resize();
	});
};

// Embed pagination
elgg.transitions.edit.embedForward = function(event) {
	var url = $(this).attr("href");
	//url = elgg.embed.addContainerGUID(url);
	$("#transitions-embed-pagination").parent().load(url);
	event.preventDefault();
};


// Embeds selected content into field
elgg.transitions.edit.embedFormat = function(elem) {
	var guid = $(elem).find(".transitions-embed-item-content").html();
	var details = $(elem).find(".transitions-embed-item-details").html();
	var fieldId = $('#transitions-embed-search').find("input[name=field_id]").val();
	
	if (!guid) { return false; }
	
	$('#transitions-embed-'+fieldId).val(guid);
	$('#transitions-embed-details-'+fieldId).html(details);
	
	$.colorbox.resize();
	elgg.ui.lightbox.close();
	//event.preventDefault();
};



elgg.register_hook_handler('init', 'system', elgg.transitions.edit.init);

