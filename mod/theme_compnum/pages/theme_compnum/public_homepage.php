<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

global $CONFIG;

$site = elgg_get_site_entity();
$title = $site->name;

// Formulaire de renvoi du mot de passe
$lostpassword_form = '<div id="adf-lostpassword" style="display:none;">';
//$lostpassword_form = '<h2>' . elgg_echo('user:password:lost') . '</h2>';
$lostpassword_form .= elgg_view_form('user/requestnewpassword');
$lostpassword_form .= '</div>';

// Formulaire d'inscription
if (elgg_get_config('allow_registration')) {
  $register_form = elgg_view_form('register', array(), array('friend_guid' => (int) get_input('friend_guid', 0), 'invitecode' => get_input('invitecode') ));
}

$content = '';

$content .= '<style>
body > section { padding-top:0; }
</style>';
$content .= '<div style="width:100%;">';
$content .= elgg_view('slider/slider', array());
$content .= '</div>';

$content .= '<div id="adf-homepage" class="interne">';

/*
texte d'accueil (idem celui en mode intranet)
liste des groupes publics (icône + titre) - aléatoire parmi les groupes en Une
fil d'activité global

bloc agenda
bloc de connexion
bloc d'inscription
*/



$intro = elgg_get_plugin_setting('homeintro', 'adf_public_platform');
if (!empty($intro)) $content .= '<div id="home_intro">' . $intro . '</div><div class="clearfloat"></div>';




//$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => '', ));
$body = $content;


// Affichage
echo elgg_view_page($title, $body);

