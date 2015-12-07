<?php


/* Get access token from owncloud API
 * $data : data string
 * $write_token : alternate write token
 * $api_endpoint : alternate push API URL
 */
/*
function owncloud_get_access_token($data, $api_endpoint = 'https://api.domain.tld', $access_token) {
	if (empty($api_endpoint)) $api_endpoint = elgg_get_plugin_setting('api_auth_endpoint', 'owncloud');
	
	$headers = array();
	$headers = array("Authorization : Basic $access_token");
	
	// Combine data if needed
	if (is_array($data)) {
		$data = json_encode($data);
		//$api_endpoint .= '?';
		//foreach($data as $key => $val) { $api_endpoint .= "$key=$val&"; }
	}
	//echo $data;
	
	// Perform POST request
	return owncloud_httpPost($api_endpoint, $data, $headers);
}
*/


/* Get data from owncloud API
 * $data : data string
 * $write_token : alternate write token
 * $api_endpoint : alternate push API URL
 */
function owncloud_get_data($username = false, $password = false, $api_endpoint = '', $data, $method = "POST", $disable_ca_check = false) {
	if (empty($api_endpoint)) $api_endpoint = elgg_get_plugin_setting('api_url', 'owncloud');
	if (empty($username)) $username = elgg_get_plugin_user_setting('username', 'owncloud');
	if (empty($password)) $password = elgg_get_plugin_user_setting('password', 'owncloud');
	
	// Add authentication
	//$headers = array("Authorization : Basic $access_token");
	//$headers = array("Authorization : Bearer $access_token");
	
	// Combine data if needed
	//if (is_array($data)) $data = implode("\n", $data);
	//if (is_array($data)) $data = json_encode($data);
	//echo $data;
	
	// Perform POST request
	return owncloud_httpPost($username, $password, $api_endpoint, $data, $headers, $method, $disable_ca_check);
}


/* Performs a POST request */
function owncloud_httpPost($username = false, $password = false, $api_endpoint = '', $data = false, $headers = false, $method = "POST", $disable_ca_check = false) {
	if (empty($api_endpoint)) { return false; }
	
	/* POST json data
	
	$data = array("name" => "Hagrid", "age" => "36");
	$data_string = json_encode($data);

$ch = curl_init('http://api.local/rest/users');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($data_string))
);

$result = curl_exec($ch);
	*/
	
	if (($method == 'GET') && $data) {
		$api_endpoint .= '?' . http_build_query($data);
	}
	
	//$ch = curl_init();
	//curl_setopt($ch, CURLOPT_URL, $url);
	$ch = curl_init($api_endpoint);
	
	// Authentification HTTP
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	
	// Permettre redirection
	
	curl_setopt_array($ch, array(
				CURLOPT_FOLLOWLOCATION => TRUE,
				CURLOPT_HEADER => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_VERBOSE => TRUE,
			)
		);
	
	// Disable SSL verification
	if ($disable_ca_check) {
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	}
	
	switch($method) {
		case 'GET':
			// Set options
			curl_setopt_array($ch, array(
					CURLOPT_CUSTOMREQUEST => 'GET',
				));
			break;
		case 'POST':
		default:
			// Set options
			curl_setopt_array($ch, array(
					CURLOPT_POSTFIELDS => $data,
					//CURLOPT_POST => 1,
					CURLOPT_CUSTOMREQUEST => 'POST',
				));
	}
	
	if ($headers) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	
	$response = curl_exec($ch);
	
	// Get response header and body
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	// list($header, $body) = explode("\r\n\r\n", $response, 2); // Alternate method (slower ?)
	$header = substr($response, 0, $header_size);
	$body = substr($response, $header_size);

	if ($response === FALSE) { die(curl_error($ch)); }
	
	curl_close($ch);
	return array('response' => $response, 'header'=> $header, 'body' => $body);
}


