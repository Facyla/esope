<?php
/**
 * Elgg bookmarks widget
 *
 * @package Bookmarks
 */

$max = (int) $vars['entity']->num_display;
$filter = $vars['entity']->filter;

$options = array(
	'type' => 'object',
	'subtype' => 'bookmarks',
	'limit' => $max,
	'full_view' => FALSE,
	'pagination' => FALSE,
);

switch ($filter) {
	case 'all':
		$content = elgg_list_entities($options);
		break;
	case 'friends':
		$content = list_user_friends_objects($vars['entity']->owner_guid, 'bookmarks', $max, false, false, false);
		break;
	case 'mygroups':
		$mygroups = elgg_get_entities_from_relationship(array('type' => 'group', 'relationship' => 'member', 'relationship_guid' => $vars['entity']->owner_guid, 'inverse_relationship' => false, 'limit' => false));
		if ($mygroups) {
			foreach ($mygroups as $ent) { $group_guids[] = $ent->guid; }
			$options['container_guids'] = $group_guids;
			$content = elgg_list_entities($options);
		}
		break;
	case 'mine':
	default:
		$options['owner_guid'] = $vars['entity']->owner_guid;
		$content = elgg_list_entities($options);
}


echo $content;

if ($content) {
	$url = "bookmarks/owner/" . elgg_get_page_owner_entity()->username;
	$more_link = elgg_view('output/url', array(
		'href' => $url,
		'text' => elgg_echo('bookmarks:more'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('bookmarks:none');
}
