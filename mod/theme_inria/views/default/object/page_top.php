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

$url = elgg_get_site_url();
$page_owner = elgg_get_page_owner_entity();

// Facyla : Export de la page courante
if (!$full && elgg_instanceof($page_owner, 'group')) {
	elgg_register_menu_item('entity', array(
			'name' => 'htmlexport', 'text' => elgg_echo('theme_inria:pages:pageexport'), 'title' => elgg_echo('theme_inria:pages:pageexport:title'),
			'href' => elgg_add_action_tokens_to_url(elgg_get_site_url() . 'action/pages/html_export?subpages=yes&guid=' . $page->guid),
		));
}


if ($revision) {
	$annotation = $revision;
} else {
	$annotation = $page->getAnnotations(array(
		'annotation_name' => 'page',
		'limit' => 1,
		'reverse_order_by' => true,
	));
	if ($annotation) {
		$annotation = $annotation[0];
	} else {
		elgg_log("Failed to access annotation for page with GUID {$page->guid}", 'WARNING');
		return;
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
$subtitle = '<div class="elgg-pages-subtitle">' . $subtitle . '</div>';

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


// In groups
if (elgg_instanceof($page_owner, 'group')) {
	$menu = elgg_view_menu('entity', array(
			'entity' => $page,
			'handler' => $page->getSubtype(),
			'sort_by' => 'priority',
			'class' => 'elgg-menu-vert',
		));
	$menu = '<div class="entity-submenu float-alt">
			<a href="javascript:void(0);" onClick="$(this).parent().find(\'.entity-submenu-content\').toggleClass(\'hidden\')"><i class="fa fa-ellipsis-h"></i></a>
			<div class="entity-submenu-content hidden">' . $menu . '</div>
		</div>';

	$pages_actions = '';
	$pages_actions .= '<li>' . elgg_view('output/url', array(
			'name' => 'htmlexport', 'text' => elgg_echo('theme_inria:pages:pageexport'), 
			'title' => elgg_echo('theme_inria:pages:pageexport:title'),
			'href' => elgg_add_action_tokens_to_url($url . 'action/pages/html_export?subpages=yes&guid=' . $page->guid),
		)) . '</li>';
	$pages_actions .= '<li><a href="' . $url . 'pages/edit/' . $page->guid . '"><i class="fa fa-edit"></i></a></li>';
	$pages_actions .= '<li><a href="' . $url . 'pages/history/' . $page->guid . '"><i class="fa fa-clock-o"></i></a></li>';

	$actions = elgg_view('page/components/iris_object_actions', array('entity' => $page, 'mode' => 'content', 'metadata' => $pages_actions));

	$subpages = elgg_view('pages/sub-pages', array('entity' => $page));
	if (!$full) {
		$subpages = '<div class="pages-subpages hidden" id="pages-subpages-' . $page->guid . '">' . $subpages . '</div>';
	}

	$title = $page->title;
	if (!$full) {
		if ($subpages) {
			$title = '<h3><a href="javascript: void(0);" onClick="javascript:$(\'#pages-subpages-' . $page->guid . '\').slideToggle(); return false;"><i class="fa fa-angle-down"></i></a> <a href="' . $page->getURL() . '">' . $title . '</a></h3>';
		} else {
			$title = '<h3><a href="' . $page->getURL() . '">' . $title . '</a></h3>';
		}
	}
	
}


if ($full) {
	
	/*
	// Export du wiki complet
	elgg_register_menu_item('title', array(
			'name' => 'htmlexport', 'text' => elgg_echo('theme_inria:pages:fullexport'), 'title' => elgg_echo('theme_inria:pages:fullexport:title'),
			'href' => elgg_add_action_tokens_to_url(elgg_get_site_url() . 'action/pages/html_export?guid=' . $page->guid),
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
	$toggle_link = elgg_view('output/url', array(
		'text' => '<i class="fa fa-caret-down"></i> ' . elgg_echo('theme_inria:pages:summarytoggle'),
		'href' => "#full-width-pages-nav-content",
		'rel' => 'toggle',
	));
	$navigation = '<div class="full-width-pages-nav">
		' . $toggle_link . '
		<div id="full-width-pages-nav-content" class="hidden">
			' . elgg_view('pages/top-summary', array('page' => $page)) . '
		</div>
	</div>';
	
	/*
	echo elgg_view('object/elements/full', array(
		'entity' => $page,
		'title' => false,
		'icon' => $page_icon,
		'summary' => $summary,
		'body' => $body,
	));
	*/
	
	
	/*
	// Liste des sous-pages
	$content .= elgg_view('pages/sub-pages', array('entity' => $page));
	
	// Edit button
	if ($page->canEdit()) {
		$content .= '<div class="clearfloat"></div><br /><br />';
		$content .= '<h3>' . elgg_echo('pages:edit') . '</h3>';
		$content .= '<p><a href="' . elgg_get_site_url() . 'pages/edit/' . $page->guid . '" class="elgg-button elgg-button-action">' . elgg_echo('edit') . '</a></p>';
	}
	*/
	
	
	// In groups
	if (elgg_instanceof($page_owner, 'group')) {
		echo $navigation . '<div class="iris-object iris-object-content">' . $menu . $title . $subtitle . $actions . '<div class="pages-content">' . $body . '</div>' . $subpages . '</div>';
		return;
	}
	
	$content .= $navigation . $body . $actions . $subpages;
	
	
} else {
	// brief view

	if (elgg_in_context('workspace')) {
		// Icon = auteur
		$owner = $page->getOwnerEntity();
		$page_icon = '<a href="' . $owner->getURL() . '" class="elgg-avatar"><img src="' . $owner->getIconURL(array('medium')) . '" style="width:54px;" /></a>';
		$metadata_alt = '';
	} else {
	}
	
	$excerpt = elgg_get_excerpt($page->description);

	/*
	$params = array(
		'entity' => $page,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	*/
	
	// In groups
	if (elgg_instanceof($page_owner, 'group')) {
		echo '<div class="iris-object iris-object-content">' . $menu . $title . $subtitle . $excerpt . $actions . $subpages . '</div>';
		return;
	}
	
	//echo elgg_view_image_block($page_icon, $list_body);
	$content = $subtitle . $excerpt . $subpages;
	
}


echo elgg_view('page/components/iris_object', array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt));

