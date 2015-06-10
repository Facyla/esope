<?php
global $CONFIG;

// Ensure that only logged-in users can see this page
gatekeeper();

$user_guid = elgg_get_logged_in_user_guid();
$user = elgg_get_logged_in_user_entity();

// Set context and title
elgg_set_context('dashboard');
elgg_set_page_owner_guid($user_guid);
//$title = elgg_echo('dashboard');
$title = elgg_echo('adf_platform:dashboard:title');

// Titre de la page
$static = '<h2 class="invisible">' . $title . '</h2>';

// Premiers pas (si configuré)
$firststeps_guid = elgg_get_plugin_setting('firststeps_guid', 'adf_public_platform');
$firststeps_page = get_entity($firststeps_guid);
if ($firststeps_page instanceof ElggObject) {
	$firststeps = '<div class="firststeps">
			<a href="javascript:void(0);" onClick="$(\'#firsteps_toggle\').toggle(); $(\'#firststeps_show\').toggle(); $(\'#firststeps_hide\').toggle();">' . elgg_echo('adf_platform:firststeps:linktitle') . '
				<span id="firststeps_show" style="float:right;">&#x25BC;</span>
				<span id="firststeps_hide" style="float:right; display:none;">&#x25B2;</span>
			</a>'
		. '<div id="firsteps_toggle" style="padding:10px; border:0 !important;">'
			. $firststeps_page->description
		. '</div>' 
	. '</div>';
	// Masqué par défaut après les 2 premiers passages
	// @todo : on pourrait le faire si pas connecté depuis X temps..
	if (($_SESSION['user']->last_login >= 0) && ($_SESSION['user']->prev_last_login >= 0)) {
		$first_time = '<script type="text/javascript">
		$(document).ready(function() {
			$(\'#firsteps_toggle\').hide();
		})
		</script>';
		$firststeps .= $first_time;
	}
}

// Texte intro configurable
$intro = elgg_get_plugin_setting('dashboardheader', 'adf_public_platform');
//if (empty($intro) && elgg_is_admin_logged_in()) { $intro = '<a href="' . $vars['url'] . 'admin/plugin_settings/adf_public_platform">' . elgg_echo('adf_platform:welcome:msg') . '</a>'; }


// Composition de la page
//$body = elgg_view_layout('one_column', array('content' => $static . '<div class="clearfloat"></div>' . $widgets));
$body = '<header><div class="intro">' . $static . $firststeps . $intro . '</div></header>';


// BLOCS CONFIGURABLES
$left_side = ''; $thewire = ''; $right_side = '';
// BLOC GAUCHE
// Eléments du groupe d'accueil (à partir du GUID de ce groupe)
$homegroup_guid = elgg_get_plugin_setting('homegroup_guid', 'adf_public_platform');
$homegroup_index = elgg_get_plugin_setting('homegroup_index', 'adf_public_platform');
$homegroup_autojoin = elgg_get_plugin_setting('homegroup_autojoin', 'adf_public_platform');
if (elgg_is_active_plugin('groups') && !empty($homegroup_guid) && ($homegroup = get_entity($homegroup_guid))) {
	// Inscription forcée si demandé
	if ($homegroup_autojoin == 'force') {
		if (!$homegroup->isMember($user)) { $homegroup->join($user); }
	}
	//Affichage actus du groupe si demandé
	if ($homegroup_index == 'yes') {
		$left_side .= '<h3>';
		//$left_side .= 'Activité récente dans ';
		$left_side .= 'En direct de ';
		$left_side .= '<a href="' . $homegroup->getURL() . '"><img src="' . $homegroup->getIconURL('tiny') . '" style="margin:-2px 0 3px 8px; float:right;" />' . $homegroup->name . '</a></h3>';
		/* Forum..	bof car pas forcément activé..
		$left_side .= elgg_list_entities(array(
				'type' => 'object', 'subtype' => 'groupforumtopic',
				'order_by' => 'e.last_action desc', 'limit' => 6, 'full_view' => false,
			));
		*/
		// Activité du groupe
		elgg_push_context('widgets');
		$db_prefix = elgg_get_config('dbprefix');
		$left_side .= elgg_list_river(array(
				'limit' => 3, 'pagination' => false,
				'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
				'wheres' => array("(e1.container_guid = $homegroup->guid)"),
			));
		elgg_pop_context();
	}
}
//Affichage actus du site si demandé
$homesite_index = elgg_get_plugin_setting('homesite_index', 'adf_public_platform');
if ($homesite_index == 'yes') {
	$left_side .= '<h3><a href="' . $CONFIG->url . 'activity">' . elgg_echo('adf_platform:site:activity') . '</a></h3>';
	// Activité du site
	//elgg_push_context('widgets');
	$db_prefix = elgg_get_config('dbprefix');
	// Pour un filtre très fin : 'type_subtype_pairs' => array('object' => array('blog', 'event_calendar', 'page', 'page_top', 'bookmarks'), 'group' => null)
	//$left_side .= elgg_list_river(array('limit' => 40, 'pagination' => false, 'types' => array('object', 'group'), 'action_types' => array('create', 'comment', 'reply')));
	$left_side .= elgg_list_river(array('limit' => 5, 'pagination' => false, 'type_subtype_pairs' => array('object' => array('blog', 'event_calendar', 'page', 'page_top', 'bookmarks', 'groupforumtopic'), 'group' => null), 'action_types' => array('create', 'comment', 'reply')));
	$left_side .= '<p><a href="' . $CONFIG->url . 'activity">&raquo;&nbsp;Découvrez toute l\'activité</a></p>';
	//elgg_pop_context();
}

// BLOC CENTRAL
// The Wire
$index_wire = elgg_get_plugin_setting('index_wire', 'adf_public_platform');
if (elgg_is_active_plugin('thewire') && ($index_wire == 'yes')) {
	// Show/hide version
	//$thewire .= '<h3><a style="float:right;" href="javascript:void(0);" onClick="$(\'#thewire_homeform\').toggle();">' . elgg_echo('adf_platform:thewire:togglelink') . '</a><a href="' . $CONFIG->url . 'thewire/all">' . elgg_echo('adf_platform:homewire:title', array($CONFIG->sitename)) . '</a></h3>';
	//$thewire .= '<h3>Le Fil, vous et la Fing</h3>';
	$thewire .= '<h3><a href="' . $CONFIG->url . 'thewire/all">Le Fil, vous et la Fing</a></h3>';
	$thewire .= '<div id="thewire_homeform" style="display:block;">' . elgg_view_form('thewire/add', array('class' => 'thewire-form no-spaces')) . elgg_view('input/urlshortener') . '</div>';
	$thewire .= elgg_list_entities(array('type' => 'object', 'subtype' => 'thewire', 'limit' => 5, 'pagination' => false));
	$thewire .= '<p><a href="' . $CONFIG->url . 'thewire/all">&raquo;&nbsp;Remontez tout le fil</a></p>';
}

// BLOC DROITE
// Groupes en Une et connectés
$index_groups = elgg_get_plugin_setting('index_groups', 'adf_public_platform');
if (elgg_is_active_plugin('groups') && ($index_groups == 'yes')) {
	//$right_side .= '<div class="home-static">' . elgg_view('adf_platform/sidebar_groups') . '</div>';
	$right_side .= '<div class="home-static">' . elgg_view('theme_fing/sidebar_groups') . '</div>';
}
// Membres connectés et nouveaux inscrits
$index_members = elgg_get_plugin_setting('index_members', 'adf_public_platform');
$index_recent_members = elgg_get_plugin_setting('index_recent_members', 'adf_public_platform');
if (elgg_is_active_plugin('members')) {
	if ($index_members == 'yes') {
		if (!empty($right_side)) $right_side .= '<br />';
		$right_side .= '<div class="home-static">' . elgg_view('adf_platform/users/online') . '</div>';
	}
	if ($index_recent_members == 'yes') {
		if (!empty($right_side)) $right_side .= '<br />';
		$right_side .= '<br /><div class="home-static">' . elgg_view('adf_platform/users/newest') . '</div>';
	}
}
// Derniers contenus likés
if (elgg_is_active_plugin('likes')) {
	if (!empty($right_side)) $right_side .= '<br />';
	$right_side .= '<br /><div class="home-static">';
	$right_side .= '<h3>' . elgg_echo('esope:likes') . '</h3>';
	elgg_push_context('widgets');
	$right_side .= elgg_view('theme_fing/liked_content', array('limit' => 5));
	elgg_pop_context();
	$right_side .= '<p><a href="' . $CONFIG->url . 'likes">&raquo;&nbsp;Tous les contenus appréciés</a></p>';
	$right_side .= '</div>';
}

// Slider
$slider_params = array(
		//'sliderparams' => "theme:'cs-portfolio', buildStartStop:false, resizeContents:false, ", 
		//'slidercss_main' => "width:100%; height:400px;", 
		'width' => '100%',
		'height' => '300px', 
	);
//$slider = elgg_view('slider/slider', $slider_params);
$slider = elgg_view('theme_fing/slider_loggedin', $slider_params);


// Evénements : : agenda sous forme de timeline
if (elgg_is_active_plugin('event_calendar')) {
	elgg_load_library('elgg:event_calendar');
	
	elgg_push_context('widgets');
	$start_ts = time() - 24*3600; // Starting date
	$end_ts = $start_ts + 366*24*3600; // End date
	// @TODO : select only the need number of events ?
	$count_recent_events = event_calendar_get_events_between($start_ts,$end_ts,true,0,0,0,false);
	$recent_events = event_calendar_get_events_between($start_ts,$end_ts,false,$count_recent_events,0,0,false);
	/*
	// Tri des events de la timeine des autres : timeline si tag timeline, sinon agenda
	if ($recent_events) foreach ($recent_events as $ent) {
		if (in_array('timeline', $ent->tags) || ($ent->tags == 'timeline')) { $timeline_events[] = $ent; } else $agenda_events[] = $ent;
	}
	*/
	$timeline_events = $recent_events;
	// Timeline = 5 derniers events taggués "timeline"
	$timeline_events = array_slice($timeline_events, 0, 5);
	$timeline .= '<h2>Timeline</h2>';
	foreach ($timeline_events as $ent) {
		$timeline .= elgg_view("object/timeline_event_calendar",array('entity' => $ent));
	}
	$timeline .= '<div class="clearfloat"></div>';
}



// Composition de la ligne
$body .= '<div class="clearfloat"></div>';
$body .= '
	<div class="home-static-container" style="width:76%; float:left;">
		<div style="padding: 0 26px 26px 13px;">
		
			<div style="width:100%;" class="fing-slider">'
				. $slider
				//. elgg_view('cmspages', array('pagetype' => 'fing-accueil-connecte'))
			. '</div>
			<div class="clearfloat"></div><br /><br />
		
			<div class="home-static-container" style="width:40%; float:left;">
				<div class="home-box home-activity">' . $left_side . '</div>
			</div>
			<div class="home-static-container" style="width:57%; float:right;">
				<div class="home-box home-wire">' . $thewire . '</div>
			</div>
	
		</div>
	</div>
	
	<div class="home-static-container" style="width:22%; float:right;">' . $right_side . '</div>
	
	<div class="clearfloat"></div>';

$body .= '<br /><div class="home-timeline home-static-container">' . $timeline . '</div>';

/* Widgets + wrap intro message in a div
 * @uses $vars['content']					Optional display box at the top of layout
 * @uses $vars['num_columns']			Number of widget columns for this layout (3)
 * @uses $vars['show_add_widgets'] Display the add widgets button and panel (true)
 * @uses $vars['exact_match']			Widgets must match the current context (false)
 * @uses $vars['show_access']			Show the access control (true)
 */
$params = array(
		'content' => '', // Texte en intro des widgets (avant les 3 colonnes)
		'num_columns' => 3, 
		'show_access' => false, 
	);
$widgets = elgg_view_layout('widgets', $params);
$body .= '<h2 class="hidden">' . elgg_echo('theme_inria:home:widgets') . '</h2>' . $widgets;


// Affichage
echo elgg_view_page($title, $body);

