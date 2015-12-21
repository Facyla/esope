<?php
/**
 * Walled garden page shell
 *
 * Used for the walled garden index page
 */

global $CONFIG;

$site = elgg_get_site_entity();
$title = $site->name;

// Texte d'accueil
$homeintro = elgg_get_plugin_setting('homeintro', 'esope');
if (!empty($homeintro)) { 
	$intro = '<div class="home-intro">';
	$intro .= $homeintro;
	$intro .= '<div class="clearfloat"></div>';
	$intro .= '</div>';
}

// Formulaire de renvoi du mot de passe
$lostpassword_form = '<div id="esope-lostpassword" style="display:none;">';
//$lostpassword_form = '<h2>' . elgg_echo('user:password:lost') . '</h2>';
$lostpassword_form .= elgg_view_form('user/requestnewpassword');
$lostpassword_form .= '</div>';

// Connexion + mot de passe perdu
$login_form = '<div id="esope-login">';
	$login_form .= '<h2>' . elgg_echo('esope:homepage:login') . '</h2>';
	$login_form .= elgg_view_form('login');
	$login_form .= $lostpassword_form;
	$login_form .= '<div class="clearfloat"></div>';
$login_form .= '</div>';

// Formulaire d'inscription
if (elgg_get_config('allow_registration')) {
	$register_form = '<div id="esope-register">';
	$register_form .= '<h2>' . elgg_echo('esope:homepage:register') . '</h2>';
	$register_form .= elgg_view_form('register', array(), array('friend_guid' => (int) get_input('friend_guid', 0), 'invitecode' => get_input('invitecode') ));
	$register_form .= '</div>';
}


// COMPOSITION DE LA PAGE
$content = '<div id="esope-homepage">';

/* Colonne droite :
 * bloc de connexion
 * bloc d'inscription
*/
$content .= '<div style="width:50%; float:right;" class="home-static-container">';
	$content .= $login_form;
	// Création nouveau compte
	if (elgg_get_config('allow_registration')) { $content .= $register_form; }
	$content .= '<div class="clearfloat"></div>';
$content .= '</div>';

/* Colonne gauche :
 * fil d'activité global
 * bloc agenda
 * liste des groupes publics en Une (icône + titre, aléatoire parmi les groupes en Une)
*/

$content .= '<div style="width:44%; float:left;" class="home-static-container">';
	if (!empty($intro)) $content .= $intro;
	
	// Evenements proches
	if (elgg_is_active_plugin('event_calendar')) {
		require_once($CONFIG->pluginspath . "event_calendar/models/model.php");
		$content .= '<div class="home-calendar">';
			$content .= '<h2>' .elgg_echo('esope:homepage:calendar') . '</h2>';
			$start_date = date('Y-m-d');
			$start_ts = strtotime($start_date);
			$end_ts = $start_ts + 50000000;
			$events_count = event_calendar_get_events_between($start_ts,$end_ts,true,3,0);
			$events = event_calendar_get_events_between($start_ts,$end_ts,false,3,0);
			if ($events) {
				$content .= elgg_view_entity_list($events, $events_count, 0, 3, false, false);
			} else {
				$content .= '<p>' .elgg_echo('esope:homepage:calendar:none') . '</p>';
			}
			$content .= '<div class="clearfloat"></div>';
		$content .= '</div>';
	}
	
	// Liste des groupes en Une avec icônes
	if (elgg_is_active_plugin('groups')) {
		$content .= '<div class="home-groups">';
			$content .= '<h2>' .elgg_echo('esope:homepage:groups') . '</h2>';
			//$groups = elgg_get_entities(array('types' => 'group', 'limit' => 0));
			$groups = elgg_get_entities_from_metadata(array('types' => 'group', 'metadata_name' => 'featured_group', 'metadata_value' => 'yes', 'limit' => 0));
			shuffle($groups);
			//$content .= elgg_view_entity_list($groups, '', 0, 99, false, false, false);
			foreach ($groups as $group) {
				$content .= '<a href="' . $group->getURL() . '">';
				$content .= '<div class="home-group-item">';
				$content .= '<img src="' . $group->getIconURL('medium') . '" style="float:left; margin:0 6px 4px 0;"/>';
				$content .= '<h3>' . $group->name . '</h3>';
				$content .= '<p style="font-size:11px;">' . $group->briefdescription . '</p>';
				$content .= '</div>';
				$content .= '</a>';
			}
			$content .= '<div class="clearfloat"></div>';
		$content .= '</div>';
	}
$content .= '</div>';


//$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => '', ));
$body = $content;


// Affichage
echo elgg_view_page($title, $body);

