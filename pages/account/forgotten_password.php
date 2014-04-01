<?php
/**
 * Assembles and outputs the forgotten password page.
 *
 * @package Elgg.Core
 * @subpackage Registration
 */

if (elgg_is_logged_in()) {
	forward();
}

$title = elgg_echo("user:password:lost");
$content = elgg_view_title($title);

$content .= elgg_view_form('user/requestnewpassword', array(
	'class' => 'elgg-form-account',
));

