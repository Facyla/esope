<?php
/**
 * Page to request a login URL/code
 */

echo elgg_view_page(elgg_echo('login_by_email:menu:login:new_request'), [
	'content' => elgg_view_form('login_by_email/request_link', ['class' => 'elgg-form-account']),
	'sidebar' => false,
	'filter' => false,
], 'walled_garden');
