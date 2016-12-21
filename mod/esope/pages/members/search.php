<?php
/**
 * Members search
 *
 */

$hide_directory = elgg_get_plugin_setting('hide_directory', 'esope');
if ($hide_directory == 'yes') { gatekeeper(); }

//elgg_require_js('elgg/spinner'); // @TODO make spinner work...

$num_members = esope_get_number_users();
$title = elgg_echo('members');

$content = elgg_view('esope/users/search', $vars);

//elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('search'));

$params = array(
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'title' => $title . " ($num_members)",
	'filter_override' => elgg_view('members/nav', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

