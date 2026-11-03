<?php
/**
 * Landing page after requesting a login code
 */

use Elgg\Exceptions\Http\BadRequestException;

$session = elgg_get_session();
if (!$session->has('login_by_email_code') || !$session->has('login_by_email_user_guid')) {
	throw new BadRequestException();
}

echo elgg_view_page(elgg_echo('login_by_email:code:title'), [
	'content' => elgg_view_form('login_by_email/code'),
	'sidebar' => false,
	'filter' => false,
], 'walled_garden');
