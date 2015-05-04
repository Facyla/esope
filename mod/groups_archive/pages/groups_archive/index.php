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

$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );

$title = elgg_echo('groups_archive:index');

$content = '';
$sidebar = "";



// Process form, or set form defaults based on group status
$guid = get_input('guid', false);
$enabled = get_input('enabled', false);
if ($guid && $enabled) {
	access_show_hidden_entities(true);
	
	$group = get_entity($guid);
	switch($enabled) {
		// Disable group
		case 'no':
			$group->disable();
			break;
		
		// Enable group
		case 'yes':
			$group->enable();
			break;
		
		// Set default form value
		default:
			if ($group->isEnabled()) $enabled = 'yes'; else $enabled = 'no';
	}
	
}

// FORMULAIRE DE DESACTIVATION D'UN GROUPE ET DE SES CONTENUS
$sidebar .= '<h2></h2>';
$sidebar .= '<form method="POST" class="elgg-form">
	<p><label>' . elgg_echo('groups_archive:groupguid') . ' ' . elgg_view('input/text', array('name' => "guid", 'value' => $guid, 'placeholder' => elgg_echo('groups_archive:groupguid'))) . '</label></p>
	<p><label>' . elgg_echo('groups_archive:grouparchive') . ' ' . elgg_view('input/dropdown', array('name' => 'enabled', 'options_values' => $yes_no_opt, 'value' => $enabled)) . '</label></p>
	<p>' . elgg_view('input/submit', array('value' => elgg_echo('groups_archive:proceed'), 'class' => "elgg-button elgg-button-submit")) . '</p>
	</form>';


$disabled_groups_param = array(
		'types' => "group", 
		'wheres' => array("e.enabled = 'no'"),
	);
$disabled_groups = elgg_get_entities($disabled_groups_param);

$content .= '<div>';
$content .= '<ul>';
foreach($disabled_groups as $group) {
	$content .= '<li class="elgg-list group-disabled"><h3>' . $group->name . ' (GUID ' . $group->guid . ')</h3>Contenus du groups (archivés)&nbsp;:';
	$objects = $group->getObjects('', 0);
	if ($objects) {
		$content .= '<ul class="elgg-output">';
		foreach ($objects as $ent) {
			$content .= "<li>" . $ent->guid . ' (' . $ent->getSubtype() . ')&nbsp;: ' . $ent->title . $ent->name . '</li>';
		}
		$content .= '</ul>';
	}
	$content .= '</li>';
}
$content .= '</ul>';
$content .= '</div>';


// Render the page
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
echo elgg_view_page($title, $body);


