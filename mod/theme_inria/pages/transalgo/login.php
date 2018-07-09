<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

elgg_push_context('login'); // Avoids 'login' link in topbar

$site = elgg_get_site_entity();
$title = $site->name;

// Formulaire de renvoi du mot de passe
$lostpassword_form = '<div id="adf-lostpassword" class="hidden">';
//$lostpassword_form = '<h2>' . elgg_echo('user:password:lost') . '</h2>';
$lostpassword_form .= elgg_view_form('user/requestnewpassword');
$lostpassword_form .= '</div>';


// Composition de la page
$content = '<div id="transalgo-login">';

	$content .= '<h1>' . elgg_echo('transalgo:login:title') . '</h1>';
	$content .= '<p class="subtitle">' . elgg_echo('transalgo:login:subtitle') . '</p>';
	$content .= '<p>' . elgg_echo('transalgo:login:details') . '</p>';

	/*
	$content .= '<div style="width:46%; float:left;">';
		$intro = elgg_get_plugin_setting('homeintro', 'adf_public_platform');
		if (!empty($intro)) $content .= $intro . '<div class="clearfloat"></div>';
		$content .= '<div class="clearfloat"></div><br />';
	$content .= '</div>';
	*/

	//$content .= '<div style="width:50%; float:right;">';
	$content .= '<div class="transalgo-login-box">';
		// Connexion + mot de passe perdu
		$content .= '<h2>' . elgg_echo('login') . '</h2>';
		$content .= elgg_view_form('transalgo/login', ['action' => 'action/login'], []);
		$content .= $lostpassword_form;
		$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';

$content .= '</div>';


//$content = elgg_view_layout('content', array('content' => $content, 'sidebar' => '', ));


// Affichage
echo elgg_view_page($title, $content);

