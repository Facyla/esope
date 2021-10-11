<?php
// Statistiques de recueil du consentement

$user = elgg_get_logged_in_user_entity();
$title = elgg_echo('gdpr_consent:index:title');
$content = '';


$current_config = gdpr_consent_get_current_config();

$content .= '<h3>Configuration actuelle</h3>';
//$content .= '<pre>' . print_r($current_config, true) . '</pre>';

$content .= '<table id="gdpr_consent-statistics" border="1" style="border: 1px solid;">';
$content .= '<thead>';
$content .= '<tr><th>Document</th><th>version</th><th>URL</th><th>clef</th><th>Nb consentements recueillis</th></tr>';
$content .= '</thead>';
$content .= '<tbody>';
foreach($current_config as $consent) {
	$proof_name = "{$consent['key']}_{$consent['version']}"; // eg. privacy_0.1
	$params = [
		'plugin_id' => 'gdpr_consent',
		//'plugin_user_settings_names' => $proof_name,
		'plugin_user_setting_name_value_pairs' => ['name' => $proof_name, 'value' => 0, 'operand' => '>'],
		'count' => true,
	];
	$all_consent_count = elgg_get_entities_from_plugin_user_settings($params);
	$content .= "<tr><th>{$consent['text']}</th><td>{$consent['version']}</td><td>{$consent['href']}</td><td>{$proof_name}</td><td>{$all_consent_count}</td></tr>";
}
$content .= '</tbody>';
$content .= '</table>';
$content .= '<br />';

$content .= '<h3>Bannière affichée</h3>';
$content .= elgg_view('gdpr_consent/gdpr_consent_banner', ['show_validated' => true, 'anonymous' => true]);


echo elgg_view_page(null, [
	'title' => $title,
	'content' => $content,
	'sidebar' => false,
]);

