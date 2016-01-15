<?php
/**
 * Elgg Market Plugin
 * @package market
 */

// Get the post, if it exists
$guid = (int) get_input('guid');
$post = get_entity($guid);
		
if ($post && $post->canEdit()) {
	$title = elgg_echo('market:edit');
	$form_vars = array(
			'name' => 'marketForm',
			'enctype' => 'multipart/form-data'
			);
	$body_vars = market_prepare_form_vars($post);
	$content = elgg_view_form("market/save", $form_vars, $body_vars);
} else {
	$title = elgg_echo('market:none:found');
	$content = elgg_view("market/error");
}

elgg_push_breadcrumb(elgg_echo('market:title'), "market/category");
elgg_push_breadcrumb($post->title, $post->getURL());
elgg_push_breadcrumb(elgg_echo('market:edit'));

// Show market sidebar
//$sidebar = elgg_view("market/sidebar");
		
$params = array(
		'content' => $content,
		'title' => $title,
		'sidebar' => $sidebar,
		);

$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);

