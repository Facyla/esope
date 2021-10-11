<?php
$plugin = elgg_extract('entity', $vars);

$url = elgg_get_site_url();

// Define select options
$yn_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$ny_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];

// Preset / default configuration


// Clean up and save again settings configuration
$config = gdpr_consent_get_current_config();
$plaintext_config = gdpr_consent_get_settings_from_config($config);
$plugin->consent_config = $plaintext_config;

echo '<h3>Paramètres de configuration</h3>';
echo '<p>' . elgg_echo('gdpr_consent:settings:details') . '</p>';

/*
Devrait conserver pour chaque utilisateur (plugin user setting) la nature + la version + date de validation des documents concernés (car il peut y en avoir plusieurs, et avec des versions différentes).
Config plugin : liste des documents (type + URL + titre + version).
*/

// Lien vers la page de statistiques
echo '<p>' . elgg_view('output/url', ['href' => "{$url}gdpr_consent", 'text' => elgg_echo('gdpr_consent:settings:adminlink'), 'class' => "elgg-button elgg-button-action"]) . '</p>';


// Configuration des documents à valider : key|URL|Title|Version, eg. privacy|https://mysite.com/privacy|Politique de confidentialité|0.1
echo '<div><label for="consent_config">' . elgg_echo('gdpr_consent:settings:consent_config') . '</label><br />';
echo '<p><em>' . elgg_echo('gdpr_consent:settings:consent_config:details') . '</em>';
echo elgg_view('input/plaintext', ['name' => 'params[consent_config]', 'id' => 'consent_config', 'value' => $plugin->consent_config]);
echo '</div>';


