<?php
// Selectors
$allowed_subtypes = array(
	'all' => elgg_echo('esope:option:nofilter'),
	'blog' => elgg_echo('blog'),
	'page_top' => elgg_echo('page_top'),
	'page' => elgg_echo('page'),
	'pages' => elgg_echo('pages') . ' (' . elgg_echo('all') . ')',
	'bookmarks' => elgg_echo('bookmarks'),
	'groupforumtopic' => elgg_echo('groups:forum'),
	'file' => elgg_echo('file'), 
	'event_calendar' => elgg_echo('event_calendar'),
);
$available_templates = array(
	'default' => elgg_echo('newsletter:embed:template:default'),
	'fullcontent' => elgg_echo('newsletter:embed:template:fullcontent'),
	'fullcontentauthor' => elgg_echo('newsletter:embed:template:fullcontentauthor'),
);


// Input data and parameters
$newsletter = $vars["entity"];
$offset = (int) max(get_input("offset", 0), 0);
$limit = (int) max(get_input("limit", 10), 0);
// Subtypes adjustments
$subtype = get_input('subtype', 'all');
if ($subtype == 'all') $subtype = array('blog', 'bookmarks', 'event_calendar', 'file', 'groupforumtopic', 'page', 'page_top');
else if ($subtype == 'pages') $subtype = array('page', 'page_top');
// Used to select various embed content templates
$template = get_input('template', 'fullcontentauthor');
$display = get_input('display', false);
// Search query
$query = get_input("q", false);
$query = sanitise_string($query);


// Build selection query
$options = array(
		"type" => "object",
		"subtype" => $subtype,
		"full_view" => false,
		"limit" => $limit,
		"offset" => $offset,
		"count" => true
	);

if ($newsletter->getContainerEntity() instanceof ElggGroup) {
	$options["container_guid"] = $newsletter->getContainerGUID();
}

if (!empty($query)) {
	$dbprefix = elgg_get_config("dbprefix");
	$options["joins"] = array("JOIN " . $dbprefix . "objects_entity oe ON e.guid = oe.guid");
	$options["wheres"] = array("(oe.title LIKE '%" . $query . "%')");
}


// Search form - always display it as we allow some wider search thah default setting
// Note : any new field/parameter should be added to the js/newsletter/site view
$form_data = '';
$form_data .= '<p><label>' . elgg_echo('newsletter:embed:templates') . ' ' . elgg_view("input/dropdown", array("name" => "template", "value" => $template, 'options_values' => $available_templates)) . '</label></p>';
$form_data .= '<p><label>' . elgg_echo('newsletter:embed:search') . ' ' . elgg_view("input/text", array("name" => "q", "value" => $query)) . '</label></p>';
$form_data .= '<p><label>' . elgg_echo('newsletter:embed:subtype') . ' ' . elgg_view("input/dropdown", array("name" => "subtype", "value" => $subtype, 'options_values' => $allowed_subtypes)) . '</label></p>';
$form_data .= elgg_view("input/hidden", array('name' => "display", 'value' => 'yes'));
$form_data .= elgg_view("input/submit", array("value" => elgg_echo("search"), "class" => "elgg-button-action"));

echo elgg_view("input/form", array("action" => "newsletter/embed/" . $newsletter->getGUID(), "id" => "newsletter-embed-search", "body" => $form_data));
echo '<div class="clearfloat"></div>';


// Search results
// Display search results only after we've clicked on Search button
if ($display) {
	$count = elgg_get_entities($options);
	unset($options["count"]);
	
	if ($count > 0) {
		$entities = elgg_get_entities($options);
		echo "<ul id='newsletter-embed-list'>";
	
		// Build selection list
		foreach ($entities as $entity) {
			// Define embed model here
			$subtype = $entity->getSubtype();
			$description = $entity->description;
		
			// Use selected content template
			$embed_content = '';
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
					if ($entity->tags) $embed_meta .= elgg_echo('tags') . '&nbsp;: ' . implode(', ', $entity->tags) . '<br />';
					if (!empty($embed_meta)) $embed_content .= '<small>' . $embed_meta . '</small>';
					$embed_content .= '<br style="clear:both;" />';
					// Full content
					if (!empty($description)) $embed_content .= elgg_view('output/longtext', array('value' => $description));
					// DL link (files)
					if ($subtype == 'file') {
						$embed_content .= '<p><a href="' . $vars['url'] . 'file/download/' . $entity->guid . '" target="_blank">' . elgg_echo("file:download") . '</a></p>';
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
					$embed_meta .= '<em>' . elgg_echo('by') . ' ' . $author->name . ' ' . friendly_time($entity->time_created) . '</em><br />';
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
						$embed_content .= '<p><a href="' . $vars['url'] . 'file/download/' . $entity->guid . '" target="_blank">' . elgg_echo("file:download") . '</a></p>';
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
					$embed_content .= "<strong>" . $entity->title . "</strong><br />";
					if ($entity->icontime) {
						$description = elgg_view("output/img", array("src" => $entity->getIconURL("large"), "alt" => $entity->title, "style" => "float: left; margin: 5px;")) . $description;
					}
					$embed_content .= elgg_view("output/longtext", array("value" => $description));
					break;
				
				default:
			
			}
		
			// Build list item
			echo '<li class="' . $subtype . '">';
			echo '<div>';
			// Add info on object subtype
			echo '[' . $allowed_subtypes[$subtype] . '] <strong>' . $entity->title . '</strong> ';
			echo elgg_get_excerpt($description);
			echo '</div>';
			echo '<div class="newsletter-embed-item-content">' . $embed_content . '<br style="clear:both;" /></div>';
			echo '</li>';
		}
		echo '</ul>';

		echo '<div id="newsletter-embed-pagination">';
		echo elgg_view("navigation/pagination", array("offset" => $offset, "limit" => $limit, "count" => $count));
		echo "</div>";
	} else {
		echo elgg_echo("notfound");
	}
}

