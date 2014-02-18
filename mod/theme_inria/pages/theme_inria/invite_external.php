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

global $CONFIG;

gatekeeper();

$own = elgg_get_logged_in_user_entity();
// Verrouillage pour membres LDAP uniquement - ou admin
if (elgg_is_admin_logged_in() || ($own->membertype == 'inria') ) {
	$access_valid = '';
	if ($own->membertype == 'inria') $access_valid .= 'Inria';
	else if (elgg_is_admin_logged_in()) $access_valid .= 'Administrateur';
} else {
	//register_error('You do not have the rights to access this page.');
	forward();
}

elgg_set_context('members');
elgg_push_context('inria_invite');
elgg_push_breadcrumb('inria_invite');

$content = '';
$sidebar = '';
$title = elgg_echo('theme_inria:useradd');

$content .= elgg_echo('theme_inria:useradd:details', array($access_valid));
$content .= elgg_view_form('inria_useradd', '', array());


// Composition de la page
$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => false, 'filter' => false));


// Affichage
echo elgg_view_page($title, $body);

