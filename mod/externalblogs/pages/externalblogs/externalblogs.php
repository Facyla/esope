<?php
/**
 * Elgg externalblogs plugin everyone page
 *
 * @package Elggexternalblogs
 */
$url = elgg_get_site_url();

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('externalblogs'));

elgg_register_title_button();

// Listing global des blogs
$externalblogs_count = elgg_get_entities(array('types' => 'object', 'subtypes' => 'externalblog', 'count' => true));
$externalblogs = elgg_get_entities(array('types' => 'object', 'subtypes' => 'externalblog', 'limit' => $externalblogs_count));
foreach ($externalblogs as $externalblog) {
	if (elgg_is_logged_in()) {
		$content .= elgg_view_entity($externalblog) . '<br />';
	} else {
		$content .= '<h3><a href="' . $url . $externalblog->blogname . '">' . $externalblog->title . ' (' . $url . $externalblog->blogname . '</a>)</h3><br />';
	}
	/*
	$content .= '<h3>' . $externalblog->title . ' (<a href="' . $url . $externalblog->blogname . '">' . $url . $externalblog->blogname . '</a>)</h3>';
	if (!empty($externalblog->password)) $content .= 'Mot de passe : ' . $externalblog->password . '<br />';
	if (!empty($externalblog->description)) $content .= $externalblog->description . '<br />';
	if (elgg_is_logged_in() && $externalblog->canEdit()) {
		$content .= '<a href="' . $url . 'externalblogs/edit/' . $externalblog->guid . '">Modifier</a>&nbsp; &nbsp;';
		$content .= elgg_view('output/url', array('href' => $url . 'action/externalblogs/delete?guid=' . $externalblog->guid, 'is_action' => true, 'text' => 'Supprimer')) . '<br />';
	}
	$content .= '<br /><br />';
	*/
}
if (!$content) { $content = elgg_echo('externalblogs:none'); }


/*
// Listing global des modules
$externalblog_modules = elgg_get_entities(array('types' => 'object', 'subtypes' => 'externalblog_module', 'limit' => 10));
foreach ($externalblog_modules as $externalblog_module) {
	if (elgg_is_logged_in()) {
		//$content .= elgg_view_entity($externalblog_module) . '<br />';
		$module_content .= '<h3><a href="' . $url . 'externalblog/module/' . $externalblog_module->guid . '">' . $externalblog_module->title . '</a></h3>' . $externalblog_module->description . '<br /><br />';
	}
}
if (!$module_content) { $module_content = elgg_echo('externalblogs:module:none'); }
$content .= '<h3>Modules</h3>' . $module_content;
*/


// Menu latéral
$sidebar = elgg_view('externalblogs/sidebar');



// Rendu de la page
$title = elgg_echo('externalblogs:all');
if (elgg_is_logged_in()) {
	$body = elgg_view_layout('content', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar, 'filter' => ''));
} else {
	$body = elgg_view_title($title) . $content;
}
echo elgg_view_page($title, $body);

