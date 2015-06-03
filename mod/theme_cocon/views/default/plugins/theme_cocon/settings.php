<?php 
$plugin = $vars["entity"];
$site = elgg_get_site_entity();
$site_email = $site->email;

$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );
$count_opt = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);

if (empty($vars['entity']->fonctions)) {
	$vars['entity']->fonctions = "chef::Chef d'établissement
chefadjoint::Chef d'établissement adjoint
cpe::CPE
direction::Equipe de direction
projet::Equipe de projet
enseignant::Enseignant
autre::Autre";
}


if (empty($vars['entity']->disciplines)) {
	$vars['entity']->disciplines = "francais::Français
maths::Mathématiques
histgeo::Histoire-Géographie
langues::Langues vivantes
physique::Sciences Physiques
svt::Sciences de la Vie et de la Terre
technologie::Technologie
musique::Education Musicale
artplastique::Arts Plastiques
eps::Education Physique et Sportive
autre::Autres";
}

if (!isset($vars['entity']->email_logo)) { $vars['entity']->email_logo$site->url . 'mod/theme_cocon/graphics/email/logo_cocon.png'; } }



echo '<fieldset><legend>Eléments de configuration visuelle</legend>';
	// Cocon default header
	$url = elgg_get_site_url();
	$urlimg = $url . 'mod/theme_cocon/graphics/';
	$header_content = '<img class="ministere" src="' . $urlimg . 'header_ministere.jpg" /><a href="' . $url . '" title="' . elgg_echo('adf_platform:gotohomepage') . '"><img class="cocon" src="' . $urlimg . 'header_cocon.png" style="margin-left:14px;" /></a><img class="cartouche" src="' . $urlimg . 'cartouche_strategie_numerique.png" />';
	echo "Configuration du bandeau : pour le bandeau Cocon \"standard\", copiez-collez le code suivant dans la configuration du thème : ";
	echo '<textarea readonly="readonly">' . $header_content . '</textarea>';
	
	
	echo "<p><label>Image à utiliser en entête des notification par email et des résumés périodiques d'activité" . elgg_view('input/text', array( 'name' => 'params[email_logo]', 'value' => $vars['entity']->email_logo )) . '</label></p>';
	if (!empty($vars['entity']->email_logo)) {
		echo '<p>Image actuelle : <a href="' . $vars['entity']->email_logo . '" target="_blank">' . $vars['entity']->email_logo . '</a></p>';
	} else {
		echo '<p>Image actuelle : aucune (l\'image par défaut serra utilisée)</p>';
	}

echo '</fieldset>';



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

	echo "<p><label>Liste des fonctions, une par ligne, sous la forme : identifiant::valeur" . elgg_view('input/plaintext', array( 'name' => 'params[fonctions]', 'value' => $vars['entity']->fonctions )) . '</label></p>';

	echo "<p><label>Liste des disciplines, une par ligne, sous la forme :  identifiant::valeur" . elgg_view('input/plaintext', array( 'name' => 'params[disciplines]', 'value' => $vars['entity']->disciplines )) . '</label></p>';

	// @TODO : accepter liste CSV avec structure simple : 1/ligne, sép=,
	// Champs = Nom,RNE,Académie,Département,Ville,Adresse postale,adresse courriel fonctionnelle
	echo "<p><label>Liste des établissements<br />Format : Nom;Académie;UAI;Département;Adresse;mail<br />Attention : une entrée par ligne, et pas de ligne de titre !" . elgg_view('input/plaintext', array( 'name' => 'params[etablissements]', 'value' => $vars['entity']->etablissements )) . '</label></p>';
echo '</fieldset>';



