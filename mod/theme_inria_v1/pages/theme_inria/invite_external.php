<?php
/**
 * This page is used to let Inria members create external accounts for other people outside Inria
 * 
 * 2 étapes :
 *  - création de compte
 *  - confirmation email
 *  - validation a priori du compte
 * 
 */

gatekeeper();

$own = elgg_get_logged_in_user_entity();
// Verrouillage pour membres LDAP uniquement - ou admin
if (elgg_is_admin_logged_in() || ($own->membertype == 'inria') ) {
	$access_valid = '';
	if ($own->membertype == 'inria') { $access_valid .= 'Inria'; }
	else if (elgg_is_admin_logged_in()) { $access_valid .= 'Admin'; }
} else {
	//register_error('You do not have the rights to access this page.');
	forward();
}

elgg_set_context('members');
elgg_set_context('invite_external');
elgg_push_breadcrumb(elgg_echo('inria_invite'));

$content = '';
$sidebar = '';
$title = elgg_echo('inria_invite');

$content .= '<p><strong>' . elgg_echo('theme_inria:useradd') . '</strong></p>';

$content .= elgg_echo('theme_inria:useradd:details', array($access_valid));
if (elgg_get_plugin_setting('admin_validation', 'theme_inria') == 'yes') {
	$content .= '<p><em>' . elgg_echo('theme_inria:useradd:adminvalidation') . '</em></p>';
}

$content .= elgg_view_form('inria_useradd', '', array());


// Composition de la page
$body = elgg_view_layout('content', array('title' => $title, 'content' => $content, 'sidebar' => false, 'filter' => false));
//$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => false, 'filter' => false));
//$body = elgg_view_layout('one_column', array('title' => $title, 'content' => $content, 'sidebar' => false, 'filter' => false));


// Affichage
echo elgg_view_page($title, $body);

