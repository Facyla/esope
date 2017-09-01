<?php
require_once dirname(dirname(dirname(__FILE__))) . '/engine/start.php';

// Limited to admin !
admin_gatekeeper();

$hide_directory = elgg_get_plugin_setting('hide_directory', 'adf_public_platform');
if ($hide_directory == 'yes') gatekeeper();

$num_members = get_number_users();
$title = elgg_echo('members');

$content = '';

//elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('search'));

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

$metadata_search_fields = array('inria_location', 'inria_location_main', 'epi_ou_service', 'location');
$metadata_search = '';

// Build metadata search fields
if (elgg_is_active_plugin('profile_manager')) {
	// Metadata options fetching will only work if those are stored somewhere
	foreach ($metadata_search_fields as $metadata) {
		$name = "metadata[$metadata]";
		$meta_title = elgg_echo($metadata);
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . ucfirst($meta_title) . esope_make_search_field_from_profile_field(array('metadata' => $metadata, 'name' => $name, 'auto-options' => true)) . '</label></div>';
	}
} else {
	// We'll rely on text inputs then
	foreach ($metadata_search_fields as $metadata) {
		$name = "metadata[$metadata]";
		$meta_title = elgg_echo($metadata);
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-text"><label>' . ucfirst($meta_title) . '<input type="text" name="' . $name . '" /></label></div>';
	}
}


$search_form = '<form id="esope-search-form" method="post" action="' . $search_action . '">';
$search_form .= elgg_view('input/securitytoken');
$search_form .= elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'user'));
$search_form .= '<fieldset>';
$search_form .= $metadata_search . '<div class="clearfloat"></div>';
$search_form .= '<input type="submit" class="elgg-button elgg-button-submit elgg-button-livesearch" value="' . elgg_echo('search') . '" />';
$search_form .= '</fieldset></form><br />';

$content .= $search_form;
$content .= '<div id="esope-search-results"></div>';


$params = array(
	'content' => $content,
	'title' => $title . " ($num_members)",
);

$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);

