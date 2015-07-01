<?php
/**
 * User transitions widget display view
 */

$num = $vars['entity']->num_display;

$options = array(
	'type' => 'object',
	'subtype' => 'transitions',
	'container_guid' => $vars['entity']->owner_guid,
	'limit' => $num,
	'full_view' => false,
	'pagination' => false,
	'distinct' => false,
);
$content = elgg_list_entities($options);

echo $content;

if ($content) {
	$transitions_url = "transitions/owner/" . elgg_get_page_owner_entity()->username;
	$more_link = elgg_view('output/url', array(
		'href' => $transitions_url,
		'text' => elgg_echo('transitions:moretransitionss'),
		'is_trusted' => true,
	));
	echo "<span class=\"elgg-widget-more\">$more_link</span>";
} else {
	echo elgg_echo('transitions:notransitionss');
}
