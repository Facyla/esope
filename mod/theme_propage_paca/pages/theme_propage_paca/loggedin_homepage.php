<?php
global $CONFIG;

// Ensure that only logged-in users can see this page
gatekeeper();

$url = elgg_get_site_url();

$user_guid = elgg_get_logged_in_user_guid();
$user = elgg_get_logged_in_user_entity();

// Set context and title
elgg_set_context('dashboard');
elgg_set_page_owner_guid($user_guid);
//$title = elgg_echo('dashboard');
$title = elgg_echo('adf_platform:dashboard:title');
$body = '';

// Titre de la page
$body .= '<h2 class="invisible">' . $title . '</h2>';

$viewall = '<span class="esope-more">' . elgg_echo('link:view:all') . '</span>';

// Texte intro configurable
//$intro = elgg_get_plugin_setting('dashboardheader', 'adf_public_platform');
//$body = '<div class="intro">' . $$intro . '</div>';


// BLOCS CONFIGURABLES
$left_col = ''; $center_col = ''; $right_col = '';

// BLOC GAUCHE
$left_col .= elgg_view('cmspages/view', array('pagetype' => 'accueil-edito'));
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
		$left_col .= '<h3>';
		//$left_col .= 'Activité récente dans ';
		$left_col .= 'En direct de ';
		$left_col .= '<a href="' . $homegroup->getURL() . '"><img src="' . $homegroup->getIconURL('tiny') . '" style="margin:-2px 0 3px 8px; float:right;" />' . $homegroup->name . '</a></h3>';
		// Activité du groupe
		elgg_push_context('widgets');
		$db_prefix = elgg_get_config('dbprefix');
		$left_col .= elgg_list_river(array(
				'limit' => 3, 'pagination' => false,
				'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
				'wheres' => array("(e1.container_guid = $homegroup->guid)"),
			));
		elgg_pop_context();
	}
}


// BLOC CENTRAL
elgg_push_context('widgets');
// Derniers articles de blog groupe Actualités
$newsgroup_guid = elgg_get_plugin_setting('newsgroup_guid', 'theme_propage_paca');
$ia = elgg_set_ignore_access(true);
$newsgroup = get_entity($newsgroup_guid);
elgg_set_ignore_access($ia);
if (elgg_instanceof($newsgroup, 'group')) {
	$center_col .= '<div class="home-static afparh-news">';
	$center_col .= '<h3><a href="' . $url . 'blog/group/' . $newsgroup_guid . '/all">' . elgg_echo('theme_propage_paca:news') . $viewall . '</a></h3>';
	$center_col .= elgg_list_entities(array('type' => 'object', 'subtype' => 'blog', 'limit' => 3, 'container_guid' => $newsgroup_guid, 'full_view' => false, 'pagination' => false));
	/*
	$news = elgg_get_entities(array('type' => 'object', 'subtype' => 'blog', 'limit' => 3, 'container_guid' => $newsgroup_guid));
	foreach ($news as $ent) {
		$img = $ent->getIconURL('medium');
		$text = '<h4><a href="' . $ent->getURL() . '">' . $ent->title . '</a></h4>' . $ent->getExcerpt();
		$center_col .= elgg_view_image_block($img, $text);
	}
	*/
	if (elgg_is_admin_logged_in() || $newsgroup->isMember()) {
		$center_col .= '<p> <a class="elgg-button elgg-button-action" href="' . $url . 'blog/add/' . $newsgroup_guid . '"><i class="fa fa-gears"></i>' . elgg_echo('blog:add') . '</a></p>';
	}
	$center_col .= '</div>';
}
// The Wire
$index_wire = elgg_get_plugin_setting('index_wire', 'adf_public_platform');
if (elgg_is_active_plugin('thewire') && ($index_wire == 'yes')) {
	$center_col .= '<div class="home-static propage-home">';
	// Show/hide version
	//$thewire .= '<h3><a style="float:right;" href="javascript:void(0);" onClick="$(\'#thewire_homeform\').toggle();">' . elgg_echo('adf_platform:thewire:togglelink') . '</a><a href="' . $url . 'thewire/all">' . elgg_echo('adf_platform:homewire:title', array($CONFIG->sitename)) . '</a></h3>';
	$center_col .= '<h3><a href="' . $url . 'thewire/all">' . elgg_echo('adf_platform:homewire:title', array($CONFIG->sitename)) . $viewall . '</a></h3>';
	$center_col .= '<div id="thewire_homeform" style="display:block;">' . elgg_view_form('thewire/add', array('class' => 'thewire-form no-spaces')) . elgg_view('input/urlshortener') . '</div>';
	$center_col .= elgg_list_entities(array('type' => 'object', 'subtype' => 'thewire', 'limit' => 3, 'pagination' => false));
	$center_col .= '</div>';
}
elgg_pop_context('widgets');


// BLOC DROITE
// Mon profil + Edit link
$right_col .= '<div class="home-static">';
	$right_col .= '<h3><a href="' . elgg_get_site_url() . 'profile/' . $user->username . '">' . elgg_echo('theme_propage_paca:myprofile') . '<span class="esope-more">' . elgg_echo('theme_propage_paca:display') . '</span></a></h3>';
	$right_col .= elgg_view('profile_manager/profile_completeness');
	$right_col .= '<br /><a class="elgg-button elgg-button-action" href="' . elgg_get_site_url() . 'profile/' . $user->username . '/edit">' . elgg_echo('theme_propage_paca:profile:edit') . '</a>';
	$right_col .= '<div class="clearfloat"></div>';
$right_col .= '</div>';
// Inter-séquences : Page CMS
$right_col .= '<div class="home-static">';
$right_col .= '<h3><a href="' . elgg_get_site_url() . 'p/accueil-rencontres">' . elgg_echo('theme_propage_paca:ateliers') . '<span class="esope-more">' . elgg_echo('theme_propage_paca:moreinfo') . '</span></a></h3>';
$right_col .= elgg_view('cmspages/view', array('pagetype' => 'accueil-rencontres', 'read_more' => 300));
$right_col .= '</div>';
// Prochaines rencontres : Evénements
$right_col .= '<div class="home-static propage-home">';
$right_col .= '<h3><a href="' . elgg_get_site_url() . 'p/accueil-prochaines-rencontres">' . elgg_echo('theme_propage_paca:ateliers:future') . '<span class="esope-more">' . elgg_echo('theme_propage_paca:moreinfo') . '</span></a></h3>';
// search?q=atelier&entity_subtype=event_calendar&entity_type=object&search_type=entities
$right_col .= elgg_view('theme_propage_paca/ateliers');
$right_col .= '</div>';
// Groupes en Une et connectés
$index_groups = elgg_get_plugin_setting('index_groups', 'adf_public_platform');
if (elgg_is_active_plugin('groups') && ($index_groups == 'yes')) {
	$right_col .= '<div class="home-static">' . elgg_view('adf_platform/sidebar_groups') . '</div>';
}
// Membres connectés et nouveaux inscrits
$index_members = elgg_get_plugin_setting('index_members', 'adf_public_platform');
$index_recent_members = elgg_get_plugin_setting('index_recent_members', 'adf_public_platform');
if (elgg_is_active_plugin('members')) {
	if ($index_members == 'yes') {
		if (!empty($right_col)) $right_col .= '<br />';
		$right_col .= '<div class="home-static">' . elgg_view('adf_platform/users/online') . '</div>';
	}
	if ($index_recent_members == 'yes') {
		if (!empty($right_col)) $right_col .= '<br />';
		$right_col .= '<br /><div class="home-static">' . elgg_view('adf_platform/users/newest') . '</div>';
	}
}



// PLEINE PAGE
//Affichage actus du site si demandé
$homesite_index = elgg_get_plugin_setting('homesite_index', 'adf_public_platform');
$activity = '';
if ($homesite_index == 'yes') {
	$activity .= '<h3><a href="' . $url . 'activity">' . elgg_echo('adf_platform:site:activity') . $viewall . '</a></h3>';
	// Activité du site
	elgg_push_context('widgets');
	$db_prefix = elgg_get_config('dbprefix');
	$activity .= elgg_list_river(array('limit' => 5, 'pagination' => false));
	elgg_pop_context();
}



// Composition de la page
$body .= '<div class="clearfloat"></div>';
$body .= '<div class="home-static-container" style="width:74%; float:left;">';
	$body .= '<div class="home-static" style="width:36%; float:left; margin-right:3%;">' . $left_col . '</div>';
	$body .= '<div class="home-static-container" style="width:60%; float:left;">' . $center_col . '</div>';
	$body .= '<div class="clearfloat"></div>';
	$body .= '<div class="home-static propage-home">' . $activity . '</div>';
$body .= '</div>';
$body .= '<div class="home-static-container" style="width:24%; float:right;">' . $right_col . '</div>';
$body .= '<div class="clearfloat"></div>';


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
$body .= '<div class="clearfloat"></div>';
$body .= elgg_view_layout('widgets', $params);


// Affichage
echo elgg_view_page($title, $body);

