<?php
/**
 * View for page object
 *
 * @package ElggPages
 *
 * @uses $vars['entity']    The page object
 * @uses $vars['full_view'] Whether to display the full view
 * @uses $vars['revision']  This parameter not supported by elgg_view_entity()
 */


$full = elgg_extract('full_view', $vars, FALSE);
$page = elgg_extract('entity', $vars, FALSE);
$revision = elgg_extract('revision', $vars, FALSE);

if (!$page) {
	return TRUE;
}

// pages used to use Public for write access
if ($page->write_access_id == ACCESS_PUBLIC) {
	// this works because this metadata is public
	$page->write_access_id = ACCESS_LOGGED_IN;
}

// Facyla : Export de la page courante
elgg_register_menu_item('entity', array(
		'name' => 'htmlexport', 'text' => elgg_echo('theme_inria:pages:pageexport'), 'title' => elgg_echo('theme_inria:pages:pageexport:title'),
		'href' => elgg_add_action_tokens_to_url($vars['url'] . 'action/pages/html_export?subpages=yes&guid=' . $page->guid),
	));


if ($revision) {
	$annotation = $revision;
} else {
	$annotation = $page->getAnnotations('page', 1, 0, 'desc');
	if ($annotation) {
		$annotation = $annotation[0];
	}
}

$page_icon = elgg_view('pages/icon', array('annotation' => $annotation, 'size' => 'small'));

$editor = get_entity($annotation->owner_guid);
$editor_link = elgg_view('output/url', array(
	'href' => "pages/owner/$editor->username",
	'text' => $editor->name,
	'is_trusted' => true,
));

$date = elgg_view_friendly_time($annotation->time_created);
$editor_text = elgg_echo('pages:strapline', array($date, $editor_link));
$categories = elgg_view('output/categories', $vars);

$comments_count = $page->countComments();
//only display if there are commments
if ($comments_count != 0 && !$revision) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $page->getURL() . '#page-comments',
		'text' => $text,
		'is_trusted' => true,
	));
} else {
	$comments_link = '';
}

$subtitle = "$editor_text $comments_link $categories";

// do not show the metadata and controls in widget view
if (!elgg_in_context('widgets')) {
	// If we're looking at a revision, display annotation menu
	if ($revision) {
		$metadata = elgg_view_menu('annotation', array(
			'annotation' => $annotation,
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz float-alt',
		));
	} else {
		// Regular entity menu
		$metadata = elgg_view_menu('entity', array(
			'entity' => $vars['entity'],
			'handler' => 'pages',
			'sort_by' => 'priority',
			'class' => 'elgg-menu-hz',
		));
	}
}


if ($full) {
	
	/*
	// Export du wiki complet
	elgg_register_menu_item('title', array(
			'name' => 'htmlexport', 'text' => elgg_echo('theme_inria:pages:fullexport'), 'title' => elgg_echo('theme_inria:pages:fullexport:title'),
			'href' => elgg_add_action_tokens_to_url($vars['url'] . 'action/pages/html_export?guid=' . $page->guid),
			'link_class' => 'elgg-button elgg-button-action',
		));
	*/
	
	$body = elgg_view('output/longtext', array('value' => $annotation->value));

	$params = array(
		'entity' => $page,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	// Ajout Facyla pour avoir le sommaire qqpart dans l'interface et naviguer dans les pages...
	// Note : si on prévoit des listings en full_view, il faut ajouter une var globale pour avoir un sommaire unique
	$wiki_nav = '<div class="full-width-pages-nav"><a href="#full-width-pages-nav-content" rel="toggle"><i class="fa fa-caret-down"></i> ' . elgg_echo('theme_inria:pages:summarytoggle'). '</a><div id="full-width-pages-nav-content" style="display:none;">' . elgg_view('pages/top-summary', array('entity' => $page)) . '</div></div>';
	echo $wiki_nav;
	
	echo elgg_view('object/elements/full', array(
		'entity' => $page,
		'title' => false,
		'icon' => $page_icon,
		'summary' => $summary,
		'body' => $body,
	));
	
	echo elgg_view('pages/sub-pages', array('entity' => $page));
	
} else {
	// brief view

	$excerpt = elgg_get_excerpt($page->description);

	$params = array(
		'entity' => $page,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);

	echo elgg_view_image_block($page_icon, $list_body);
}
