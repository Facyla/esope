<?php 

$plugin = $vars["entity"];

$count_opt = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);


$site_email = elgg_get_site_entity()->email;

	echo '<p><label>Nombre de liens dans le menu Aide</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[help_menu_count]', 'options_values' => $count_opt, 'value' => $vars['entity']->help_menu_count )) . '</p>';

if ($vars['entity']->help_menu_count > 0) {
	for ($i = 1; $i <= $vars['entity']->help_menu_count; $i++) {
		echo '<p><label>Sous-menu n°' . $i . ' (URL::Titre du lien)</label> ' . elgg_view('input/text', array( 'name' => 'params[help_menu_' . $i . ']', 'value' => $vars['entity']->{'help_menu_'.$i} )) . '</p>';
	}
}

echo '<br />';

echo "<p>Vous pouvez définir jusqu'à 3 personnes qui seront prévenues par mail de la création de tout nouveau compte par des membres Inria</p>";

echo '<p><label>Identifiant 1 </label> ' . elgg_view('input/text', array( 'name' => 'params[useradd_notify1]', 'value' => $vars['entity']->{'useradd_notify1'} )) . '</p>';

echo '<p><label>Identifiant 2 </label> ' . elgg_view('input/text', array( 'name' => 'params[useradd_notify2]', 'value' => $vars['entity']->{'useradd_notify2'} )) . '</p>';

echo '<p><label>Identifiant 3 </label> ' . elgg_view('input/text', array( 'name' => 'params[useradd_notify3]', 'value' => $vars['entity']->{'useradd_notify3'} )) . '</p>';


/*
echo "<div>";
echo elgg_echo("html_email_handler:settings:notifications");
echo "&nbsp;" . elgg_view("input/dropdown", array("name" => "params[notifications]", "options_values" => $noyes_options, "value" => $plugin->notifications));
echo "<div class='elgg-subtext'>" . elgg_echo("html_email_handler:settings:notifications:subtext") . "</div>";
echo "</div>";
*/

echo "</div>";

