<?php
/**
 * Elgg pageshell
 * The standard HTML page shell that everything else fits into
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['head']        Parameters for the <head> element
 * @uses $vars['body_attrs']  Attributes of the <body> tag
 * @uses $vars['body'] The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// backward compatability support for plugins that are not using the new approach
// of routing through admin. See reportedcontent plugin for a simple example.
if (elgg_get_context() == 'admin') {
	if (get_input('handler') != 'admin') {
		elgg_deprecated_notice("admin plugins should route through 'admin'.", 1.8);
	}
	_elgg_admin_add_plugin_settings_menu();
	elgg_unregister_css('elgg');
	echo elgg_view('page/admin', $vars);
	return true;
}

$lang = get_current_language();
$class = 'elgg-public';
if (elgg_is_logged_in()) { $class = 'elgg-loggedin'; }

// render content before head so that JavaScript and CSS can be loaded. See #4032

$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));

$header = elgg_view('page/elements/header', $vars);
$content = elgg_view('page/elements/body', $vars);
$footer_side = elgg_view('page/elements/footer_side', $vars);
$footer_main = elgg_view('page/elements/footer_main', $vars);

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

