<?php
/**
 * Groups search
 *
 */

$title = elgg_echo('groups');

$content = '';

elgg_pop_breadcrumb();

elgg_register_title_button();

// URL-params
$q = get_input('q');
$limit = get_input('limit');
$offset = get_input('offset');

// Prepare JS script for forms
$action_base = elgg_get_site_url() . 'action/esope/';
$esope_search_url = elgg_add_action_tokens_to_url($action_base . 'esearch');

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
$metadata_search_fields = elgg_get_plugin_setting('metadata_groupsearch_fields', 'esope');
// Default to general advanced fields if not set
if (empty($metadata_search_fields)) { $metadata_search_fields = elgg_get_plugin_setting('metadata_search_fields', 'esope'); }
if (!empty($metadata_search_fields)) {
	$metadata_search_fields = str_replace(' ', '', $metadata_search_fields);
	$metadata_search_fields = explode(',', $metadata_search_fields);
}
$metadata_search = '';

// Build metadata search fields
// @TODO : use better translations for metadata names
if ($metadata_search_fields) {
	$use_profile_manager = false;
	if (elgg_is_active_plugin('profile_manager')) { $use_profile_manager = true; }
	foreach ($metadata_search_fields as $metadata) {
		$name = "metadata[$metadata]";
		$meta_title = elgg_echo("groups:$metadata");
		if ($meta_title == "groups:$metadata") { $meta_title = elgg_echo($metadata); }
		$meta_title = ucfirst($meta_title);
		if (elgg_is_active_plugin('profile_manager')) {
			// Metadata options fetching will only work if those are stored somewhere
			$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . $meta_title . esope_make_search_field_from_profile_field(array('metadata' => $metadata, 'name' => $name)) . '</label></div>';
		} else {
			// We'll rely on text inputs then
			$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-text"><label>' . $meta_title . '<input type="text" name="' . $name . '" /></label></div>';
		}
	}
}


// Compose search form
$search_form = '<form id="esope-search-form" method="post" action="' . $search_action . '">';
$search_form .= elgg_view('input/securitytoken');
$search_form .= elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'group'));
$search_form .= elgg_view('input/hidden', array('name' => 'limit', 'value' => $limit));
$search_form .= elgg_view('input/hidden', array('name' => 'offset', 'value' => $offset));
$search_form .= '<fieldset>';
$search_form .= $metadata_search . '<div class="clearfloat"></div>';

$search_form .= '<div class="esope-search-fulltext"><label>' . elgg_echo('esope:fulltextsearch:group') . elgg_view('input/text', array('name' => 'q', 'value' => $q)) . '</label></div>';
$search_form .= '<input type="submit" class="elgg-button elgg-button-submit elgg-button-livesearch" value="' . elgg_echo('search') . '" />';
$search_form .= '</fieldset></form><br />';

$content .= $search_form;
$content .= '<div id="esope-search-results"></div>';

// If any parameter is passed, perform search on page load (>1 because there is always a default __elgg_uri param)
//if (!empty($_GET)) {
if (sizeof($_GET) > 1) {
	$content .= '<script type="text/javascript">esope_search();</script>';
}

$sidebar = 	'';
$sidebar .= elgg_view('groups/group_tagcloud_block');
$sidebar .= elgg_view('groups/sidebar/featured');

$params = array(
	'content' => $content,
	'sidebar' => $sidebar,
	'title' => $title,
	'filter_override' => elgg_view('groups/group_sort_menu', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

