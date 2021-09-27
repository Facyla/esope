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
			$dependencies_content .= "activé";
		} else {
			$dependencies_content .= "désactivé";
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
			$dependencies_content .= "activé";
		} else {
			$dependencies_content .= "désactivé";
			$missing_optional = true;
		}
	$dependencies_content .= '</strong></li>';
}
$dependencies_content .= '</ul>';
$dependencies_content .= '</div>';

if ($missing_required || $missing_optional) {
	if ($missing_required) {
		echo "<p><strong>Des plugins obligatoires ne sont pas activés.</strong></p>";
	}
	if ($missing_optional) {
		echo "<p><strong>Des plugins optionnels ne sont pas activés.</strong></p>";
	}
	echo $dependencies_content;
} else {
	echo "<p><strong>Tous les plugins obligatoires et recommandés sont activés.</strong></p>";
}


echo '<h3>Paramètres de configuration</h3>';

// Texte sur l'accueil
echo '<div><label>' . elgg_echo('theme_adf:settings:home_text') . ' ' . elgg_view('input/longtext', ['name' => 'params[home_text]', 'value' => $plugin->home_text]) . '</label></div>';

// Pied de page
echo '<div><label>' . elgg_echo('theme_adf:settings:footer_text') . ' ' . elgg_view('input/longtext', ['name' => 'params[footer_text]', 'value' => $plugin->footer_text]) . '</label></div>';

// Accueil des pges d'aide (URL)
echo '<div><label>' . elgg_echo('theme_adf:settings:help_url') . ' ' . elgg_view('input/url', ['name' => 'params[help_url]', 'value' => $plugin->help_url]) . '</label></div>';



