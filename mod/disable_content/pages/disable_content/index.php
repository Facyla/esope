<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2015
* @link http://id.facyla.fr/
*/

admin_gatekeeper();

access_show_hidden_entities(true);
$ia = elgg_set_ignore_access(true);

$enable_opts = array('' => '', 'yes' => elgg_echo('disable_content:option:enabled'), 'no' => elgg_echo('disable_content:option:disabled') );

$title = elgg_echo('disable_content:index');

$content = '';
$sidebar = "";



// Used vars
$guid = get_input('guid', false);
$enabled = get_input('enabled', '');
$limit = get_input('limit', 10);
$offset = get_input('offset', 0);
$base_url = elgg_get_site_url() . 'disable_content';


// Process form, or set form defaults based on object status
if ($guid) {
	$object = get_entity($guid);
	if (elgg_instanceof($object, 'object')) {
		
		if (in_array($enabled, array('yes', 'no'))) {
			$entity_title = $object->title;
			if (empty($entity_title)) $entity_title = $object->name;
			if (empty($entity_title)) $entity_title = "GUID " . $object->guid;
			
			// Disable object
			if ($enabled == 'no') {
				if ($object->disable()) {
					system_message(elgg_echo('disable_content:disable:success'), array($entity_title));
				} else {
					register_error(elgg_echo('disable_content:disable:success'), array($entity_title));
				}
			} else if ($enabled == 'yes') {
				// Enable object
				if ($object->enable()) {
					system_message(elgg_echo('disable_content:enable:success'), array($entity_title));
				} else {
					register_error(elgg_echo('disable_content:enable:error'), array($entity_title));
				}
			}
			// Clear form fields
			forward($base_url . '?guid=' . $guid);
		} else {
			// Set default form value
			//if ($object->isEnabled()) $enabled = 'yes'; else $enabled = 'no';
			//register_error(elgg_echo('disable_content:error:noaction'));
		}
		
	}
}



// FORMULAIRE DE DESACTIVATION D'UN GROUPE ET DE SES CONTENUS
$sidebar .= '<p><em>' . elgg_echo('disable_content:information') . '</em></p>';

/*
$sidebar .= '<h3>' . elgg_echo('disable_content:form:title') . '</h3>';
$sidebar .= '<form method="POST" class="elgg-form" id="objects-disable-form">';
//$sidebar .= '<p><label>' . elgg_echo('disable_content:objectguid') . ' ' . elgg_view('input/text', array('name' => "guid", 'value' => $guid, 'placeholder' => elgg_echo('disable_content:objectguid'))) . '</label></p>';
$sidebar .= '<p><label>' . elgg_echo('disable_content:objectguid') . ' ' . elgg_view('input/objects_select', array('name' => "guid", 'value' => $guid, 'style' => "max-width:90%;")) . '</label></p>';
$sidebar .= '<p><label>' . elgg_echo('disable_content:objectdisable') . ' ' . elgg_view('input/dropdown', array('name' => 'enabled', 'options_values' => $enable_opts, 'value' => $enabled)) . '</label></p>';
$sidebar .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('disable_content:proceed'), 'class' => "elgg-button elgg-button-submit")) . '</p>';
$sidebar .= '</form>';
*/



// Main content
$disabled_objects_count = disable_content_get_disabled_objects(array('count' => true));
$disabled_objects = disable_content_get_disabled_objects(array('limit' => $limit, 'offset' => $offset));

$content .= '<p>' . elgg_echo('disable_content:index:details') . '</p>';
if ($disabled_objects_count > 0) {
	$title .= " ($disabled_objects_count)";
	if ($disabled_objects_count > $limit) {
		$nav = elgg_view('navigation/pagination', array(
			'baseurl' => $base_url,
			'offset' => $offset,
			'count' => $disabled_objects_count,
			'limit' => $limit,
			'offset_key' => 'offset',
		));
	}
	
	// Objects listing
	$content .= '<ul>';
	foreach($disabled_objects as $object) {
		$entity_title = $object->title;
		if (empty($entity_title)) $entity_title = $object->name;
		if (empty($entity_title)) $entity_title = "GUID " . $object->guid;
		
		$content .= '<li class="elgg-output elgg-list object-disabled">';
		$content .= '<a href="' . $base_url . '?guid=' . $object->guid . '&enabled=yes" class="elgg-button elgg-button-action">' . elgg_echo('disable_content:enable') . '</a>';
		$content .= '<a href="' . $base_url . '/view/' . $object->guid . '"><h3>' . $entity_title . ' (' . $object->getSubtype() . ', GUID ' . $object->guid . ')</a>&nbsp;: <span class="elgg-subtext">' . elgg_get_excerpt($object->description) . '</span></h3>';
		$content .= '</li>';
	}
	$content .= '</ul>';
	$content .= $nav;
}


$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

elgg_set_ignore_access($ia);

// Render the page
echo elgg_view_page($title, $body);


