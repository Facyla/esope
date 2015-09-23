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

// Texte intro configurable
$intro = elgg_get_plugin_setting('dashboardheader', 'adf_public_platform');

// Composition de la page
//$body = elgg_view_layout('one_column', array('content' => $static . '<div class="clearfloat"></div>' . $widgets));
$body = '<header><div class="intro">' . $static . $intro . '</div></header>';
  

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
	elgg_push_context('widgets');
	$db_prefix = elgg_get_config('dbprefix');
	$left_side .= elgg_list_river(array('limit' => 4, 'pagination' => false));
	elgg_pop_context();
}
// BLOC CENTRAL
// The Wire
$index_wire = elgg_get_plugin_setting('index_wire', 'adf_public_platform');
if (elgg_is_active_plugin('thewire') && ($index_wire == 'yes')) {
	// Show/hide version
	//$thewire .= '<h3><a style="float:right;" href="javascript:void(0);" onClick="$(\'#thewire_homeform\').toggle();">' . elgg_echo('adf_platform:thewire:togglelink') . '</a><a href="' . $CONFIG->url . 'thewire/all">' . elgg_echo('adf_platform:homewire:title', array($CONFIG->sitename)) . '</a></h3>';
	$thewire .= '<h3><a href="' . $CONFIG->url . 'thewire/all">' . elgg_echo('adf_platform:homewire:title', array($CONFIG->sitename)) . '</a></h3>';
	$thewire .= '<div id="thewire_homeform" style="display:block;">' . elgg_view_form('thewire/add', array('class' => 'thewire-form no-spaces')) . elgg_view('input/urlshortener') . '</div>';
	elgg_push_context('widgets');
	$thewire .= elgg_list_entities(array('type' => 'object', 'subtype' => 'thewire', 'limit' => 3, 'pagination' => false));
	elgg_pop_context('widgets');
}
// BLOC DROITE
// Groupes en Une et connectés
$index_groups = elgg_get_plugin_setting('index_groups', 'adf_public_platform');
if (elgg_is_active_plugin('groups') && ($index_groups == 'yes')) {
	$right_side .= '<div class="home-static">' . elgg_view('adf_platform/sidebar_groups') . '</div>';
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

// Composition de la ligne
$static = '';
if ($thewire && $left_side && $right_side) {
	$static .= '<div class="home-static" style="width:32%; float:left; margin-right:3%;">' . $left_side . '</div>';
	$static .= '<div class="home-static" style="width:40%; float:left;">' . $thewire . '</div>';
	$static .= '<div class="home-static-container" style="width:20%; float:right;">' . $right_side . '</div>';
} else if ($thewire && $left_side) {
	$static .= '<div class="home-static" style="width:32%; float:left;">' . $left_side . '</div>';
	$static .= '<div class="home-static" style="width:64%; float:right;">' . $thewire . '</div>';
} else if ($thewire && $right_side) {
	$static .= '<div class="home-static" style="width:70%; float:left;">' . $thewire . '</div>';
	$static .= '<div style="width:24%; float:right;">' . $right_side . '</div>';
} else if ($left_side && $right_side) {
	$static .= '<div class="home-static" style="width:68%; float:left;">' . $left_side . '</div>';
	$static .= '<div class="home-static-container" style="width:28%; float:right;">' . $right_side . '</div>';
} else {
	$static .=	$left_side . $thewire . $right_side;
}
if (!empty($static)) $body .= '<div class="clearfloat"></div>' . $static;

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
$body .= '<div class="clearfloat"></div>' . $widgets;


// Affichage
echo elgg_view_page($title, $body);

