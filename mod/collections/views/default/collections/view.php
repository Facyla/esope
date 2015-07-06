<?php
// Get collection
$collection = $vars['entity'];
// Alternate method (more friendly with cmspages)
if (!$collection) {
	$guid = $vars['guid'];
	$collection = get_entity($guid);
}
if (!elgg_instanceof($collection, 'object', 'collection')) return;

$collection_content = '<li>' . implode('</li><li>', $collection->slides) . '</li>'; // Content without enclosing <ul> (we need id)
$height = '100%';
$width = '100%';
if (!empty($collection->height)) $height = $collection->height;
if (!empty($collection->width)) $width = $collection->width;

$collection_params = array(
		'collectioncontent' => $collection_content,
		'collectionparams' => $collection->config,
		'collectioncss_main' => "",
		'collectioncss_textslide' => "",
		'height' => $height,
		'width' => $width,
	);

echo '<div style="height:' . $height . '; width:' . $width . '; overflow:hidden;" id="collection-' . $collection->guid . '" class="collection-' . $collection->name . '">
	<style>
	' . $collection->css . '
	</style>
	' . elgg_view('collection/collection', $collection_params) . '
</div>';

