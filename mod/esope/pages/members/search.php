<?php
/**
 * Members search
 *
 */

$hide_directory = elgg_get_plugin_setting('hide_directory', 'esope');
if ($hide_directory == 'yes') { gatekeeper(); }

//elgg_require_js('elgg/spinner'); // @TODO make spinner work...

$num_members = get_number_users();
$title = elgg_echo('members');

$content = '';

//elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('search'));

// Prepare JS script for forms
$action_base = elgg_get_site_url() . 'action/esope/';
$esope_search_url = elgg_add_action_tokens_to_url($action_base . 'esearch');

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


// Préparation du formulaire : on utilise la config du thème + adaptations spécifiques pour notre cas
// Note : on peut récupérer les résultats sur cette page plutôt qu'en AJAX, si on veut...

$search_action = "javascript:esope_search();";
// Should be an array, so clear blanks then make it an array
$metadata_search_fields = elgg_get_plugin_setting('metadata_membersearch_fields', 'esope');
// Default to general advanced fiilds if not set
if (empty($metadata_search_fields)) { $metadata_search_fields = elgg_get_plugin_setting('metadata_search_fields', 'esope'); }
if (!empty($metadata_search_fields)) {
	$metadata_search_fields = str_replace(' ', '', $metadata_search_fields);
	$metadata_search_fields = explode(',', $metadata_search_fields);
}
$metadata_search = '';

// Build metadata search fields
// Use PFM if available, except if forced to text, or to auto dropdown values
$use_profile_manager = elgg_is_active_plugin('profile_manager');
foreach ($metadata_search_fields as $metadata) {
	// @TODO : autocomplete using existing values ? (as a text input alternative to dropdown)
	$use_text = false;
	$use_auto_values = false;
	$metadata_params = explode(':', $metadata);
	$metadata = array_shift($metadata_params);
	$name = "metadata[$metadata]";
	$meta_title = elgg_echo($metadata);
	// Process special syntax parameters (text takes precedence over auto parameter)
	if (count($metadata) > 0) {
		if (in_array('text', $metadata_params)) { $use_text = true; } else if (in_array('auto', $metadata_params)) { $use_auto_values = true; }
	}
	// Use selected input field
	if ($use_profile_manager && !$use_text && !$use_auto_values) {
		// Use profile manager configuration - will default to text input if field is not defined
		// Metadata options fetching will only work if those are stored somewhere
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . ucfirst($meta_title) . esope_make_search_field_from_profile_field(array('metadata' => $metadata, 'name' => $name)) . '</label></div>';
	} else if ($use_auto_values) {
		// Metadata options are selected from the database
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . ucfirst($meta_title) . esope_make_dropdown_from_metadata(array('metadata' => $metadata, 'name' => $name)) . '</label></div>';
	} else {
		// We'll rely on text inputs then
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-text"><label>' . ucfirst($meta_title) . '<input type="text" name="' . $name . '" /></label></div>';
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

$profiletypes_opt = esope_get_profiletypes(true); // $guid => $title
$profiletypes_opt[0] = '';
$profiletypes_opt = array_reverse($profiletypes_opt, true); // We need to keep the keys here !


$search_form = '<form id="esope-search-form" method="post" action="' . $search_action . '">';
$search_form .= elgg_view('input/securitytoken');
$search_form .= elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'user'));
$search_form .= '<fieldset>';
// Display role filter only if it has a meaning
if (sizeof($profiletypes_opt) > 2) {
	$search_form .= '<div class="esope-search-metadata esope-search-profiletype esope-search-metadata-select"><label> ' . elgg_echo('esope:search:members:role') . ' ' . elgg_view('input/dropdown', array('name' => 'metadata[custom_profile_type]', 'value' => '', 'options_values' => $profiletypes_opt)) . '</label></div>';
}
$search_form .= $metadata_search . '<div class="clearfloat"></div>';

$search_form .= '<div class="esope-search-fulltext"><label>' . elgg_echo('esope:fulltextsearch:user') . '<input type="text" name="q" value="' . $q . '" /></label></div>';
$search_form .= '<input type="submit" class="elgg-button elgg-button-submit elgg-button-livesearch" value="' . elgg_echo('search') . '" />';
$search_form .= '</fieldset></form><br />';

$content .= $search_form;
$content .= '<div id="esope-search-results"></div>';

// If any parameter is passed, perform search on page load
if (!empty($_GET)) {
	$content .= '<script type="text/javascript">
	esope_search();
	</script>';
}

$params = array(
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'title' => $title . " ($num_members)",
	'filter_override' => elgg_view('members/nav', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

