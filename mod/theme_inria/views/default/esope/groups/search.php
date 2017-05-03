<?php
/**
 * Groups search
 * Inria : use custom action so we can add some filters
 *
 */

$content = '';

// Prepare JS script for forms
$action_base = elgg_get_site_url() . 'action/theme_inria/';
$esope_search_url = elgg_add_action_tokens_to_url($action_base . 'groupsearch');

$content .= '<script type="text/javascript">
var formdata;
function esope_search(){
	//var spinner = require(["elgg/spinner"]);
	$("body").addClass("esope-search-wait");
	//spinner.start();
	$("#esope-search-results").html(""); // clear previous result set
	formdata = $("#esope-search-form").serialize();
	$.post("' . $esope_search_url . '", formdata, function(data){
		$("#esope-search-results").html(data);
		$("body").removeClass("esope-search-wait");
		//spinner.stop();
	});
}
</script>';

// @TODO Handle and perform URL-preset query
$q = get_input('q');
$limit = get_input('limit', 100);
$offset = get_input('offset', 0);
$order_by = get_input('order_by', 'alpha');


// Préparation du formulaire : on utilise la config du thème + adaptations spécifiques pour notre cas
// Note : on peut récupérer les résultats sur cette page plutôt qu'en AJAX, si on veut...

$search_action = "javascript:esope_search();";
// Should be an array, so clear blanks then make it an array
$metadata_search_fields = elgg_get_plugin_setting('metadata_groupsearch_fields', 'esope');
// Default to general advanced fields if not set
if (empty($metadata_search_fields)) { $metadata_search_fields = elgg_get_plugin_setting('metadata_search_fields', 'esope'); }
if (!empty($metadata_search_fields)) {
	$metadata_search_fields = str_replace(' ', '', $metadata_search_fields);
	$metadata_search_fields = explode(',', $metadata_search_fields);
}
// Iris override
$metadata_search_fields = array('community', 'group_location', 'interests');


// Preset hidden filters
$metadata_search_filter = elgg_get_plugin_setting('metadata_groupsearch_filter', 'esope');
// Default to general search filters if not set
if (empty($metadata_search_filter)) { $metadata_search_filter = elgg_get_plugin_setting('metadata_search_filter', 'esope'); }
if (!empty($metadata_search_filter)) {
	$metadata_search_filter = str_replace(' ', '', $metadata_search_filter);
	$metadata_search_filter = explode(',', $metadata_search_filter);
} else { $metadata_search_filter = false; }
//echo implode(', ',$metadata_search_filter);

$metadata_search = '';

// Build metadata search fields
// Use PFM if available, except if forced to text, or to auto select values
$use_profile_manager = elgg_is_active_plugin('profile_manager');
foreach ($metadata_search_fields as $metadata) {
	// @TODO : autocomplete using existing values ? (as a text input alternative to select)
	$use_text = false;
	$use_auto_values = false;
	$metadata_params = explode(':', $metadata);
	$metadata = array_shift($metadata_params);
	$name = "metadata[$metadata]";
	$meta_title = elgg_echo("groups:profile:$metadata");
	if ($meta_title == "groups:profile:$metadata") { $meta_title = elgg_echo($metadata); }
	$meta_title = ucfirst($meta_title);
	// Process special syntax parameters (text takes precedence over auto parameter)
	if (count($metadata) > 0) {
		if (in_array('text', $metadata_params)) { $use_text = true; } else if (in_array('auto', $metadata_params)) { $use_auto_values = true; }
	}
	// Use selected input field
	if ($use_profile_manager && !$use_text && !$use_auto_values) {
		// Use profile manager configuration - will default to text input if field is not defined
		// Metadata options fetching will only work if those are stored somewhere
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . $meta_title . esope_make_search_field_from_profile_field(array('metadata' => $metadata, 'name' => $name, 'type' => 'group')) . '</label><div class="clearfloat"></div></div>';
	} else if ($use_auto_values) {
		// Metadata options are selected from the database
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . $meta_title . esope_make_dropdown_from_metadata(array('metadata' => $metadata, 'name' => $name)) . '</label><div class="clearfloat"></div></div>';
	} else {
		// We'll rely on text inputs then
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-text"><label>' . $meta_title . '<input type="text" name="' . $name . '" /></label><div class="clearfloat"></div></div>';
	}
}

/*
// @TODO : allow to fetch existing values - autocomplete using existing values ? => esope_get_meta_values($meta_name)
if (elgg_is_active_plugin('profile_manager')) {
	// Metadata options fetching will only work if those are stored somewhere
	foreach ($metadata_search_fields as $metadata) {
		$name = "metadata[$metadata]";
		$meta_title = elgg_echo($metadata);
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . ucfirst($meta_title) . esope_make_search_field_from_profile_field(array('metadata' => $metadata, 'name' => $name)) . '</label></div>';
	}
} else {
	// We'll rely on text inputs then
	foreach ($metadata_search_fields as $metadata) {
		$name = "metadata[$metadata]";
		$meta_title = elgg_echo($metadata);
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-text"><label>' . ucfirst($meta_title) . '<input type="text" name="' . $name . '" /></label></div>';
	}
}
*/



$search_form = '';
$search_form .= '<form id="esope-search-form" method="post" action="' . $search_action . '">';
$search_form .= '<h3>' . "Filtres avancés" . '</h3>';
$search_form .= elgg_view('input/securitytoken');
$search_form .= elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'group'));
// Pass URL values to search form (any URL parameter has to be passed to the form because it's JS-sent)
$search_form .= elgg_view('input/hidden', array('name' => 'limit', 'value' => $limit));
$search_form .= elgg_view('input/hidden', array('name' => 'offset', 'value' => $offset));
$search_form .= elgg_view('input/hidden', array('name' => 'order_by', 'value' => $order_by));


// Group search type
$search_types = array(
		'mine' => "Mes groupes",
		'all' => "Tous les groupes",
		'operator' => "Mes groupes (admin)",
	);
$search_form .= '<div class="esope-search-metadata esope-search-metadata-select">';
$search_form .= '<label>' . "Type" . elgg_view('input/select', array('name' => "group_search_type", 'value' => get_input('group_search_type'), 'options_values' => $search_types)) . '</label>';
$search_form .= '<div class="clearfloat"></div>';
$search_form .= '</div>';


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

$search_form .= '<div class="iris-search-fulltext"><label>' . elgg_echo('esope:fulltextsearch:group') . '<input type="text" name="q" value="' . $q . '" /></label></div>';

$search_form .= $metadata_search;

$search_form .= '<input type="submit" class="elgg-button elgg-button-submit elgg-button-livesearch" value="' . elgg_echo('search') . '" />';
$search_form .= '</form>';




$content .= $search_form;
// Iris v2 : form in sidebar, results in main content
//$content .= '<div id="esope-search-results">' . elgg_echo('esope:search:nosearch') . '</div>';

// If any parameter is passed, perform search on page load (>1 because there is always a default __elgg_uri param)
//echo '<pre>' . print_r($_GET, true) . '</pre>'; // debug
//if (sizeof($_GET) > 1) {
$content .= '<script type="text/javascript">esope_search();</script>';
//}

echo $content;

