<?php
require_once dirname(dirname(dirname(__FILE__))) . '/engine/start.php';

$username = get_input('username', false);

$user = get_user_by_username($username);

echo "Créé : " . elgg_view_friendly_time($user->time_created) . '<hr />';
echo "Mis à jour : " . elgg_view_friendly_time($user->time_updated) . '<hr />';
echo "Dernière action : " . elgg_view_friendly_time($user->last_action) . '<hr />';
echo "Avant-dernière action : " . elgg_view_friendly_time($user->prev_last_action) . '<hr />';
echo "Dernier login : " . elgg_view_friendly_time($user->last_login) . '<hr />';
echo "Avant-dernier login : " . elgg_view_friendly_time($user->prev_last_login) . '<hr />';

echo "Type de compte : " . elgg_view_friendly_time($user->membertype) . '<hr />';
echo "Statut du compte : " . elgg_view_friendly_time($user->membertype) . '<hr />';

