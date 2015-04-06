<?php
/**
 * Download counter stats page
 * 
 * 
 */

admin_gatekeeper();
//elgg_push_context('admin');

$content = '';

$files = elgg_get_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'file',
	'metadata_name' => array('name' => 'download_counter'),
	'sort_by' => 'download_counter',
));


$content .= '<div id="download-counter-admin">';

elgg_push_context('widget');
foreach($files as $ent) {
	$content .= '<div class="" style="">';
	$content .= '<span class="" style="">' . elgg_echo('download_counter:count', array($ent->download_counter)) . '</span>';
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

