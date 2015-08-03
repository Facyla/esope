<?php
// Selectors
$allowed_subtypes = array(
	'all' => elgg_echo('collections:embed:nofilter'),
	'blog' => elgg_echo('blog'),
	'page_top' => elgg_echo('page_top'),
	'page' => elgg_echo('page'),
	'pages' => elgg_echo('pages') . ' (' . elgg_echo('all') . ')',
	'bookmarks' => elgg_echo('bookmarks'),
	'groupforumtopic' => elgg_echo('groups:forum'),
	'file' => elgg_echo('file'), 
	'event_calendar' => elgg_echo('event_calendar'),
);


// Input data and parameters
$collection = $vars["entity"];
if (elgg_instanceof($collection, 'object', 'collection')) {
	$collection_guid = $collection->guid;
	$collection_container = $collection->getContainerEntity();
	$collection_container_guid = $collection->getContainerGUID();
}


$offset = (int) max(get_input("offset", 0), 0);
$limit = (int) max(get_input("limit", 10), 0);
// Subtypes adjustments
$subtype_value = get_input('subtype', 'all');
$subtype = $subtype_value;
if ($subtype_value == 'all') $subtype = array('blog', 'bookmarks', 'event_calendar', 'file', 'groupforumtopic', 'page', 'page_top');
else if ($subtype_value == 'pages') $subtype = array('page', 'page_top');
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

if (elgg_instanceof($collection_container, 'group')) {
	$options["container_guid"] = $collection_container_guid;
}

if (!empty($query)) {
	$dbprefix = elgg_get_config("dbprefix");
	$options["joins"] = array("JOIN " . $dbprefix . "objects_entity oe ON e.guid = oe.guid");
	$options["wheres"] = array("(oe.title LIKE '%" . $query . "%')");
}


// Search form - always display it as we allow some wider search thah default setting
// Note : any new field/parameter should be added to the js/collections/site view
$form_data = '';
$form_data .= '<p><label>' . elgg_echo('collections:embed:search') . ' ' . elgg_view("input/text", array("name" => "q", "value" => $query)) . '</label></p>';
$form_data .= '<p><label>' . elgg_echo('collections:embed:subtype') . ' ' . elgg_view("input/dropdown", array("name" => "subtype", "value" => $subtype_value, 'options_values' => $allowed_subtypes)) . '</label></p>';
$form_data .= elgg_view("input/hidden", array('name' => "display", 'value' => 'yes'));
$form_data .= elgg_view("input/submit", array("value" => elgg_echo("search"), "class" => "elgg-button-action"));

echo elgg_view("input/form", array("action" => "collection/embed/" . $collection_guid, "id" => "collections-embed-search", "body" => $form_data));
echo '<div class="clearfloat"></div>';


// Search results
// Display search results only after we've clicked on Search button
if ($display) {
	$count = elgg_get_entities($options);
	unset($options["count"]);
	
	if ($count > 0) {
		$entities = elgg_get_entities($options);
		echo "<ul id='collections-embed-list'>";
	
		// Build selection list
		foreach ($entities as $entity) {
			// Define embed model here
			$subtype = $entity->getSubtype();
			$description = $entity->description;
		
			// Use selected content template
			$embed_content = '';
			$embed_content .= $entity->guid;
			$embed_content .= " <strong>" . $entity->title . "</strong><br />";
			/*
			if ($entity->icontime) {
				$description = elgg_view("output/img", array("src" => $entity->getIconURL("large"), "alt" => $entity->title, "style" => "float: left; margin: 5px;")) . $description;
			}
			$embed_content .= elgg_view("output/longtext", array("value" => $description));
			*/
		
			// Build list item
			echo '<li class="' . $subtype . '">';
			echo '<div>';
			// Add info on object subtype
			echo '[' . $allowed_subtypes[$subtype] . '] <strong>' . $entity->title . '</strong> ';
			echo elgg_get_excerpt($description);
			echo '</div>';
			echo '<div class="collections-embed-item-content">' . $embed_content . '<br style="clear:both;" /></div>';
			echo '</li>';
		}
		echo '</ul>';

		echo '<div id="collections-embed-pagination">';
		echo elgg_view("navigation/pagination", array("offset" => $offset, "limit" => $limit, "count" => $count));
		echo "</div>";
	} else {
		echo elgg_echo("notfound");
	}
}

