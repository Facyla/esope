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

$title = elgg_echo('disable_content:view');

$content = '';
$sidebar = "";

// Load some required libraries (main are checked and loaded, but some may be missing depending on enabled plugins)
if (elgg_is_active_plugin('pages')) { elgg_load_library('elgg:pages'); }
if (elgg_is_active_plugin('bookmarks')) { elgg_load_library('elgg:bookmarks'); }
if (elgg_is_active_plugin('blog')) { elgg_load_library('elgg:blog'); }
if (elgg_is_active_plugin('event_calendar')) { elgg_load_library('elgg:event_calendar'); }
if (elgg_is_active_plugin('groups')) {
	elgg_load_library('elgg:groups');
	elgg_load_library('elgg:discussion');
}

// Used vars
$guid = get_input('guid', '');
$limit = get_input('limit', 10);
$offset = get_input('offset', 0);
$base_url = elgg_get_site_url() . 'disable_content';
$base_view_url = $base_url . '/view/';
$base_nav_url = $base_view_url . $guid;


// Process form, or set form defaults based on group status
if ($guid) { $entity = get_entity($guid); }
if (!($entity instanceof ElggEntity)) {
	register_error('disable_content:error:invalidentity');
	forward('disable_content');
}


// SIDEBAR


// Main content
$content .= '<p><blockquote>' . elgg_echo('disable_content:notice:previewonly') . '</blockquote></p>';
$content .= '<div class="elgg-output">';

// View entity (should be an object, but not user|group|site)
if (elgg_instanceof($entity, 'object')) {
	$title = elgg_echo('disable_content:view:object');
	$content .= '<a href="' . $base_url . '?guid=' . $entity->guid . '&enabled=yes" class="elgg-button elgg-button-action" style="float:right;">' . elgg_echo('disable_content:enable') . '</a>';
	$content .= '<h3>' . $entity->title . ' (GUID ' . $entity->guid . ')</h3>';
	
	$content .= '<div class="clearfloat"></div>';
	//$content .= '<h2>' . elgg_echo('disable_content:preview') . '</h2>';
	$content .= '<hr />';
	
	// Full entity view
	$content .= elgg_view_entity($entity, array('full_view' => true));
}
$content .= '</div>';



elgg_push_breadcrumb($title);

$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
elgg_set_ignore_access($ia);

// Render the page
echo elgg_view_page($title, $body);

