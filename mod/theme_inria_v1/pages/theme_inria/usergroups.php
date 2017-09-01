<?php
/**
 * This page is used to provide an easy access to (own) profile user image
 * Could be easily updated to give access to any profile icon
 * Note : This respects user access level on avatar visibility
 * 
 */

$help = get_input('help', false);
//$size = get_input('size', "small");
//$embed = get_input('embed', false);
//$username = get_input('username', '');
$limit = get_input('limit', "12");

$title = '';
$content = '';

// Couleurs
$content .= '<style>
html, body, html body { background: #ECECEC !important; margin:0; padding:0; min-width:0; }
h2, h3, a { color: #292A2E; }
h3 { font-size:20px; font-weight:normal; }
a { font-size:16px; }
</style>';


if ($help) {
	header('Content-Type: text/html; charset=utf-8');
	$content .= "<p>Cette page renvoie les groupes de l'utilisateur actuellement connecté.</p>";
	elgg_render_embed_content($content, $title);
	exit;
}

$title = '';
if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
} else {
	// CAS autologin, if CAS detected
	if (elgg_is_active_plugin('elgg_cas') && function_exists('elgg_cas_autologin')) {
		//elgg_cas_autologin(); // Forwards to home if not logged in
		// CAS login
		$own = elgg_cas_login();
	}
}


// Choix de l'user à afficher - celui connecté
if (elgg_instanceof($own, 'user')) { $user = $own; } 

$content .= '<div style="">';

// Vérification si tout est ok pour affichage
if (elgg_instanceof($user, 'user')) {
	// Autorisé si l'user l'autorise, ou si on est connecté sur Iris ou via CAS
	$allowed = esope_user_profile_gatekeeper($user, false);
	if ($allowed || elgg_instanceof($own, 'user')) {
		
		$title = elgg_echo('inria:mygroups:title');
		$content .= '<h3>' . $title . '</h3>';
		
		$groups = elgg_get_entities_from_relationship(array(
				'type' => 'group',
				'relationship' => 'member',
				'relationship_guid' => $own->guid,
				'inverse_relationship' => false,
				'limit' => $limit,
			));
			if ($groups) {
				elgg_push_context('widgets');
				$content .= '<div>';
				foreach ($groups as $group) {
					$content .= '<a href="' . $group->getURL() . '" title="' . $group->name . '" target="_blank"><img src="' . $group->getIconURL('small') . '" style="margin:1px 6px 3px 0;" /></a>';
				}
				$content .= '</div>';
				$content .= '<br />';
				elgg_pop_context();

				$content .= '<p><a href="' . elgg_get_site_url() . 'groups/member/' . $own->username . '" target="_blank"><i class="fa fa-plus-circle"></i> ' . elgg_echo("inria:mygroups") . '</a></p>';
			}
			
		// $content .= '</div>'; // Bloc d'encadrement inutile car seule une partie est utile pour l'intranet
		
	} else {
		$content = elgg_echo('InvalidParameterException:NoEntityFound');
	}
	
} else {
	$content .= elgg_echo('theme_inria:noprofilefound');
}
$content .= '<div class="clearfloat"></div><br />';

/*
if (elgg_is_logged_in()) {
	$content .= '<a class="elgg-button elgg-button-action" href="' . elgg_get_site_url() . '">' . elgg_echo('theme_inria:userprofile:irisopen') . '</a>';
} else {
	$content .= '<a class="elgg-button elgg-button-action" href="' . elgg_get_site_url() . 'login">' . elgg_echo('theme_inria:userprofile:irislogin') . '</a>';
}
*/

$content .= '<div class="clearfloat"></div><br />';
$content .= '</div>';


//elgg_render_embed_content($content = '', $title = '', $embed_mode = 'iframe', $headers);
elgg_render_embed_content($content, $title, 'iframe', null);



