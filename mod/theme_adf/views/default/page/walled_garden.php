<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 *
 * @uses $vars['head']        Parameters for the <head> element
 * @uses $vars['body']        The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

elgg_unregister_external_file('css', 'elgg');
elgg_load_external_file('css', 'elgg.walled_garden');

// render content before head so that JavaScript and CSS can be loaded. See #4032
$messages = elgg_view('page/elements/messages', ['object' => elgg_extract('sysmessages', $vars)]);
$content = elgg_extract('body', $vars);

$header_logo = elgg_view('page/elements/header_logo');
$header = '';
if (elgg_get_config('allow_registration') && !elgg_in_context('register')) {
	$header .= '<div id="register-link">' . elgg_view('output/url', ['href' => "{$url}register", 'text' => elgg_echo('theme_adf:register')]) . '</div>';
}
if (!elgg_in_context('login')) {
	$header .= '<div id="login-link">' . elgg_view('output/url', ['href' => "{$url}login", 'text' => elgg_echo('theme_adf:login')]) . '</div>';
	//$header .= elgg_view('core/account/login_dropdown');
}

//$footer = elgg_view('page/elements/walled_garden/footer', $vars);
$footer = elgg_view('page/elements/footer', $vars);

$body = <<<__BODY
<div class="elgg-page elgg-page-walled-garden">
	
	<div class="elgg-page-messages">
		$messages
	</div>
	
	<div class="elgg-page-header">
		<div class="elgg-nav-logo">
			$header_logo
		</div>
		<div class="elgg-nav-login">
			$header
		</div>
	</div>
	
	<div class="elgg-inner">
		<div class="elgg-page-body">
			<div class="elgg-inner">
				$content
			</div>
		</div>
	</div>
	
	<div class="elgg-page-footer">
		<div class="elgg-inner">
			$footer
		</div>
	</div>
	
</div>
__BODY;

$body .= elgg_view('page/elements/foot');

$head = elgg_view('page/elements/head', elgg_extract('head', $vars, []));

$params = [
	'head' => $head,
	'body' => $body,
];

echo elgg_view('page/elements/html', $params);
