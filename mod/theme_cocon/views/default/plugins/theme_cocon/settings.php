<?php 

$plugin = $vars["entity"];

$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );
$count_opt = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);

$site_email = elgg_get_site_entity()->email;

/*
echo '<p><label>Nombre de liens dans le menu Aide</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[help_menu_count]', 'options_values' => $count_opt, 'value' => $vars['entity']->help_menu_count )) . '</p>';

if ($vars['entity']->help_menu_count > 0) {
	for ($i = 1; $i <= $vars['entity']->help_menu_count; $i++) {
		echo '<p><label>Sous-menu n°' . $i . ' (URL::Titre du lien)</label> ' . elgg_view('input/text', array( 'name' => 'params[help_menu_' . $i . ']', 'value' => $vars['entity']->{'help_menu_'.$i} )) . '</p>';
	}
}
*/


//echo '<p><label>Validation manuelle des comptes par un admin</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[admin_validation]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->admin_validation )) . '</p>';


/*
echo "<div>";
echo elgg_echo("html_email_handler:settings:notifications");
echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[notifications]", "options_values" => $noyes_options, "value" => $plugin->notifications));
echo "<div class='elgg-subtext'>" . elgg_echo("html_email_handler:settings:notifications:subtext") . "</div>";
echo "</div>";
*/

echo '<fieldset><legend>Configuration des champs de profil</legend>';
echo '<p><em>Ces champs sont utilisés par le Kit Méthode Cocon</em></p>';

echo "<p><label>Liste des établissements, par issue d'un fichier CSV. Une entrée par ligne, sous la forme : Nom,RNE,Académie,Département,Ville,Adresse postale,adresse courriel fonctionnelle" . elgg_view('input/plaintext', array( 'name' => 'params[etablissements]', 'value' => $vars['entity']->etablissements )) . '</label></p>';

echo "<p><label>Liste des fonctions, une par ligne, sous la forme : identifiant::valeur" . elgg_view('input/plaintext', array( 'name' => 'params[fonctions]', 'value' => $vars['entity']->fonctions )) . '</label></p>';

echo "<p><label>Liste des disciplines, une par ligne, sous la forme :  identifiant::valeur" . elgg_view('input/plaintext', array( 'name' => 'params[disciplines]', 'value' => $vars['entity']->disciplines )) . '</label></p>';

echo '</fieldset>';


