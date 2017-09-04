<?php
/**
 * All wire posts
 * 
 */

elgg_push_breadcrumb(elgg_echo('thewire'));

$title = elgg_echo('theme_inria:home:wire');

$content = '';

if (elgg_is_logged_in()) {
	$form_vars = array('class' => 'thewire-form');
	$content .= elgg_view_form('thewire/add', $form_vars);
	$content .= elgg_view('input/urlshortener');
}

$content .= '<div class="clearfloat"></div>';
// Iris v2 : message supprimé ?
//$content .= '<blockquote class="thewire-inria-info">' . elgg_echo('theme_inria:thewire:explanations') . '</blockquote>';


// Exclusion des messages du Fil provenant des groupes
$thewire_params = array(
	'type' => 'object',
	'subtype' => 'thewire',
	'limit' => get_input('limit', 10),
);

$add_group_container = get_input('add_group_container', 'no');
// This is for container filtering only, can be removed if no filtering
if ($add_group_container == 'yes') {
	$thewire_params["joins"] = array("INNER JOIN " . elgg_get_config('dbprefix') . "entities AS ce ON e.container_guid = ce.guid");
	$thewire_params["wheres"] = array("ce.type != 'group'"); // avoid messages where container is a group
}


$content .= '<div class="iris-box">';
$content .= elgg_list_entities($thewire_params);
$content .= '</div>';

$sidebar = elgg_view('thewire/sidebar');
$sidebar .= elgg_view('thewire/filter');

$body = elgg_view_layout('content', array(
	'filter_context' => 'all',
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);
