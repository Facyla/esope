<?php
/**
 * View for blog objects
 *
 * @package Blog
 */

$full = elgg_extract('full_view', $vars, FALSE);
$blog = elgg_extract('entity', $vars, FALSE);

if (!$blog) { return TRUE; }

$page_owner = elgg_get_page_owner_entity();

$owner = $blog->getOwnerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = $blog->excerpt;
if (!$excerpt) {
	$excerpt = elgg_get_excerpt($blog->description);
}

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => "blog/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($blog->time_created);

// The "on" status changes for comments, so best to check for !Off
if ($blog->comments_on != 'Off') {
	$comments_count = $blog->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $blog->getURL() . '#comments',
			'text' => $text,
			'is_trusted' => true,
		));
	} else {
		$comments_link = '';
	}
} else {
	$comments_link = '';
}

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'blog',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}

$status = '';
if ($blog->status == 'draft') {
	$status .= '<p>
		<blockquote>' . elgg_echo('theme_inria:blog:draft') . '<br />
		<a href="' . elgg_get_site_url() . 'blog/edit/' . $blog->guid . '" class="elgg-button elgg-button-action">' . elgg_echo('edit') . '</a>
		</blockquote></p>';
}


if ($full) {
	
	if (!empty($blog->description)) {
		$body = elgg_view('output/longtext', array(
			'value' => $blog->description,
			'class' => 'blog-post',
		));
	}
	
	/*
	$params = array(
		'entity' => $blog,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);
	
	echo elgg_view('object/elements/full', array(
		'entity' => $blog,
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $body,
	));
	*/
	$content = $status . $categories . $body;
	
	// Add comments, without the add form
	if ($blog->comments_on == 'Off') {
		$content .= elgg_view_comments($blog, false, []);
		$content .= '<p><em>' . elgg_echo('theme_inria:comments:off') . '</em></p>';
	}

} else {
	// brief view
	
	if (elgg_in_context('workspace')) {
		// Icon = auteur
		$owner_icon = '<a href="' . $owner->getURL() . '" class="elgg-avatar"><img src="' . $owner->getIconURL(array('medium')) . '" style="width:54px;" /></a>';
		$metadata_alt = '';
	} else {
	}

	/*
	$params = array(
		'entity' => $blog,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	echo elgg_view_image_block($owner_icon, $list_body);
	*/
	
	$content = $excerpt;
}


echo elgg_view('page/components/iris_object', $vars + array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt, 'full_view' => $vars['full_view']));

