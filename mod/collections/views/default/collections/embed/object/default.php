<?php

$entity = elgg_extract("entity", $vars);
if (empty($entity) || !elgg_instanceof($entity, "object")) {
	return;
}

// Add info on object subtype
if ($entity->icontime) {
	echo elgg_view("output/img", array("src" => $entity->getIconURL("small"), "alt" => $entity->title, "style" => "float: left; margin: 5px;"));
}
echo '<h3>' . $entity->title . '</h3> ';
if (elgg_instanceof($entity, 'object', 'transitions')) {
	echo '<span class="transitions-category-' . $entity->category . '">' . elgg_echo('transitions:category:'.$entity->category) . '</span> ';
}
if (!empty($entity->excerpt)) {
	echo '<p><em>' . $entity->excerpt . '</em></p>';
} else {
	echo '<p><em>' . elgg_get_excerpt($entity->description) . '</em></p>';
}
//echo elgg_view_entity($entity, array('full_view' => false));

