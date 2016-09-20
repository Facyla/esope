<?php
// 3 méthodes d'inscription : Fing, pré-remplissage via RS, et inscription

echo '<p class="transitions2-register-subtitle">' . elgg_echo('theme_transitions:register:subtitle') . '</p>';
echo '<hr />';
echo '<h3>' . elgg_echo('theme_transitions:registerwithfing:title') . '</h3>';
echo '<p>' . elgg_echo('theme_transitions:registerwithfing') . '</p>';

if (elgg_is_active_plugin('hybridauth')) {
	echo '<hr />';
	echo '<h3>' . elgg_echo('theme_transitions:registerwithhybridauth:title') . '</h3>';
}

