<?php
/**
 * Content search (overridable)
 *
 */

$content = '';

// Prepare JS script for forms
$action_base = elgg_get_site_url() . 'action/esope/';
$esope_search_url = elgg_add_action_tokens_to_url($action_base . 'esearch');
//$unique_form_key = 'groups'; @todo

$content .= '<script type="text/javascript">
var formdata;
function esope_search_groups(){
	//var spinner = require(["elgg/spinner"]);
	$("body").addClass("esope-search-wait");
	//spinner.start();
	$("#esope-search-results-groups").html(""); // clear previous result set
	formdata = $("#esope-search-form-groups").serialize();
	$.post("' . $esope_search_url . '", formdata, function(data){
		$("#esope-search-results-groups").html(data);
		$("body").removeClass("esope-search-wait");
		//spinner.stop();
	});
}
</script>';

// @TODO Handle and perform URL-preset query
$q = get_input('q');
if (!empty($q)) { elgg_push_breadcrumb('&laquo;&nbsp;' . $q . '&nbsp;&raquo;'); }
$limit = get_input('limit', elgg_get_config('default_limit'));
$offset = get_input('offset', 0);

// Get form values if set (and pagination nav)
$entity_subtype = get_input('entity_subtype');
$container_guid = get_input('container_guid');
$owner_guid = get_input('owner_guid');
$created_time_lower = get_input('created_time_lower');
$created_time_upper = get_input('created_time_upper');

// Préparation du formulaire : on utilise la config du thème + adaptations spécifiques pour notre cas
// Note : on peut récupérer les résultats sur cette page plutôt qu'en AJAX, si on veut...

$search_action = "javascript:esope_search_groups();";
// Should be an array, so clear blanks then make it an array
$metadata_search_fields = elgg_get_plugin_setting('metadata_groupsearch_fields', 'esope');
// Default to general advanced fields if not set
if (empty($metadata_search_fields)) { $metadata_search_fields = elgg_get_plugin_setting('metadata_search_fields', 'esope'); }
if (!empty($metadata_search_fields)) {
	$metadata_search_fields = str_replace(' ', '', $metadata_search_fields);
	$metadata_search_fields = explode(',', $metadata_search_fields);
}

// Preset hidden filters
$metadata_search_filter = elgg_get_plugin_setting('metadata_groupsearch_filter', 'esope');
// Default to general search filters if not set
if (empty($metadata_search_filter)) { $metadata_search_filter = elgg_get_plugin_setting('metadata_search_filter', 'esope'); }
if (!empty($metadata_search_filter)) {
	$metadata_search_filter = str_replace(' ', '', $metadata_search_filter);
	$metadata_search_filter = explode(',', $metadata_search_filter);
} else { $metadata_search_filter = false; }
//echo implode(', ',$metadata_search_filter);


// Filtre par sous-subtypes
// Types d'entités et subtypes
$types_opt = array('user' => elgg_echo('user'), 'group' => elgg_echo('group'), 'object' => elgg_echo('object')); // We dont't want empty type
$registered_subtypes = get_registered_entity_types(); // Returns all subtypes, even non-objects
$subtypes_opt[] = '';
foreach ($registered_subtypes as $type => $subtypes) {
	foreach ($subtypes as $type => $subtype) {
		$subtypes_opt[$subtype] = elgg_echo('item:object:'.$subtype);
	}
}


$metadata_search = '';

// Build metadata search fields
foreach ($metadata_search_fields as $metadata) {
	// @TODO : autocomplete using existing values ? (as a text input alternative to select)
	$use_text = false;
	$use_auto_values = false;
	$metadata_params = explode(':', $metadata);
	$metadata = array_shift($metadata_params);
	$name = "metadata[$metadata]";
	$meta_title = elgg_echo("profile:$metadata");
	if ($meta_title == "profile:$metadata") { $meta_title = elgg_echo($metadata); }
	$meta_title = ucfirst($meta_title);
	// Process special syntax parameters (text takes precedence over auto parameter)
	if (count($metadata) > 0) {
		if (in_array('text', $metadata_params)) { $use_text = true; } else if (in_array('auto', $metadata_params)) { $use_auto_values = true; }
	}
	// Use selected input field
	if ($use_auto_values) {
		// Metadata options are selected from the database
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . $meta_title . esope_make_dropdown_from_metadata(array('metadata' => $metadata, 'name' => $name)) . '</label></div>';
	} else {
		// We'll rely on text inputs then
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-text"><label>' . $meta_title . '<input type="text" name="' . $name . '" /></label></div>';
	}
}

/*
// @TODO : allow to fetch existing values - autocomplete using existing values ? => esope_get_meta_values($meta_name)

// We'll rely on text inputs then
foreach ($metadata_search_fields as $metadata) {
	$name = "metadata[$metadata]";
	$meta_title = elgg_echo($metadata);
	$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-text"><label>' . ucfirst($meta_title) . '<input type="text" name="' . $name . '" /></label></div>';
}
*/


$search_form = '<form id="esope-search-form-groups" method="post" action="' . $search_action . '">';
$search_form .= elgg_view('input/securitytoken');
$search_form .= elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'group'));
// Pass URL values to search form (any URL parameter has to be passed to the form because it's JS-sent)

// Use preset hidden filters
if ($metadata_search_filter) {
	foreach ($metadata_search_filter as $meta_filter) {
		$meta_filter = explode('=', $meta_filter);
		if (!empty($meta_filter[0]) && !empty($meta_filter[1])) {
			$search_form .= elgg_view('input/hidden', array('name' => "metadata[{$meta_filter[0]}]", 'value' => $meta_filter[1]));
		}
	}
}

/* Dev and debug options
if (false && elgg_is_admin_logged_in()) {
	$limit_opt = array(10, 50, 100, 200, 500);
	if (!in_array($limit, $limit_opt)) { $limit_opt[] = $limit; }
	$default_limit = elgg_get_config('default_limit');
	if (!in_array($default_limit, $limit_opt)) { $limit_opt[] = $default_limit; }
	sort($limit_opt);
	$search_form .= '<label>' . elgg_echo('search:field:limit') . ' ' . elgg_view('input/select', array('name' => 'limit', 'value' => $limit, 'options' => $limit_opt)) . '</label> &nbsp; ';
	$search_form .= '<label>' . elgg_echo('search:field:offset') . ' ' . elgg_view('input/text', array('name' => 'offset', 'value' => $offset)) . '</label> &nbsp; ';
	$search_form .= elgg_view('input/hidden', array('name' => 'debug', 'value' => 'yes'));
}
*/

//$search_form .= '<p><label>' . elgg_echo('esope:search:type') . ' ' . elgg_view('input/select', array('name' => 'entity_type', 'value' => '', 'options_values' => $types_opt)) . '</label></p>';

$search_form .= '<div style="display: flex; flex-wrap: wrap;">';
	//$search_form .= '<div class="esope-search-fulltext" style="flex: 1 1 12rem;"><label>' . elgg_echo('esope:fulltextsearch:object') . '<input type="text" name="q" value="' . $q . '" /></label></div>';
	$search_form .= '<div class="esope-search-fulltext" style="flex: 1 1 12rem;"><label><span class="hidden">' . elgg_echo('esope:fulltextsearch:object') . '</span>' . elgg_view('input/text', array('name' => 'q', 'value' => $q, 'placeholder' => elgg_echo('esope:fulltextsearch:object'))) . '</label></div>';
	$search_form .= '<div class="esope-search-submit" style="flex: 0 0 6rem;"><input type="submit" class="elgg-button elgg-button-submit elgg-button-livesearch" value="' . elgg_echo('search') . '" /></div>';
$search_form .= '</div>';
$search_form .= '<div class="clearfloat"></div>';

$search_form .= '<fieldset>';
	$search_form .= $metadata_search;
$search_form .= '</fieldset>';


// Limit, offset...
$search_form .= elgg_view('input/hidden', array('name' => 'limit', 'value' => $limit));
// @TODO : display offset if > 0 (but hide if pagination is displayed ?)
if ($offset > 0) {
	$search_form .= '<div class="esope-search-metadata"><label>' . elgg_echo('search:field:offset') . elgg_view('input/text', array('name' => 'offset', 'value' => $offset)) . '</label></div>';
} else {
	$search_form .= elgg_view('input/hidden', array('name' => 'offset', 'value' => $offset));
}

$search_form .= '</form><br />';

$content .= $search_form;
$content .= '<div id="esope-search-results-groups">' . elgg_echo('esope:search:nosearch') . '</div>';

// If any parameter is passed, perform search on page load (>1 because there is always a default __elgg_uri param)
//echo '<pre>' . print_r($_GET, true) . '</pre>'; // debug
//if (!empty($_GET)) {
if (sizeof($_GET) > 1) {
	$content .= '<script type="text/javascript">esope_search_groups();</script>';
}

echo $content;

