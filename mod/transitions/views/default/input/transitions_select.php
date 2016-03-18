<?php
/* Transitions select
 * 
 * @uses string $vars['filter']    The current value. Single value. Optional.
 * @uses string $vars['value']    The current value. Single value. Optional.
 */

$options = array('types' => 'object', 'subtypes' => 'transitions', 'order_by' => 'time_created desc', 'limit' => 0);

// Select options
$name = elgg_extract('name', $vars, 'transitions');
$value = elgg_extract('value', $vars, false);
$label = elgg_extract('label', $vars, '');
$lang = elgg_extract('lang', $vars, '');
$onChange = elgg_extract('onChange', $vars, '');


// Filters
$category = elgg_extract('category', $vars, '');
$sort = elgg_extract('sort', $vars, 'alpha');

// Filter by published status (no private access level)
$options['wheres'][] = "(e.access_id <> 0)";

// Filter by transitions category
if (!empty($category)) {
	$options['metadata_name_value_pairs'][] = array('name' => 'content_type', 'value' => $category);
}

// Get cmspages
if (!empty($options['metadata_name_value_pairs'])) { $transitions = elgg_get_entities_from_metadata($options); }
else { $transitions = elgg_get_entities($options); }

if ($transitions) {
	// Tri des pages : dernières, alpha
	switch($sort) {
		case 'alpha':
			// Tri alphabétique des pages (sur la base du pagetype)
			usort($transitions, create_function('$a,$b', 'return strcmp($a->title,$b->title);'));
			break;
		case 'latest':
		default:
	}
}

// Liste multisite partout car on a besoin de pouvoir mettre tout type d'article en avant
$transitions_opt = array();
$transitions_opt['no'] = '' . elgg_echo('transitions:option:none');
foreach ($transitions as $ent) {
	$title = $ent->title;
	if (!empty($ent->category)) $title .= ' (' . elgg_echo('transitions:category:' . $ent->category) . ')';
	$transitions_opt[$ent->guid] = $title;
}

// Render select input
$select = elgg_view('input/select', array('name' => $name, 'options_values' => $transitions_opt, 'value'=> $value, 'class' => "transitions-select", 'onChange' => $onChange));
if (!empty($label)) {
	echo '<label>' . $label . ' ' . $select . '</label>';
} else {
	echo $select;
}


