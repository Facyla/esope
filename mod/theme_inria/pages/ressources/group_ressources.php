<?php
/**
 * Elgg bookmarks plugin everyone page
 *
 * @package ElggBookmarks
 */

$owner = elgg_get_page_owner_entity();
if (!$owner) { forward('', '404'); }

elgg_push_context('ressources');

elgg_pop_breadcrumb();
elgg_push_breadcrumb($owner->name);


$owner = elgg_get_page_owner_entity();
if (!elgg_instanceof($owner, 'group')) {
	register_error('ressources:notingroup');
	forward();
}

$content = '';
$sidebar = '';

elgg_set_context('widgets');

// Add files if enabled
//if ($owner->file_enable == 'yes') {
if (elgg_is_active_plugin('files')) {
	$files = elgg_list_entities(array(
		'type' => 'object', 'subtype' => 'file',
		'full_view' => false, 'view_toggle_type' => false,
		'container_guid' => $owner->guid,
	));
	if (!$files) { $files = elgg_echo('files:none'); }
	
	$files = '<h3><a href="' . $vars['url'] . 'file/group/' . $owner->guid . '/all">' . elgg_echo("file:user", array($owner->name)) . '</a></h3>' . $files;
	// Sidebar : not sure it adds anything but complexity
	//$sidebar .= file_get_type_cloud(elgg_get_page_owner_guid());
	//$sidebar .= elgg_view('file/sidebar');
}

// Add bookmarks if enabled
if ($owner->bookmarks_enable == 'yes') {
	$bookmarks = elgg_list_entities(array(
		'type' => 'object', 'subtype' => 'bookmarks',
		'full_view' => false, 'view_toggle_type' => false,
		'container_guid' => $owner->guid,
	));
	if (!$bookmarks) { $bookmarks = elgg_echo('bookmarks:none'); }
	
	$bookmarks = '<h3><a href="' . $vars['url'] . 'bookmarks/group/' . $owner->guid . '/all">' . elgg_echo('bookmarks:owner', array($owner->name)) . '</a></h3>' . $bookmarks;
	// Sidebar : not sure it adds anything but complexity
	//$sidebar .= elgg_view('bookmarks/sidebar');
}

elgg_pop_context();



// Compose page content
$content .= '<div class="elgg-grid">';
if ($bookmarks && $files) {
	$content .= '<div style="width:48%; float:left;">' . $files . '</div>';
	$content .= '<div style="width:48%; float:right;">' . $bookmarks . '</div>';
} else if ($bookmarks) {
	$content .= '<div class="elgg-col elgg-col-1of1">' . $bookmarks . '</div>';
} else if ($files) {
	$content .= '<div class="elgg-col elgg-col-1of1">' . $files . '</div>';
}
$content .= '</div>';

if (!$content) { $content = elgg_echo('ressources:none'); }

$title = elgg_echo('ressources:group', array($owner->name));

$body = elgg_view_layout('content', array(
	//'filter_context' => 'all',
	'filter' => false,
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);

