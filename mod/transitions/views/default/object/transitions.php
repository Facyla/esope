

<?php
/**
 * View for transitions objects
 *
 * @package Transitions
 */

$full = elgg_extract('full_view', $vars, FALSE);
$list_type = elgg_extract('list_type', $vars, FALSE);
$transitions = elgg_extract('entity', $vars, FALSE);

if (!$transitions) {
	return TRUE;
}

$owner = $transitions->getOwnerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = $transitions->excerpt;
if (!$excerpt) {
	$excerpt = elgg_get_excerpt($transitions->description);
}

$owner_icon = elgg_view_entity_icon($owner, 'tiny');
$owner_link = elgg_view('output/url', array(
	'href' => "transitions/owner/$owner->username",
	'text' => $owner->name,
	'is_trusted' => true,
));
$author_text = elgg_echo('byline', array($owner_link));
$date = elgg_view_friendly_time($transitions->time_created);

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
if(!empty($transitions->icontime)) {
	$params = $vars;
	if ($full) {
		$params["size"] = 'large';
		$params["align"] = 'left';
	} else {
		if (elgg_in_context("listing") || ($list_type != 'gallery')) {
			$params["size"] = 'listing';
			$params["align"] = 'right';
		} else {
			$params["size"] = 'gallery';
			$params["align"] = 'none';
		}
	}
}
// Set size to non-existing value to get default (eg "dummy")
$transitions_icon = elgg_view_entity_icon($transitions, $params["size"], $params);

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'transitions',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}


// @TODO add stats and actions blocks
$stats = '';
$stats .= '<i class="fa fa-heart">Likes</i> ';
$stats .= '<i class="fa fa-comments">Comments</i> ';
$stats .= '<i class="fa fa-user">People</i> ';
$stats .= '<i class="fa fa-tags">Tags</i>';
$actions = '';
$actions .= '<i class="fa fa-thumb-tack">Pin</i> ';
$actions .= '<a href="' . $transitions->getURL() . '"<i class="fa fa-link"></i></a> ';
$actions .= '<i class="fa fa-code">Embed</i>';

// @TODO : add following meta display :
$other_meta = '';
$other_meta .= '<p>Catégorie : ' . $transitions->category . '</p>';
if (!empty($transitions->attachment)) $other_meta .= '<p>Lien web : <a href="' . $transitions->getAttachmentURL() . '">' . $transitions->getAttachmentName() . '</a></p>';
if (!empty($transitions->url)) $other_meta .= '<p>Lien web : <a href="' . $transitions->url . '">' . $transitions->url . '</a></p>';
$other_meta .= '<p>Langue : ' . $transitions->lang . '</p>';
$other_meta .= '<p>Langue de la ressource : ' . $transitions->resource_lang . '</p>';
if (!empty($transitions->territory)) $other_meta .= '<p>Territoire : ' . $transitions->territory . '</p>';
if ($transitions->category == 'actor') $other_meta .= '<p>Type d\'acteur : ' . $transitions->actor_type . '</p>';
if (!empty($transitions->start_date)) $other_meta .= '<p>Depuis le ' . date('d M Y H:i:s', $transitions->start_date) . '</p>';
if (!empty($transitions->end_date)) $other_meta .= '<p>Jusqu\'au ' . date('d M Y H:i:s', $transitions->end_date) . '</p>';
$other_meta .= '<p>Carte : ' . $transitions->location . '</p>';
/*
'url' => '',
'category' => '',
'resource_lang' => '',
'lang' => '',
// ssi category "actor" : territory + geolocation, actor_type
'territory' => '', // +geolocation
'actor_type' => '',
// ssi category "project" : territory + geolocation, start_date + relation to actors
'start_date' => '',
// ssi category "event" : start_date, end_date, territory + geolocation
'end_date' => '',
*/


if ($full) {

	$body = '';
	if (!empty($transitions->excerpt)) $body .= '<p><strong><em>' . $transitions->excerpt . '</em></strong></p>';
	
	$body .= '<p>';
	if (!empty($transitions->category)) $body .= '<span class="transitions-' . $transitions->category . '">' . elgg_echo('transitions:category:' . $transitions->category);
	if (($transitions->category == 'actor') && !empty($transitions->actor_type)) $body .= '&nbsp;: ' . elgg_echo('transitions:actortype:' . $transitions->actor_type) . '';
	$body .= '</span></p>';
	if (!empty($transitions->url)) $body .= '<p><i class="fa fa-bookmark"></i> <a href="' . $transitions->url . '" target="_blank">' . $transitions->url . '</a>';
	if (!empty($transitions->attachment)) $body .= '<p><i class="fa fa-file"></i> <a href="' . $transitions->getAttachmentURL() . '" target="_blank">' . $transitions->getAttachmentName() . '</a></p>';
	if (!empty($transitions->territory)) $body .= '<p><i class="fa fa-map-marker"></i> Territoire : ' . $transitions->territory . '</p>';
	if (!empty($transitions->territory)) $body .= '<p><i class="fa fa-street-view"></i> Carte : ' . $transitions->getLatitude() . ' ' . $transitions->getLongitude() . '</p>' . elgg_view('leaflet/map', array('entity' => $transitions));
	if (!empty($transitions->start_date)) $body .= '<p><i class="fa fa-calendar-o"></i> Depuis le ' . date('d M Y H:i:s', $transitions->start_date) . '</p>';
	if (!empty($transitions->end_date)) $body .= '<p>Jusqu\'au ' . date('d M Y H:i:s', $transitions->end_date) . '</p>';
	if (!empty($transitions->lang)) $body .= '<p><i class="fa fa-flag"></i> Langue : ' . elgg_echo($transitions->lang) . '</p>';
	if (!empty($transitions->resource_lang)) $body .= '<p><i class="fa fa-flag-o"></i> Langue de la ressource : ' . elgg_echo($transitions->resource_lang) . '</p>';
	
	
	$body .= elgg_view('output/longtext', array(
		'value' => $transitions->description,
		'class' => 'transitions-post',
	));

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
		'body' => $transitions_icon . $body,
	));

} else {
	// brief view
	
	if (elgg_in_context("listing") || ($list_type != 'gallery')) {
		$params = array(
			'entity' => $transitions,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'content' => $excerpt,
		);
		$params = $params + $vars;
		$list_body = elgg_view('object/elements/summary', $params);
		
		echo elgg_view_image_block($owner_icon, $list_body, array('image_alt' => $transitions_icon));
		
	} else {
		// do not show the metadata and controls in gallery view
		$metadata = '';
		$params = array(
			'text' => elgg_get_excerpt($transitions->title, 100),
			'href' => $transitions->getURL(),
			'is_trusted' => true,
		);
		$title_link = elgg_view('output/url', $params);
		
		echo '<div class="transitions-gallery-item">';
			echo '<div class="transitions-gallery-head">';
				if ($metadata) { echo $metadata; }
				echo '<span class="transitions-category transitions-' . $transitions->category . '">' . elgg_echo('transitions:category:' . $transitions->category) . '</span>';
				if ($title_link) { echo "<h3>$title_link</h3>"; }
				echo '<div class="elgg-subtext">' . $subtitle . '</div>';
				echo elgg_view('object/summary/extend', $vars);
				echo elgg_view('output/tags', array('tags' => $transitions->tags));
				//echo elgg_view_image_block($owner_icon, $list_body);
			echo '</div>';
		
			echo '<div class="transitions-gallery-box">';
				echo $transitions_icon;
				echo '<div class="transitions-gallery-hover">';
					// @TODO : nb likes, commentaires, objets liés, personnes et projets liés...
					echo '<div class="elgg-content">' . $stats . '</div>';
					echo '<div class="elgg-content">' . $excerpt . '</div>';
					echo '<div class="elgg-content">' . $other_meta . '</div>';
				echo '</div>';
				echo '<div class="clearfloat"></div>';
			echo '</div>';
			// @TODO actions possibles : commenter, liker, ajouter une métadonnée/relation
			echo '<div class="transitions-gallery-actions">';
				echo $actions;
			echo '</div>';
		echo '</div>';
	}
}

