<?php
// Get collection
$collection = elgg_extract('entity', $vars);
// Alternate method (more friendly with cmspages)
if (!$collection) {
	$guid = elgg_extract('guid', $vars);
	$collection = get_entity($guid);
}
if (!elgg_instanceof($collection, 'object', 'collection')) { return; }

foreach($collection->entities as $k => $entity_guid) {
	$publication = get_entity($entity_guid);
	$publication_comment = $collection['entities'][$k];
	$collection_content .= '<li>' . $publication->title . '<br /><em>' . $publication_comment . '</em></li>'
}


$collection_params = array(
		'collectioncontent' => $collection_content,
	);

echo '<div style="height:' . $height . '; width:' . $width . '; overflow:hidden;" id="collection-' . $collection->guid . '" class="collection-' . $collection->name . '">
	' . elgg_view('collection/collection', $collection_params) . '
</div>';

