<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2015
* @link http://id.facyla.fr/
*/

$path = get_input('path', false); // Share path
$share_id = get_input('share_id', false); // Share id

$title = "Titre";

$content = "Owncloud main page";

$api_url = elgg_get_plugin_setting('api_url', 'owncloud');
$api_shares = elgg_get_plugin_setting('api_shares', 'owncloud');
$oc_username = elgg_get_plugin_user_setting('username', 'owncloud');
$oc_password = elgg_get_plugin_user_setting('password', 'owncloud');
$oc_admin_username = elgg_get_plugin_setting('username', 'owncloud');
$oc_admin_password = elgg_get_plugin_setting('password', 'owncloud');

$endpoint = $api_url . $api_shares;

$request_data = array();

if ($path) {
	$request_data['path'] = $path;
	$request_data['reshares'] = true;
	$request_data['subfiles'] = true;
}
if ($share_id) {
	$endpoint .= "/$share_id";
}


$content .= '<p>URL API : ' . $api_url . '</p>';
$content .= '<p>Shares API : ' . $api_shares . '</p>';
$content .= '<p>Full endpoint URL : ' . $endpoint . '</p>';
$content .= '<p>User username : ' . $oc_username . '</p>';
$content .= '<p>User password : xxxx</p>';
$content .= '<p>Admin username : ' . $oc_admin_username . '</p>';
$content .= '<p>Admin password : xxxx</p>';


// Make request
// Shares REST API doc : https://github.com/owncloud/documentation/blob/stable6/developer_manual/core/ocs-share-api.rst
$response = owncloud_get_data($username, $password, $endpoint, $request_data, 'GET', true);
//$content .= '<p><pre>' . print_r($response, true) . '</pre></p>';
//$content .= '<p><pre>' . print_r($response['body'], true) . '</pre></p>';
$response_obj = simplexml_load_string($response['body']);
$content .= '<div class="elgg-output"><h3>Partages</h3>';
if ($response_obj->data) {
	$content .= '<ul>';
	foreach ($response_obj->data->element as $element) {
		$content .= '<li><strong>' . $element->path . '</strong> =>' . $element->file_target . ' (' . $element->item_source . ', ' . $element->file_source . ') partagé avec ' . $element->share_with . '</li>';
	}
	$content .= '</ul>';
}
$content .= '</div>';

// View full response body
$content .= '<p><pre>' . print_r($response_obj, true) . '</pre></p>';


if (elgg_is_active_plugin('elgg_webdav')) {
	elgg_load_library('elgg:webdav:sabreDAV');
	$settings = array(
		'baseUri' => $api_url . 'remote.php/webdav/',
		'userName' => $oc_username,
		'password' => $oc_password,
		//'proxy' => 'locahost:8888',
	);
	$client = new Sabre\DAV\Client($settings);
	$response = $client->options();
	//$response = $client->request('GET');
	$content .= '<p><pre>' . print_r($response, true) . '</pre></p>';
	/*
	*/
	
	/*
	// Will do a GET request on the base uri
	$response = $client->request('GET'); 

	// Will do a HEAD request relative to the base uri
	$response = $client->request('HEAD', 'stuff');

	// Will do a PUT request with a request body
	$response = $client->request('PUT', 'file.txt', "New contents");

	// Will do a DELETE request with a condition
	$response = $client->request('DELETE', 'file.txt', null, array('If-Match' => '"12345765"'));
	*/
	
}



$sidebar = "Contenu de la sidebar";

// Render the page
$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));
echo elgg_view_page($title, $body);


