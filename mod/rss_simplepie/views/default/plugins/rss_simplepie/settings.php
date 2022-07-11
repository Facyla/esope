<?php
$plugin = elgg_extract('entity', $vars);

// Select values
$yes_no_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$no_yes_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];


/*
// Mode direct : activer / sélection comptes (tous/sauf admin) /
echo '<fieldset style="border: 1px solid; padding: 1rem;"><legend><h3>' . elgg_echo('rss_simplepie:settings:direct_mode') . '</h3></legend>';
	echo '<p>' . elgg_echo('rss_simplepie:settings:direct_mode:description') . '</p>';

	// Statut : actif/inactif
	echo '<p><label>' . elgg_echo('rss_simplepie:settings:direct_mode:enable') . elgg_view('input/select', ['name' => 'params[direct_mode]', 'value' => $plugin->direct_mode, 'options_values' => $yes_no_opt]) . '</label><br />' . elgg_echo('rss_simplepie:settings:direct_mode:details') . '</p>';

echo '</fieldset>';
*/


