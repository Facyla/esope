<?php
/* CMSPages select
 * 
 * @uses string $vars['filter']    The current value. Single value. Optional.
 * @uses string $vars['value']    The current value. Single value. Optional.
 */

$options = array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created desc', 'limit' => 0);

// Select options
$name = elgg_extract('name', $vars, 'cmspages');
$value = elgg_extract('value', $vars, false);
$label = elgg_extract('label', $vars, '');
$use_guid = elgg_extract('use_guid', $vars, false); // Defaults to pagetype
$onChange = elgg_extract('onChange', $vars, '');

// Filters
$content_type = elgg_extract('content_type', $vars, '');
$status = elgg_extract('status', $vars, 'published');
$sort = elgg_extract('sort', $vars, 'alpha');

// Filter by published status (draft or other access level)
if ($status == 'draft') {
	$options['wheres'][] = "(e.access_id = 0)";
} else if ($status == 'published') {
	$options['wheres'][] = "(e.access_id <> 0)";
}
// Filter by content type
if (!empty($content_type)) {
	if ($content_type == 'editor') {
		$options['metadata_name_value_pairs'][] = array('name' => 'content_type', 'value' => 'module', 'operand' => '<>');
		$options['metadata_name_value_pairs'][] = array('name' => 'content_type', 'value' => 'template', 'operand' => '<>');
	} else {
		$options['metadata_name_value_pairs'][] = array('name' => 'content_type', 'value' => $content_type);
	}
}

// Get cmspages
if (!empty($options['metadata_name_value_pairs'])) { $cmspages = elgg_get_entities_from_metadata($options); }
else { $cmspages = elgg_get_entities($options); }

if ($cmspages) {
	// Tri des pages : dernières, alpha
	switch($sort) {
		case 'alpha':
			// Tri alphabétique des pages (sur la base du pagetype)
			usort($cmspages, create_function('$a,$b', 'return strcmp($a->pagetype,$b->pagetype);'));
			break;
		case 'latest':
		default:
	}
}

// Liste multisite partout car on a besoin de pouvoir mettre tout type d'article en avant
$cmspages_opt = array();
$cmspages_opt['no'] = '' . elgg_echo('cmspages:settings:none');
foreach ($cmspages as $ent) {
	$linktext = $ent->pagetype;
	if (!empty($ent->pagetitle)) $linktext .= ' (' . $ent->pagetitle . ')';
	if ($use_guid) {
		$cmspages_opt[$ent->guid] = $linktext;
	} else {
		$cmspages_opt[$ent->pagetype] = $linktext;
	}
}

// Render select input
$select = elgg_view('input/select', array('name' => $name, 'options_values' => $cmspages_opt, 'value'=> $value, 'class' => "cmspages-select", 'onChange' => $onChange));
if (!empty($label)) {
	echo '<label>' . $label . ' ' . $select . '</label>';
} else {
	echo $select;
}


