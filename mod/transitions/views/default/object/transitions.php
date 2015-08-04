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

elgg_load_js('lightbox');
elgg_load_css('lightbox');
elgg_require_js('jquery.form');
elgg_load_js('elgg.embed');
elgg_load_js('elgg.transitions.edit');

$body = '';

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
//if(!empty($transitions->icontime)) {
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
//}
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
if (elgg_is_active_plugin('likes')) {
	$num_of_likes = \Elgg\Likes\DataService::instance()->getNumLikes($transitions);
	$stats .= '<i class="fa fa-heart"></i> ' . $num_of_likes . ' &nbsp; ';
}
$stats .= '<i class="fa fa-comments"></i> ' . $transitions->countComments() . ' &nbsp; ';
$stats .= '<i class="fa fa-tags"></i> ' . count($transitions->tags_contributed) . ' &nbsp; ';
$stats .= '<i class="fa fa-thumbs-o-up"></i> ' . count($transitions->links_supports) . ' &nbsp; ';
$stats .= '<i class="fa fa-thumbs-o-down"></i> ' . count($transitions->links_invalidates) . ' &nbsp; ';
$actions = '';
if (elgg_is_admin_logged_in()) {
	$actions .= '<a href=""><i class="fa fa-thumb-tack"></i> Pin</a> ';
}


//if ($transitions->status != 'draft') {
	// Permalink
	$actions .= elgg_view('output/url', array('text' => '<i class="fa fa-link"></i>&nbsp;' . elgg_echo('transitions:permalink'), 'rel' => 'popup', 'href' => '#transitions-popup-link-' . $transitions->guid));
	if (elgg_is_active_plugin('shorturls')) {
		$permalink = '<p>' . elgg_echo('transitions:permalink:details') . '</p><textarea readonly="readonly" onClick="this.setSelectionRange(0, this.value.length);">' . elgg_get_site_url() . 's/' . $transitions->guid . '</textarea>';
	} else {
		$permalink = '<p>' . elgg_echo('transitions:permalink:details') . '</p><textarea readonly="readonly" onClick="this.setSelectionRange(0, this.value.length);">' . $transitions->getURL() . '</textarea>';
	}
	$actions .= elgg_view_module('popup', elgg_echo('transitions:permalink'), $permalink, array('id' => 'transitions-popup-link-' . $transitions->guid, 'class' => 'transitions-popup-link hidden clearfix'));
	
	// Embed code
	//$actions .= '<a href="' . elgg_get_site_url() . 'export_embed/entity?guid=' . $transitions->guid . '&viewtype=gallery&nomainlink=true"><i class="fa fa-code">Embed</i></a>'; // @TODO open popup with embed code
	$actions .= elgg_view('output/url', array('text' => '<i class="fa fa-code"></i>&nbsp;' . elgg_echo('transitions:embed'), 'rel' => 'popup', 'href' => '#transitions-popup-embed-' . $transitions->guid));
	$embed_code = '<p>' . elgg_echo('transitions:embed:details') . '</p><textarea readonly="readonly" onClick="this.setSelectionRange(0, this.value.length);">&lt;iframe src="' . elgg_get_site_url() . 'export_embed/entity?guid=' . $transitions->guid . '&viewtype=gallery&nomainlink=true" style="width:320px; height:400px;" /&gt;</textarea>';
	$actions .= elgg_view_module('popup', elgg_echo('transitions:embed'), $embed_code, array('id' => 'transitions-popup-embed-' . $transitions->guid, 'class' => 'transitions-popup-embed hidden clearfix'));
//}



if ($full) {
	$body .= '<span class="transitions-' . $transitions->category . '" style="float:left; margin-right:1em;">';
	if (!empty($transitions->category)) $body .= elgg_echo('transitions:category:' . $transitions->category);
	if (($transitions->category == 'actor') && !empty($transitions->actor_type)) $body .= '&nbsp;: ' . elgg_echo('transitions:actortype:' . $transitions->actor_type) . '';
	$body .= '</span>';
	
	if (!empty($transitions->excerpt)) $body .= '<p><strong><em>' . $transitions->excerpt . '</em></strong></p>';
	
	$body .= $transitions_icon;
	
	$body .= elgg_view('output/longtext', array('value' => $transitions->description, 'class' => 'transitions-post'));
	
	$body .= '<div class="clearfloat"></div><br />';
	
	
	// Territory : actor|project|event only
	if (in_array($transitions->category, array('actor', 'project', 'event')) && !empty($transitions->territory)) {
		$body .= '<span style="float:right">' . elgg_view('transitions/location_map', array('entity' => $transitions, 'width' => '300px', 'height' => '150px;')) . '</span>';
		$body .= '<p><i class="fa fa-map-marker"></i> ' . elgg_echo('transitions:territory') . '&nbsp;: ' . $transitions->territory . '</p>';
	}
	
	// Dates : projects and events only
	if (in_array($transitions->category, array('project', 'event'))) {
		if (!empty($transitions->start_date) || !empty($transitions->end_date)) {
			$body .= '<p><i class="fa fa-calendar-o"></i> ';
		}
		if ($transitions->category == 'project') {
			// Format : MM YYYY [- MM YYYY]
			$date_format = elgg_echo('transitions:dateformat');
			if (!empty($transitions->start_date) && !empty($transitions->end_date)) {
				$body .= date($date_format, $transitions->start_date) . ' - ' . date($date_format, $transitions->end_date);
			} else if (!empty($transitions->start_date)) {
				$body .= date($date_format, $transitions->start_date);
			} else if (!empty($transitions->end_date)) {
				$body .= date($date_format, $transitions->end_date);
			}
		} else {
			$date_format = elgg_echo('transitions:dateformat:time');
			// Format : from DD MM YYYY [until DD MM YYYY]
			if (!empty($transitions->start_date) && !empty($transitions->end_date)) {
				$body .= elgg_echo('transitions:date:since') . ' ' . date($date_format, $transitions->start_date);
				$body .= ' ' . elgg_echo('transitions:date:until') . ' ' . date($date_format, $transitions->end_date);
			} else if (!empty($transitions->start_date)) {
				$body .= elgg_echo('transitions:date:since') . ' ' . date($date_format, $transitions->start_date);
			} else if (!empty($transitions->end_date)) {
				$body .= elgg_echo('transitions:date:until') . ' ' . date($date_format, $transitions->end_date);
			}
		}
		if (!empty($transitions->start_date) || !empty($transitions->end_date)) { $body .= '</p>'; }
	}
	
	// URL et PJ
	if (!empty($transitions->url)) $body .= '<p><i class="fa fa-bookmark"></i> ' . elgg_echo('transitions:url') . '&nbsp;: <a href="' . $transitions->url . '" target="_blank">' . $transitions->url . '</a>';
	if (!empty($transitions->attachment)) $body .= '<p><i class="fa fa-file"></i> ' . elgg_echo('transitions:attachment') . '&nbsp;: <a href="' . $transitions->getAttachmentURL() . '" target="_blank">' . $transitions->getAttachmentName() . '</a></p>';
	
	// Meta
	if (!empty($transitions->lang) || !empty($transitions->resource_lang)) {
		$body .= '<p>';
		if (!empty($transitions->lang)) {
			$body .= '<i class="fa fa-flag"></i> ' . elgg_echo('transitions:lang'). ' : ' . elgg_echo($transitions->lang) . ' &nbsp; ';
		}
		if (!empty($transitions->resource_lang)) {
			$body .= '<i class="fa fa-flag-o"></i> ' . elgg_echo('transitions:resourcelang'). ' : ' . elgg_echo($transitions->resource_lang);
		}
		$body .= '</p>';
	}
	
	// @TODO ssi challenge => afficher le flux RSS
	if ($transitions->category == 'challenge') { $body .= '<p>' . $transitions->rss_feed . '</p>'; }
	
	$body .= '<div class="clearfloat"></div><br />';
	
	
	// Content enrichments
	if ($transitions->status != 'draft') {
		// Contributed tags (anyone)
		if ($transitions->tags_contributed) {
			$tags_contributed = elgg_view('output/tags', array('tags' => $transitions->tags_contributed));
			$body .= elgg_view_module('featured', elgg_echo('transitions:tags_contributed'), $tags_contributed);
		}
		if ($transitions->links_supports) {
			$links_supports = '<ul>';
			foreach((array)$transitions->links_supports as $link) {
				$links_supports .= '<li>' . elgg_view('output/url', array('href' => $link, 'target' => "_blank")) . '</li>';
			}
			$links_supports .= '</ul>';
			$body .= elgg_view_module('featured', elgg_echo('transitions:links_supports'), $links_supports);
		}
		// Contributed contradiction links
		if ($transitions->links_invalidates) {
			$links_invalidates = '<ul>';
			foreach((array)$transitions->links_invalidates as $link) {
				$links_invalidates .= '<li>' . elgg_view('output/url', array('href' => $link, 'target' => "_blank")) . '</li>';
			}
			$links_invalidates .= '</ul>';
			$body .= elgg_view_module('featured', elgg_echo('transitions:links_invalidates'), $links_invalidates);
		}
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
				$body .= elgg_view_module('featured', elgg_echo('transitions:related_actors'), $related_actors);
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
				$body .= elgg_view_module('featured', elgg_echo('transitions:related_content'), $related_content);
			}
		}
	}
	
	
	// Enrichment forms
	// Contributed tags
	$body .= elgg_view_form('transitions/addtag', array(), array('guid' => $transitions->guid));
	$body .= '<div class="clearfloat"></div><br />';
	
	// Contributed support links
	$body .= elgg_view_form('transitions/addlink', array(), array('guid' => $transitions->guid));
	$body .= '<div class="clearfloat"></div><br />';
	
	// Add relation to related actors (anyone)
	if ($transitions->category == 'project') {
		$body .= elgg_view_form('transitions/addactor', array(), array('guid' => $transitions->guid));
		$body .= '<div class="clearfloat"></div><br />';
	}
	
	// Add relation to answer resources (anyone)
	// @TODO : réservé aux auteurs du défi...
	/*
	if ($transitions->category == 'challenge') {
		$body .= elgg_view_form('transitions/addrelation', array(), array('guid' => $transitions->guid, 'relation' => 'challenge_element'));
		$body .= '<div class="clearfloat"></div><br />';
	}
	*/
	
	// Permalink
	$body .= elgg_view_module('info', elgg_echo('transitions:permalink'), $permalink);
	
	// Embed code
	$body .= elgg_view_module('info', elgg_echo('transitions:embed'), $embed_code);
	
	
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

} else {
	// brief view
	
	if (elgg_in_context("listing") || ($list_type != 'gallery')) {
		// Listing view
		$category = '';
		if (!empty($transitions->category)) {
			$category = '<span class="transitions-category transitions-' . $transitions->category . '">' . elgg_echo('transitions:category:' . $transitions->category) . '</span>';
		}
		$params = array(
			'entity' => $transitions,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'content' => $category . $excerpt,
		);
		$params = $params + $vars;
		$list_body = elgg_view('object/elements/summary', $params);
		
		if (!empty(trim($transitions_icon))) {
			echo elgg_view_image_block($owner_icon, $list_body, array('image_alt' => $transitions_icon));
		} else {
			echo elgg_view_image_block($owner_icon, $list_body);
		}
		//echo elgg_view_image_block($transitions_icon, $owner_icon . $list_body);
		
	} else {
		// Gallery view
		// do not show the metadata and controls in gallery view
		$metadata = '';
		$params = array(
			'text' => elgg_get_excerpt($transitions->title, 100),
			'href' => $transitions->getURL(),
			'is_trusted' => true,
		);
		$title_link = elgg_view('output/url', $params);
		
		echo '<div class="transitions-gallery-item">';
			echo '<div class="transitions-gallery-box">';
				
				echo $transitions_icon;
				echo '<div class="transitions-gallery-hover">';
					
					// Entête
					if (!empty($transitions->category)) echo '<span class="transitions-category transitions-' . $transitions->category . '">' . elgg_echo('transitions:category:' . $transitions->category) . '</span>';
					echo '<div class="transitions-gallery-head">';
						if ($metadata) { echo $metadata; }
						if ($title_link) { echo "<h3>$title_link</h3>"; }
						echo '<div class="elgg-subtext">' . $subtitle . '</div>';
						echo elgg_view('object/summary/extend', $vars);
						echo elgg_view('output/tags', array('tags' => $transitions->tags));
						//echo elgg_view_image_block($owner_icon, $list_body);
		
						// @TODO : nb likes, commentaires, objets liés, personnes et projets liés...
						echo '<div class="transitions-gallery-content">';
							echo '<div class="elgg-content">' . $excerpt . '</div>';
						echo '</div>';
					
						// @TODO actions possibles : commenter, liker, ajouter une métadonnée/relation
						echo '<div class="transitions-gallery-actions">';
							echo $stats;
							echo '<br />';
							echo $actions;
						echo '</div>';
					echo '</div>';
					
				echo '</div>';
				
				echo '<div class="clearfloat"></div>';
			echo '</div>';
		echo '</div>';
	}
}

