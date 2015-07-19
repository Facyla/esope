<?php
// Get collection
$collection = elgg_extract('entity', $vars);
// Alternate method (more friendly with cmspages)
if (!$collection) {
	$guid = elgg_extract('guid', $vars);
	$collection = get_entity($guid);
}
if (!elgg_instanceof($collection, 'object', 'collection')) { $collection = collections_get_entity_by_name($guid); }
if (!elgg_instanceof($collection, 'object', 'collection')) { return; }

$collection_content = '';
foreach($collection->entities as $k => $entity_guid) {
	$publication = get_entity($entity_guid);
	$publication_comment = $collection->entities_comment[$k];
	$collection_content .= '<li>';
	$collection_content .= $publication->title . '<br /><em>' . $publication_comment . '</em>';
	$collection_content .= '</li>';
}


echo $collection_content;

$height = '200px;';
$width = '100%;';
$slider_params = array(
		'slidercontent' => $collection_content,
		'height' => $height,
		'width' => $width,
		//'theme' => 'cs-portfolio',
	);

echo '<div style="height:' . $height . '; width:' . $width . ';" id="collection-' . $collection->guid . '" class="collection-' . $collection->name . '">
	' . elgg_view('slider/slider', $slider_params) . '
</div>';
/*
*/


