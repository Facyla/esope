<?php
// Sidebar

global $CONFIG;
$sidebar = '';

$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') $admin = true;
$role_info = elgg_echo("uhb_annonces:role:$types");
$role_info = '<p><strong>' . elgg_echo('uhb_annonces:role:title', array($role_info)) . '</strong></p>';
if (!elgg_is_logged_in()) { $role_info .= '<p><a href="' . $CONFIG->url . 'login" class="elgg-button elgg-button-action">' . elgg_echo('uhb_annonces:login') . '</a></p>'; }


// 1 - Partie générique + Candidatures
$sidebar_title = elgg_echo('uhb_annonces:sidebar:title');
$sidebar_content = '';

// Anyone can create a new offer
$create_link = '<a href="' . $CONFIG->url . 'annonces/add">' . ucfirst(elgg_echo('uhb_annonces:offre:create:link')) . '</a>';
$own_offers = uhb_annonces_has_offer(elgg_get_logged_in_user_entity());

//$sidebar .= '<p>' . elgg_echo('uhb_annonces:offre:create', array($create_link)) . '</p>';
$sidebar_content .= '<p>' . $create_link . '</p>';

// Rôle utilisateur
$sidebar_content .= $role_info;

// Lien vers ses propres annonces
if ($own_offers) {
	$sidebar_content .= '<p><a href="' . $CONFIG->url . 'annonces/list/mine">' . elgg_echo('uhb_annonces:sidebar:mypublished') . '</a></p>';
}

// Only some profiles can search and browse offers
if (uhb_annonces_can_view()) {
	$sidebar_content .= '<p><a href="' . $CONFIG->url . 'annonces/search">' . elgg_echo('uhb_annonces:sidebar:search') . '</a></p>';
}


// Less profiles are allowed to candidate to offers (students)
if (uhb_annonces_can_candidate()) {
	//$sidebar .= elgg_view('uhb_annonces/sidebar_widget_candidate', $vars);
	$ownguid = elgg_get_logged_in_user_guid();

	$mycandidated = uhb_annonces_get_from_relationship('has_candidated', $ownguid, false, true);
	$mymemorised = uhb_annonces_get_from_relationship('memorised', $ownguid, false, true);

	// List generic tools for candidates
	//$content .= '<p><a href="' . $CONFIG->url . 'annonces/search">' . elgg_echo('uhb_annonces:sidebar:search') . '</a></p>';
	$sidebar_content .= '<p><a href="' . $CONFIG->url . 'annonces/list/memorised">' . elgg_echo('uhb_annonces:sidebar:memorised', array($mymemorised)) . '</a></p>';
	$sidebar_content .= '<p><a href="' . $CONFIG->url . 'annonces/list/candidated">' . elgg_echo('uhb_annonces:sidebar:candidated', array($mycandidated)) . '</a></p>';
}

$sidebar .= elgg_view_module('aside', $sidebar_title, $sidebar_content);


// 3 - Stats et actions liées à l'offre affichée
// All offer-related stats and actions
// Note : Admin users also have all roles functionnalities
if ($vars['entity']) { $sidebar .= elgg_view('uhb_annonces/sidebar_widget_offer', $vars); }


// 4 - Stats et actions admin
// Admin users have access to global stats
//if ($admin) { $sidebar .= elgg_view('uhb_annonces/sidebar_widget_stats', $vars); }


// Rendu
echo '<div id="uhb_annonces-sidebar">' . $sidebar . '</div>';

