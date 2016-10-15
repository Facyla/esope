<?php
/**
 * Page de recherche ESOPE
 *
 */

$title = elgg_echo('esope:search:title');
$content = '';

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('search'));


// Prepare JS script for forms
$action_base = elgg_get_site_url() . 'action/esope/';
$esope_search_url = elgg_add_action_tokens_to_url($action_base . 'esearch');

$content .= '<script>
var formdata;
function esope_search(){
	$("#esope-search-ajax-loader").removeClass("hidden");
	formdata = $("#esope-search-form").serialize();
	$.post("' . $esope_search_url . '", formdata, function(data){
		$("#esope-search-results").html(data);
		$("#esope-search-ajax-loader").addClass("hidden");
	});
}
</script>';


// Préparation du formulaire
$search_action = "javascript:esope_search();";
// Should be an array, so clear blanks then make it an array
$metadata_search_fields = elgg_get_plugin_setting('metadata_search_fields', 'esope');
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
		$metadata_search .= '<p><label>' . ucfirst(elgg_echo($metadata)) . ' ' . esope_make_search_field_from_profile_field(array('metadata' => $metadata, 'name' => $name)) . '</label></p>';
	}
} else {
	// We'll rely on text inputs then
	foreach ($metadata_search_fields as $metadata) {
		$name = "metadata[$metadata]";
		$metadata_search .= '<p><label>' . ucfirst(elgg_echo($metadata)) . ' <input type="text" name="' . $name . '" /></label></p>';
	}
}

// Types d'entités et subtypes
$types_opt = array('user' => elgg_echo('user'), 'group' => elgg_echo('group'), 'object' => elgg_echo('object')); // We dont't want empty type
$registered_subtypes = get_registered_entity_types(); // Returns all subtypes, even non-objects
$subtypes_opt[] = '';
foreach ($registered_subtypes as $type => $subtypes) {
	foreach ($subtypes as $type => $subtype) {
		$subtypes_opt[] = $subtype;
	}
}

// Types de profils des utilisateurs
$profiletypes_opt = esope_get_profiletypes(); // $guid => $title
$profiletypes_opt[0] = '';
$profiletypes_opt = array_reverse($profiletypes_opt, true); // We need to keep the keys here !


// Construction du formulaire
$search_form = '<form id="esope-search-form" method="post" action="' . $search_action . '">
	' . elgg_view('input/securitytoken') . '
	<fieldset>
	<p><label>' . elgg_echo('esope:fulltextsearch') . ' <input type="text" name="q" value="" /></label></p>
	<p><label>' . elgg_echo('esope:search:type') . ' ' . elgg_view('input/select', array('name' => 'entity_type', 'value' => '', 'options_values' => $types_opt)) . '</label></p>
	<p><label>' . elgg_echo('esope:search:profile_type') . ' ' . elgg_view('input/select', array('name' => 'metadata[custom_profile_type]', 'value' => '', 'options_values' => $profiletypes_opt)) . '</label></p>
	<p><label>' . elgg_echo('esope:search:subtype') . ' ' . elgg_view('input/select', array('name' => 'entity_subtype', 'value' => '', 'options' => $subtypes_opt)) . '</label></p>
	' . $metadata_search . '
	<div class="clearfloat"></div>
	<input type="submit" class="elgg-button elgg-button-submit" value="' . elgg_echo('search') . '" />
	</fieldset>
	</form><br />';

$content .= $search_form;
$content .= elgg_view('graphics/ajax_loader', array('id' => "esope-search-ajax-loader"));
$content .= '<div id="esope-search-results"></div>';


// If any parameters is passed, perform search on page load
if (!empty($_GET)) {
	$content .= '<script type="text/javascript">
	esope_search();
	</script>';
}


$body = elgg_view_layout('one_column', array(
//	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => false,
));

echo elgg_view_page($title, $body);

