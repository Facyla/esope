<?php
/**
 * adf_platforms
 *
 */

elgg_register_event_handler('init', 'system', 'adf_platform_init'); // Init

// Menu doit être chargé en dernier pour overrider le reste
//elgg_register_event_handler("init", "system", "adf_platform_pagesetup", 999); // Menu
elgg_register_event_handler("pagesetup", "system", "adf_platform_pagesetup"); // Menu

// Activation des notifications par mail lors de l'entrée dans un groupe
elgg_register_event_handler('create','member','adf_public_platform_group_join', 800);

// Suppression des notifications lorsqu'on quitte le groupe
elgg_register_event_handler('delete','member','adf_public_platform_group_leave', 800);


/**
 * Init adf_platform plugin.
 */
function adf_platform_init() {
  
  global $CONFIG;
  
  // CSS et JS
  elgg_extend_view('css/elgg', 'adf_platform/css');
  elgg_extend_view('css/admin', 'adf_platform/admin_css'); // Remplace la CSS ???
  // Nouveau thème : 
  elgg_extend_view('css/elgg', 'adf_platform/css/style');
  elgg_extend_view('css/ie', 'adf_platform/css/ie');
  elgg_extend_view('css/ie6', 'adf_platform/css/ie6');
  
  elgg_register_js('jquery', '/mod/adf_public_platform/views/default/adf_platform/js/jquery-1.7.2.min.php', 'head');
  elgg_register_js('adf_platform.fonction', 'mod/adf_public_platform/views/default/adf_platform/js/fonction.php', 'head');
  elgg_load_js('adf_platform.fonction');
  
  // Passe le datepicker en français
  elgg_register_js('jquery.datepicker.fr', 'mod/adf_public_platform/views/default/js/ui.datepicker-fr.php', 'head');
  elgg_load_js('jquery.datepicker.fr');
  
  
  // REMPLACEMENT DE HOOKS DU CORE OU DE PLUGINS
  // Pour changer la manière de filtrer les tags
	elgg_unregister_plugin_hook_handler('validate', 'input', 'htmlawed_filter_tags');
	elgg_register_plugin_hook_handler('validate', 'input', 'adf_platform_htmlawed_filter_tags', 1);
  if (elgg_is_active_plugin('threads')) {
    // Pour n'afficher "Répondre" que pour les objets (et non tous types d'entités)
    elgg_unregister_plugin_hook_handler('register', 'menu:entity', 'threads_topic_menu_setup');
    elgg_register_plugin_hook_handler('register', 'menu:entity', 'adf_platform_threads_topic_menu_setup');
  }
  // On enlève aussi les liens commentaires de la rivière
  //elgg_unregister_plugin_hook_handler('register', 'menu:river', 'threads_add_to_river_menu');
  elgg_unregister_plugin_hook_handler('register', 'menu:river', 'elgg_river_menu_setup');
  elgg_unregister_plugin_hook_handler('register', 'menu:river', 'discussion_add_to_river_menu');
  
  // Pour faire apparaître le menu dans le menu "apparence" - mais @todo intégrer dans un form
  //elgg_register_admin_menu_item('configure', 'adf_theme', 'appearance');
  
  // Remplacement page d'accueil par tableau de bord personnel
  if (elgg_is_logged_in()) {
    elgg_register_plugin_hook_handler('index','system','adf_platform_index');
  }
  
  // MODIFICATION DES MENUS STANDARDS
  elgg_unregister_plugin_hook_handler('register', 'menu:widget', 'elgg_widget_menu_setup');
  elgg_register_plugin_hook_handler('register', 'menu:widget', 'adf_platform_elgg_widget_menu_setup');
  // Modification des menus des groupes
  //elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'event_calendar_owner_block_menu');
  elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'adf_platform_owner_block_menu', 1000);
  
  
  //elgg_register_page_handler('dashboard', 'adf_platform_dashboard_page_handler');
  
  // Redirection après login
  elgg_register_event_handler('login','user','adf_platform_login_handler');
  
  
  // MODIFICATION DE PAGES DE LISTING (NON GÉRABLES PAR DES VUES)
  if (elgg_is_active_plugin('categories')) {
    // Pour ajouter la liste des catégories en sidebar
    elgg_unregister_page_handler('categories', 'categories_page_handler');
    elgg_register_page_handler('categories', 'adf_platform_categories_page_handler');
  }
  // Pour modifier la page de listing des groupes
	elgg_unregister_page_handler('groups', 'groups_page_handler');
  elgg_register_page_handler('groups', 'adf_platform_groups_page_handler');
	elgg_register_library('elgg:adf_platform:groups', elgg_get_plugins_path() . 'adf_public_platform/lib/groups.php');
	// Pour sélectionner "Tous" dans la recherche
	elgg_unregister_page_handler('search', 'search_page_handler');
	elgg_register_page_handler('search', 'adf_platform_search_page_handler');
	// Pour permettre à tout éditeur valable de la page d'y ajouter une sous-page'
	elgg_unregister_page_handler('pages', 'pages_page_handler');
	elgg_register_page_handler('pages', 'adf_platform_pages_page_handler');
	// Pour modifier la page d'arrivée par défaut en popular
	elgg_unregister_page_handler('members', 'members_page_handler');
	elgg_register_page_handler('members', 'adf_platform_members_page_handler');
	
	
	// Public pages - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'adf_public_platform_public_pages');
	
  /*
	elgg_register_event_handler('upgrade', 'upgrade', 'adf_platform_run_upgrades');

	// add to the main css
	elgg_extend_view('css/elgg', 'adf_platform/css');
function search_page_handler($page) {

	// if there is no q set, we're being called from a legacy installation
	// it expects a search by tags.
	// actually it doesn't, but maybe it should.
	// maintain backward compatibility
	if(!get_input('q', get_input('tag', NULL))) {
		set_input('q', $page[0]);
		//set_input('search_type', 'tags');
	}

	$base_dir = elgg_get_plugins_path() . 'search/pages/search';

	include_once("$base_dir/index.php");
	return true;
}
	// register the adf_platform's JavaScript
	$adf_platform_js = elgg_get_simplecache_url('js', 'adf_platform/save_draft');
	elgg_register_js('elgg.adf_platform', $adf_platform_js);

	// routing of urls
	elgg_register_page_handler('adf_platform', 'adf_platform_page_handler');

	// override the default url to view a adf_platform object
	elgg_register_entity_url_handler('object', 'adf_platform', 'adf_platform_url_handler');
	*/
	
	
	// Modification des titres des widgets
	elgg_unregister_widget_type('blog');
	elgg_unregister_widget_type('bookmarks');
	elgg_unregister_widget_type('brainstorm');
	elgg_unregister_widget_type('event_calendar');
	elgg_unregister_widget_type('filerepo');
	elgg_unregister_widget_type('groups');
	elgg_unregister_widget_type('pages');
	elgg_register_widget_type('blog', elgg_echo('adf_platform:widget:blog:title'), elgg_echo('blog:widget:description'), 'profile');
	elgg_register_widget_type('bookmarks', elgg_echo('adf_platform:widget:bookmark:title'), elgg_echo('bookmarks:widget:description'));
	elgg_register_widget_type('brainstorm', elgg_echo('adf_platform:widget:brainstorm:title'), elgg_echo('brainstorm:widget:description'));
	elgg_register_widget_type('event_calendar',elgg_echo("adf_platform:widget:event_calendar:title"),elgg_echo('event_calendar:widget:description'));
	elgg_register_widget_type('filerepo', elgg_echo('adf_platform:widget:file:title'), elgg_echo("file:widget:description"));
	elgg_register_widget_type('a_users_groups', elgg_echo('adf_platform:widget:group:title'), elgg_echo('groups:widgets:description'));
	elgg_register_widget_type('pages', elgg_echo('adf_platform:widget:page:title'), elgg_echo('pages:widget:description'));
	
	
	// Modification du Fil d'Ariane
	elgg_register_plugin_hook_handler('view', 'navigation/breadcrumbs', 'adf_platform_alter_breadcrumb');
	
}


/**
 * htmLawed filtering of data
 *
 * Called on the 'validate', 'input' plugin hook
 *
 * Triggers the 'config', 'htmlawed' plugin hook so that plugins can change
 * htmlawed's configuration. For information on configuraton options, see
 * http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm#s2.2
 *
 * @param string $hook   Hook name
 * @param string $type   The type of hook
 * @param mixed  $result Data to filter
 * @param array  $params Not used
 * @return mixed
 */
function adf_platform_htmlawed_filter_tags($hook, $type, $result, $params) {
	$var = $result;

	elgg_load_library('htmlawed');

	$htmlawed_config = array(
		  // seems to handle about everything we need.
		  // /!\ Liste blanche des balises autorisées
		  //'elements' => 'iframe,embed,object,param,video,script,style',
		  'safe' => false, // true est un peu radical, à moins de lister toutes les balises autorisées ci-dessus
		  // Attributs interdits
		  'deny_attribute' => 'on*',
		  // Filtrage suppélementaires des attributs autorisés (cf. start de htmLawed)
		  'hook_tag' => 'htmlawed_tag_post_processor',
		
		  'schemes' => '*:http,https,ftp,news,mailto,rtsp,teamspeak,gopher,mms,callto',
		  // apparent this doesn't work.
		  // 'style:color,cursor,text-align,font-size,font-weight,font-style,border,margin,padding,float'
	  );
	
	// add nofollow to all links on output
	if (!elgg_in_context('input')) {
		$htmlawed_config['anti_link_spam'] = array('/./', '');
	}
	
	$htmlawed_config = elgg_trigger_plugin_hook('config', 'htmlawed', null, $htmlawed_config);
	
	if (!is_array($var)) {
		$result = htmLawed($var, $htmlawed_config);
	} else {
		array_walk_recursive($var, 'htmLawedArray', $htmlawed_config);
		$result = $var;
	}

	return $result;
}


function adf_platform_members_page_handler($page) {
	$base = elgg_get_plugins_path() . 'members/pages/members';
	if (!isset($page[0])) { $page[0] = 'online'; }
	$vars = array();
	$vars['page'] = $page[0];
	if ($page[0] == 'search') {
		$vars['search_type'] = $page[1];
		require_once "$base/search.php";
	} else {
		require_once "$base/index.php";
	}
	return true;
}

function adf_platform_pages_page_handler($page) {
	elgg_load_library('elgg:pages');
	// add the jquery treeview files for navigation
	elgg_load_js('jquery-treeview');
	elgg_load_css('jquery-treeview');
	if (!isset($page[0])) { $page[0] = 'all'; }
	elgg_push_breadcrumb(elgg_echo('pages'), 'pages/all');
	$base_dir = elgg_get_plugins_path() . 'pages/pages/pages';
	$alt_base_dir = elgg_get_plugins_path() . 'adf_public_platform/pages/pages';

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			include "$alt_base_dir/owner.php";
			break;
		case 'friends':
			include "$base_dir/friends.php";
			break;
		case 'view':
			set_input('guid', $page[1]);
			include "$alt_base_dir/view.php";
			break;
		case 'add':
			set_input('guid', $page[1]);
			include "$base_dir/new.php";
			break;
		case 'edit':
			set_input('guid', $page[1]);
			include "$base_dir/edit.php";
			break;
		case 'group':
			include "$alt_base_dir/owner.php";
			break;
		case 'history':
			set_input('guid', $page[1]);
			include "$base_dir/history.php";
			break;
		case 'revision':
			set_input('id', $page[1]);
			include "$base_dir/revision.php";
			break;
		case 'all':
			include "$base_dir/world.php";
			break;
		default:
			return false;
	}
	return true;
}


function adf_public_platform_public_pages($hook, $type, $return_value, $params) {
  // Get and prepare valid domain config array from plugin settings
  $publicpages = get_plugin_setting('publicpages', 'adf_public_platform');
  $publicpages = preg_replace('/\r\n|\r/', "\n", $publicpages);
  // Add csv support - cut also on ";" and ","
  $publicpages = str_replace(array(' ', '<p>', '</p>'), '', $publicpages); // Delete all white spaces
  $publicpages = str_replace(array(';', ','), "\n", $publicpages);
  $publicpages = explode("\n",$publicpages);
  foreach ($publicpages as $publicpage) {
    if (!empty($publicpage)) $return_value[] = $publicpage;
  }
  /* Pages publiques ADF au 27 juillet 2012
  $return_value[] = 'pages/view/3792/charte-de-dpartements-en-rseaux';
  $return_value[] = 'pages/view/3819/mentions-lgales';
  $return_value[] = 'pages/view/3827/a-propos-de-dpartements-en-rseaux';
  $return_value[] = 'pages/group/3519/all';
  */
  /* Les pages à rendre accessibles doivent correspondre  à l'URL complète
  $return_value[] = '';
  */
  return $return_value;
}


function adf_platform_search_page_handler($page) {
	// if there is no q set, we're being called from a legacy installation
	// it expects a search by tags.
	// actually it doesn't, but maybe it should.
	// maintain backward compatibility
	if(!get_input('q', get_input('tag', NULL))) {
		set_input('q', $page[0]);
		//set_input('search_type', 'tags');
	}
	$base_dir = elgg_get_plugins_path() . 'adf_public_platform/pages/search';
	include_once("$base_dir/index.php");
	return true;
}


function adf_platform_groups_page_handler($page) {
	elgg_load_library('elgg:groups');
	elgg_load_library('elgg:adf_platform:groups');

	elgg_push_breadcrumb(elgg_echo('groups'), "groups/all");

	switch ($page[0]) {
		case 'all':
			adf_platform_groups_handle_all_page();
			break;
		case 'search':
			groups_search_page();
			break;
		case 'owner':
			groups_handle_owned_page();
			break;
		case 'member':
			set_input('username', $page[1]);
			groups_handle_mine_page();
			break;
		case 'invitations':
			set_input('username', $page[1]);
			groups_handle_invitations_page();
			break;
		case 'add':
			groups_handle_edit_page('add');
			break;
		case 'edit':
			groups_handle_edit_page('edit', $page[1]);
			break;
		case 'profile':
			groups_handle_profile_page($page[1]);
			break;
		case 'activity':
			groups_handle_activity_page($page[1]);
			break;
		case 'members':
			groups_handle_members_page($page[1]);
			break;
		case 'invite':
			groups_handle_invite_page($page[1]);
			break;
		case 'requests':
			groups_handle_requests_page($page[1]);
			break;
		default:
			return false;
	}
	return true;
}


function adf_platform_threads_topic_menu_setup($hook, $type, $return, $params){
	//return $return; // Pas besoin d'ajouter le form si on l'affiche d'entrée de jeu
	
	$entity = $params['entity'];
	
	elgg_load_library('elgg:threads');
	elgg_load_js('jquery.plugins.parsequery');
  elgg_load_js('elgg.threads');
	
	$group = $entity->getContainerEntity();
	$topic = threads_top($entity->guid);
	
	// Facyla : on limite ça aux objets : n'a pas de sens pour groupes et membres
	if(elgg_instanceof($entity, 'object') 
	  && ($group && $group->canWriteToContainer() || elgg_is_admin_logged_in()) 
	  && $topic->status != 'closed'
	  ){
		$url = elgg_http_add_url_query_elements($topic->getURL(), array(
			'box' => 'reply',
			'guid' => $entity->guid,
		));
		//$url .= '#elgg_add_comment_' . $entity->guid;

		$options = array(
			'name' => 'reply',
			'href' => $url,
			'text' => elgg_echo('reply'),
			'text_encode' => false,
			'priority' => 200
		);
		$return[] = ElggMenuItem::factory($options);
	}
	return $return;
}

function adf_platform_categories_page_handler() {
	include(dirname(__FILE__) . "/pages/categories/listing.php");
	return true;
}

/* Modifications des menus de l'owner_block : sélectionne l'outil utilisé */
function adf_platform_owner_block_menu($hook, $type, $return, $params) {
	foreach ($return as $item) {
  	if (elgg_in_context($item->getName())) $item->setSelected();
	}
	return $return;
}

/* Boutons des widgets */
function adf_platform_elgg_widget_menu_setup($hook, $type, $return, $params) {
  global $CONFIG;
  $urlicon = $CONFIG->url . 'mod/adf_public_platform/img/theme/';
  
  $widget = $params['entity'];
  $show_edit = elgg_extract('show_edit', $params, true);
  
  $widget_title = $widget->getTitle();
  $collapse = array(
      'name' => 'collapse',
      'text' => '<img src="' . $urlicon . 'masquer.png" alt="' . elgg_echo('widget:toggle', array($widget_title)) . '" />',
      'href' => "#elgg-widget-content-$widget->guid",
      'class' => 'masquer',
      'rel' => 'toggle',
      'priority' => 900
    );
  $return[] = ElggMenuItem::factory($collapse);
  
  if ($widget->canEdit()) {
    $delete = array(
        'name' => 'delete',
        'text' => '<img src="' . $urlicon . 'suppr.png" alt="' . elgg_echo('widget:delete', array($widget_title)) . '" />',
        'href' => "action/widgets/delete?widget_guid=" . $widget->guid,
        'is_action' => true,
        'class' => 'elgg-widget-delete-button suppr',
        'id' => "elgg-widget-delete-button-$widget->guid",
        'priority' => 900
      );
    $return[] = ElggMenuItem::factory($delete);

    if ($show_edit) {
      $edit = array(
          'name' => 'settings',
          'text' => '<img src="' . $urlicon . 'config.png" alt="' . elgg_echo('widget:editmodule', array($widget_title)) . '" />',
          'href' => "#widget-edit-$widget->guid",
          'class' => "elgg-widget-edit-button config",
          'rel' => 'toggle',
          'priority' => 800,
        );
      $return[] = ElggMenuItem::factory($edit);
    }
  }
  
  return $return;
}



function adf_platform_pagesetup(){
  /*
  if (elgg_is_logged_in()) {
    elgg_unregister_menu_item('topbar', 'elgg_logo');
  }
  */
	if (elgg_is_logged_in()) {
  	
		// Remove unwanted personnal tools : keep only files (embed), bookmarks, and ideas
		if (elgg_instanceof(elgg_get_page_owner_entity(), 'ElggUser')) {
		  elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'file_owner_block_menu');
		  elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'blog_owner_block_menu');
		  elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'bookmarks_owner_block_menu');
		  elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'brainstorm_owner_block_menu');
		  elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'pages_owner_block_menu');
		}
  	
  	// Retire les demandes de contact des messages
  	if (elgg_get_context() == "messages") { elgg_unregister_menu_item("page", "friend_request"); }
  	
  	// Report content link
		elgg_unregister_menu_item('footer', 'report_this');
  	// Extend extras instead of footer with report content link
		$href = "javascript:elgg.forward('reportedcontent/add'";
		$href .= "+'?address='+encodeURIComponent(location.href)";
		$href .= "+'&title='+encodeURIComponent(document.title));";
		elgg_register_menu_item('extras', array(
			  'name' => 'report_this', 'href' => $href, 'rel' => 'nofollow',
			  'title' => elgg_echo('reportedcontent:this:tooltip'),
			  'text' => '<span class="elgg-icon elgg-icon-report-this "><span class="invisible">Signaler cette page</span></span>', 
		  ));
	}
	
	// Rewrite breadcrumbs : use a more user-friendly logic
	// Structure du Fil : Accueil (site) > Container (group/user page owner) > Subtype > Content > action
	// Default structure : Tool > Tool for page owner > Content > Subcontent  => Home > Page owner (group or user) > Tool for page owner > Content > Subcontent
	// Group structure : All groups > Page owner (group or user)  => Home > Page owner (group or user)
	// Target structure : Home > Page owner (group or user) > Tool for page owner > Content > Subcontent
	// @todo : Insert Home at first, replace 1st entry with page owner, rename owner tool using context
	if (elgg_get_viewtype() == 'default') {
	  global $CONFIG;
	  if (is_array($CONFIG->breadcrumbs)) {
  	  // Remove "Tool home" entry
  	  unset ($CONFIG->breadcrumbs[0]);
  	  // Rename "Owner tool" to the tool name
  	  //$CONFIG->breadcrumbs[1]['title'] = elgg_echo(elgg_get_context()) . ' ' . $CONFIG->breadcrumbs[1]['title'];
  	  $CONFIG->breadcrumbs[1]['title'] = elgg_echo(elgg_get_context());
	    // Insert page owner only if it's a user or group (not a site..)
	    $page_owner = elgg_get_page_owner_entity();
	    if ($page_owner instanceof ElggGroup) {
      	array_unshift($CONFIG->breadcrumbs, array('title' => $page_owner->name, 'link' => $CONFIG->url . 'groups/profile/' . $page_owner->guid . '/' . $page_owner->name) );
	    } else if ($page_owner instanceof ElggUser) {
      	array_unshift($CONFIG->breadcrumbs, array('title' => $page_owner->name, 'link' => $CONFIG->url . 'profile/' . $page_owner->username) );
	    }
	    // Insert home link in all cases
    	array_unshift($CONFIG->breadcrumbs, array('title' => $CONFIG->sitename, 'link' => $CONFIG->url));
	  } else {
	    $CONFIG->breadcrumbs = array(
	        array('title' => $CONFIG->sitename, 'link' => $CONFIG->url), 
	        array('title' => elgg_echo(elgg_get_context()), 'link' => $CONFIG->url . elgg_get_context())
	      );
	  }
	}
	
  return true;
}


/* Permet de modifier chacun des éléments du Fil d'Ariane *individuellement*
function adf_platform_alter_breadcrumb($hook, $type, $returnvalue, $params) {
    // we only want to alter when viewtype is "default"
    if ($params['viewtype'] !== 'default') {
        return $returnvalue;
    }
    // output nothing if the content doesn't have a single link
    if (false === strpos($returnvalue, '<a ')) {
        return '';
    }
}
*/

// Remplace l'index par un tableau de bord légèrement modifié
function adf_platform_index() {
  global $CONFIG;
  
	// Ensure that only logged-in users can see this page
	gatekeeper();

	// Set context and title
	elgg_set_context('dashboard');
	elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());
	$title = elgg_echo('dashboard');
	
	// Define static elements in top of widgets - or use a modified widgets view directly
	$static .= '<h2 class="invisible">Tableau de bord personnalisable</h2><hr />';
	
  if (elgg_is_logged_in()) {
    $intro = elgg_get_plugin_setting('dashboardheader', 'adf_public_platform');
  	if (empty($intro)) { $intro = 'Bienvenue sur votre plateforme collaborative.<br />Vous allez pouvoir partager vos projets et échanger vos expériences avec votre communauté. Administrateurs du site, pensez à éditer ce message !'; }
	  $firststeps_page = get_entity(182);
// @DEBUG : Affiché 1ère fois seulement // prev_last_login
/*
$intro .= "test : ";
$intro .= "test : " . $_SESSION['user']->last_login;
$intro .= "test : " . $_SESSION['user']->prev_last_login;
*/
	  if (($_SESSION['user']->last_login >= 0) && ($_SESSION['user']->prev_last_login >= 0)) {
	    $first_time = '<script type="text/javascript">
	    $(document).ready(function() {
  	    $(\'#firsteps_toggle\').hide();
	    })
	    </script>';
	  }
 	  $firststeps = '<div class="firststeps"><a href="javascript:void(0);" onClick="$(\'#firsteps_toggle\').toggle();">Premiers pas (cliquer pour afficher / masquer)</a>'
 	  . '<div id="firsteps_toggle" style=" border:2px solid grey; background:#DEDEDE; padding:10px;">'
	  . $firststeps_page->description
 	  . '</div>' 
	  . '</div>';
	  $firststeps .= $first_time;
    
	  $static = '<header><div class="intro">' . $firststeps . $intro . '</div></header>';
  }
  
	// wrap intro message in a div
	//$intro_message = elgg_view('dashboard/blurb');
	$params = array(
		'content' => $intro_message,
		'num_columns' => 3,
		'show_access' => false,
	);
	$widgets = elgg_view_layout('widgets', $params);
	
	//$body = elgg_view_layout('one_column', array('content' => $static . '<div class="clearfloat"></div>' . $widgets));
	$body = $static . '<div class="clearfloat"></div>' . $widgets;

	echo elgg_view_page($title, $body);
	return true;
}


function adf_public_platform_group_join($event, $object_type, $relationship) {
  if (elgg_is_logged_in()) {
    if (($relationship instanceof ElggRelationship) && ($event == 'create') && ($object_type == 'member')) {
      add_entity_relationship($relationship->guid_one, 'notifyemail', $relationship->guid_two);
    }
  }
  return true;
}
function adf_public_platform_group_leave($event, $object_type, $relationship) {
	global $NOTIFICATION_HANDLERS;
  if (($relationship instanceof ElggRelationship) && ($event == 'delete') && ($object_type == 'member')) {
  	// loop through all notification types
	  foreach($NOTIFICATION_HANDLERS as $method => $foo) {
		  remove_entity_relationship($relationship->guid_one, "notify{$method}", $relationship->guid_two);
	  }
  }
  return true;
}



/*
 * Forwards to internal referrer, if set
 * Otherwise redirects to home after login
*/
function adf_platform_login_handler($event, $object_type, $object) {
  global $CONFIG;
  // Si on vient d'une page particulière, retour à cette page
  if(!empty($_SESSION['referer'])) {
    $referer = $_SESSION['referer'];
    $_SESSION['referer'] = "";
    forward($referer);
  }
  // Sinon, pour aller sur la page d'accueil à la connexion
  $loginredirect = '';
  // On vérifie que l'URL est bien valide - Attention car on n'a plus rien si URL erronée !
  if (empty($loginredirect)) { forward($CONFIG->url); } else { forward($CONFIG->url . $loginredirect); }
}
/*
*/



/**
 * Dispatches adf_platform pages.
 * URLs take the form of
 *
 * Title is ignored
 *
 * @todo no archives for all adf_platforms or friends
 *
 * @param array $page
 * @return NULL
 */
/*
function adf_platform_page_handler($page) {
	$page_type = $page[0];
	switch ($page_type) {
		default:
			$title = elgg_echo('adf_platform:title');
			$params = array();
			break;
	}
	$params['sidebar'] .= elgg_view('adf_platform/sidebar', array('page' => $page_type));
	$body = elgg_view_layout('content', $params);

	echo elgg_view_page($params['title'], $body);
}
*/

