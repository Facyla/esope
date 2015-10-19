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

// Set the content type
//header("Content-type: text/html; charset=UTF-8");

// Allow external embed (hack)
if (function_exists('header_remove')) { header_remove('X-Frame-Options'); } else { header('X-Frame-Options: GOFORIT'); }


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
$footer = elgg_view('page/elements/footer', $vars);

$body = <<<__BODY
<div class="elgg-page elgg-page-default">
	
	<div class="elgg-page-messages">
		$messages
	</div>
__BODY;

// ESOPE : the topbar is part of the header (and does not use its own wrapper)
$topbar = elgg_view('page/elements/topbar', $vars);

if (!empty($header) || !empty($topbar)) {
$body .= <<<__BODY
	<div class="elgg-page-header">
		<div class="elgg-inner">
			$topbar
			$header
		</div>
	</div>
__BODY;
}
if (!empty($content)) {
$body .= <<<__BODY
	<div class="elgg-page-body">
		<div class="elgg-inner">
			$content
		</div>
	</div>
__BODY;
}
if (!empty($footer)) {
$body .= <<<__BODY
	<div class="elgg-page-footer">
		<div class="elgg-inner">
			$footer
		</div>
	</div>
__BODY;
}

$body .= '</div>';

$body .= elgg_view('page/elements/foot');

$head = elgg_view('page/elements/head', $vars['head']);

$params = array(
	'head' => $head,
	'body' => $body,
	'class' => $class, // Esope : add loggedin class
);

if (isset($vars['body_attrs'])) {
	$params['body_attrs'] = $vars['body_attrs'];
}

echo elgg_view("page/elements/html", $params);

