<?php
$url = elgg_get_site_url();

// Define dropdown options
//$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );

// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name = 'default'; }

// Set defaults
if (!isset($vars['entity']->fing_api_auth_url)) { $vars['entity']->fing_api_auth_url = 'http://reseau.fing.org/services/api/rest/json/?method=fing.external.auth'; }


// Define Site menus replacement ?
$menus_options = elgg_menus_menus_opts();

//echo "Choose custom site menus";
echo '<fieldset><legend>Choisissez les menus du site</legend>';

	/*
	echo '<p><label>Topbar menu ' . elgg_view('input/dropdown', array('name' => 'params[menu_topbar]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_topbar)) . '</label></p>';

	echo '<p><label>Page menu ' . elgg_view('input/dropdown', array('name' => 'params[menu_page]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_page)) . '</label></p>';
	*/

	echo '<p><label>Site menu (main navigation) ' . elgg_view('input/dropdown', array('name' => 'params[menu_site]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_site)) . '</label> &nbsp; ';
	echo '<a href="' . elgg_get_site_url() . 'admin/appearance/menus?menu_name=' . $vars['entity']->menu_site . '" target="_blank" class="elgg-button elgg-button-action">Editer le menu ' . $vars['entity']->menu_site . '</a></p>';

	echo '<p><label>Footer menu ' . elgg_view('input/dropdown', array('name' => 'params[menu_footer]', 'options_values' => $menus_options, 'value' => $vars['entity']->menu_footer)) . '</label> &nbsp; ';
	echo '<a href="' . elgg_get_site_url() . 'admin/appearance/menus?menu_name=' . $vars['entity']->menu_footer . '" target="_blank" class="elgg-button elgg-button-action">Editer le menu ' . $vars['entity']->menu_footer . '</a></p>';

echo '</fieldset>';


echo '<fieldset>';
	echo '<legend>Administrateurs</legend>';
	echo "<h3>Liste des administrateurs contenus</h3>";
	echo "<p><em>Les administrateurs contenus disposent de tous les droits d'édition sur les contenus du site.</em></p>";
	echo elgg_list_entities(array('list_type' => "gallery"), 'theme_transitions_get_content_admins');
	echo '<div class="clearfloat"></div>';

	echo "<h3>Liste des administrateurs platforme</h3>";
	echo "<p><em>Les administrateurs plateforme disposent de tous les droits des administrateurs contenus, plus divers droits notamment la gestion des utilisateurs, de la Une et de la newsletter.</em></p>";
	echo elgg_list_entities(array('list_type' => "gallery"), 'theme_transitions_get_content_admins');
	echo '<div class="clearfloat"></div>';

	echo "<h3>Liste des administrateurs globaux</h3>";
	echo "<p><em>Les administrateurs plateforme disposent de tous les droits des administrateurs plateforme, plus l'accès complet au backoffice.</em></p>";
	echo elgg_list_entities(array('list_type' => "gallery"), 'elgg_get_admins');
	echo '<div class="clearfloat"></div>';

echo '</fieldset>';


// Auth API (from RSFing)
echo '<fieldset>';
	echo '<legend>Authentification via le réseau Fing</legend>';
	echo '<p><label>URL d\'authentification ' . elgg_view('input/text', array('name' => 'params[fing_api_auth_url]', 'value' => $vars['entity']->fing_api_auth_url)) . '</label></p>';
	echo '<p><label>Clef API publique ' . elgg_view('input/text', array('name' => 'params[fing_api_publickey]', 'value' => $vars['entity']->fing_api_publickey)) . '</label></p>';
	echo '<p><label>Clef API privée ' . elgg_view('input/text', array('name' => 'params[fing_api_privatekey]', 'value' => $vars['entity']->fing_api_privatekey)) . '</label></p>';
echo '</fieldset>';



echo '<fieldset>';
	echo '<legend>Pied de page</legend>';
	echo '<p><label>Footer gauche : Impulsé par... ' . elgg_view('input/plaintext', array('name' => 'params[footer_left]', 'value' => $vars['entity']->footer_left)) . '</label></p>';
	echo '<p><label>Footer droit : Soutenu par... ' . elgg_view('input/plaintext', array('name' => 'params[footer_right]', 'value' => $vars['entity']->footer_right)) . '</label></p>';
echo '</fieldset>';




