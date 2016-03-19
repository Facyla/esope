<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */


admin_gatekeeper();

$title = "Suppression des paramètres CMIS personnels";
$content = '';
$sidebar = '';

$content .= "<p>Cet outil permet de supprimer les paramètres personnels associés au plugin elgg_cmis.</p>";

if (elgg_is_active_plugin('elgg_cmis')) {
	$content .= "<p>Cet outil ne peut être utilisé qu'une fois le plugin CMIS désactivé.</p>";
} else {
	$proceed = get_input('clear_cmis_credentials', false);
	if ($proceed == 'yes') {
		set_time_limit(0); // Ce sera long
		$usersettings = array('cmis_login', 'cmis_password', 'cmis_password2', 'user_cmis_url');
		$users_options = array('types' => 'user', 'limit' => 0, 'usersettings' => $usersettings);
		$batch = new ElggBatch('elgg_get_entities', $users_options, 'esope_clear_elgg_cmis_usersettings', 10);
		$content .= '<p>Suppression des paramètres personnels CMIS terminée.</p>';
	} else {
		$content .= '<a class="elgg-button elgg-button-action" href="' . current_page_url() . '?clear_cmis_credentials=yes">Supprimer tous les paramètres personnels associés au plugin elgg_cmis</a><br />Attention, cette action est irréversible.';
	}
}

// Function that is used to clear previously set usersettings
function esope_clear_elgg_cmis_usersettings($user, $getter, $options) {
	$usersettings = $options['usersettings'];
	$ps = get_all_private_settings($user->guid);
	//echo "$user->name : " . print_r($ps, true);
	foreach($usersettings as $setting) {
		remove_private_setting($user->guid, "plugin:user_setting:elgg_cmis:$setting");
	}
}

$params = array('content' => $content, 'title' => $title, 'sidebar' => $sidebar);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);

