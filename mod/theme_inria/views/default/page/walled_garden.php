<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 *
 * @uses $vars['head']        Parameters for the <head> element
 * @uses $vars['body_attrs']  Attributes of the <body> tag
 * @uses $vars['body'] The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

$lang = get_current_language();
$class = 'elgg-public';

// render content before head so that JavaScript and CSS can be loaded. See #4032
$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));

$header = elgg_view('page/elements/header', $vars);
$content = elgg_view('page/elements/body', $vars);
$footer_side = elgg_view('page/elements/footer_side', $vars);
$footer_main = elgg_view('page/elements/footer_main', $vars);


$site = elgg_get_site_entity();
$title = $site->name;


$content = '<div id="adf-homepage" class="">';
	// Formulaire de renvoi du mot de passe
	$lostpassword_form = '<div id="adf-lostpassword" class="hidden">';
	//$lostpassword_form = '<h2>' . elgg_echo('user:password:lost') . '</h2>';
	$lostpassword_form .= elgg_view_form('user/requestnewpassword');
	$lostpassword_form .= '</div>';

	$content .= '<div class="elgg-main">';
		$content .= '<div style="border:1px solid #CCCCCC; padding:0.5rem 1rem; margin: 2rem; background:#F6F6F6;">';
			// Connexion + mot de passe perdu
			$content .= '<h2>' . elgg_echo('login') . '</h2>';
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



$body = <<<__BODY
<div class="elgg-page elgg-page-default $class">
	
	<div class="elgg-page-messages">
		$messages
	</div>
__BODY;

// ESOPE : the topbar is part of the header (and does not use its own wrapper)
$topbar = elgg_view('page/elements/topbar', $vars);

$body .= <<<__BODY
	<div id="iris-topbar">
		$topbar
	</div>
	<div id="iris-page">
		<div id="iris-navigation">
			$header
			<div id="iris-footer">
				$footer_side
			</div>
		</div>
		<div id="iris-body">
			$content
			<div id="iris-footer-main">
				$footer_main
			</div>
		</div>
	</div>
__BODY;


$body .= elgg_view('page/elements/foot');

$body .= '<div class="overlay"></div>';

$head = elgg_view('page/elements/head', $vars['head']);

$params = array(
	'head' => $head,
	'body' => $body,
	'body_attrs' => array(
		'class' => $class, // Esope : add public/loggedin class to body tag
	),
);

if (isset($vars['body_attrs'])) {
	$params['body_attrs'] = $vars['body_attrs'];
}

echo elgg_view("page/elements/html", $params);

