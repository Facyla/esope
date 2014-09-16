<?php
include 'EtherpadLiteClient.php';


function elgg_etherpad_view_response($response) {
	$content = false;
	if ($response) {
		$content = '<pre>' . print_r($response, true) . '</pre>';
	}
	return $content;
}

function elgg_etherpad_get_response_data($response, $key = false) {
	$return = false;
	if ($response) {
		$return = $response;
		if ($key) { $return = $return->$key; }
	}
	return $return;
}


