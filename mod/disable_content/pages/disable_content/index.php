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
$base_url = elgg_get_site_url() . 'groups-archive';


// Process form, or set form defaults based on group status
if ($guid) {
	$group = get_entity($guid);
	if (elgg_instanceof($group, 'group')) {
		
		if (in_array($enabled, array('yes', 'no'))) {
			// Disable group
			if ($enabled == 'no') {
				if ($group->disable()) {
					system_message(elgg_echo('disable_content:disable:success'), array($group->name));
				} else {
					register_error(elgg_echo('disable_content:disable:success'), array($group->name));
				}
			} else if ($enabled == 'yes') {
				// Enable group
				if ($group->enable()) {
					system_message(elgg_echo('disable_content:enable:success'), array($group->name));
				} else {
					register_error(elgg_echo('disable_content:enable:error'), array($group->name));
				}
			}
			// Clear form fields
			forward($base_url . '?guid=' . $guid);
		} else {
			// Set default form value
			//if ($group->isEnabled()) $enabled = 'yes'; else $enabled = 'no';
			//register_error(elgg_echo('disable_content:error:noaction'));
		}
		
	}
}



// FORMULAIRE DE DESACTIVATION D'UN GROUPE ET DE SES CONTENUS
$sidebar .= '<p><em>' . elgg_echo('disable_content:information') . '</em></p>';

$sidebar .= '<h3>' . elgg_echo('disable_content:form:title') . '</h3>';
$sidebar .= '<form method="POST" class="elgg-form" id="groups-archive-form">';
//$sidebar .= '<p><label>' . elgg_echo('disable_content:groupguid') . ' ' . elgg_view('input/text', array('name' => "guid", 'value' => $guid, 'placeholder' => elgg_echo('disable_content:groupguid'))) . '</label></p>';
$sidebar .= '<p><label>' . elgg_echo('disable_content:groupguid') . ' ' . elgg_view('input/groups_select', array('name' => "guid", 'value' => $guid, 'style' => "max-width:90%;")) . '</label></p>';
$sidebar .= '<p><label>' . elgg_echo('disable_content:grouparchive') . ' ' . elgg_view('input/dropdown', array('name' => 'enabled', 'options_values' => $enable_opts, 'value' => $enabled)) . '</label></p>';
$sidebar .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('disable_content:proceed'), 'class' => "elgg-button elgg-button-submit")) . '</p>';
$sidebar .= '</form>';



// Main content
$disabled_groups_count = disable_content_get_disabled_groups(array('count' => true));
$disabled_groups = disable_content_get_disabled_groups(array('limit' => $limit, 'offset' => $offset));

$content .= '<p>' . elgg_echo('disable_content:index:details') . '</p>';
if ($disabled_groups_count > 0) {
	$title .= " ($disabled_groups_count)";
	if ($disabled_groups_count > $limit) {
		$nav = elgg_view('navigation/pagination', array(
			'baseurl' => $base_url,
			'offset' => $offset,
			'count' => $disabled_groups_count,
			'limit' => $limit,
			'offset_key' => 'offset',
		));
	}
	
	// Group listing
	$content .= '<ul>';
	foreach($disabled_groups as $group) {
		$content .= '<li class="elgg-output elgg-list group-disabled">';
		$content .= '<a href="' . $base_url . '?guid=' . $group->guid . '&enabled=yes" class="elgg-button elgg-button-action" style="float:right;">' . elgg_echo('disable_content:unarchive') . '</a>';
		$content .= '<a href="' . $base_url . '/view/' . $group->guid . '"><h3>' . $group->name . ' (GUID ' . $group->guid . ')</a></h3>';
		// Group content listing (preview)
		$objects_count = disable_content_get_groups_content($group, array('count' => true));
		$objects = disable_content_get_groups_content($group); // Get only 10, that's already much if we have many groups...
		if ($objects) {
			$content .= elgg_echo('disable_content:content:count', array($objects_count));
			$content .= '<ul class="">';
			foreach ($objects as $ent) {
				$content .= '<li>' . $ent->title . $ent->name . ' (' . $ent->getSubtype() . ', ' . $ent->guid . ')&nbsp;: <span class="elgg-subtext">' . elgg_get_excerpt($ent->description) . '</span></li>';
			}
			$content .= '</ul>';
		} else {
			$content .= '<p>' . elgg_echo('disable_content:nocontent') . '</p>';
		}
		$content .= '</li>';
	}
	$content .= '</ul>';
	$content .= $nav;
}


$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

elgg_set_ignore_access($ia);

// Render the page
echo elgg_view_page($title, $body);


