<?php
/**
 * Groups search
 *
 */

global $CONFIG;
$title = elgg_echo('groups');

$content = '';

elgg_pop_breadcrumb();

elgg_register_title_button();

// Prepare JS script for forms
$ts = time();
$token = generate_action_token($ts);
$action_token = '?__elgg_token=' . $token . '&__elgg_ts=' . $ts;
$action_base = $CONFIG->url . 'action/esope/';
$esope_search_url = $action_base . 'esearch' . $action_token;

$content .= '<script>
var formdata;
function esope_search(){
	//$("body").addClass("esope-search-wait");
	formdata = $("#esope-search-form").serialize();
	$.post("' . $esope_search_url . '", formdata, function(data){
		$("#esope-search-results").html(data);
		//$("body").removeClass("esope-search-wait");
	});
}
</script>';


// Préparation du formulaire : on utilise la config du thème + adaptations spécifiques pour notre cas
// Note : on peut récupérer les résultats sur cette page plutôt qu'en AJAX, si on veut...

$search_action = "javascript:esope_search();";
// Should be an array, so clear blanks then make it an array
$metadata_search_fields = elgg_get_plugin_setting('metadata_groupsearch_fields', 'adf_public_platform');
// Default to general advanced fiilds if not set
if (empty($metadata_search_fields)) $metadata_search_fields = elgg_get_plugin_setting('metadata_search_fields', 'adf_public_platform');
if (!empty($metadata_search_fields)) {
	$metadata_search_fields = str_replace(' ', '', $metadata_search_fields);
	$metadata_search_fields = explode(',', $metadata_search_fields);
}
$metadata_search = '';

// Build metadata search fields
if (elgg_is_active_plugin('profile_manager')) {
	// Metadata options fetching will only work if those are stored somewhere
	foreach ($metadata_search_fields as $metadata) {
		$name = "metadata[$metadata]";
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . ucfirst(elgg_echo($metadata)) . esope_make_search_field_from_profile_field(array('metadata' => $metadata, 'name' => $name)) . '</label></div>';
	}
} else {
	// We'll rely on text inputs then
	foreach ($metadata_search_fields as $metadata) {
		$name = "metadata[$metadata]";
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-text"><label>' . ucfirst(elgg_echo($metadata)) . '<input type="text" name="' . $name . '" /></label></div>';
	}
}


$search_form = '<form id="esope-search-form" method="post" action="' . $search_action . '">';
$search_form .= elgg_view('input/securitytoken');
$search_form .= elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'group'));
$search_form .= '<fieldset>';
$search_form .= $metadata_search . '<div class="clearfloat"></div>';

$search_form .= '<div class="esope-search-fulltext"><label>' . elgg_echo('esope:fulltextsearch') . '<input type="text" name="q" value="" /></label></div>';
$search_form .= '<input type="submit" class="elgg-button elgg-button-submit elgg-button-livesearch" value="' . elgg_echo('search') . '" />';
$search_form .= '</fieldset></form><br />';

$content .= $search_form;
$content .= '<div id="esope-search-results"></div>';


$sidebar = 	'';
$sidebar .= elgg_view('page/elements/group_tagcloud_block');
$sidebar .= elgg_view('groups/sidebar/featured');

$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'title' => $title,
	'filter_override' => elgg_view('groups/group_sort_menu', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

