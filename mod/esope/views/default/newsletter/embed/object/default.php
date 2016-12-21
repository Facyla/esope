<?php
/* ESOPE : this view is used only for search result selection (not for the actual embedding of the content)
 * To define the actual embed content, see js/newsletter/embed
 */

$entity = elgg_extract('entity', $vars);
if (!elgg_instanceof($entity, 'object')) {
	return;
}
$template = elgg_extract('template', $vars);
$type = $entity->getType();
$subtype = $entity->getSubtype();
$description = $entity->description;


$container = $entity->getContainerEntity();

// data for embedding
$data = [
	'data-title' => $entity->title,
	'data-description' => $entity->description,
	'data-url' => $entity->getURL(),
];
// Add full path for pages
if (elgg_instanceof($entity, 'object', 'page')) {
	if ($entity->parent_guid) {
		$parents = array();
		$parent = get_entity($entity->parent_guid);
		while ($parent) {
			$parents[] = $parent;
			$parent = get_entity($parent->parent_guid);
		}
		$path_title = '';
		foreach($parents as $parent) {
			if (!empty($path_title)) { $path_title .= ' > '; }
			$path_title .= $parent->title;
		}
		if (sizeof($parents) > 1) {
			$path_title = elgg_echo('esope:pages:parents') . $path_title;
		} else {
			$path_title = elgg_echo('esope:pages:parent') . $path_title;
		}
		$data['title'] = $path_title;
	}
}


// excerpt support
$excerpt = $entity->excerpt;
if (empty($excerpt)) {
	$excerpt = elgg_get_excerpt($entity->description);
}
if (!empty($excerpt)) {
	$data['data-excerpt'] = $excerpt;
}

// icon support
if ($entity->icontime) {
	$data['data-icon-url'] = $entity->getIconURL('large');
}

// subtitle
$subtitle = [
	elgg_echo('item:object:' . $entity->getSubtype()),
	elgg_echo('by') . ' ' . $entity->getOwnerEntity()->name,
];
if (elgg_instanceof($container, 'group')) {
	$subtitle[] = elgg_echo('river:ingroup', [$container->name]);
}

// Use default layout
if (!in_array($template, array())) {
/*
	// build listing view
	$params = [
		'entity' => $entity,
		'title' => $entity->title,
		'subtitle' => implode(' ', $subtitle),
		'tags' => false,
		'content' => $excerpt,
	];

	echo elgg_format_element('div', $data, elgg_view('object/elements/summary', $params));
	return;
*/
}



// Use selected content template
switch($template) {

	// Custom template : titre + tags + date + texte complet (+ lien de téléchargement ou URL)
	case 'fullcontent':
		// Blog and files now, but could be used by other subtypes later...
		if ($entity->icontime) {
			$embed_content .= elgg_view('output/img', array('src' => $entity->getIconURL('large'), 'alt' => $entity->title, 'style' => "float: left; margin: 5px;"));
		}
		// Title
		$embed_content .= '<strong><a href="' . $entity->getURL() . '">' . $entity->title . '</a></strong><br />';
		// Meta info
		$embed_meta = '';
		if ($entity->tags) { $embed_meta .= elgg_echo('tags') . '&nbsp;: ' . implode(', ', $entity->tags) . '<br />'; }
		if (!empty($embed_meta)) { $embed_content .= '<small>' . $embed_meta . '</small>'; }
		$embed_content .= '<br style="clear:both;" />';
		// Full content
		if (!empty($description)) { $embed_content .= elgg_view('output/longtext', array('value' => $description)); }
		// DL link (files)
		if ($subtype == 'file') {
			$embed_content .= '<p><a href="' . elgg_get_site_url() . 'file/download/' . $entity->guid . '" target="_blank">' . elgg_echo("file:download") . '</a></p>';
		}
		// Web URL (bookmarks)
		if ($entity->address) {
			$embed_content .= '<div class="sharing_item_address"><p><a href="' . $entity->address . '" target="_blank">' . elgg_echo('bookmarks:visit') . '</a></p></div>';
		}
		// Event_calendar support : basic ; replaces regular content
		if ($subtype == 'event_calendar') {
			elgg_push_context('widgets');
			$embed_content = elgg_view('object/event_calendar', array('entity' => $entity, 'full_view' => false));
			elgg_pop_context();
		}
		break;

	// Custom template #2 : same as 'fullcontent' + photo auteur + nb commentaires
	case 'fullcontentauthor':
		// Author photo
		$author = $entity->getOwnerEntity();
		$image = elgg_view('output/img', array('src' => $author->getIconURL('small'), 'alt' => $author->name));
		// Title
		$embed_content .= '<strong><a href="' . $entity->getURL() . '">' . $entity->title . '</a></strong><br />';
		// Meta info
		$embed_meta = '';
		if ($entity->tags) $embed_meta .= elgg_echo('tags') . '&nbsp;: ' . implode(', ', $entity->tags) . '<br />';
		$embed_meta .= '<em>' . elgg_echo('by') . ' ' . $author->name . ' ' . elgg_view_friendly_time($entity->time_created) . '</em><br />';
		// Number of comments
		$comments = $entity->countComments();
		if ($comments > 0) $embed_meta .= elgg_echo('comments:count', array($comments)) . '<br />';
		if (!empty($embed_meta)) $embed_content .= '<small>' . $embed_meta . '</small>';
		$embed_content .= '<br style="clear:both;" />';
		// Blog and files but could be used by other subtypes later...
		if ($entity->icontime) {
			$embed_content .= elgg_view('output/img', array('src' => $entity->getIconURL('large'), 'alt' => $entity->title));
		}
		// Full content
		if (!empty($description)) $embed_content .= elgg_view('output/longtext', array('value' => $description));
		// Download link (files)
		if ($subtype == 'file') {
			$embed_content .= '<p><a href="' . elgg_get_site_url() . 'file/download/' . $entity->guid . '" target="_blank">' . elgg_echo("file:download") . '</a></p>';
		}
		// Web URL (bookmarks)
		if ($entity->address) {
			$embed_content .= '<div class="sharing_item_address"><p><a href="' . $entity->address . '" target="_blank">' . elgg_echo('bookmarks:visit') . '</a></p></div>';
		}
		// Event_calendar support : basic ; replaces regular content
		if ($subtype == 'event_calendar') {
			elgg_push_context('widgets');
			$embed_content = elgg_view('object/event_calendar', array('entity' => $entity, 'full_view' => false));
			elgg_pop_context();
		}
		// Compose final view
		$embed_content = '<div style="float: left; margin: 5px;">' . $image . '</div>' . $embed_content;
		break;

	// Default template of newsletter plugin
	case 'default':
		/*
		$embed_content .= "<strong>" . $entity->title . "</strong><br />";
		if ($entity->icontime) {
			$description = elgg_view("output/img", array("src" => $entity->getIconURL("large"), "alt" => $entity->title, "style" => "float: left; margin: 5px;")) . $description;
		}
		
		$embed_content .= elgg_view("output/longtext", array("value" => $description));
		break;
		*/
	
	default:
		// Default plugin rendering
		// build listing view
		$params = [
			'entity' => $entity,
			'title' => $entity->title,
			'subtitle' => implode(' ', $subtitle),
			'tags' => false,
			'content' => $excerpt,
		];
		$embed_content .= elgg_view('object/elements/summary', $params);
}

//$embed_content = '<div>' . '[' . $allowed_subtypes[$subtype] . '] <strong>' . $entity->title . '</strong> ' . elgg_get_excerpt($description) . '</div>' . '<div class="newsletter-embed-item-content">' . $embed_content . '<br style="clear:both;" /></div>';
echo elgg_format_element('div', $data, $embed_content);


