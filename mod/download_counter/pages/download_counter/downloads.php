<?php
/**
 * Download counter stats page
 * 
 * 
 */

admin_gatekeeper();
//elgg_push_context('admin');

$content = '';

// List ordered by metadata value
$files = elgg_list_entities_from_metadata(array(
		'type' => 'object',
		'subtype' => 'file',
		'metadata_name' => array('name' => 'download_counter'),
		'order_by_metadata' => array('name' => 'download_counter', 'direction' => 'DESC'),
		'limit' => 50,
		'pagination' => true,
		'full_view' => false,
	));


$content .= '<div id="download-counter-admin">' . $files . '</div>';


$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
));

echo elgg_view_page($title, $body);

