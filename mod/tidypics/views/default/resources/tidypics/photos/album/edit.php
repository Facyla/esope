<?php
/**
 * Edit an album
 *
 * @author Cash Costello
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License v2
 */

$guid = elgg_extract('guid', $vars);
$entity = get_entity($guid);
if (!($entity instanceof TidypicsAlbum)) {
	forward('photos/all');
}

if (!$entity->canEdit()) {
	forward('photos/all');
}

elgg_set_page_owner_guid($entity->getContainerGUID());
$owner = elgg_get_page_owner_entity();

elgg_gatekeeper();
elgg_group_gatekeeper();

$title = elgg_echo('album:edit');

// set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('photos'), 'photos/siteimagesall');
elgg_push_breadcrumb(elgg_echo('tidypics:albums'), 'photos/all');
if ($owner instanceof ElggUser) {
	elgg_push_breadcrumb($owner->name, "photos/owner/$owner->username");
} else {
	elgg_push_breadcrumb($owner->name, "photos/group/$owner->guid/all");
}
elgg_push_breadcrumb($entity->getTitle(), $entity->getURL());
elgg_push_breadcrumb($title);

$vars = tidypics_prepare_form_vars($entity);
$content = elgg_view_form('photos/album/save', ['method' => 'post'], $vars);

$body = elgg_view_layout('content', [
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'sidebar' => elgg_view('photos/sidebar_al', ['page' => 'upload']),
]);

echo elgg_view_page($title, $body);
