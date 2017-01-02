<?php
/**
 * Elgg externalblogs plugin everyone page
 *
 * @package Elggexternalblogs
 */

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('externalblogs'));

use_widgets('externalblog_edit');
elgg_set_context('externalblog_edit');

$guid = get_input('guid', false);
if ($guid) $entity = get_entity($guid);
$container_guid = get_input('container_guid', false);

//$body = elgg_view_form('externalblog/edit', array(), array('title' => 'titre_test', 'blogname' => 'nom_url'));

// Check who can edit this ?
if (elgg_is_logged_in()) {
	if (elgg_instanceof($entity, 'object', 'externalblog') && $entity->canEdit()) {
		$title = elgg_echo('externalblogs:blog:edit');
		$content = elgg_view('externalblogs/forms/edit', array('entity' => $entity));
	} else if ($container_guid) {
		$title = elgg_echo('externalblogs:blog:new');
		$content = elgg_view('externalblogs/forms/edit', array('container_guid' => $container_guid));
	} else {
		register_error('No editing rights on this blog');
		forward(elgg_get_site_url() . 'externalblog');
}
} else {
	forward(elgg_get_site_url() . 'externalblog');
}


// Menu latéral
$sidebar = elgg_view('externalblogs/sidebar');


// Rendu de la page
$title = elgg_echo('externalblogs:blog');
$body = elgg_view_layout('content', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar, 'filter' => ''));
echo elgg_view_page($title, $body);

