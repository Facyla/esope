<?php
/**
 * Elgg WebDAV home page
 *
 * @package ElggWebDAV
 */

/*
elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('webdav'));
*/
global $CONFIG;
//$view_url = $CONFIG->url . 'webdav/';

$title = elgg_echo('elgg_webdav:index');

$content = '';

$content .= '<h3>' . $title . '</h3>';

//$content .= '<p><a href="' . $view_url . 'd3" class="elgg-button elgg-button-action">D3</a> generic visualisation library</p>';

$content .= '<br />';
$content .= '<br />';


$body = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));

echo elgg_view_page($title, $body);

