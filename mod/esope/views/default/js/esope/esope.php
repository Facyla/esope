//<script>
elgg.provide('elgg.esope');


/** Initialize the collection editing javascript */
elgg.esope.init = function() {
	
	// Advanced search : conditionnal fields
	$("#advanced-search-form select[name=search_type]").live("change", elgg.esope.advsearch_search_type);
	$("#advanced-search-form select[name=entity_type]").live("change", elgg.esope.advsearch_entity_type);
	$("#advanced-search-form select[name=entity_subtype]").live("change", elgg.esope.advsearch_entity_subtype);
	
};


// ADVANCED SEARCH SCRIPTS

// Auto-set search_type if type selected
elgg.esope.advsearch_search_type = function(event) {
	var searchtype = $("select[name='search_type']").val();
	var type = $("select[name='entity_type']").val();
	if (searchtype == 'all') {
		$("#advanced-search-form select[name='entity_type']").val('');
		$("#advanced-search-form select[name='entity_subtype']").val('');
		$("#advanced-search-form select[name='limit']").val('2');
	}
}

// Auto-set search_type if type selected
// If entity_type is set to any non empty value, search_type cannot be 'all' (tags can be kept)
elgg.esope.advsearch_entity_type = function(event) {
	var type = $("select[name='entity_type']").val();
	var searchtype = $("select[name='search_type']").val();
	if ((type != '') && (searchtype == 'all')) {
		$("#advanced-search-form select[name='search_type']").val('entities');
	}
	/* Note : we should not force subtype because it can apply to any type, not only objects (but there is none besides objects yet)
	*/
	if (type != 'object') {
		$("#advanced-search-form select[name='entity_subtype']").val('');
	}
}

// Auto-set search_type and type if non-empty subtype selected
elgg.esope.advsearch_entity_subtype = function(event) {
	var subtype = $("#advanced-search-form select[name='entity_subtype']").val();
	var searchtype = $("#advanced-search-form select[name='search_type']").val();
	var type = $("#advanced-search-form select[name='entity_type']").val();
	if (subtype != '') {
		if (searchtype == 'all') {
			$("#advanced-search-form select[name='search_type']").val('entities');
		}
		/* Note : we should not remove subtype filter because subtypes may apply to other entity types (but there is none besides objects yet)
		*/
		if (type != 'object') {
			$("#advanced-search-form select[name='entity_type']").val('object');
		}
	}
}



elgg.register_hook_handler('init', 'system', elgg.esope.init);

