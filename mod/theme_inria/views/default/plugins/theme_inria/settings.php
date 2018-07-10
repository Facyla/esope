<?php 

$plugin = $vars["entity"];

$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));
$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));
$count_opt = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);

$site_email = elgg_get_site_entity()->email;

// Defaults
if (!isset($vars['entity']->home_slider)) { $vars['entity']->home_slider = 'home_slider'; }


// Auto-corrections
if (!empty($vars['entity']->home_slider)) { $vars['entity']->home_slider = elgg_get_friendly_title($vars['entity']->home_slider); }
echo '<fieldset><legend>Gestion du menu "Aide"</legend>';
	
	echo '<p><label>Nombre de liens dans le menu Aide</label> ' . elgg_view('input/select', array( 'name' => 'params[help_menu_count]', 'options_values' => $count_opt, 'value' => $vars['entity']->help_menu_count )) . '</p>';
	
	if ($vars['entity']->help_menu_count > 0) {
		// FR
		echo '<p><strong>Menu par défaut (version française)</strong><br />';
		for ($i = 1; $i <= $vars['entity']->help_menu_count; $i++) {
			echo '<label>Sous-menu n°' . $i . ' (URL::Titre du lien)</label> ' . elgg_view('input/text', array( 'name' => 'params[help_menu_' . $i . ']', 'value' => $vars['entity']->{'help_menu_'.$i} )) . '<br />';
		}
		echo '</p>';
	
		// EN
		echo '<p><strong>Menu en anglais</strong><br />';
		for ($i = 1; $i <= $vars['entity']->help_menu_count; $i++) {
			echo '<label>Sub-menu n°' . $i . ' (URL::Link title)</label> ' . elgg_view('input/text', array( 'name' => 'params[help_menu_' . $i . '_en]', 'value' => $vars['entity']->{'help_menu_'.$i.'_en'} )) . '<br />';
		}
		echo '</p>';
	}
echo '</fieldset>';


echo '<fieldset><legend>Gestion des inscriptions</legend>';
	echo "<p>Iris est ouvert à toute personne disposant d'un compte LDAP valide.</p>";
	echo '<h3>Modération des invitations à rejoindre Iris</h3>';

	echo "<p>Vous pouvez choisir de ne pas activer les comptes, et requérir une validaiton manuelle par un administrateur.<br />Note : l'activation de cette fonctionnalité nécesssite que le plugin \"User validation by admin\" soit activé (et \"User validation by email désactivé\").</p>";

	echo '<p><label>Validation manuelle des comptes par un admin</label> ' . elgg_view('input/select', array( 'name' => 'params[admin_validation]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->admin_validation )) . '</p>';

	if (($vars['entity']->admin_validation == 'yes') && !elgg_is_active_plugin('uservalidationbyadmin')) {
		register_error("Attention : le plugin uservalidationbyadmin n'est pas activé !  Les comptes créés ne pourront pas être activés !");
	} else {
		echo " &nbsp; <strong>OK - plugin uservalidationbyadmin activé</strong>";
	}

	/*
	echo "<div>";
	echo elgg_echo("html_email_handler:settings:notifications");
	echo "&nbsp;" . elgg_view("input/select", array("name" => "params[notifications]", "options_values" => $noyes_options, "value" => $plugin->notifications));
	echo "<div class='elgg-subtext'>" . elgg_echo("html_email_handler:settings:notifications:subtext") . "</div>";
	echo "</div>";
	*/
echo '</fieldset>';


echo '<fieldset><legend>Notification de création des comptes</legend>';
	echo '<p>';
	echo "Vous pouvez définir jusqu'à 3 personnes qui seront prévenues par mail de la création de tout nouveau compte par des membres Inria</p>";
	echo '<label>Identifiant 1 </label> ' . elgg_view('input/text', array( 'name' => 'params[useradd_notify1]', 'value' => $vars['entity']->{'useradd_notify1'} )) . '<br />';
	echo '<label>Identifiant 2 </label> ' . elgg_view('input/text', array( 'name' => 'params[useradd_notify2]', 'value' => $vars['entity']->{'useradd_notify2'} )) . '<br />';
	echo '<label>Identifiant 3 </label> ' . elgg_view('input/text', array( 'name' => 'params[useradd_notify3]', 'value' => $vars['entity']->{'useradd_notify3'} ));
	echo '</p>';
echo '</fieldset>';


echo '<fieldset><legend>Blocage des notifications des Discussions dans certains groupes</legend>';
	echo "<p>Ceci permet de bloquer totalement l'envoi de notifications dans certains groupes, quels que soient les réglages de notifications définis dans ce groupe. L'intérêt est d'éviter de recevoir des flots d'email lors de l'utilisation d'applications mobiles ou de systèmes d'actualisation des discussions en temps réel.</p>";
	echo '<p><label>GUID des groupes (guid1, guid2, etc.) </label> ' . elgg_view('input/text', array( 'name' => 'params[block_notif_forum_groups]', 'value' => $vars['entity']->{'block_notif_forum_groups'} )) . '</p>';
	echo '<p><label>Bloquer les notifications lors de la création de nouveaux sujets</label> ' . elgg_view('input/select', array( 'name' => 'params[block_notif_forum_groups_object]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->block_notif_forum_groups_object)) . '</p>';
	echo '<p><label>Bloquer les notifications des réponses</label> ' . elgg_view('input/select', array( 'name' => 'params[block_notif_forum_groups_replies]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->block_notif_forum_groups_replies)) . '</p>';
echo '</fieldset>';


echo "<fieldset><legend>Activation du cron d'actualisation des données LDAP</legend>";
	echo '<p><label>Activer le cron quotidien de synchronisation des donnes LDAP ' . elgg_view('input/select', array( 'name' => 'params[ldap_cron]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->ldap_cron)) . '</label></p>';
echo '</fieldset>';


//Homepage slider
echo "<p>
	<label>GUID ou identifiant du slider à afficher sur l'accueil " . elgg_view('input/text', array('name' => 'params[home_slider]', 'value' => $vars['entity']->home_slider)) . '</label><br />
	<a href="' . elgg_get_site_url() . 'slider" class="" target="_blank">Afficher la liste des sliders disponibles</a>
	</p>';



// TransAlgo
echo '</div>';

echo '<div class="elgg-head"><h3>Configuration TransAlgo</h3></div>';
echo '<div class="elgg-body">';
	echo "<p><label>Page de redirection après connexion (URL complète) " . elgg_view('input/text', array('name' => 'params[login_redirect]', 'value' => $vars['entity']->login_redirect)) . '</label></p>';
echo '</div>';


