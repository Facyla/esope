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


$lang = get_current_language();
$class = 'elgg-public';
if (elgg_is_logged_in()) { $class = 'elgg-loggedin'; }

// render content before head so that JavaScript and CSS can be loaded. See #4032

$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));

$header = elgg_view('page/elements/header', $vars);
$content = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);

$body = <<<__BODY
<div class="$class">
	
	<div class="notifications">
		$messages
	</div>
__BODY;


if (!empty($content)) {
	$body .= $content;
}

$body .= '</div>';

$body .= elgg_view('page/elements/bootstrap_foot');

$head = elgg_view('page/elements/bootstrap_head', $vars['head']);

$params = array(
	'head' => $head,
	'body' => $body,
	/*
	'body_attrs' => array(
		'class' => $class, // Esope : add loggedin class
	),
	*/
);

if (isset($vars['body_attrs'])) {
	$params['body_attrs'] = $vars['body_attrs'];
}

echo elgg_view("page/elements/bootstrap_html", $params);


