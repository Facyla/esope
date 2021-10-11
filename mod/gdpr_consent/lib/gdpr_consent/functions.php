<?php

// Convert plaintext settings into a usable configuration array
// Use current settings by default
// @param string $consent_config override plaintext settings
function gdpr_consent_get_current_config($consent_config = false) {
	$config = [];
	if (!$consent_config) {
		$consent_config = elgg_get_plugin_setting('consent_config', 'gdpr_consent');
	}
	
	// Lines split
	$lines = str_replace("\r", "\n", $consent_config);
	$lines = explode("\n", $lines);
	// Suppression des espaces
	$lines = array_map('trim', $lines);
	// Suppression des doublons
	$lines = array_unique($lines);
	// Supression valeurs vides
	$lines = array_filter($lines);

	// Per line, parameters split
	foreach($lines as $i => $line) {
		$line = explode("|", $line);
		$line = array_map('trim', $line);
		if (!empty($line[0]) && !empty($line[1]) && !empty($line[2]) && !empty($line[3])) {
			$config[] = ['key' => $line[0], 'href' => $line[1], 'text' => $line[2], 'version' => $line[3]];
		}
	}
	return $config;
}

// Convert back the configuration array to plaintext settings (cleaned up !)
function gdpr_consent_get_settings_from_config($config = []) {
	$lines = [];
	foreach($config as $element) {
		$lines[] = $element['key'] . ' | ' . $element['href'] . ' | ' . $element['text'] . ' | ' . $element['version'];
	}
	return implode("\n", $lines);
}



