<?php
$plugin = elgg_extract('entity', $vars);

// Select values
$yes_no_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$no_yes_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

/* Interception de la suppression d'un compte utilisateur afin de transférer les contenus non-personnels
 *  - mode automatique : {groupes et types d'objets} => {transfert | suppression} => {entité cible (groupe ou membre)}
 *  - mode manuel : choix des groupes et contenus , et de l'entité cible (soit globalement, soit entité par entité)
 */


echo '<p>' . elgg_view('output/url', ['text' => "Page de contrôle et d'exécution", 'href' => elgg_get_site_url() . "content_lifecycle/", 'class' => "elgg-button elgg-button-action", 'target' => "_blank"]) . '</p>';



/*
// Mode direct : activer / sélection comptes (tous/sauf admin) / 
echo '<fieldset style="border: 1px solid; padding: 1rem;"><legend><h3>' . elgg_echo('content_lifecycle:settings:direct_mode') . '</h3></legend>';
	echo '<p>' . elgg_echo('content_lifecycle:settings:direct_mode:description') . '</p>';

	// Statut : actif/inactif
	echo '<p><label>' . elgg_echo('content_lifecycle:settings:direct_mode:enable') . elgg_view('input/select', ['name' => 'params[direct_mode]', 'value' => $plugin->direct_mode, 'options_values' => $yes_no_opt]) . '</label><br />' . elgg_echo('content_lifecycle:settings:direct_mode:details') . '</p>';


	// Critères de sélection des comptes
	// Admin
	echo '<p><label>' . elgg_echo('content_lifecycle:settings:direct_include_admin') . elgg_view('input/select', ['name' => 'params[direct_include_admin]', 'value' => $plugin->direct_include_admin, 'options_values' => $no_yes_opt]) . '</label></p>';
//	// Métadonnée
//	echo '<p><label>' . elgg_echo('content_lifecycle:settings:direct_metadata_name') . elgg_view('input/text', ['name' => 'params[direct_metadata_name]', 'value' => $plugin->direct_metadata_name]) . '</label></p>';
//	// Valeur (clause =) ou série de valeurs (clause IN)
//	echo '<p><label>' . elgg_echo('content_lifecycle:settings:direct_metadata_value') . elgg_view('input/select', ['name' => 'params[direct_metadata_value]', 'value' => $plugin->direct_metadata_value, 'options_values' => $no_yes_opt]) . '</label></p>';
	
	// Date de début (première exécution) - date limite à laquelle l'action prévue sera effectuée
	//echo '<p><label>' . elgg_echo('content_lifecycle:settings:direct_start_date') . elgg_view('input/date', ['name' => 'params[direct_start_date]', 'value' => $plugin->direct_start_date]) . '</label><br /><em>' . elgg_echo('content_lifecycle:field:start_date:details') . '</em></p>';
	
	// Périodicité (intervale en jours) entre 2 vérifications
	echo '<p><label>' . elgg_echo('content_lifecycle:settings:direct_interval') . elgg_view('input/number', ['name' => 'params[direct_interval]', 'value' => $plugin->direct_interval, 'min' => 1, 'style' => 'max-width: 6rem;']) . '</label><br /><em>' . elgg_echo('content_lifecycle:field:interval:details') . '</em></p>';
	
	// Action à effectuer
	echo '<p><label>' . elgg_echo('content_lifecycle:settings:direct_rule') . elgg_view('input/select', ['name' => 'params[direct_rule]', 'value' => $plugin->direct_rule, 'options_values' => $direct_rule_opt]) . '</label></p>';
	
	// Rappels : notifications de rappel par email (0-n, eg. 1,3,7,30)
	//echo '<p><label>' . elgg_echo('content_lifecycle:settings:direct_reminders') . elgg_view('input/text', ['name' => 'params[direct_reminders]', 'value' => $plugin->direct_reminders]) . '</label><br /><em>' . elgg_echo('content_lifecycle:field:reminders:details') . '</em></p>';
	
	// @TODO Récapitulatif / simulation
//	echo '<div style="background: #DEDEDE; padding: 1rem;">';
//		$select_criteria = ['type' => 'user', 'list_type' => 'gallery'];
//		echo '<p>' . elgg_get_entities($select_criteria + ['count' => true]) . ' comptes utilisateurs concernés</>';
//		echo elgg_list_entities($select_criteria);
//		echo '<p>Prochaine échéance : ' . date('Y-m-d à H:i:s', content_lifecycle_get_next_date()) . '</p>';
//		
//		echo '<p>Prochains rappels : <ul><li>' . implode('</li><li>', content_lifecycle_get_reminders_dates('Y-m-d H:i:s')) . '</li></ul></p>';
//	echo '</div>';
	
	echo '<p>' . elgg_view('output/url', ['text' => "Page de contrôle et d'exécution", 'href' => elgg_get_site_url() . "content_lifecycle/", 'class' => "elgg-button elgg-button-action", 'target' => "_blank"]) . '</p>';
	
echo '</fieldset>';
echo '<br /><br />';
// Direct mode logs
echo '<div class="account-lifecyle-direct-log">';
$logs = elgg_list_annotations(['guid' => $plugin->guid, 'name' => 'direct_mode_log']);
echo "<h4>Historique</h4>" . $logs;
echo '</div>';




// Mode complet : non opérationnel
echo '<fieldset style="border: 1px solid; padding: 1rem;"><legend><h3>' . elgg_echo('content_lifecycle:settings:full_mode') . ' - NON OPERATIONNEL</h3></legend>';
	echo '<p>' . elgg_echo('content_lifecycle:settings:full_mode:description') . '</p>';

	echo '<p><label>' . elgg_echo('content_lifecycle:settings:full_mode:enable') . elgg_view('input/select', ['name' => 'params[full_mode]', 'value' => $plugin->full_mode, 'options_values' => $no_yes_opt]) . '</label><br />' . elgg_echo('content_lifecycle:settings:full_mode:details') . '</p>';

	// Règles de gestion des comptes utilsateur
	echo '<p>' . elgg_view('output/url', ['text' => "Ajouter une règle de gestion des comptes", 'href' => "content_lifecycle/add", 'is_action' => true, 'class' => 'elgg-button elgg-button-action']) . '</p>';
	echo elgg_list_entities(['type' => 'object', 'subtype' => 'content_lifecycle', 'no_results' => "Aucune règle de gestion des comptes"]);
echo '</fieldset>';
*/


