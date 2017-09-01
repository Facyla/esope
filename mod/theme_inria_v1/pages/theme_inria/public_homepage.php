<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */


$site = elgg_get_site_entity();
$title = $site->name;

// Formulaire de renvoi du mot de passe
$lostpassword_form = '<div id="adf-lostpassword" class="hidden">';
//$lostpassword_form = '<h2>' . elgg_echo('user:password:lost') . '</h2>';
$lostpassword_form .= elgg_view_form('user/requestnewpassword');
$lostpassword_form .= '</div>';

// Formulaire d'inscription
if (elgg_get_config('allow_registration')) {
	$register_form = elgg_view_form('register', array(), array('friend_guid' => (int) get_input('friend_guid', 0), 'invitecode' => get_input('invitecode') ));
}


// Composition de la page
$content = '<div id="adf-homepage" class="">';

/*
$content .= '<div style="width:46%; float:left;">';
	$intro = elgg_get_plugin_setting('homeintro', 'adf_public_platform');
	if (!empty($intro)) $content .= $intro . '<div class="clearfloat"></div>';
	$content .= '<div class="clearfloat"></div><br />';
$content .= '</div>';
*/

//$content .= '<div style="width:50%; float:right;">';
$content .= '<div class="elgg-main">';
	$content .= '<div style="border:1px solid #CCCCCC; padding:0.5em 1em; margin-top:2em; background:#F6F6F6;">';
		// Connexion + mot de passe perdu
		$content .= '<h2>Connexion</h2>';
		$content .= elgg_view_form('login');
		$content .= $lostpassword_form;
		$content .= '<div class="clearfloat"></div>';
	
		// Création nouveau compte
		if (elgg_get_config('allow_registration')) { $content .= '<br /><hr /><br />' . $register_form; }
		$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';
	$content .= '<div class="clearfloat"></div><br />';
$content .= '</div>';


$content .= '</div>';


//$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => '', ));
$body = $content;


// Affichage
echo elgg_view_page($title, $body);

