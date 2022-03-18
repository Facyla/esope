<?php
/**
 * Main delivery modes page
 */

elgg_admin_gatekeeper();

$url = elgg_get_site_url();

elgg_push_breadcrumb(elgg_echo('account_lifecycle:anonymize'), 'account_lifecycle');

// @TODO bouton visible ssi les fonctionnalités avancées sont développées
//elgg_register_title_button('account_lifecycle', 'add', 'object', 'account_lifecycle');

$content = '';

// Plugin parameters
/*
$include_admin = elgg_get_plugin_setting('direct_include_admin', 'account_lifecycle');
$interval = elgg_get_plugin_setting('direct_interval', 'account_lifecycle');
$action = elgg_get_plugin_setting('direct_rule', 'account_lifecycle');

$content .= "<h3>" . elgg_echo('account_lifecycle:parameters') . "</h3>";
$content .= '<ul style="list-style: initial; margin-left: 1rem;">' . "
	<li>" . elgg_echo('account_lifecycle:settings:direct_include_admin') . " : <strong>" . elgg_echo("option:$include_admin") . "</strong></li>
	<li>" . elgg_echo('account_lifecycle:settings:direct_interval') . " : <strong>tous les $interval jours</strong></li>
	<li>" . elgg_echo('account_lifecycle:settings:direct_rule') . " : <strong>{$direct_rule_opt[$action]}</strong></li>
</ul>
<br />";
*/

$yes_no_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$no_yes_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

// Per-user mode
$anonymize_mode = get_input('anonymize_mode');
$anonymize_simulate = get_input('anonymize_simulate');
$anonymize_verbose = get_input('anonymize_verbose');
$anonymize_users = get_input('anonymize_users');
$remove_email = get_input('remove_email');
$replace_name = get_input('replace_name');
$replace_username = get_input('replace_username');
$remove_profile_data = get_input('remove_profile_data');
$remove_messages = get_input('remove_messages');
$anonymize_verbose = get_input('anonymize_verbose');
$remove_publications = get_input('remove_publications');


$content .= "<h3>" . elgg_echo('account_lifecycle:anonymize') . "</h3>";
$content .= "<em>" . elgg_echo('account_lifecycle:anonymize:description') . "</em>";
$content .= '<br /><br />';

$content .= '<form id="account_lifecycle-anonymize-form" action="" method="GET">';
	$content .= "<label>" . elgg_echo('account_lifecycle:simulation') . ' ' . elgg_view('input/select', ['name' => 'anonymize_simulate', 'options_values' => $yes_no_opt, 'value' => $anonymize_simulate]) . "</label><br />";
	$content .= "<label>" . elgg_echo('account_lifecycle:verbose') . ' ' . elgg_view('input/select', ['name' => 'anonymize_verbose', 'options_values' => $yes_no_opt, 'value' => $anonymize_verbose]) . "</label><br />";
	
	$content .= "<label>" . elgg_echo('account_lifecycle:select_users') . ' ' . elgg_view('input/userpicker', ['name' => 'anonymize_users', 'value' => $anonymize_users]) . "</label><br />";
	// Remove email
	$content .= "<p><label>" . elgg_echo('account_lifecycle:remove_email') . ' ' . elgg_view('input/select', ['name' => 'remove_email', 'options_values' => $no_yes_opt, 'value' => $remove_email]) . "</label><br /><em>" . elgg_echo('account_lifecycle:remove_email:details') . "</em></p>";
	// Replace username => userGUID
	$content .= "<p><label>" . elgg_echo('account_lifecycle:replace_username') . ' ' . elgg_view('input/select', ['name' => 'replace_username', 'options_values' => $no_yes_opt, 'value' => $replace_username]) . "</label><br /><em>" . elgg_echo('account_lifecycle:replace_username:details') . "</em></p>";
	// Replace name
	$replacement = elgg_echo('account_lifecycle:replace_name:replacement');
	$content .= "<p><label>" . elgg_echo('account_lifecycle:replace_name') . ' ' . elgg_view('input/select', ['name' => 'replace_name', 'options_values' => $no_yes_opt, 'value' => $replace_name]) . "</label><br /><em>" . elgg_echo('account_lifecycle:replace_name:details', [$replacement]) . "</em></p>";
	// Remove personal data
	$content .= "<p><label>" . elgg_echo('account_lifecycle:remove_profile_data') . ' ' . elgg_view('input/select', ['name' => 'remove_profile_data', 'options_values' => $no_yes_opt, 'value' => $remove_profile_data]) . "</label><br /><em>" . elgg_echo('account_lifecycle:remove_profile_data:details') . "</em></p>";
	// @TODO also clear user settings ? 
	// => no because they are designed to store admin data and settings, and not personal data
	// Remove messages
	$content .= "<p><label>" . elgg_echo('account_lifecycle:remove_messages') . ' ' . elgg_view('input/select', ['name' => 'remove_messages', 'options_values' => $no_yes_opt, 'value' => $remove_messages]) . "</label><br /><em>" . elgg_echo('account_lifecycle:remove_messages:details') . "</em></p>";
	// Remove some objects data - based on subtype and container
	//$content .= "<p><label>" . elgg_echo('account_lifecycle:anonymize:remove_publications') . ' ' . elgg_view('input/select', ['name' => 'remove_publications', 'options_values' => $no_yes_opt, 'value' => $remove_publications]) . "</label></p>";
	
	$content .= elgg_view('input/hidden', ['name' => "anonymize_mode", 'value' => "yes"]);
	$content .= '<p>' . elgg_view('input/submit', ['value' => elgg_echo('account_lifecycle:run_now'), 'class' => "elgg-button elgg-button-action"]) . '</p>';
$content .= '</form>';

// Exécution
if ($anonymize_mode == 'yes') {
	// Build parameters for action function
	$params = [
		'simulation' => ($anonymize_simulate == 'no') ? false : true,   // default true
		'verbose' => ($anonymize_verbose == 'no') ? false : true,   // default true
		'remove_email' => ($remove_email == 'yes') ? true : false,   // default false
		'replace_name' => ($replace_name == 'yes') ? true : false,   // default false
		'replace_username' => ($replace_username == 'yes') ? true : false,   // default false
		'remove_profile_data' => ($remove_profile_data == 'yes') ? true : false,   // default false
		'remove_messages' => ($remove_messages == 'yes') ? true : false,   // default false
		'remove_publications' => ($remove_publications == 'yes') ? true : false,   // default false
	];
	
	$content .= account_lifecycle_execute_anonymization($anonymize_users, $params);
	
	/*
	$content .= '<ul class="elgg-output">';
	foreach($users as $user) {
		$content .= '<li>';
		$content .= '<a href="' . $user->getURL() . '" target="_blank">';
		$content .= '<img src="' . $user->getIconURL('tiny') . '" /> ';
		$content .= "{$user->name} ({$user->guid}, {$user->username}) ";
		$content .= '</a><ul>';
		
		// Remove email (along with password reinit, blocks any attempt to connect)
		if ($remove_email) {
			$user->email = false;
			// Reset password to prevent any further login with (username+password)
			$new_random_password = generate_random_cleartext_password();
			$user->setPassword($new_random_password);
			// set user as unvalidated
			$user->validated = false;
			$user->setValidationStatus(false, 'account_lifecycle anonymize');
			$content .= "<li>email supprimé</li>";
		}
		
		// Remplacement nom du compte
		if ($replace_name) {
			$replacement = elgg_echo('account_lifecycle:replace_name:replacement');
			$user->name = $replacement;
			$content .= "<li>nom du compte supprimé et remplacé par : $replacement</li>";
		}
		
		// Remplacement identifiant (nom d'utilisateur)
		if ($replace_username) {
			$new_username = "user{$user->guid}";
			$user->username = $new_username;
			$content .= "<li>identifiant du compte anonymisé : $new_username</li>";
		}
		
		// Suppression des données du profil
		if ($remove_profile_data) {
			$categorized_fields = profile_manager_get_categorized_fields($user);
			$cats = elgg_extract('categories', $categorized_fields);
			$fields = elgg_extract('fields', $categorized_fields);
			$fields_count = 0;
			foreach ($cats as $cat_guid => $cat) {
				if ($cat_guid == -1) { continue; }
				//$content .= "CAT $cat <pre>" . print_r($field, true) . '</pre>';
				foreach($fields[$cat_guid] as $field) {
					$meta_name = $field->metadata_name;
					$user->$meta_name = null;
					$fields_count++;
				}
			}
			$content .= '<li>' . "$fields_count champs du profil supprimés" . '</li>';
		}
		
		// Suppression des messages privés
		if ($remove_messages) {
			$messages = elgg_get_entities(['type' => 'object', 'subtype' => 'messages', 'owner_guid' => $user->guid, 'limit' => false]);
			foreach($messages as $ent) {
				if ($ent->delete()) { $messages_count++; }
			}
			$content .= '<li>' . "$messages_count messages privés sur " . count($messages) . " supprimés" . '</li>';
		}
		
		// Note : if we have to remove publications, we probably also want to remove the account itself, 
		// which is handled by content_lifecycle (which enables transfering publicaitons before account removal) 
		// -> this feature should be focused on anonymising or removing some objects without removing the account itself
		// @TODO : merge plugins for a unified account and content lifecycle control
		if ($remove_publications) {
			// not implemented yet
		}
		
		$content .= '</ul></li>';
		$user->account_lifecycle_anonymize_last_ts = time();
	}
	$content .= '</ul>';
	
	//$content .= account_lifecycle_execute_rules($anonymize_force_run, $anonymize_simulate, $anonymize_verbose, $anonymize_users);
	*/
}


// SIDEBAR
$sidebar .= elgg_view('account_lifecycle/sidebar', ['selected' => 'check']);


// Sidebar droite
$sidebar_alt .= '';



echo elgg_view_page($title, [
	'title' => elgg_echo('account_lifecycle:anonymize'),
	'content' =>  $content,
	'sidebar' => $sidebar,
	//'sidebar_alt' => $sidebar_alt,
	'class' => 'elgg-chat-layout',
]);

