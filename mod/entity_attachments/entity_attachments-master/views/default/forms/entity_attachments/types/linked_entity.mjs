import 'jquery';
import elgg from 'elgg';

function getAdditionalFilters() {
	var $subtype = $('select[name="linked_entity[subtype]"]');
	var $container_guid = $('input[type="hidden"][name^="linked_entity[container_guids]"]');
	
	var params = {
		subtype: $subtype.val(),
		container_guid: []
	};
	
	$container_guid.each(function(index, elem) {
		var value = $(elem).val();
		if (!value.length) {
			return;
		}
		
		params.container_guid.push(value);
	});
	
	return params;
};

$.ajaxPrefilter(function(options, originalOptions, jqXHR) {
	
	if (!originalOptions.data || originalOptions.data.match_on !== 'linked_entity') {
		return;
	}
	
	var requestData = originalOptions.data;
	requestData = $.extend(true, requestData, getAdditionalFilters(), {view: 'json'});
	
	options.url = elgg.normalize_url('livesearch?' + $.param(requestData));
});
