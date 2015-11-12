<?php

// Data model : https://schema.org/Person

elgg_load_js('elgg.directory.directory');

elgg_load_js('lightbox');
elgg_load_css('lightbox');
elgg_require_js('jquery.form');
elgg_load_js('elgg.embed');

// Get current directory (if exists)
$guid = get_input('guid', false);
$person = get_entity($guid);
$container_guid = get_input('container_guid', false);
$container = get_entity($container_guid);

$content = '';
$sidebar = '';

// Get directory vars
if (elgg_instanceof($person, 'object', 'person')) {
	$person_name = $person->name;
	$person_title = $person->title; // directory title, for easier listing
	$person_description = $person->description; // Clear description of what this directory is for
	// Complete directory content - except the first-level <ul> tag (we could use an array instead..) - Use several blocks si we can have an array of individual entities
	$person_access = $person->access_id; // Default access level
	
} else {
	$person_css = elgg_get_plugin_setting('css', 'directory'); // CSS
	$person_access = get_default_access(); // Default access level
	$person_entities = $entity_guid;
	$person_entities_comment = array();
}

// Options
$access_opt = array('0' => elgg_echo('directory:access:draft'), '2' => elgg_echo('directory:access:published'));
$write_access_opt = array('2' => elgg_echo('directory:write:open'), '0' => elgg_echo('directory:write:closed'));


// Edit form
$content = '';

// Param vars
if ($person) { $content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid)) . '</p>'; }

// @TODO : Enable quick configuration of data model
$fields_config = directory_data_person();
foreach($fields_config as $field => $input_type) {
	$content .= '<p><label>' . elgg_echo("directory:edit:person:$field") . ' ' . elgg_view("input/$input_type", array('name' => $field, 'value' => $person->$field, 'placeholder' => elgg_echo("directory:edit:person:$field:placeholder"))) . '</label><br /><em>' . elgg_echo("directory:edit:person:$field:details") . '</em></p>';
}


$sidebar .= '<p style="text-align:right;">' . elgg_view('input/submit', array('value' => elgg_echo('directory:edit:submit'), 'class' => "elgg-button elgg-button-action")) . '</p>';

// Illustration
$sidebar .= '<p><label for="directory_icon">';
if ($person) {
	$sidebar .= elgg_echo("directory:icon");
} else {
	$sidebar .= elgg_echo("directory:icon:new");
}
$sidebar .= '</label><br />';
$sidebar .= '<em>' . elgg_echo('directory:icon:details') . '</em><br />';
$sidebar .= elgg_view("input/file", array("name" => "icon", "id" => "directory_icon"));
if ($person && $person->icontime) {
	$sidebar .= '<br /><img src="' . $person->getIconURL('listing') . '" /><br />';
	$sidebar .= elgg_view("input/checkbox", array('name' => "remove_icon", 'value' => "yes"));
	$sidebar .= elgg_echo("directory:icon:remove");
}
$sidebar .= '</p>';

// Access
//$content .= '<p><label>' . elgg_echo('directory:edit:access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $person_access)) . '</label><br /><em>' . elgg_echo('directory:edit:access:details') . '</em></p>';
$sidebar .= '<p><label>' . elgg_echo('directory:edit:access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $person_access, 'options_values' => $access_opt)) . '</label><br /><em>' . elgg_echo('directory:edit:access:details') . '</em></p>';

$sidebar .= '<div class="clearfloat"></div>';


// 2 columns layout
$title = elgg_echo('directory:edit');
$content = <<<___HTML
<h2>$title</h2>

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
if (is_array($person_entities)) {
	foreach($person_entities as $k => $entity_guid) {
		$content .= elgg_view('directory/input/entity', array('guid' => $person->guid, 'entity_guid' => $entity_guid, 'entity_comment' => $person_entities_comment[$k], 'offset' => $k));
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


/*
echo '<div class="clearfloat"></div><br />';

// Informations on embed and insert
if ($person) {
	echo '<h3><i class="fa fa-info-circle"></i> ' . elgg_echo('directory:embed:instructions') . '</h3>';
	echo '<p><blockquote>';
	echo elgg_echo('directory:iframe:instructions', array($person->guid)) . '<br />';
	if (elgg_is_active_plugin('shortcodes')) { echo elgg_echo('directory:shortcode:instructions', array($person->guid)) . '<br />'; }
	if (elgg_is_active_plugin('cmspages')) {
		echo elgg_echo('directory:cmspages:instructions', array($person->guid)) . '<br />';
		if (elgg_is_active_plugin('shortcodes')) { echo elgg_echo('directory:cmspages:instructions:shortcode', array($person->guid)) . '<br />'; }
	}
	echo '</blockquote></p>';
}
*/

// Prévisualisation
/*
if ($person) {
	echo '<div class="clearfloat"></div><br /><br />';
	echo '<a href="' . $person->getURL() . '" style="float:right" target="_blank" class="elgg-button elgg-button-action">' . elgg_echo('directory:edit:view') . '</a>';
	echo '<h2>' . elgg_echo('directory:edit:preview') . '</h2>';
	echo elgg_view('directory/view', array('entity' => $person));
}
*/


// Affichage du formulaire
// Display the form - Affichage du formulaire
echo elgg_view('input/form', array('action' => elgg_get_site_url() . "action/directory/edit", 'body' => $content, 'id' => "directory-edit-form", 'enctype' => 'multipart/form-data'));

