<?php
$plugin = elgg_extract('entity', $vars);

$url = elgg_get_site_url();

// Define select options
$yn_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$ny_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];


// Vérification des pré-requis
echo '<h3>Vérification des pré-requis</h3>';
$dependencies = theme_adf_plugin_dependencies();
$dependencies_content = '';
$missing_required = false;
$missing_optional = false;
$dependencies_content .= '<div class="elgg-content"><h3>' . elgg_echo('theme_adf:requisites') . '</h3>';
$dependencies_content .= '<p>' . elgg_echo('theme_adf:requisites:details') . '</p>';

$dependencies_content .= '<h4>' . elgg_echo('theme_adf:requisites:required') . '</h4>';
$dependencies_content .= '<em>' . elgg_echo('theme_adf:requisites:required:details') . '</em>';
$dependencies_content .= '<ul>';
foreach($dependencies['requires'] as $plugin_dep) {
	$dependencies_content .= '<li>';
		$dependencies_content .= "<a href=\"{$url}admin/plugins#{$plugin_dep}\" target=\"_blank\">{$plugin_dep}</a>&nbsp;: <strong>";
		if (elgg_is_active_plugin($plugin_dep)) {
			$dependencies_content .= '<span style="color: #0A0;">activé</span>';
		} else {
			$dependencies_content .= '<span style="color: #A00;">désactivé</span>';
			$missing_required = true;
		}
	$dependencies_content .= '</strong></li>';
}
$dependencies_content .= '</ul><br />';

$dependencies_content .= '<h4>' . elgg_echo('theme_adf:requisites:suggested') . '</h4>';
$dependencies_content .= '<em>' . elgg_echo('theme_adf:requisites:suggested:details') . '</em>';
$dependencies_content .= '<ul>';
foreach($dependencies['suggests'] as $plugin_dep) {
	$dependencies_content .= '<li>';
		$dependencies_content .= "<a href=\"{$url}admin/plugins#{$plugin_dep}\" target=\"_blank\">{$plugin_dep}</a>&nbsp;: <strong>";
		if (elgg_is_active_plugin($plugin_dep)) {
			$dependencies_content .= '<span style="color: #0A0;">activé</span>';
		} else {
			$dependencies_content .= '<span style="color: #E80;">désactivé</span>';
			$missing_optional = true;
		}
	$dependencies_content .= '</strong></li>';
}
$dependencies_content .= '</ul>';
$dependencies_content .= '</div>';

$hidden_space = 'hidden';
//if ($missing_required || $missing_optional) {
if ($missing_required || $missing_optional) {
	if ($missing_required) {
		$hidden_space = '';
		echo "<p><strong>Des plugins obligatoires ne sont pas activés.</strong></p>";
	}
	if ($missing_optional) {
		echo "<p><strong>Des plugins optionnels ne sont pas activés.</strong></p>";
	}
} else {
	echo "<p><strong>Tous les plugins obligatoires et recommandés sont activés.</strong></p>";
}
echo '<p><a href="javacript: void(0);" onClick="$(\'#theme-adf-dependencies\').slideToggle();" class="elgg-button -elgg-button-action">Afficher/masquer les plugins obligatoires et recommandés</a></p>';
echo '<div id="theme-adf-dependencies" class="' . $hidden_space . '">';
	echo $dependencies_content;
echo '</div>';


echo '<h3>Paramètres de configuration</h3>';

// Texte sur l'accueil
echo '<div><label>' . elgg_echo('theme_adf:settings:home_text') . ' ' . elgg_view('input/longtext', ['name' => 'params[home_text]', 'value' => $plugin->home_text]) . '</label></div>';

// Pied de page
echo '<div><label>' . elgg_echo('theme_adf:settings:footer_text') . ' ' . elgg_view('input/longtext', ['name' => 'params[footer_text]', 'value' => $plugin->footer_text]) . '</label></div>';

// Accueil des pages d'aide (URL)
echo '<h3>' . elgg_echo('theme_adf:settings:help') . '</h3>';
echo '<p><em>' . elgg_echo('theme_adf:settings:help:details') . '</em></p>';
echo '<div><label>' . elgg_echo('theme_adf:settings:help_url') . ' ' . elgg_view('input/url', ['name' => 'params[help_url]', 'value' => $plugin->help_url]) . '</label></div>';
echo '<div><label>' . elgg_echo('theme_adf:settings:help_faq') . ' ' . elgg_view('input/url', ['name' => 'params[help_faq]', 'value' => $plugin->help_faq]) . '</label></div>';
echo '<div><label>' . elgg_echo('theme_adf:settings:help_firststeps') . ' ' . elgg_view('input/url', ['name' => 'params[help_firststeps]', 'value' => $plugin->help_firststeps]) . '</label></div>';
echo '<div><label>' . elgg_echo('theme_adf:settings:contact_email') . ' ' . elgg_view('input/email', ['name' => 'params[contact_email]', 'value' => $plugin->contact_email]) . '</label></div>';



