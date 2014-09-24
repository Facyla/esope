<?php
// Main KDB view, for inner group + public interface

$fields = elgg_extract('fields', $vars);
$container_guid = elgg_extract('container_guid', $vars);
$publish_guid = elgg_extract('publish_guid', $vars);


// Search vars
$search_q = get_input('q');
// The other vars are in a single loop


// Types d'entités et subtypes
/*
$types_opt = array('user' => elgg_echo('user'), 'group' => elgg_echo('group'), 'object' => elgg_echo('object')); // We dont't want empty type
$registered_subtypes = get_registered_entity_types(); // Returns all subtypes, even non-objects
$subtypes_opt[] = '';
foreach ($registered_subtypes as $type => $subtypes) {
	foreach ($subtypes as $type => $subtype) {
		$subtypes_opt[] = $subtype;
	}
}
*/
$subtypes = elgg_get_plugin_setting('kdb_subtypes', 'knowledge_database');
$subtypes = esope_get_input_array($subtypes);
$subtypes_opt[''] = elgg_echo('knowledge_database:subtype:all');
if ($subtypes) foreach ($subtypes as $subtype) {
	$subtypes_opt[$subtype] = elgg_echo("knowledge_database:subtype:$subtype");
}





// FORMULAIRE
// Prepare JS script for forms
$action_base = $CONFIG->url . 'action/knowledge_database/';
$kdb_search_url = elgg_add_action_tokens_to_url($action_base . 'search');


$content .= '<h3>' . elgg_echo("knowledge_database:search:title") . '</h3>';
$content .= '<script>
var formdata;
function kdb_search(){
	//$("body").addClass("esope-search-wait");
	formdata = $("#kdb-search-form").serialize();
	$.post("' . $kdb_search_url . '", formdata, function(data){
		$("#esope-search-results").html(data);
		//$("body").removeClass("esope-search-wait");
	});
}
</script>';

// Préparation du formulaire
$search_action = "javascript:kdb_search();";
// Should be an array, so clear blanks then make it an array
$metadata_search = '';

// Construction du formulaire
$search_form = '<form id="kdb-search-form" method="post" action="' . $search_action . '">';
$search_form .= elgg_view('input/securitytoken');
//$search_form .= elgg_view('input/hidden', array('name' => 'debug', 'value' => 'true'));
// @TODO Limit in a container (group) only if we are in a KDB group
if ($container_guid) $search_form .= elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
$search_form .= elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'object'));

$search_form .= '<p><em><i class="fa fa-info-circle"></i> ' . elgg_echo('knowledge_database:search:details') . '</em></p>';
// Main search
$search_form .= '<fieldset style="border: 1px solid #2195B1; padding: 1ex 2ex; background: #f5f5f5; margin-top:1ex;">';
//$search_form .= '<legend>' . elgg_echo("knowledge_database:search:form:title") . '</legend>';
$search_form .= '<div class="kdb-search-main">';
$search_form .= '<p><label><i class="fa fa-eye"></i> ' . elgg_echo('knowledge_database:fulltextsearch') . ' <input type="text" name="q" value="' . $search_q . '" /></label><br />' . elgg_echo('knowledge_database:fulltextsearch:details') . '<em></em></p>';
$search_form .= '</div>';
$search_form .= '<div class="clearfloat"></div>';

// Custom fields
if ($fields) foreach ($fields as $name) {
	$field_content = '';
	$inputs[$name] = get_input($name);
	
	// Selectors options
	$config = knowledge_database_get_field_config($name);
	$selectors[$name] = $config['params']['options_values'];
	if ($selectors[$name]) array_unshift($selectors[$name], ''); // Ajoute une option vide au début du tableau
	
	$title = esope_get_best_translation_for_metadata($name, 'knowledge_database:metadata', $config['title']);
	
	// Adjust input types
	$view = 'text';
	//$view = $config['type'];
	if (in_array($config['type'], array('dropdown', 'multiselect'))) { $view = 'dropdown'; }
	else if (in_array($config['type'], array('date'))) { $view = 'date'; }
	else if (in_array($config['type'], array('longtext', 'plaintext', 'tags', 'email'))) { $view = 'text'; }
	else if (in_array($config['type'], array('file'))) { continue; }
	
	// Build search field
	$field_content .= '<div class="kdb-search-filter">';
		$field_content .= '<p><label><span>' . $title . '</span> ';
		$field_content .= elgg_view("input/$view", array('name' => "metadata[$name]", 'value' => $inputs[$name], 'options_values' => $selectors[$name]));
		$field_content .= '</label></p>';
	$field_content .= '</div>';
	
	$fieldset = $config['category'];
	if (empty($fieldset)) $fieldset = 'default';
	// Add field to appropriate fieldset
	$fieldset_fields[$fieldset] .= $field_content;
}


// Render fields into fieldsets
foreach ($fieldset_fields as $fieldset => $fields_content) {
	$search_form .= '<div class="clearfloat"></div>';
	if ($fieldset == 'default') {
		$search_form .= $fields_content;
	} else {
		$fieldset_title = esope_get_best_translation_for_metadata($fieldset, 'knowledge_database:fieldset');
		$search_form .= '<fieldset class="knowledge_database-fieldset">';
		$search_form .= '<legend>' . $fieldset_title . '</legend>';
		$search_form .= $fields_content;
		$search_form .= '</fieldset>';
	}
	$search_form .= '<div class="clearfloat"></div><br />';
}

$search_form .= '<div class="clearfloat" style="margin:0;"></div>';
$search_form .= '<input type="submit" class="elgg-button elgg-button-submit fa fa-search" value="' . elgg_echo('search') . '" />';
$search_form .= '</fieldset>';
$search_form .= '</form><br />';




// @TODO make it a view !
// Random database ressources
$content_latest .= '<h3>' . elgg_echo("knowledge_database:latestressources") . '</h3>';
$params = array('type' => 'object', 'limit' => 0);
if ($container_guid) $params['container_guid'] = $container_guid;
$latest = elgg_get_entities($params);
shuffle($latest);
$latest = array_slice($latest, 0, 3);
foreach($latest as $ent) {
	$icon = knowledge_database_get_icon($ent, 'medium');
	$content_latest .= '<div class="kdb-featured">
			<div class="kdb-featured-content">
				<div class="kdb-featured-header">
					<a href="' . $ent->getURL() . '">
						<div class="image-block">' . $icon . '</div>
						<h4>' . $ent->title . '</h4></a>
				</div>
				<p>' . elgg_view('output/tags', array('tags' => $ent->tags)) . '</p>
				<p>' . elgg_get_excerpt($ent->description, 150) . '</p>
			</div>
		</div>';
}
$content_latest .= '<div class="clearfloat"></div><br /><br />';



// @TODO make it a view
// Add content block
$content_add = '<h3>' . elgg_echo('knowledge_database:addressource') . '</h3>';
if (elgg_is_logged_in()) {
	$content_add .= '<ul id="maghrenov-kdb-add">';
	$content_add .= '<li><a href="' . $CONFIG->url . 'file/add/' . $publish_guid . '"><i class="fa fa-file"></i><br />' . elgg_echo('knowledge_database:addfile') . '</a></li>';
	$content_add .= '<li><a href="' . $CONFIG->url . 'bookmarks/add/' . $publish_guid . '"><i class="fa fa-link"></i><br />' . elgg_echo('knowledge_database:addbookmark') . '</a></li>';
	//$content_add .= '<li><a href="' . $CONFIG->url . 'event_calendar/add/' . $publish_guid . '"><i class="fa fa-calendar"></i><br />Announce an event in the calendar</a></li>';
	$content_add .= '<li><a href="' . $CONFIG->url . 'blog/add/' . $publish_guid . '"><i class="fa fa-file-text-o"></i><br />' . elgg_echo('knowledge_database:addblog') . '</a></li>';
	$content_add .= '</ul>';
} else {
	$content_add = '<h3>' . elgg_echo('knowledge_database:contribute') . '</h3>';
}
$content_add .= '<div class="clearfloat"></div><br /><br />';




// Compose final page
$content .= $search_form;
$content .= '<div id="esope-search-results">' . $content_latest . '</div>';
$content .= '<div class="clearfloat"></div><br /><br />';
$content .= $content_add;
$content .= '<div class="clearfloat"></div><br /><br />';

elgg_set_context('knowledge_database');

echo $content;

