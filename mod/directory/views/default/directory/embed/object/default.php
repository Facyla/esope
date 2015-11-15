<?php

$entity = elgg_extract("entity", $vars);
if (empty($entity) || !elgg_instanceof($entity, "object")) {
	return;
}

// Add info on object subtype
if ($entity->icontime) {
	echo elgg_view("output/img", array("src" => $entity->getIconURL("small"), "alt" => $entity->title, "style" => "float: left; margin-right: 10px;"));
}

if (elgg_instanceof($entity, 'object')) {
	$subtype = $entity->getSubtype();
	echo '<strong>';
	switch($subtype) {
		case 'directory':
			echo '<span class="">' . elgg_echo('directory:'.$subtype) . '</span> &nbsp; ' . $entity->title;
			break;
		case 'organisation':
			echo '<span class="">' . elgg_echo('directory:'.$subtype) . '</span> &nbsp; ' . $entity->name;
			break;
		case 'person':
			echo '<span class="">' . elgg_echo('directory:'.$subtype) . '</span> &nbsp; ' . $entity->name;
			break;
	}
	echo '</strong> ';
}
echo '<p><em>';
if (!empty($entity->excerpt)) {
	echo $entity->excerpt;
} else {
	echo elgg_get_excerpt($entity->description);
}
echo '</em></p>';
//echo elgg_view_entity($entity, array('full_view' => false));

