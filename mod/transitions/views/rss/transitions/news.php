<?php
/**
 * Full view for transitions objects
 *
 * @package Transitions
 */

$transitions = elgg_extract('entity', $vars, FALSE);
$embed = elgg_extract('embed', $vars, FALSE);

if (!$transitions) {
	return TRUE;
}

// Add hit counter
if (!isset($transitions->views_count)) {
	$transitions->views_count = 1;
} else {
	$transitions->views_count++;
}


$body = '';

$owner = $transitions->getOwnerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = $transitions->excerpt;
if (!$excerpt) {
	$excerpt = elgg_get_excerpt($transitions->description, 137);
}
// Limit to max chars
if (strlen($excerpt) >= 140) { $excerpt = elgg_get_excerpt($excerpt, 137); }


// The "on" status changes for comments, so best to check for !Off
if ($transitions->comments_on != 'Off') {
	$comments_count = $transitions->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array(
			'href' => $transitions->getURL() . '#comments',
			'text' => $text,
			'is_trusted' => true,
		));
	} else {
		$comments_link = '';
	}
} else {
	$comments_link = '';
}

$transitions_icon = "";
// show icon
//if(!empty($transitions->icontime)) {
	$params = $vars;
	$params["size"] = 'master';
	$params["align"] = 'none';
//}
$transitions_icon = elgg_view_entity_icon($transitions, $params["size"], $params);
$transitions_icon = trim($transitions_icon);
$transitions_icon_url = $transitions->getIconURL($params["size"]);

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'transitions',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));
$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) { $metadata = ''; }

// Contribution category : not displayed for news


// TABS BLOCK - Stats and actions blocks : likes, contributions (links + comments)
$stats = '';
if (elgg_is_active_plugin('likes')) {
	$num_of_likes = \Elgg\Likes\DataService::instance()->getNumLikes($transitions);
	$stats .= '<i class="fa fa-heart"></i> ' . $num_of_likes . ' &nbsp; ';
}
$stats .= '<i class="fa fa-comments"></i> ' . $transitions->countComments() . ' &nbsp; ';
//$stats .= '<i class="fa fa-tags"></i> ' . count($transitions->tags_contributed) . ' &nbsp; ';
//$stats .= '<i class="fa fa-thumbs-o-up"></i> ' . count($transitions->links_supports) . ' &nbsp; ';
//$stats .= '<i class="fa fa-thumbs-o-down"></i> ' . count($transitions->links_invalidates) . ' &nbsp; ';
$stats .= '<i class="fa fa-link"></i> ' . count($transitions->links) . ' &nbsp; ';



// Main content column
$body .= $transitions_icon;
//$body .= '<div class="transitions_image transitions-image-master flexible-block" style="background: url(' . $transitions_icon_url . ') 50% 20%; background-size:cover; width: 558px; height: 300px; max-width: 60%;"></div>';

// Short excerpt (140 chars)
if (!empty($transitions->excerpt)) $body .= '<p class="transitions-excerpt">' . $transitions->excerpt . '</p>';
// Full description
//$body .= elgg_view('output/longtext', array('value' => $transitions->description, 'class' => 'transitions-post'));
$description = parse_urls($transitions->description);
$body .= '<div class="transitions-post">' . $description . '</div>';
$body .= '<div class="clearfloat"></div><br />';


// Sidebar : all meta information
$sidebar = '';

// Exact dates : events only
if (($transitions->category == 'event') && (!empty($transitions->start_date) || !empty($transitions->end_date))) {
	$date_format = elgg_echo('transitions:dateformat:time');
	// Format : from DD MM YYYY [until DD MM YYYY]
	$sidebar .= '<p class="transitions-dates"><i class="fa fa-calendar-o"></i> ';
	if (!empty($transitions->start_date) && !empty($transitions->end_date)) {
		$sidebar .= elgg_echo('transitions:date:since') . ' ' . date($date_format, $transitions->start_date);
		$sidebar .= '<br />' . elgg_echo('transitions:date:until') . ' ' . date($date_format, $transitions->end_date);
	} else if (!empty($transitions->start_date)) {
		$sidebar .= elgg_echo('transitions:date:since') . ' ' . date($date_format, $transitions->start_date);
	} else if (!empty($transitions->end_date)) {
		$sidebar .= elgg_echo('transitions:date:until') . ' ' . date($date_format, $transitions->end_date);
	}
	$sidebar .= '</p>';
	$sidebar .= '<div class="clearfloat"></div><br />';
}
// Text dates for projects
if (($transitions->category == 'project') && (!empty($transitions->start) || !empty($transitions->end))) {
	$sidebar .= '<p class="transitions-dates"><i class="fa fa-calendar-o"></i> ';
	if ($transitions->category == 'project') {
		$date_format = elgg_echo('transitions:dateformat');
		if (!empty($transitions->start) && !empty($transitions->end)) {
			$sidebar .= $transitions->start . ' - ' . $transitions->end;
		} else if (!empty($transitions->start)) {
			$sidebar .= $transitions->start;
		} else if (!empty($transitions->end)) {
			$sidebar .= $transitions->end;
		}
	}
	$sidebar .= '</p>';
	$sidebar .= '<div class="clearfloat"></div><br />';
}

// Territory : actor|project|event only
if (in_array($transitions->category, array('actor', 'project', 'event')) && !empty($transitions->territory)) {
	$sidebar .= '<i class="fa fa-map-marker"></i> ' . elgg_echo('transitions:territory') . '&nbsp;: ' . $transitions->territory;
	if ($transitions->getLatitude()) {
		$sidebar .= elgg_view('transitions/location_map', array('entity' => $transitions, 'width' => '100%', 'height' => '200px;'));
	}
	$sidebar .= '<div class="clearfloat"></div><br />';
}

// Ressources : langues puis ressources
$resource_lang = '';
if (!empty($transitions->resource_lang)) {
	$resource_lang = ' (<i class="fa fa-flag-o"></i>&nbsp;' . elgg_echo($transitions->resource_lang) . ')';
}
// URL et PJ
if (!empty($transitions->url)) {
	$sidebar .= '<p><i class="fa fa-external-link"></i> ' . elgg_echo('transitions:url') . '&nbsp;: <a href="' . $transitions->url . '" target="_blank" title="' . $transitions->url . '">' . elgg_get_excerpt($transitions->url, 30) . '</a>' . $resource_lang . '</p>';
}
if (!empty($transitions->attachment)) {
	$sidebar .= '<p><i class="fa fa-download"></i> ' . elgg_echo('transitions:attachment') . '&nbsp;: <a href="' . $transitions->getAttachmentURL() . '" target="_blank">' . $transitions->getAttachmentName() . '</a>' . $resource_lang . '</p>';
}

// Main tags
$sidebar .= elgg_view('output/tags', array('tags' => $transitions->tags, 'base_url' => "catalogue"));


$sidebar .= '<br /><div class="clearfloat"></div>';

// Contributed tags (anyone)
if ($transitions->tags_contributed) {
	$tags_contributed = '';
	$tags_contributed = elgg_view('output/tags', array('tags' => $transitions->tags_contributed, 'base_url' => "catalogue"));
	/*
	foreach((array)$transitions->tags_contributed as $tag) {
		$tags_contributed .= '<i class="fa fa-external-link"></i> ' . elgg_view('output/url', array('href' => elgg_get_site_url() . 'transitions/?q=' . $tag, 'target' => "_blank", 'text' => $tag)) . ' &nbsp; ';
	}
	*/
	$sidebar .= elgg_view_module('aside', elgg_echo('transitions:tags_contributed'), $tags_contributed);
}

// Contributed links
if ($transitions->links) {
	$links = (array)$transitions->links;
	$links_comment = (array)$transitions->links_comment;
	$contributed_links = '<ul class="transitions-contributed-links">';
	foreach($links as $i => $link) {
		$displayed_link = elgg_get_excerpt($link, 40) . '&nbsp; <i class="fa fa-external-link"></i>';
		$contributed_links .= '<li>' . elgg_view('output/url', array('href' => $link, 'target' => "_blank", 'text' => $displayed_link, 'title' => $link)) . '';
		$contributed_links .= '<br /><em>' . $links_comment[$i] . '</em>';
		$contributed_links .= '</li>';
	}
	$links .= '</ul>';
	$sidebar .= elgg_view_module('aside', elgg_echo('transitions:links'), $contributed_links);
}


// 2 columns layout
/*
$body = '<div class="flexible-block float" style="width:60%;">
		<div class="transitions-view-main">' . $body . '</div>
	</div>
	<div class="flexible-block" style="width:40%; float:right;">
		<div class="transitions-view-sidebar">' . $sidebar . '</div>
	</div>
	<div class="clearfloat"></div>';
*/
$body = '<div class="transitions-view-main">
		<div class="flexible-block" style="width:40%; float:right; background: white;">
			<div class="transitions-view-sidebar">' . $sidebar . '</div>
		</div>' . $body . '
	</div>
	<div class="clearfloat"></div>';

// Challenge => afficher la collection associée
if ($transitions->category == 'challenge') {
	$collection = get_entity($transitions->collection);
	if (elgg_instanceof($collection, 'object', 'collection')) {
		$body .= '<div class="transitions-view-collection">' . elgg_view_entity($collection, array('embed' => true)) . '</div>';
	}
}

// Related actors => full-width
if ($transitions->category == 'project') {
	$related_actors = elgg_list_entities_from_relationship(array(
			'relationship' => 'partner_of',
			'relationship_guid' => $transitions->guid,
			'inverse_relationship' => true,
			'type' => 'object',
			'limit' => 0,
			'list_type' => 'gallery',
			'gallery_class' => '',
		));
	if (!empty($related_actors)) {
		$body .= '<div class="transitions-view-content">' . elgg_view_module('featured', elgg_echo('transitions:related_actors'), $related_actors) . '</div>';
	}
}
if ($transitions->category == 'challenge') {
	$related_content = elgg_list_entities_from_relationship(array(
			'relationship' => 'related_content',
			'relationship_guid' => $transitions->guid,
			'inverse_relationship' => true,
			'type' => 'object',
			'limit' => 0,
			'list_type' => 'gallery',
			'gallery_class' => '',
		));
	if (!empty($related_content)) {
		$body .= elgg_view_module('aside', elgg_echo('transitions:related_content'), $related_content);
	}
}


// RENDER EMBED CONTENT : no sharing/contribution tools + no metadata menu
$title = $vars['entity']->title;
if (empty($title)) {
	$title = strip_tags($vars['entity']->description);
	$title = elgg_get_excerpt($title, 32);
}
$title = htmlspecialchars_decode($title);

$permalink = htmlspecialchars($vars['entity']->getURL(), ENT_NOQUOTES, 'UTF-8');
$pubdate = date('r', $vars['entity']->getTimeCreated());

$rss_description = $category . '<div class="clearfloat"></div>' . $body;

$creator = elgg_view('page/components/creator', $vars);
$georss = elgg_view('page/components/georss', $vars);
$extension = elgg_view('extensions/item', $vars);

$item = <<<__HTML
<item>
	<guid isPermaLink="true">$permalink</guid>
	<pubDate>$pubdate</pubDate>
	<link>$permalink</link>
	<title><![CDATA[$title]]></title>
	<description><![CDATA[$rss_description]]></description>
	$creator$georss$extension
</item>

__HTML;

echo $item;

