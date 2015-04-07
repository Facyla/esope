<?php
/**
 * Download counter stats page
 * 
 * 
 */

admin_gatekeeper();
//elgg_push_context('admin');

$content = '';

// @TODO : order by metadata value
$files = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'file',
	'metadata_name' => array('name' => 'download_counter'),
	'order_by_metadata' => 'download_counter',
	'limit' => 0,
));


$content .= '<div id="download-counter-admin">';

// @TODO : add pagination
elgg_push_context('widget');
foreach($files as $ent) {
	$content .= '<div class="download_counter-item" style="">';
	$content .= elgg_view_entity($ent);
	$content .= '</div>';
}
elgg_pop_context();

$content .= '</div>';


$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);

