<?php 

$plugin = $vars["entity"];

$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );
$count_opt = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);

$site_email = elgg_get_site_entity()->email;

echo '<p><label>Nombre de liens dans le menu Aide</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[help_menu_count]', 'options_values' => $count_opt, 'value' => $vars['entity']->help_menu_count )) . '</p>';

if ($vars['entity']->help_menu_count > 0) {
	for ($i = 1; $i <= $vars['entity']->help_menu_count; $i++) {
		echo '<p><label>Sous-menu n°' . $i . ' (URL::Titre du lien)</label> ' . elgg_view('input/text', array( 'name' => 'params[help_menu_' . $i . ']', 'value' => $vars['entity']->{'help_menu_'.$i} )) . '</p>';
	}
}

echo '<h3>Notification de création des comptes</h3>';

echo "<p>Vous pouvez définir jusqu'à 3 personnes qui seront prévenues par mail de la création de tout nouveau compte par des membres Inria</p>";

echo '<p><label>Identifiant 1 </label> ' . elgg_view('input/text', array( 'name' => 'params[useradd_notify1]', 'value' => $vars['entity']->{'useradd_notify1'} )) . '</p>';

echo '<p><label>Identifiant 2 </label> ' . elgg_view('input/text', array( 'name' => 'params[useradd_notify2]', 'value' => $vars['entity']->{'useradd_notify2'} )) . '</p>';

echo '<p><label>Identifiant 3 </label> ' . elgg_view('input/text', array( 'name' => 'params[useradd_notify3]', 'value' => $vars['entity']->{'useradd_notify3'} )) . '</p>';


echo '<h3>Modération des invitations à rejoindre Iris</h3>';

echo "<p>Vous pouvez choisir de ne pas activer les comptes, et requérir une validaiton manuelle par un administrateur.<br />Note : l'activation de cette fonctionnalité nécesssite que le plugin \"User validation by admin\" soit activé (et \"User validation by email désactivé\").</p>";

echo '<p><label>Validation manuelle des comptes par un admin</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[admin_validation]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->admin_validation )) . '</p>';

if (($vars['entity']->admin_validation == 'yes') && !elgg_is_active_plugin('uservalidationbyadmin')) {
	register_error("Attention : le plugin uservalidationbyadmin n'est pas activé !  Les comptes créés ne pourront pas être activés !");
} else {
	echo " &nbsp; <strong>OK - plugin uservalidationbyadmin activé</strong>";
}


/*
echo "<div>";
echo elgg_echo("html_email_handler:settings:notifications");
echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[notifications]", "options_values" => $noyes_options, "value" => $plugin->notifications));
echo "<div class='elgg-subtext'>" . elgg_echo("html_email_handler:settings:notifications:subtext") . "</div>";
echo "</div>";
*/

echo "</div>";

