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
// Use custom views for full view
if ($full) {
		// Full view
	if (elgg_in_context('transitions-news')) {
		echo elgg_view('transitions/news', $vars);
	} else {
		if (elgg_in_context('export_embed')) { $vars['embed'] = true; }
		echo elgg_view('transitions/view', $vars);
	}
	return;
}



elgg_load_js('lightbox');
elgg_load_css('lightbox');
elgg_require_js('jquery.form');
elgg_load_js('elgg.embed');
elgg_load_js('elgg.transitions');

if (elgg_is_active_plugin('theme_transitions2')) {
	$is_admin = theme_transitions2_user_is_content_admin();
} else {
	$is_admin = elgg_is_admin_logged_in();
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
//if(!empty($transitions->icontime)) {
	$params = $vars;
	$params["align"] = 'none';
	$params["size"] = 'gallery';
	if (elgg_in_context("listing") || ($list_type != 'gallery')) {
		$params["size"] = 'listing';
		$params["align"] = 'right';
	}
//}
$transitions_icon = elgg_view_entity_icon($transitions, $params["size"], $params);
$transitions_icon = trim($transitions_icon);
$transitions_icon_url = $transitions->getIconURL($params["size"]);

$metadata = elgg_view_menu('entity', array(
	'entity' => $vars['entity'],
	'handler' => 'catalogue',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

$subtitle = "$author_text $date $comments_link $categories";

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets')) {
	$metadata = '';
}


// Stats and actions blocks : likes, contributions (links + comments)
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
if ($is_admin && elgg_is_active_plugin('pin')) {
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
$embedcode .= '<textarea readonly="readonly" onClick="this.setSelectionRange(0, this.value.length);">&lt;iframe src="' . elgg_get_site_url() . 'export_embed/entity?guid=' . $transitions->guid . '&viewtype=gallery&nomainlink=true" style="width:310px; height:224px;" /&gt;</textarea>';

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




// brief view

if (elgg_in_context("listing") || ($list_type != 'gallery')) {
	// Listing view
	$category = '';
	if (!empty($transitions->category)) {
		$category = '<span class="transitions-category transitions-' . $transitions->category . '">' . elgg_echo('transitions:category:' . $transitions->category) . '</span> ';
	}
	$params = array(
		'entity' => $transitions,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $category . $excerpt,
	);
	$params = $params + $vars;
	$list_body = elgg_view('object/elements/summary', $params);
	
	if (!empty($transitions_icon)) {
		//echo elgg_view_image_block($owner_icon, $list_body, array('image_alt' => $transitions_icon));
		echo elgg_view_image_block($transitions_icon, $list_body);
	} else {
		//echo elgg_view_image_block($owner_icon, $list_body);
		echo elgg_view_image_block('', $list_body);
	}
	//echo elgg_view_image_block($transitions_icon, $owner_icon . $list_body);
	
} else {
	// Gallery view
	// do not show the metadata and controls in gallery view
	$metadata = '';
	$params = array(
		'text' => elgg_get_excerpt($transitions->title, 70),
		'href' => $transitions->getURL(),
		'is_trusted' => true,
	);
	$title_link = elgg_view('output/url', $params);
	
	$category_class = 'transitions-category-' . $transitions->category;
	// Add specific class for iframe export embed
	if (elgg_in_context('export_embed')) { $category_class .= " iframe"; }

	// If multilingual duplicate, display only link to main version ?
	if (!multilingual_is_best_version($transitions)) {
		$best_version = multilingual_select_best_version($transitions);
		$category_class .= " multilingual-alternate";
	}
	
	echo '<div class="transitions-gallery-item ' . $category_class . '">';
		echo '<div class="transitions-gallery-box" style="background-image:url(' . $transitions_icon_url . ');">';
			
			//echo $transitions_icon;
			echo '<div class="transitions-gallery-hover">';
				
				// Entête
				echo '<div class="transitions-gallery-head">';
					if (!empty($transitions->category)) echo '<span class="transitions-category transitions-' . $transitions->category . '">' . elgg_echo('transitions:category:' . $transitions->category) . '</span>';
					//if ($metadata) { echo $metadata; }
					if ($title_link) { echo "<h3>$title_link</h3>"; }
					//echo '<div class="elgg-subtext">' . $subtitle . '</div>';
					//echo elgg_view('object/summary/extend', $vars);
					//echo elgg_view('output/tags', array('tags' => $transitions->tags));
					//echo elgg_view_image_block($owner_icon, $list_body);

					// Contenu "texte"
					echo '<div class="elgg-content">' . $excerpt . '</div>';
				
					// Stats et actions possibles : commenter, liker, ajouter une métadonnée/relation
					echo '<div class="transitions-gallery-actions">';
						echo '<div class="transitions-gallery-inner">';
							echo '<span class="float-alt">' . $actions . '</span>';
							echo $stats;
						echo '</div>';
					echo '</div>';
					// Admins only (all T² admins)
					if ($is_admin) {
						echo '<div class="transitions-gallery-admin">';
							echo '<div class="transitions-gallery-inner">';
								switch($transitions->featured) {
									case 'featured': echo '<i class="fa fa-star" title="' . elgg_echo('transitions:featured:featured') . '"></i>&nbsp; '; break;
									case 'background': echo '<i class="fa fa-star-o" title="' . elgg_echo('transitions:featured:background') . '"></i>&nbsp; '; break;
									default: echo '<i class="fa fa-star-half-o" title="' . elgg_echo('transitions:featured:default') . '"></i>&nbsp; ';
								}
								switch($transitions->status) {
									case 'published': echo '<i class="fa fa-eye" title="' . elgg_echo('status:published') . '"></i>&nbsp; '; break;
									case 'draft':
									default: echo '<i class="fa fa-eye-slash" title="' . elgg_echo('status:draft') . '"></i>&nbsp; ';
								}
							echo '<a href="' . elgg_get_site_url() . 'transitions/edit/' . $transitions->guid . '"><i class="fa fa-pencil" title="' . elgg_echo('edit') . '"></i></a>&nbsp; ';
							echo '</div>';
						echo '</div>';
					}
				echo '</div>';
				
			echo '</div>';
			
			echo '<div class="clearfloat"></div>';
		echo '</div>';
	echo '</div>';
}


