<?php

$entity = elgg_extract("entity", $vars);
if (empty($entity) || !elgg_instanceof($entity, "object")) {
	return;
}

// Add info on object subtype
if ($entity->icontime) {
	echo elgg_view("output/img", array("src" => $entity->getIconURL("small"), "alt" => $entity->title, "style" => "float: left; margin-right: 10px;"));
}
echo '<strong>';
if (elgg_instanceof($entity, 'object', 'transitions')) {
	echo '<span class="transitions-category-' . $entity->category . '">' . elgg_echo('transitions:category:'.$entity->category) . '</span> &nbsp; ';
}
echo $entity->title . '</strong> ';
echo '<p><em>';
if (!empty($entity->excerpt)) {
	echo $entity->excerpt;
} else {
	echo elgg_get_excerpt($entity->description);
}
echo '</em></p>';
//echo elgg_view_entity($entity, array('full_view' => false));

