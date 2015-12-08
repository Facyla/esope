<?php
/**
 * Elgg WebDAV home page
 *
 * @package ElggWebDAV
 */

elgg_pop_breadcrumb();
elgg_push_breadcrumb(elgg_echo('webdav'));
/*
*/

$title = elgg_echo('elgg_webdav:view');
$content = '';

$url = elgg_get_site_url();
$main_url = $url . 'webdav/virtual';
$webdav_url = parse_url($url . 'webdav/virtual');
$webdav_root = $webdav_url['path'];

$content .= '<p>Vous pouvez monter des dossiers WebDAV distants pour pouvoir y accéder depuis ce site. Cette fonctionnalité est en cours de développement.</p>';


elgg_load_library('elgg:webdav:sabreDAV');
use Sabre\DAV\Client;
$settings = array(
	'baseUri' => 'http://example.org/dav/',
	'userName' => 'user',
	'password' => 'password',
	'proxy' => 'locahost:8888',
);

$client = new Sabre\DAV\Client($settings);


$content .= '<br />';
$content .= '<br />';


$content = '<div class="elgg-output">' . $content . '</div>';
$body = elgg_view_layout('one_column', array('content' => $content, 'title' => $title));

echo elgg_view_page($title, $body);

