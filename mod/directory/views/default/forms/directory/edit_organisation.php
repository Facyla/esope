<?php

// Data model : https://schema.org/Organization

elgg_load_js('elgg.directory.directory');

elgg_load_js('lightbox');
elgg_load_css('lightbox');
elgg_require_js('jquery.form');
elgg_load_js('elgg.embed');

// Get current directory (if exists)
$guid = get_input('guid', false);
$organisation = get_entity($guid);
$container_guid = get_input('container_guid', false);
$container = get_entity($container_guid);

$content = '';
$sidebar = '';

// Get directory vars
if (elgg_instanceof($organisation, 'object', 'organisation')) {
	$organisation_title = $organisation->title; // directory title, for easier listing
	$organisation_description = $organisation->description; // Clear description of what this directory is for
	$organisation_access = $organisation->access_id; // Default access level
	
} else {
	$organisation_css = elgg_get_plugin_setting('css', 'directory'); // CSS
	$organisation_access = get_default_access(); // Default access level
	$organisation_entities = $entity_guid;
	$organisation_entities_comment = array();
}

// Options
//$access_opt = array('0' => elgg_echo('directory:access:draft'), '2' => elgg_echo('directory:access:published'));
//$write_access_opt = array('2' => elgg_echo('directory:write:open'), '0' => elgg_echo('directory:write:closed'));
$access_opt = get_write_access_array();
$write_access_opt = get_write_access_array();


// Edit form
$content = '';

// Param vars
$content .= elgg_view('input/hidden', array('name' => 'subtype', 'value' => 'organisation')) . '</p>';
if ($organisation) { $content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid)) . '</p>'; }

// @TODO : Enable quick configuration of data model
$fields_config = directory_data_organisation();
foreach($fields_config as $field => $input_type) {
	$content .= '<p><label>' . elgg_echo("directory:edit:organisation:$field") . ' ' . elgg_view("input/$input_type", array('name' => $field, 'value' => $organisation->$field, 'placeholder' => elgg_echo("directory:edit:organisation:$field:placeholder"))) . '</label><br /><em>' . elgg_echo("directory:edit:organisation:$field:details") . '</em></p>';
}




// SIDEBAR
$sidebar .= '<p style="text-align:right;">' . elgg_view('input/submit', array('value' => elgg_echo('directory:edit:submit'), 'class' => "elgg-button elgg-button-action")) . '</p>';

// Illustration
$sidebar .= '<p><label organisation="directory_icon">';
if ($organisation && $directory->icontime) {
	$sidebar .= elgg_echo("directory:icon");
} else {
	$sidebar .= elgg_echo("directory:icon:new");
}
$sidebar .= '</label><br />';
$sidebar .= '<em>' . elgg_echo('directory:icon:details') . '</em><br />';
$sidebar .= elgg_view("input/file", array("name" => "icon", "id" => "directory_icon"));
if ($organisation && $organisation->icontime) {
	$sidebar .= '<br /><img src="' . $organisation->getIconURL() . '" /><br />';
	$sidebar .= elgg_view("input/checkbox", array('name' => "remove_icon", 'value' => "yes"));
	$sidebar .= elgg_echo("directory:icon:remove");
}
$sidebar .= '</p>';

// Read Access
$sidebar .= '<p><label>' . elgg_echo('directory:access:read') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $organisation->access_id, 'options_values' => $access_opt)) . '</label><br /><em>' . elgg_echo('directory:access:read:details') . '</em></p>';
$sidebar .= '<div class="clearfloat"></div>';

// Write access : who can edit this organisation
$sidebar .= '<p><label>' . elgg_echo('directory:access:write') . ' ' . elgg_view('input/access', array('name' => 'write_access_id', 'value' => $organisation->write_access_id, 'options_values' => $write_access_opt)) . '</label><br /><em>' . elgg_echo('directory:access:write:details') . '</em></p>';

$sidebar .= '<div class="clearfloat"></div>';


// 2 columns layout
$content = <<<___HTML
<div class="flexible-block" style="width:56%; float:left;">
	$content
</div>

<div class="flexible-block" style="width:40%; float:right;">
	$sidebar
</div>
<div class="clearfloat"></div>
___HTML;


// ENTITIES
/*
// Sortable blocks + JS add new block
$content .= '<div class="directory-edit-entities">';
$content .= '<p><strong>' . elgg_echo('directory:edit:content') . '</strong><br />';
$content .= '<em>' . elgg_echo('directory:edit:content:details') . '</em></p>';


// directory entities (sortable)
if (is_array($organisation_entities)) {
	foreach($organisation_entities as $k => $entity_guid) {
		$content .= elgg_view('directory/input/entity', array('guid' => $organisation->guid, 'entity_guid' => $entity_guid, 'entity_comment' => $organisation_entities_comment[$k], 'offset' => $k));
	}
} else {
	$content .= elgg_view('directory/input/entity', array());
}
$content .= '</div>';
*/

//$content .= '<div class="clearfloat"></div>';
// Add new entity
$content .= elgg_view('input/button', array(
		'id' => 'directory-edit-add-entity',
		'value' => elgg_echo('directory:edit:addentity'),
		'class' => 'elgg-button directory-edit-highlight',
	));
$content .= '<div class="clearfloat"></div><br />';




/* AFFICHAGE DE LA PAGE D'ÉDITION */


// Affichage du formulaire
// Display the form - Affichage du formulaire
echo elgg_view('input/form', array('action' => elgg_get_site_url() . "action/directory/edit", 'body' => $content, 'id' => "directory-edit-form", 'enctype' => 'multipart/form-data'));

