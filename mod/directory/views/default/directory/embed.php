<?php
// Selectors
$allowed_subtypes = array(
	'all' => elgg_echo('directory:embed:nofilter'),
	'directory' => elgg_echo('directory:directory'),
	'person' => elgg_echo('directory:person'),
	'organisation' => elgg_echo('directory:organisation'),
);

// Input data and parameters
$object = $vars["entity"];
if (elgg_instanceof($object, 'object', 'directory') || elgg_instanceof($object, 'object', 'person') || elgg_instanceof($object, 'object', 'organisation')) {
	$object_guid = $object->guid;
	$object_container = $object->getContainerEntity();
	$object_container_guid = $object->getContainerGUID();
}

// Afficher les résultats avant d'appuyer sur "Rechercher" ?
$display = get_input('display', true);
// Afficher le sélecteur de subtype ?
$subtype_select = get_input('subtype-select', false);
// Search query
$query = get_input("q", false);
$query = sanitise_string($query);
$offset = (int) max(get_input("offset", 0), 0);
$limit = (int) max(get_input("limit", 10), 0);
$id = $vars['id'];
// Subtypes adjustments
$subtype_value = get_input('subtype', 'all');
if (!isset($allowed_subtypes[$subtype_value])) { $subtype_value = 'all'; }
$subtype = $subtype_value;
if ($subtype_value == 'all') $subtype = array('directory', 'person', 'organisation');

// Build selection query
$options = array(
		"type" => "object",
		"subtype" => $subtype,
		"full_view" => false,
		"limit" => $limit,
		"offset" => $offset,
		"count" => true
	);

if (elgg_instanceof($object_container, 'group')) {
	$options["container_guid"] = $object_container_guid;
}

if (!empty($query)) {
	// Some subtypes use 'name' instead of 'title'
	if (in_array($subtype_value, array('person', 'organisation'))) {
		$options['metadata_name_value_pairs'][] = array('name' => 'name', 'value' => "%$query%", 'operand' => 'LIKE');
	} else {
		$dbprefix = elgg_get_config("dbprefix");
		$options["joins"] = array("JOIN " . $dbprefix . "objects_entity oe ON e.guid = oe.guid");
		$options["wheres"] = array("((oe.title LIKE '%" . $query . "%') OR (oe.description LIKE '%" . $query . "%'))");
	}
}


// Search form - always display it as we allow some wider search thah default setting
// Note : any new field/parameter should be added to the js/directory/site view
$form_data = '';
$form_data .= '<p><label>' . elgg_echo('directory:embed:search') . ' ' . elgg_view("input/text", array("name" => "q", "value" => $query)) . '</label></p>';
$form_data .= elgg_view("input/hidden", array('name' => "id", 'value' => $id));
$form_data .= elgg_view("input/hidden", array('name' => "field_id", 'value' => $id));
if ($subtype_select) {
	$form_data .= '<p><label>' . elgg_echo('directory:embed:subtype') . ' ' . elgg_view("input/dropdown", array("name" => "subtype", "value" => $subtype_value, 'options_values' => $allowed_subtypes)) . '</label></p>';
} else {
	$form_data .= elgg_view("input/hidden", array('name' => "subtype", 'value' => $subtype_value));
}
$form_data .= elgg_view("input/hidden", array('name' => "display", 'value' => 'yes'));
$form_data .= elgg_view("input/submit", array("value" => elgg_echo("search"), "class" => "elgg-button-action"));

echo elgg_view("input/form", array("action" => "directory/embed/" . $object_guid . '/' . $id . '/' . $subtype_value, "id" => "directory-embed-search", "body" => $form_data));
echo '<div class="clearfloat"></div>';


// Search results
// Display search results only after we've clicked on Search button
if ($display) {
	$count = elgg_get_entities_from_metadata($options);
	unset($options["count"]);
	
	if ($count > 0) {
		$entities = elgg_get_entities($options);
		echo "<ul id='directory-embed-list'>";
	
		// Build selection list
		foreach ($entities as $ent) {
			// Define embed model here
			$ent_subtype = $ent->getSubtype();
			$description = $ent->description;
		
			// Use selected content template
			$embed_content = '';
			$embed_details = '';
			$embed_content .= $ent->guid; // Must be value to pass only (will update the calling hidden form field)
			$embed_details .= " <strong>" . $ent->title . $ent->name . "</strong><br />";
			/*
			if ($ent->icontime) {
				$description = elgg_view("output/img", array("src" => $ent->getIconURL("large"), "alt" => $ent->title, "style" => "float: left; margin: 5px;")) . $description;
			}
			$embed_content .= elgg_view("output/longtext", array("value" => $description));
			*/
		
			// Build list item
			echo '<li class="' . $ent_subtype . '">';
			echo '<div class="directory-embed-item-details">';
			// Add info on object subtype
			echo '[' . $allowed_subtypes[$ent_subtype] . '] <strong>' . $ent->title . '</strong> ';
			echo $embed_details;
			echo elgg_get_excerpt($description);
			echo '</div>';
			echo '<div class="directory-embed-item-content">' . $embed_content . '</div><br style="clear:both;" />';
			echo '</li>';
		}
		echo '</ul>';

		echo '<div id="directory-embed-pagination">';
		echo elgg_view("navigation/pagination", array("offset" => $offset, "limit" => $limit, "count" => $count));
		echo "</div>";
	} else {
		echo elgg_echo("notfound");
	}
}

