//<script>
elgg.provide('elgg.transitions');


/** Initialize the collection editing javascript */
elgg.transitions.init = function() {
	// Fields chars limit
	var callback = function() {
		var maxLength = $(this).data('max-length');
		if (maxLength) {
			elgg.transitions.textCounter(this, $("#transitions-characters-remaining span"), maxLength);
		}
	};
	$("#transitions_excerpt").live({input: callback, onpropertychange: callback});
	
	// Conditionnal field
	$("select[name=category]").live("change", elgg.transitions.searchFields);
	
	// Action tabs
	$("#transitions-action-tabs a").live("click", elgg.transitions.selectTab);
	
	// Load entity search inside lightbox
	$("#transitions-embed-search").live("submit", elgg.transitions.submitSearch);
	// Load paginated content
	$("#transitions-embed-pagination a").live("click", elgg.transitions.embedForward);
	// Adds the selected content into the field
	$("#transitions-embed-list li").live("click", function(event) {
		elgg.transitions.embedFormat(this);
		event.preventDefault();
	});
	
};


// Toggles optional 'actor_type' field
elgg.transitions.searchFields = function(event) {
	var category = $("select[name='category']").val();
	$(".transitions-embed-search-actortype").addClass('hidden');
	if (category == 'actor') {
		$(".transitions-embed-search-actortype").removeClass('hidden');
	}
	$.colorbox.resize({'width':'80%'});
}


// Load search into lightbox
elgg.transitions.submitSearch = function(event) {
	event.preventDefault();
	var query = $(this).serialize();
	var url = $(this).attr("action");
	//$(this).parent().parent().load(url, query, function() {
	$(this).parent().load(url, query, function() {
		$.colorbox.resize();
	});
};

// Embed pagination
elgg.transitions.embedForward = function(event) {
	var url = $(this).attr("href");
	//url = elgg.embed.addContainerGUID(url);
	$("#transitions-embed-pagination").parent().load(url);
	event.preventDefault();
};


// Embeds selected content into field
elgg.transitions.embedFormat = function(elem) {
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


// Switch action tab
elgg.transitions.selectTab = function(event) {
	var tabID = $(this).attr("href");
	$('.transitions-tab-content').hide();
	$('#transitions-action-tabs li').removeClass('elgg-state-selected');
	$(this).parent().addClass('elgg-state-selected');
	$(tabID).toggle();
	event.preventDefault();
};


elgg.transitions.textCounter = function(inputField, status, limit) {
	var remaining_chars = limit - $(inputField).val().length;
	status.html(remaining_chars);
	// @TODO Block editing ?  not here for one single field..
	if (remaining_chars < 0) {
		status.parent().addClass("transitions-characters-remaining-warning");
		//$("#transitions-post-edit input[name=save]").attr('disabled', 'disabled');
		//$("#transitions-post-edit input[name=save]").addClass('elgg-state-disabled');
	} else {
		status.parent().removeClass("transitions-characters-remaining-warning");
		//$("#transitions-post-edit input[name=save]").removeAttr('disabled', 'disabled');
		//$("#transitions-post-edit input[name=save]").removeClass('elgg-state-disabled');
	}
};


elgg.register_hook_handler('init', 'system', elgg.transitions.init);

