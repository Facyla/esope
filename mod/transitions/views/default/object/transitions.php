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
		$params["size"] = 'master';
		$params["align"] = 'left';
	} else {
		if (elgg_in_context("listing") || ($list_type != 'gallery')) {
			$params["size"] = 'small';
			$params["align"] = 'right';
		} else {
			$params["size"] = 'large';
			$params["align"] = 'none';
		}
	}
	// Set size to non-existing value to get default (eg "dummy")
	$transitions_icon = elgg_view_entity_icon($transitions, "large", $params);
}

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
$stats = '<i class="fa fa-heart">Likes</i> <i class="fa fa-comments">Comments</i> <i class="fa fa-user">People</i> <i class="fa fa-tags">Tags</i>';
$actions = '<i class="fa fa-thumbs-tack">Pin</i> <i class="fa fa-link">Link</i> <i class="fa fa-code">Embed</i>';

// @TODO : add following meta display :
$other_meta = '';
$other_meta .= '<p>Catégorie : ' . $transitions->category . '</p>';
if (!empty($transitions->url)) $other_meta .= '<p>Lien web : <a href="' . $transitions->url . '">' . $transitions->url . '</a></p>';
$other_meta .= '<p>Langue de la ressource : ' . $transitions->resource_lang . '</p>';
$other_meta .= '<p>Langue : ' . $transitions->lang . '</p>';
if (!empty($transitions->territory)) $other_meta .= '<p>Territoire : ' . $transitions->territory . '</p>';
if ($transitions->category == 'actor') $other_meta .= '<p>Type d\'acteur : ' . $transitions->actor_type . '</p>';
if (!empty($transitions->start_date)) $other_meta .= '<p>Date de début : ' . date('d M Y H:i:s', $transitions->start_date) . '</p>';
if (!empty($transitions->end_date)) $other_meta .= '<p>Date de début : ' . date('d M Y H:i:s', $transitions->end_date) . '</p>';
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

	$body = elgg_view('output/longtext', array(
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
			'content' => $transitions_icon . $excerpt,
		);
		$params = $params + $vars;
		$list_body = elgg_view('object/elements/summary', $params);

		echo elgg_view_image_block($owner_icon, $list_body);
	} else {
		$params = array(
			'text' => elgg_get_excerpt($transitions->title, 100),
			'href' => $transitions->getURL(),
			'is_trusted' => true,
		);
		$title_link = elgg_view('output/url', $params);
		
		echo '<div class="transitions-gallery-item">';
			if ($metadata) { echo $metadata; }
			if ($title_link) { echo "<h3>$title_link</h3>"; }
			echo '<div class="elgg-subtext">' . $subtitle . '</div>';
			echo elgg_view('object/summary/extend', $vars);
			echo elgg_view('output/tags', array('tags' => $transitions->tags));
			//echo elgg_view_image_block($owner_icon, $list_body);
		
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

