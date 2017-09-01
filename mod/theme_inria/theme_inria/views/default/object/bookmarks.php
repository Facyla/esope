<?php
/**
 * Elgg bookmark view
 *
 * @package ElggBookmarks
 */
// Inria : add container + open in new window

$full = elgg_extract('full_view', $vars, FALSE);
$bookmark = elgg_extract('entity', $vars, FALSE);

if (!$bookmark) { return; }

$page_owner = elgg_get_page_owner_entity();

$owner = $bookmark->getOwnerEntity();
$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$container = $bookmark->getContainerEntity();
$categories = elgg_view('output/categories', $vars);

//$bookmark_icon = elgg_view_icon('push-pin-alt');
$bookmark_icon = elgg_view_icon('link');

$address = $bookmark->address;
$address_text = htmlentities(urldecode($address));
$link = '<p class="bookmarks-address">' . elgg_view('output/url', array(
		'href' => $address, 
		'text' => $bookmark_icon . '&nbsp;' . $address_text, 
		'title' => elgg_echo('theme_inria:openinnewtab:bookmark', array($address_text)),
		'target' => '_blank', 
)) . '</p>';
$short_link = $address;
if (strlen($address) > 25) {
	$bits = parse_url($address);
	if (isset($bits['host'])) {
		$short_link = $bits['host'];
	} else {
		$short_link = elgg_get_excerpt($address_text, 100);
	}
}
$short_link = elgg_view('output/url', array(
	'href' => $address,
	'text' => $bookmark_icon . '&nbsp;' . $short_link,
	'title' => elgg_echo('theme_inria:openinnewtab:bookmark', array($address_text)),
	'target' => '_blank',
));

$description = elgg_view('output/longtext', array('value' => $bookmark->description, 'class' => 'pbl'));
$excerpt = elgg_get_excerpt($bookmark->description, 140);

$owner_link = elgg_view('output/url', array(
	'href' => "bookmarks/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));

$date = elgg_view_friendly_time($bookmark->time_created);

/*
$comments_count = $bookmark->countComments();
//only display if there are commments
$comments_link = '';
if ($comments_count != 0) {
	$text = elgg_echo("comments") . " ($comments_count)";
	$comments_link = elgg_view('output/url', array(
		'href' => $bookmark->getURL() . '#comments',
		'text' => $text,
		'is_trusted' => true,
	));
}
*/

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'bookmarks',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

//$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) { $metadata = ''; }


if ($full && !elgg_in_context('gallery')) {
	/*
	$params = array(
		'entity' => $bookmark,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);
	*/

	//$link = elgg_view('output/longtext', array('value' => $link));
	$body = <<<HTML
<div class="bookmark elgg-content mts">
	$link
	$description
</div>
HTML;

	/*
	echo elgg_view('object/elements/full', array(
		'entity' => $bookmark,
		'icon' => $owner_icon,
		'summary' => $summary,
		'body' => $body,
	));
	*/
	$content = $categories . $body;

} elseif (elgg_in_context('gallery')) {

	echo <<<HTML
<div class="bookmarks-gallery-item">
	<h3>$bookmark->title</h3>
	<p class='subtitle'>$owner_link $date</p>
</div>
HTML;

} else {
	// brief view
	
	if (elgg_in_context('workspace')) {
		// Icon = auteur
		//$owner_icon = '<a href="' . $owner->getURL() . '" class="elgg-avatar"><img src="' . $owner->getIconURL(array('medium')) . '" style="width:54px;" /></a>';
		$metadata_alt = '';
	} else {
	}
	
	// Make it really brief in listings, so that it fits with other tools
	if (elgg_in_context('widgets')) {
		// Remove any extension
		elgg_unextend_view('object/summary/extend', 'containers/views/output/containers');
		$subtitle = '';
		$metadata = '';
		$link = elgg_view('output/url', array('href' => $address, 'text' => $bookmark_icon, 'target' => '_blank', 'title' => elgg_echo('theme_inria:openinnewtab:bookmark', array($address))));
		
	} else {
		if ($excerpt) { $excerpt = '<br />' . $excerpt; }
	}
	
	/*
	$params = array(
		'entity' => $bookmark,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $content,
	);
	$params = $params + $vars;
	$body = elgg_view('object/elements/summary', $params);
	*/
	
	//echo elgg_view_image_block($owner_icon, $body);
	$content = $short_link . $excerpt;
}


echo elgg_view('page/components/iris_object', $vars + array('entity' => $vars['entity'], 'body' => $content, 'metadata_alt' => $metadata_alt));

