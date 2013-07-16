<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

global $CONFIG;
$db_prefix = elgg_get_config('dbprefix');
$url = $CONFIG->url;

$site = elgg_get_site_entity();
$title = $site->name;
$user = elgg_get_logged_in_user_entity();
elgg_set_page_owner_guid($user->guid);
elgg_set_context('profile');
//elgg_set_context('dashboard');

$title = $user->name;


// Type de profil
$member_type = dossierdepreuve_get_user_profile_type($user);
//$content .= "Votre type de profil : " . elgg_echo('profile:types:' . $member_type) . ' (' . $member_type . ')';
/*
if ($profile_type_guid = $user->custom_profile_type) {
	if (($custom_profile_type = get_entity($profile_type_guid)) && ($custom_profile_type instanceof ProfileManagerCustomProfileType)) {
		$member_type = $custom_profile_type->metadata_name;
		$content .= "Votre type de profil : " . $custom_profile_type->getTitle();
		$content .= ' (' . $custom_profile_type->metadata_name . ')';
	}
}
*/

$content .= '<div id="home_static">';

// Tous les blocs utilisables
$static_widget_profile = elgg_view('theme_compnum/modules/myprofile', array('entity' => $user));
$static_widget_help = elgg_view('theme_compnum/modules/learner_help', array('entity' => $user));
$static_widget_mygroup = elgg_view('theme_compnum/modules/learner_mygroup', array('entity' => $user));
$static_widget_dossier = elgg_view('theme_compnum/modules/mydossier', array('entity' => $user));
$static_widget_blog = elgg_view('theme_compnum/modules/myblog', array('entity' => $user));
$static_widget_groups = elgg_view('theme_compnum/modules/myadmin_groups', array('entity' => $user));
$static_widget_tutors = elgg_view('theme_compnum/modules/tutors_list', array('entity' => $user));
$static_widget_learners = elgg_view('theme_compnum/modules/mylearners_list', array('entity' => $user));
$static_widget_evaluations = elgg_view('theme_compnum/modules/myevaluation', array('entity' => $user));


// Blocs statiques différenciés selon les profils
switch($member_type) {
	case 'organisation':
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_groups . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_tutors . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_learners . '</div></div>';
		break;
	case 'learner':
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_help . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_mygroup . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_dossier . '</div></div>';
		break;
	case 'tutor':
	case 'evaluator':
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_groups . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_learners . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_evaluations . '</div></div>';
		break;
	case 'other_administrative':
	default:
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_help . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_mygroup . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_dossier . '</div></div>';
		
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_groups . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_tutors . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_learners . '</div></div>';
		
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_profile . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_blog . '</div></div>';
		$content .= '<div class="home_static_widget"><div class="elgg-widget-content">' . $static_widget_evaluations . '</div></div>';
		break;
}
$content .= '<div class="clearfloat"></div>';
$content .= '</div>';


$params = array('content' => elgg_view('profile/wrapper'), 'num_columns' => 3);
$content .= elgg_view_layout('widgets', $params);


// Pageguide : visite guidée - chargement bibliothèque et activation
if (elgg_is_active_plugin('pageguide')) {
	$content .= elgg_view('pageguide/page-homepage');
}

//forward($url . 'profile/' . elgg_get_logged_in_user_entity()->username);



//$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => '', ));
$body = elgg_view_layout('one_column', array('content' => $content));


// Affichage
echo elgg_view_page($title, $body);

