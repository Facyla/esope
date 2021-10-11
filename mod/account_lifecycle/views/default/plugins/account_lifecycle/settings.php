<?php
$plugin = elgg_extract('entity', $vars);

// Select values
$yes_no_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$no_yes_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

$direct_rule_opt = account_lifecycle_direct_rule_options();
$direct_criteria_opt = account_lifecycle_direct_criteria_options();


// Mode direct : activer / sélection comptes (tous/sauf admin) / 
echo '<fieldset style="border: 1px solid; padding: 1rem;"><legend><h3>' . elgg_echo('account_lifecycle:settings:direct_mode') . '</h3></legend>';
	echo '<p>' . elgg_echo('account_lifecycle:settings:direct_mode:description') . '</p>';

	// Statut : actif/inactif
	echo '<p><label>' . elgg_echo('account_lifecycle:settings:direct_mode:enable') . elgg_view('input/select', ['name' => 'params[direct_mode]', 'value' => $plugin->direct_mode, 'options_values' => $yes_no_opt]) . '</label><br />' . elgg_echo('account_lifecycle:settings:direct_mode:details') . '</p>';


	// Critères de sélection des comptes
	// Admin
	echo '<p><label>' . elgg_echo('account_lifecycle:settings:direct_include_admin') . elgg_view('input/select', ['name' => 'params[direct_include_admin]', 'value' => $plugin->direct_include_admin, 'options_values' => $no_yes_opt]) . '</label></p>';
	/*
	// Métadonnée
	echo '<p><label>' . elgg_echo('account_lifecycle:settings:direct_metadata_name') . elgg_view('input/text', ['name' => 'params[direct_metadata_name]', 'value' => $plugin->direct_metadata_name]) . '</label></p>';
	// Valeur (clause =) ou série de valeurs (clause IN)
	echo '<p><label>' . elgg_echo('account_lifecycle:settings:direct_metadata_value') . elgg_view('input/select', ['name' => 'params[direct_metadata_value]', 'value' => $plugin->direct_metadata_value, 'options_values' => $no_yes_opt]) . '</label></p>';
	*/
	
	// Date de début (première exécution) - date limite à laquelle l'action prévue sera effectuée
	//echo '<p><label>' . elgg_echo('account_lifecycle:settings:direct_start_date') . elgg_view('input/date', ['name' => 'params[direct_start_date]', 'value' => $plugin->direct_start_date]) . '</label><br /><em>' . elgg_echo('account_lifecycle:field:start_date:details') . '</em></p>';
	
	// Périodicité (intervale en jours) entre 2 vérifications
	echo '<p><label>' . elgg_echo('account_lifecycle:settings:direct_interval') . elgg_view('input/number', ['name' => 'params[direct_interval]', 'value' => $plugin->direct_interval, 'min' => 1, 'style' => 'max-width: 6rem;']) . '</label><br /><em>' . elgg_echo('account_lifecycle:field:interval:details') . '</em></p>';
	
	// Action à effectuer
	echo '<p><label>' . elgg_echo('account_lifecycle:settings:direct_rule') . elgg_view('input/select', ['name' => 'params[direct_rule]', 'value' => $plugin->direct_rule, 'options_values' => $direct_rule_opt]) . '</label></p>';
	
	// Rappels : notifications de rappel par email (0-n, eg. 1,3,7,30)
	//echo '<p><label>' . elgg_echo('account_lifecycle:settings:direct_reminders') . elgg_view('input/text', ['name' => 'params[direct_reminders]', 'value' => $plugin->direct_reminders]) . '</label><br /><em>' . elgg_echo('account_lifecycle:field:reminders:details') . '</em></p>';
	
	// @TODO Récapitulatif / simulation
	/*
	echo '<div style="background: #DEDEDE; padding: 1rem;">';
		$select_criteria = ['type' => 'user', 'list_type' => 'gallery'];
		echo '<p>' . elgg_get_entities($select_criteria + ['count' => true]) . ' comptes utilisateurs concernés</>';
		echo elgg_list_entities($select_criteria);
		echo '<p>Prochaine échéance : ' . date('Y-m-d à H:i:s', account_lifecycle_get_next_date()) . '</p>';
		
		echo '<p>Prochains rappels : <ul><li>' . implode('</li><li>', account_lifecycle_get_reminders_dates('Y-m-d H:i:s')) . '</li></ul></p>';
	echo '</div>';
	*/
	
	// Page de contrôle et d'exécution
	echo '<p>' . elgg_view('output/url', ['text' => "Page de contrôle et d'exécution", 'href' => elgg_get_site_url() . "account_lifecycle/", 'class' => "elgg-button elgg-button-action", 'target' => "_blank"]) . '</p>';
	
	// Lien vers la page de statistiques
	echo '<p>' . elgg_view('output/url', ['href' => "{$url}account_lifecycle/statistics", 'text' => elgg_echo('account_lifecycle:settings:adminlink'), 'class' => "elgg-button elgg-button-action"]) . '</p>';
	
echo '</fieldset>';
echo '<br /><br />';
// Direct mode logs
echo '<div class="account-lifecyle-direct-log">';
$logs = elgg_list_annotations(['guid' => $plugin->guid, 'name' => 'direct_mode_log']);
echo "<h4>Historique</h4>" . $logs;
echo '</div>';




// Mode complet : non opérationnel
echo '<fieldset style="border: 1px solid; padding: 1rem;"><legend><h3>' . elgg_echo('account_lifecycle:settings:full_mode') . ' - NON OPERATIONNEL</h3></legend>';
	echo '<p>' . elgg_echo('account_lifecycle:settings:full_mode:description') . '</p>';

	echo '<p><label>' . elgg_echo('account_lifecycle:settings:full_mode:enable') . elgg_view('input/select', ['name' => 'params[full_mode]', 'value' => $plugin->full_mode, 'options_values' => $no_yes_opt]) . '</label><br />' . elgg_echo('account_lifecycle:settings:full_mode:details') . '</p>';

	// Règles de gestion des comptes utilsateur
	echo '<p>' . elgg_view('output/url', ['text' => "Ajouter une règle de gestion des comptes", 'href' => "account_lifecycle/add", 'is_action' => true, 'class' => 'elgg-button elgg-button-action']) . '</p>';
	echo elgg_list_entities(['type' => 'object', 'subtype' => 'account_lifecycle', 'no_results' => "Aucune règle de gestion des comptes"]);
echo '</fieldset>';




/*
// Defaults
création de batches de gestion du cycle de vie = sélection de comptes + règles de gestion
- sélection : comptes admin non/oui, série de metadata => comparaison (==, !=, IN, NOT IN, >, <, <=, >=...), valeur
- règles : exiger une nouvelle validation par email / sur le site, archiver, désactiver (ban)


if (!isset($vars['entity']->extend_registration_form)) { $vars['entity']->extend_registration_form = 'yes'; }
if (!isset($vars['entity']->whitelist_enable)) { $vars['entity']->whitelist_enable = 'yes'; }
if (strlen($vars['entity']->whitelist) == 0) { $vars['entity']->whitelist = elgg_echo('registration_filter:whitelist:default'); } // Default valid domain list
if (!isset($vars['entity']->blacklist_enable)) { $vars['entity']->blacklist_enable = 'no'; }


// Note : only one of the modes should be chosen : if whitelist enable, blacklist is not useful
echo '<p><em>' . elgg_echo('registration_filter:modes') . '</em></p>';

echo '<fieldset>';
	// Enable whitelist : only matching domains are allowed
	echo '<p><label>' . elgg_echo('registration_filter:whitelist_enable') . ' ' . elgg_view('input/select', array('name' => 'params[params[whitelist_enable]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->whitelist_enable)) . '</label><br /><em>' . elgg_echo('registration_filter:whitelist_enable:details') . '</em></p>';

	// Whitelist options
	if ($vars['entity']->whitelist_enable == 'yes') {
		// Extend registration form ?
		echo '<p><label>' . elgg_echo('registration_filter:extend_registration_form') . ' ' . elgg_view('input/select', array('name' => 'params[params[extend_registration_form]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->extend_registration_form)) . '</label><br /><em>' . elgg_echo('registration_filter:extend_registration_form:details') . '</em></p>';

		// Whitelist domains
		// un nom de domaine par ligne demandé (plus clair), mais on acceptera aussi séparé par virgules et point-virgule en pratique
		echo '<p><label>' . elgg_echo('registration_filter:whitelist') . ' ' . elgg_view('input/plaintext', array('name' => 'params[params[whitelist]]', 'value' => $vars['entity']->whitelist )) . '</label><br /><em>' . elgg_echo('registration_filter:whitelist:details') . '</em></p>';
	}
echo '</fieldset>';


echo '<fieldset>';
	// Enable blacklist : matching domains are always forbidden
	echo '<p><label>' . elgg_echo('registration_filter:blacklist_enable') . ' ' . elgg_view('input/select', array('name' => 'params[params[blacklist_enable]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->blacklist_enable)) . '</label><br /><em>' . elgg_echo('registration_filter:blacklist_enable:details') . '</em></p>';

	// Blacklist domains
	if ($vars['entity']->blacklist_enable == 'yes') {
		// un nom de domaine par ligne demandé (plus clair), mais on acceptera aussi séparé par virgules et point-virgule en pratique
		echo '<p><label>' . elgg_echo('registration_filter:blacklist') . ' ' . elgg_view('input/plaintext', array('name' => 'params[params[blacklist]]', 'value' => $vars['entity']->blacklist )) . '</label><br /><em>' . elgg_echo('registration_filter:blacklist:details') . '</em></p>';
	}
echo '</fieldset>';
*/


