<?php
/**
 * Full view for transitions objects
 *
 * @package Transitions
 */

$transitions = elgg_extract('entity', $vars, FALSE);
$embed = elgg_extract('embed', $vars, FALSE);
$full_content = get_input('full_content', false);

if (!$transitions) {
	return TRUE;
}

// Add hit counter
if (!isset($transitions->views_count)) {
	$transitions->views_count = 1;
} else {
	$transitions->views_count++;
}

//echo '<span class="hidden transitions-views-count">' . $transitions->views_count . '</div>';
echo '<!-- Views count : ' . $transitions->views_count . ' //-->';

elgg_load_js('lightbox');
elgg_load_css('lightbox');
elgg_require_js('jquery.form');
elgg_load_js('elgg.embed');
elgg_load_js('elgg.transitions');

$body = '';

$owner = $transitions->getOwnerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = $transitions->excerpt;
if (!$excerpt) {
	$excerpt = elgg_get_excerpt($transitions->description, 137);
}
// Limit to max chars
if (strlen($excerpt) >= 140) { $excerpt = elgg_get_excerpt($excerpt, 137); }

$owner_image = elgg_view_entity_icon($owner, 'medium', array('use_hover' => false, 'use_link' => false));
$owner_link = elgg_view('output/url', array(
	//'href' => "transitions/owner/$owner->username",
	'href' => $owner->getURL(),
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($transitions->time_created);
$owner_image .= '<p class="elgg-subtext">' . $author_text . ' ' . $date . '</p>';


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

// Contribution category
$category = '<span class="transitions-category transitions-' . $transitions->category . '">';
if (!empty($transitions->category)) {
	$category .= elgg_echo('transitions:category:' . $transitions->category);
}
if (($transitions->category == 'actor') && !empty($transitions->actor_type)) {
	$category .= '&nbsp;: ' . elgg_echo('transitions:actortype:' . $transitions->actor_type) . '';
}
$category .= '</span>';



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
$actions = '';
if (elgg_is_admin_logged_in() && elgg_is_active_plugin('pin')) {
	//$actions .= '<a href=""><i class="fa fa-thumb-tack"></i> Pin</a> ';
	$actions .= elgg_view('pin/entity_menu', $vars);
}


// Social share
$socialshare = '';
if (elgg_is_active_plugin('socialshare')) {
	//$socialshare = '<p>' . elgg_echo('transitions:socialshare:details') . '</p>';
	$socialshare .= '<div class="transitions-socialshare">' . elgg_view('socialshare/extend', array('entity' => $transitions)) . '</div>';
}

// Permalink
$permalink = '';
$permalink .= '<p>';
//$permalink .= elgg_echo('transitions:permalink:details') . '<br />';
$permalink .= '<input type="text" onClick="this.setSelectionRange(0, this.value.length);" value="' . $transitions->getURL() . '"></p>';

// Short link
$shortlink = '';
if (elgg_is_active_plugin('shorturls')) {
	$shortlink = '<p>';
//$shortlink .= elgg_echo('transitions:shortlink:details') . '<br />';
$shortlink .= '<input type="text" readonly="readonly" onClick="this.setSelectionRange(0, this.value.length);" value="' . elgg_get_site_url() . 's/' . $transitions->guid . '"></p>';
} else {
	$shortlink = $permalink;
}

// Embed code
//$embedcode = '<p>' . elgg_echo('transitions:embed:details') . '</p>';
$embedcode .= '<textarea readonly="readonly" onClick="this.setSelectionRange(0, this.value.length);">&lt;iframe src="' . elgg_get_site_url() . 'export_embed/entity?guid=' . $transitions->guid . '&viewtype=gallery&nomainlink=true" style="width:400px; height:400px;" /&gt;</textarea>';

// Combined module : permalink + share links + embed
$share_content = '';
$share_content .= '<h3>' . elgg_echo('transitions:socialshare') . '</h3>';
$share_content .= $socialshare;
//$share_content .= '<h3>' . elgg_echo('transitions:permalink') . '</h3>';
//$share_content .= $permalink;
$share_content .= '<h3>' . elgg_echo('transitions:shortlink') . '</h3>';
$share_content .= $shortlink;
$share_content .= '<h3>' . elgg_echo('transitions:embed') . '</h3>';
$share_content .= $embedcode;

//$actions .= elgg_view('output/url', array('text' => '<i class="fa fa-send"></i>&nbsp;' . elgg_echo('transitions:share'), 'rel' => 'popup', 'href' => '#transitions-popup-share-' . $transitions->guid));
$actions .= elgg_view('output/url', array('text' => '<i class="fa fa-send"></i>', 'rel' => 'popup', 'href' => '#transitions-popup-share-' . $transitions->guid, 'title' => elgg_echo('transitions:share')));
$actions .= elgg_view_module('popup', elgg_echo('transitions:share'), $share_content, array('id' => 'transitions-popup-share-' . $transitions->guid, 'class' => 'transitions-popup-share hidden clearfix'));





// Main content column
$body .= $transitions_icon;
//$body .= '<div class="transitions_image transitions-image-master flexible-block" style="background: url(' . $transitions_icon_url . ') 50% 20%; background-size:cover; width: 558px; height: 300px; max-width: 60%;"></div>';
$body .= '<div class="clearfloat"></div>';
// Short excerpt (140 chars)
if (!empty($transitions->excerpt)) $body .= '<p class="transitions-excerpt">' . $transitions->excerpt . '</p>';
// Full description
$body .= elgg_view('output/longtext', array('value' => $transitions->description, 'class' => 'transitions-post'));

$body .= '<div class="clearfloat"></div><br />';


// Sidebar : all meta information
$sidebar = '';

// Owner block
$sidebar .= '<span class="transitions-owner-block">' . $owner_image . '</span>';

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

// Territory : actor|project|event only
if (in_array($transitions->category, array('actor', 'project', 'event')) && !empty($transitions->territory)) {
	$sidebar .= '<i class="fa fa-map-marker"></i> ' . elgg_echo('transitions:territory') . '&nbsp;: ' . $transitions->territory;
	if ($transitions->getLatitude()) {
		$sidebar .= elgg_view('transitions/location_map', array('entity' => $transitions, 'width' => '100%', 'height' => '200px;'));
	}
	$sidebar .= '<div class="clearfloat"></div><br />';
}

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
		$body .= '<div class="transitions-view-collection">' . elgg_view_entity($collection, array('embed' => true, 'full_content' => $full_content)) . '</div>';
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
if ($embed) {
	echo '<div class="transitions-view-wrapper">';
	echo '<h2 class="elgg-heading-main"><a href="' . $transitions->getURL() . '" target="_blank">' . $transitions->title . '</a></h2>';
	echo $category;
	echo '<div class="clearfloat"></div>';
	echo $body;
	echo '</div>';
	return;
}



// TABS BLOCK - Enrichment forms
// Sharing + contribution links
$params = array(
	'tabs' => array(),
	'id' => "transitions-action-tabs",
);
$tab_content = '';

// Contributed support links
$params['tabs'][] = array('title' => elgg_echo('transitions:addlink'), 'url' => "#transitions-{$transitions->guid}-addlink", 'selected' => true);
if (elgg_is_logged_in()) {
	$tab_content .= elgg_view_form('transitions/addlink', array('id' => "transitions-{$transitions->guid}-addlink", 'class' => "transitions-tab-content"), array('guid' => $transitions->guid));
//$tab_content .= '<div class="clearfloat"></div><br />';
} else {
	$tab_content .= '<div id="transitions-'. $transitions->guid . '-addlink" class="transitions-tab-content">' . elgg_echo('transitions:accountrequired') . '</div>';
}

// Contributed tags
$params['tabs'][] = array('title' => elgg_echo('transitions:addtag'), 'url' => "#transitions-{$transitions->guid}-addtag");
if (elgg_is_logged_in()) {
	$tab_content .= elgg_view_form('transitions/addtag', array('id' => "transitions-{$transitions->guid}-addtag", 'class' => "transitions-tab-content hidden"), array('guid' => $transitions->guid));
} else {
	$tab_content .= '<div id="transitions-'. $transitions->guid . '-addtag" class="transitions-tab-content hidden">' . elgg_echo('transitions:accountrequired') . '</div>';
}
//$tab_content .= '<div class="clearfloat"></div><br />';

// Add relation to related actors (anyone)
if ($transitions->category == 'project') {
	$params['tabs'][] = array('title' => elgg_echo('transitions:addactor'), 'url' => "#transitions-{$transitions->guid}-addactor");
	if (elgg_is_logged_in()) {
		$tab_content .= elgg_view_form('transitions/addactor', array('id' => "transitions-{$transitions->guid}-addactor", 'class' => "transitions-tab-content hidden"), array('guid' => $transitions->guid));
		//$tab_content .= '<div class="clearfloat"></div><br />';
	} else {
		$tab_content .= '<div id="transitions-'. $transitions->guid . '-addactor" class="transitions-tab-content hidden">' . elgg_echo('transitions:accountrequired') . '</div>';
	}
}

// Add relation to answer resources (anyone)
/*
if ($transitions->category == 'challenge') {
	$tab_content .= elgg_view_form('transitions/addrelation', array(), array('guid' => $transitions->guid, 'relation' => 'challenge_element'));
	$tab_content .= '<div class="clearfloat"></div><br />';
}
*/

// Permalink and share links
$params['tabs'][] = array('title' => elgg_echo('transitions:share'), 'url' => "#transitions-{$transitions->guid}-share");
$share_links = '';
if (elgg_is_active_plugin('socialshare')) {
	$share_links .= '<p>' . elgg_echo('transitions:socialshare:details') . '</p>';
	$share_links .= '<div class="transitions-socialshare">' . elgg_view('socialshare/extend', array('entity' => $transitions)) . '</div>';
}
$tab_content .= elgg_view_module('info', false, $share_links . $shortlink, array('id' => "transitions-{$transitions->guid}-share", 'class' => "transitions-tab-content hidden"), array('guid' => $transitions->guid));

// Embed code
$params['tabs'][] = array('title' => elgg_echo('transitions:embed'), 'url' => "#transitions-{$transitions->guid}-embed");
//$tab_content .= elgg_view_module('info', elgg_echo('transitions:embed'), $embedcode, array('id' => "transitions-{$transitions->guid}-embed", 'class' => "transitions-tab-content hidden"), array('guid' => $transitions->guid));
$tab_content .= elgg_view_module('info', false, $embedcode, array('id' => "transitions-{$transitions->guid}-embed", 'class' => "transitions-tab-content hidden"), array('guid' => $transitions->guid));

// Render tabs block
$body .= elgg_view('navigation/tabs', $params);
//$body .= '<div style="border:1px solid #DCDCDC; border-top:0; padding:0.5em 1em;">';
$body .= $tab_content;
$body .= '<div class="clearfloat"></div>';
//$body .= '</div>';



/*
$params = array(
	'entity' => $transitions,
	'title' => false,
	'metadata' => $metadata,
	'subtitle' => $subtitle,
);
$params = $params + $vars;
$summary = elgg_view('object/elements/summary', $params);
echo elgg_view('object/elements/full', array(
	'summary' => $summary,
	'icon' => $owner_icon,
	'body' => $body,
));
*/


// RENDER CONTENT
echo '<div class="transitions-view-wrapper">';
if (!empty($metadata)) {
	echo $category . $metadata;
	echo '<div class="clearfloat"></div>';
}
echo $body;
echo '</div>';



