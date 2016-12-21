<?php
/**
 * Group members sidebar
 *
 * @package ElggGroups
 *
 * @uses $vars['entity'] Group entity
 * @uses $vars['limit']  The number of members to display
 */

$limit = elgg_extract('limit', $vars, 14);

$all_link = elgg_view('output/url', array(
	'href' => 'groups/members/' . $vars['entity']->guid,
	'text' => elgg_echo('groups:members:more'),
	'is_trusted' => true,
));

$params = array(
	'relationship' => 'member',
	'relationship_guid' => $vars['entity']->guid,
	'inverse_relationship' => true,
	'type' => 'user',
	'limit' => $limit,
	'pagination' => false,
	'list_type' => 'gallery',
	'gallery_class' => 'elgg-gallery-users',
	'pagination' => false,
);
$body = elgg_list_entities_from_relationship($params);
$params['count'] = true;
$count = elgg_get_entities_from_relationship($params);

$body .= "<div class='center mts'>$all_link</div>";
$title = elgg_echo('groups:members') . '<span class="groups-members-count">[' . $count . ']</span>';

echo elgg_view_module('aside', $title, $body, array('class' => 'group-members'));

