<?php
/**
* Affiche des informations propres à l'utilisateur : contacts, invitations, demandes...
*/

$user = elgg_extract("user", $vars, elgg_get_logged_in_user_entity());
$own_infos = elgg_view('theme_adf/home-user-infos', ['user' => $user]);

if ($own_infos) {
	$title = elgg_echo('theme_adf:digest:own_infos');
	echo elgg_view_module("digest", $title, $own_infos);
}

