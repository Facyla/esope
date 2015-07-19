<?php

// Input data and parameters
$field_id = $vars["id"];

$category_opt = transitions_get_category_opt(null, true, true);
$actortype_opt = transitions_get_actortype_opt(null, true);

$offset = (int) max(get_input("offset", 0), 0);
$limit = (int) max(get_input("limit", 2), 0);
$display = get_input('display', false);
// Search query
$query = get_input("q", false);
$query = sanitise_string($query);
$actor_type = get_input('actor_type', false);
$category = get_input('category', false);


// Build selection query
$search_options = array(
		"type" => "object",
		"subtype" => 'transitions',
		"full_view" => false,
		"limit" => $limit,
		"offset" => $offset,
		'list_type' => 'gallery', 
		'item_class' => 'transitions-item',
		"count" => true,
	);

if (!empty($category)) {
	$search_options['metadata_name_value_pairs'][] = array('name' => 'category', 'value' => $category);
}
if (!empty($actor_type)) {
	$search_options['metadata_name_value_pairs'][] = array('name' => 'actor_type', 'value' => $actor_type);
}

if (!empty($query)) {
	$dbprefix = elgg_get_config("dbprefix");
	
	// Add custom metadata search
	$search_metadata = array('excerpt');
	$clauses = _elgg_entities_get_metastrings_options('metadata', array('metadata_names' => $search_metadata));
	$md_where = "(({$clauses['wheres'][0]}) AND msv.string LIKE '%$query%')";
	$search_options['joins'] = $clauses['joins'];
	
	// Add title and description search
	$search_options['joins'][] = "JOIN {$dbprefix}objects_entity oe ON e.guid = oe.guid";
	
	$search_options['joins'][] = "JOIN {$dbprefix}metadata md on e.guid = md.entity_guid";
	$search_options['joins'][] = "JOIN {$dbprefix}metastrings msv ON n_table.value_id = msv.id";
		
	$search_options['wheres'][] = "((oe.title LIKE '%$query%') OR (oe.description LIKE '%$query%') OR $md_where)";
	
}


// Search form - always display it as we allow some wider search thah default setting
// Note : any new field/parameter should be added to the js/collections/site view
$form_data = '';
$form_data .= '<p><label>' . elgg_echo('collections:embed:search') . ' ' . elgg_view("input/text", array("name" => "q", "value" => $query)) . '</label></p>';
$form_data .= '<p>';
$form_data .= '<label>' . elgg_echo('transitions:category') . ' ' . elgg_view('input/select', array('name' => 'category', 'options_values' => $category_opt, 'value' => $category)) . '</label>';
$form_data .= ' &nbsp; ';
if ($category == 'actor') {
	$form_data .= '<label class="transitions-embed-search-actortype">' . elgg_echo('transitions:actortype') . ' ' . elgg_view('input/select', array('name' => 'actor_type', 'options_values' => $actortype_opt, 'value' => $actor_type)) . '</label>';
} else {
	$form_data .= '<label class="transitions-embed-search-actortype hidden">' . elgg_echo('transitions:actortype') . ' ' . elgg_view('input/select', array('name' => 'actor_type', 'options_values' => $actortype_opt, 'value' => $actor_type)) . '</label>';
}
$form_data .= '</p>';
$form_data .= elgg_view("input/hidden", array('name' => "field_id", 'value' => $field_id));
$form_data .= elgg_view("input/hidden", array('name' => "display", 'value' => 'yes'));
$form_data .= elgg_view("input/submit", array("value" => elgg_echo("search"), "class" => "elgg-button-action"));

echo elgg_view("input/form", array("action" => "collection/embed/" . $field_id, "id" => "collections-embed-search", "body" => $form_data));
echo '<div class="clearfloat"></div>';
echo '<br />';


// Search results
// Display search results only after we've clicked on Search button
if ($display) {
	if (isset($search_options['metadata_name_value_pairs'])) {
		$count = elgg_get_entities_from_metadata($search_options);
	} else {
		$count = elgg_get_entities($search_options);
	}
	unset($search_options["count"]);
	
	if ($count > 0) {
		if (isset($search_options['metadata_name_value_pairs'])) {
			$entities = elgg_get_entities_from_metadata($search_options);
		} else {
			$entities = elgg_get_entities($search_options);
		}
		echo "<ul id='collections-embed-list'>";
	
		// Build selection list
		elgg_push_context('widgets');
		foreach ($entities as $entity) {
			// Define embed model here
			$subtype = $entity->getSubtype();
			
			// Use selected content template
			$embed_content = '';
			$embed_content .= $entity->guid;
			
			// Build list item
			echo '<li class="' . $subtype . '">';
			echo '<div class="collections-embed-item-details">';
			echo elgg_view('collections/embed/object/default', array('entity' => $entity));
			echo '</div>';
			echo '<div class="collections-embed-item-content embed-insert">' . $embed_content . '</div><br style="clear:both;" />';
			echo '</li>';
		}
		elgg_pop_context();
		echo '</ul>';

		echo '<div id="collections-embed-pagination">';
		$base_url = elgg_get_site_url() . 'collection/embed/' . $field_id . "?display=yes&query=$query&actor_type=$actor_type&category=$category";
		echo elgg_view("navigation/pagination", array("offset" => $offset, "limit" => $limit, "count" => $count, 'base_url' => $base_url));
		echo "</div>";
	} else {
		echo elgg_echo("notfound");
	}
}

