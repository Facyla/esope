<?php

$key = (string) get_input('key');
$version = (string) get_input('version');
$consent = (string) get_input('consent');

$user_guid = elgg_get_logged_in_user_guid();

// Check existing key, version, and consent value
if (elgg_is_logged_in() && $consent == 'yes') {
	// @TODO ensure these key/version axists and are currently used
	$config = gdpr_consent_get_current_config();
	
	// Check that this key/version combination actually exists
	$valid_key_version = true;
	foreach($config as $consent_doc) {
		if ($key == $consent_doc['key'] && $version == $consent_doc['version']) {
			$valid_key_version = true;
			$doc_title = $consent_doc['text'];
			/*
			$doc_url = $consent_doc['href'];
			$doc_link = elgg_view('output/url', ['text' => $doc_title, 'href' => $doc_url]);
			*/
			break;
		}
	}
	
	$proof_name = "{$key}_{$version}";
	$current_ts = time();
	//$proof_value = [];
	$proof_value = $current_ts;
	
	$user_consent = elgg_get_plugin_user_setting($proof_name, $user_guid, 'gdpr_consent');
	if (!$user_consent || empty($user_consent)) {
		elgg_set_plugin_user_setting($proof_name, $proof_value, $user_guid, 'gdpr_consent');
		system_message(elgg_echo('gdpr_consent:success', [$doc_title]));
		forward(REFERER);
		exit;
	}
	/*
	return elgg_ok_response([
		'success' => true,
		'message' => elgg_echo('gdpr_consent:success'),
		//'guid' => $user->guid,
	]);
	*/
}

//return elgg_error_response(elgg_echo('gdpr_consent:error'));
register_error(elgg_echo('gdpr_consent:error', [$doc_title]));
forward(REFERER);

