<?php
global $CONFIG;

$url = elgg_get_site_url();

// Define dropdown options
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));



/*
// Set default value
if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name == 'default'; }


// Example yes/no setting
echo '<p><label>Test select setting "setting_name"</label> ' . elgg_view('input/dropdown', array('name' => 'params[setting_name]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->setting_name)) . '</p>';


// Example text setting
echo '<p><label>Text setting "setting_name2"</label> ' . elgg_view('input/dropdown', array('name' => 'params[setting_name2]', 'value' => $vars['entity']->setting_name2)) . '</p>';
*/

echo '<fieldset><legend>Gestion du menu "Process RH"</legend>';
	
	echo '<label>Entrées du menu : une par ligne, sous la forme : URL::Titre::Infobulle</label> ' . elgg_view('input/plaintext', array('name' => 'params[menu_process]', 'value' => $vars['entity']->menu_process)) . '<br />';
	
echo '</fieldset>';


echo '<p><label>Choix du groupe "Actualités" ';
	echo elgg_view('input/groups_select', array('name' => 'params[newsgroup_guid]', 'value' => $vars['entity']->newsgroup_guid, 'empty_value' => true));
echo '</label><br />Les derniers articles de blog de ce groupe seront affichés sur la page d\'accueil du site.</p>';

echo '<fieldset><legend>Gestion des Pôles</legend>';


	echo '<p><label>Choix du groupe du Pôle droit social et dialogue social ';
		echo elgg_view('input/groups_select', array('name' => 'params[socialgroup_guid]', 'value' => $vars['entity']->socialgroup_guid, 'empty_value' => true));
	echo '<p><label>Choix du groupe du Pôle développement professionnel ';
		echo elgg_view('input/groups_select', array('name' => 'params[devprogroup_guid]', 'value' => $vars['entity']->devprogroup_guid, 'empty_value' => true));
	echo '<p><label>Choix du groupe du Pôle gestion des effectifs et des moyens ';
		echo elgg_view('input/groups_select', array('name' => 'params[gestiongroup_guid]', 'value' => $vars['entity']->gestiongroup_guid, 'empty_value' => true));
echo '</fieldset>';


