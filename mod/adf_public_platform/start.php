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
	elgg_extend_view('css/elgg', 'css/jquery-ui-1.10.2');
	elgg_extend_view('css/ie', 'adf_platform/css/ie');
	elgg_extend_view('css/ie6', 'adf_platform/css/ie6');
	elgg_extend_view('groups/sidebar/members','theme_items/online_groupmembers');
	
	// Accessibilité
	elgg_extend_view('css','accessibility/css');
	
	// jQuery
	elgg_register_js('jquery', '/mod/adf_public_platform/views/default/adf_platform/js/jquery-1.7.2.min.php', 'head');
	
	// Theme-specific JS (accessible menu)
	elgg_register_js('adf_platform.fonction', 'mod/adf_public_platform/views/default/adf_platform/js/fonction.php', 'head');
	elgg_load_js('adf_platform.fonction');
	
	// Passe le datepicker en français
	elgg_register_js('jquery.datepicker.fr', 'mod/adf_public_platform/views/default/js/ui.datepicker-fr.php', 'head');
	elgg_load_js('jquery.datepicker.fr');
	
	// Webdesign : Floatable elements (.is-floatable, .floating)
	elgg_register_js('floatable.elements', 'mod/adf_public_platform/vendors/floatable-elements.js', 'footer');
	elgg_load_js('floatable.elements');
	
	// Webdesign : Smooth scrolling : smooth transition for inline (anchors) links
	elgg_register_js('smooth.scrolling', 'mod/adf_public_platform/vendors/smooth.scrolling.js', 'head');
	elgg_load_js('smooth.scrolling');
	
	
	// REMPLACEMENT DE HOOKS DU CORE OU DE PLUGINS
	// Related functions are in lib/adf_public/platform/hooks.php
	// Pour changer la manière de filtrer les tags
	if (elgg_is_active_plugin('htmlawed')) {
		elgg_unregister_plugin_hook_handler('validate', 'input', 'htmlawed_filter_tags');
		elgg_register_plugin_hook_handler('validate', 'input', 'adf_platform_htmlawed_filter_tags', 1);
	}
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
	
	// Remplacement page d'accueil
	if (elgg_is_logged_in()) {
		// Remplacement page d'accueil par tableau de bord personnel
		// PARAM : Désactivé si vide, activé avec paramètre de config si non vide
		$replace_home = elgg_get_plugin_setting('replace_home', 'adf_public_platform');
		if (!empty($replace_home)) { elgg_register_plugin_hook_handler('index','system','adf_platform_index'); }
	} else {
		/*
		// Remplacement page d'accueil publique - ssi si pas en mode walled_garden
		// PARAM : Désactivé si vide, activé avec paramètre de config si non vide
		$replace_public_home = elgg_get_plugin_setting('replace_public_home', 'adf_public_platform');
		if (!empty($replace_public_home)) { elgg_register_plugin_hook_handler('index','system','adf_platform_public_index'); }
		*/
		$replace_public_home = elgg_get_plugin_setting('replace_public_homepage', 'adf_public_platform');
		if (!$CONFIG->walled_garden) {
			if ($replace_public_home != 'no') {
				elgg_register_plugin_hook_handler('index','system','adf_platform_public_index');
			}
		}
	}
	
	// MODIFICATION DES MENUS STANDARDS
	elgg_unregister_plugin_hook_handler('register', 'menu:widget', 'elgg_widget_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:widget', 'adf_platform_elgg_widget_menu_setup');
	// Modification des menus des groupes
	//elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'event_calendar_owner_block_menu');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'adf_platform_owner_block_menu', 1000);
	
	
	//elgg_register_page_handler('dashboard', 'adf_platform_dashboard_page_handler');
	
	// Redirection après login - load at last
	elgg_register_event_handler('login','user','adf_platform_login_handler', 999);
	
	// Actions après inscription
	elgg_register_event_handler('login','user','adf_platform_register_handler');
	
	// Modification de l'invitation de contacts dans les groupes (réglage : contacts ou tous)
	/* Permet notamment de forcer l'inscription
	*/
	if (elgg_is_active_plugin('groups')) {
		elgg_unregister_action('groups/invite');
		elgg_register_action("groups/invite", elgg_get_plugins_path() . 'adf_public_platform/actions/groups/membership/invite.php');
	}
	
	// PAGE HANDLERS : MODIFICATION DE PAGES DE LISTING (NON GÉRABLES PAR DES VUES)
	// Related functions are in lib/adf_public/platform/page_handlers.php
	if (elgg_is_active_plugin('categories')) {
		// Pour ajouter la liste des catégories en sidebar
		elgg_unregister_page_handler('categories', 'categories_page_handler');
		elgg_register_page_handler('categories', 'adf_platform_categories_page_handler');
	}
	// Pour modifier la page de listing des groupes
	elgg_unregister_page_handler('groups', 'groups_page_handler');
	elgg_register_page_handler('groups', 'adf_platform_groups_page_handler');
	// Add own library (different function names)
	elgg_register_library('elgg:adf_platform:groups', elgg_get_plugins_path() . 'adf_public_platform/lib/groups.php');
	if (elgg_is_active_plugin('au_subgroups')) {
		// route some urls that go through 'groups' handler
		elgg_unregister_plugin_hook_handler('route', 'groups', 'au_subgroups_groups_router');
		elgg_register_plugin_hook_handler('route', 'groups', 'adf_platform_subgroups_groups_router', 499);
	}
	// Pour sélectionner "Tous" dans la recherche
	elgg_unregister_page_handler('search', 'search_page_handler');
	elgg_register_page_handler('search', 'adf_platform_search_page_handler');
	// Pour permettre à tout éditeur valable de la page d'y ajouter une sous-page
	elgg_unregister_page_handler('pages', 'pages_page_handler');
	elgg_register_page_handler('pages', 'adf_platform_pages_page_handler');
	// Pour modifier la page d'arrivée par défaut en popular
	elgg_unregister_page_handler('members', 'members_page_handler');
	elgg_register_page_handler('members', 'adf_platform_members_page_handler');
	// Pour pouvoir lister tous les articles d'un membre (option du thème désactivée par défaut)
	elgg_unregister_page_handler('blog', 'blog_page_handler');
	elgg_register_page_handler('blog', 'adf_platform_blog_page_handler');
	elgg_register_library('elgg:blog', elgg_get_plugins_path() . 'adf_public_platform/lib/blog.php');
	// Pour pouvoir lister tous les bookmarks d'un membre (option du thème désactivée par défaut)
	elgg_unregister_page_handler('bookmarks', 'bookmarks_page_handler');
	elgg_register_page_handler('bookmarks', 'adf_platform_bookmarks_page_handler');
	// Pour pouvoir lister tous les fichiers d'un membre (option du thème désactivée par défaut)
	elgg_unregister_page_handler('file', 'file_page_handler');
	elgg_register_page_handler('file', 'adf_platform_file_page_handler');
	// Pour pouvoir modifier la page utilisateurs
	elgg_unregister_page_handler('profile', 'profile_page_handler');
	elgg_register_page_handler('profile', 'adf_platform_profile_page_handler');
	
	// Public pages - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'adf_public_platform_public_pages');
	
	// Modification des titres des widgets
	// Activation des plugins
	$widget_blog = elgg_get_plugin_setting('widget_blog', 'adf_public_platform');
	$widget_bookmarks = elgg_get_plugin_setting('widget_bookmarks', 'adf_public_platform');
	$widget_brainstorm = elgg_get_plugin_setting('widget_brainstorm', 'adf_public_platform');
	$widget_event_calendar = elgg_get_plugin_setting('widget_event_calendar', 'adf_public_platform');
	$widget_file = elgg_get_plugin_setting('widget_file', 'adf_public_platform');
	$widget_groups = elgg_get_plugin_setting('widget_groups', 'adf_public_platform');
	$widget_pages = elgg_get_plugin_setting('widget_pages', 'adf_public_platform');
	$widget_friends = elgg_get_plugin_setting('widget_friends', 'adf_public_platform');
	$widget_group_activity = elgg_get_plugin_setting('widget_group_activity', 'adf_public_platform');
	$widget_messages = elgg_get_plugin_setting('widget_messages', 'adf_public_platform');
	$widget_webprofiles = elgg_get_plugin_setting('widget_webprofiles', 'adf_public_platform');
	$widget_river_widget = elgg_get_plugin_setting('widget_river_widget', 'adf_public_platform');
	$widget_twitter = elgg_get_plugin_setting('widget_twitter', 'adf_public_platform');
	$widget_tagcloud = elgg_get_plugin_setting('widget_tagcloud', 'adf_public_platform');
	$widget_videos = elgg_get_plugin_setting('widget_videos', 'adf_public_platform');
	$widget_webprofiles = elgg_get_plugin_setting('widget_webprofiles', 'adf_public_platform');
	
	elgg_unregister_widget_type('blog');
	if (elgg_is_active_plugin('blog')) {
		if ($widget_blog != 'no') elgg_register_widget_type('blog', elgg_echo('adf_platform:widget:blog:title'), elgg_echo('blog:widget:description'));
	}
	
	elgg_unregister_widget_type('bookmarks');
	if (elgg_is_active_plugin('bookmarks')) {
		if ($widget_bookmarks != 'no') elgg_register_widget_type('bookmarks', elgg_echo('adf_platform:widget:bookmark:title'), elgg_echo('bookmarks:widget:description'));
	}
	
	elgg_unregister_widget_type('brainstorm');
	if (elgg_is_active_plugin('brainstorm')) {
		if ($widget_brainstorm != 'no') elgg_register_widget_type('brainstorm', elgg_echo('adf_platform:widget:brainstorm:title'), elgg_echo('brainstorm:widget:description'));
	}
	
	elgg_unregister_widget_type('event_calendar');
	if (elgg_is_active_plugin('event_calendar')) {
		if ($widget_event_calendar != 'no') elgg_register_widget_type('event_calendar',elgg_echo("adf_platform:widget:event_calendar:title"),elgg_echo('event_calendar:widget:description'));
	}
	
	elgg_unregister_widget_type('filerepo');
	if (elgg_is_active_plugin('file')) {
		if ($widget_file != 'no') elgg_register_widget_type('filerepo', elgg_echo('adf_platform:widget:file:title'), elgg_echo("file:widget:description"));
	}
	
	if ($widget_friends == 'no') elgg_unregister_widget_type('friends');
	
	if ($widget_river_widget == 'no') elgg_unregister_widget_type('river_widget');
	
	if (elgg_is_active_plugin('twitter')) {
		if ($widget_twitter == 'no') elgg_unregister_widget_type('twitter');
	}
	
	if (elgg_is_active_plugin('tagcloud')) {
		if ($widget_tagcloud == 'no') elgg_unregister_widget_type('tagcloud');
	}
	
	if (elgg_is_active_plugin('videos')) {
		if ($widget_videos == 'no') elgg_unregister_widget_type('videos');
	}
	
	elgg_unregister_widget_type('a_users_groups');
	if (elgg_is_active_plugin('groups')) {
		if ($widget_group_activity == 'no') elgg_unregister_widget_type('group_activity');
		if ($widget_groups != 'no') elgg_register_widget_type('a_users_groups', elgg_echo('adf_platform:widget:group:title'), elgg_echo('groups:widgets:description'));
	}
	
	elgg_unregister_widget_type('pages');
	if (elgg_is_active_plugin('pages')) {
		if ($widget_pages != 'no') elgg_register_widget_type('pages', elgg_echo('adf_platform:widget:page:title'), elgg_echo('pages:widget:description'));
	}
	
	elgg_unregister_widget_type('profile_completeness');
	if (elgg_is_active_plugin('profile_manager')) {
		if (elgg_get_plugin_setting("enable_profile_completeness_widget", "profile_manager") == "yes") {
			elgg_register_widget_type('profile_completeness', elgg_echo("widgets:profile_completeness:title"), elgg_echo("widgets:profile_completeness:description"), "profile,dashboard");
		}
	}
	
	// Nouveaux widgets
	if (elgg_is_active_plugin('messages')) {
		if ($widget_messages != 'no') elgg_register_widget_type('messages', elgg_echo('messages:widget:title'), elgg_echo('messages:widget:description'), 'dashboard');
	}
	
	if (elgg_is_active_plugin('webprofiles')) {
		if ($widget_webprofiles != 'no') elgg_register_widget_type('webprofiles', elgg_echo('webprofiles:widget:title'), elgg_echo('webprofiles:widget:description'), 'profile');
	}
	
	
	// Modification du Fil d'Ariane
	elgg_register_plugin_hook_handler('view', 'navigation/breadcrumbs', 'adf_platform_alter_breadcrumb');
	
	// register the color picker's JavaScript
	$colorpicker_js = elgg_get_simplecache_url('js', 'input/color_picker');
	elgg_register_simplecache_view('js/input/color_picker');
	elgg_register_js('elgg.input.colorpicker', $colorpicker_js);
	
	// register the color picker's CSS
	$colorpicker_css = elgg_get_simplecache_url('css', 'input/color_picker');
	elgg_register_simplecache_view('css/input/color_picker');
	elgg_register_css('elgg.input.colorpicker', $colorpicker_css);
	
	// Profil non public par défaut, si réglage activé
	$public_profiles = elgg_get_plugin_setting('public_profiles', 'adf_public_platform');
	if ($public_profiles == 'yes') {
		// Verrouillage de certaines pages à haut niveau (via le page_handler) 
		// Attention : ça ne bloque pas un accès direct s'il existe des fichiers à la racine du plugin...
		elgg_register_plugin_hook_handler('route', 'all', 'adf_platform_route');
		// Réglage pour l'utilisateur
		elgg_extend_view("forms/account/settings", "adf_platform/account/public_profile", 600); // En haut des réglages
		// Hook pour modifier le nouveau réglage ajouté aux paramètres personnels
		elgg_register_plugin_hook_handler('usersettings:save', 'user', 'adf_platform_public_profile_hook');
		// @TODO : compléter par un blocage direct au niveau de l'entité elle-même pour les listings et autres photos 
		// (non bloquant mais avec contenu vide à la place)
	}
	
	// Ssi déconnecté, hook pour les redirections pour renvoyer sur le login
	if (!elgg_is_logged_in()) {
		elgg_register_plugin_hook_handler('forward', 'all', 'adf_platform_public_forward_login_hook');
	}
	
}


// Include hooks & page_handlers functions (lightens this file)
require_once(dirname(__FILE__) . '/lib/adf_public_platform/page_handlers.php');
require_once(dirname(__FILE__) . '/lib/adf_public_platform/hooks.php');



function adf_platform_pagesetup(){
	/*
	if (elgg_is_logged_in()) {
		elgg_unregister_menu_item('topbar', 'elgg_logo');
	}
	*/
	if (elgg_is_logged_in()) {
		
		// ESOPE : remove personnal tools from user tools (removes creation button)
		$remove_user_tools = elgg_get_plugin_setting('remove_user_tools', 'adf_public_platform');
		if ($remove_user_tools) {
			/* Note : removing personnal tools means remove the add button, not the filter
			global $CONFIG;
			print_r($CONFIG->menus['title']);
			*/
			$remove_user_tools = explode(',', $remove_user_tools);
			$context = elgg_get_context();
			if (in_array($context, $remove_user_tools)) elgg_unregister_menu_item('title', 'add');
		}
		
		
		// Retire les demandes de contact des messages
		if (elgg_get_context() == "messages") { elgg_unregister_menu_item("page", "friend_request"); }
		
		// Report content link
		elgg_unregister_menu_item('footer', 'report_this');
		if (elgg_is_active_plugin('reportedcontent')) {
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
		
		// Admin menus
		if(elgg_in_context("admin") && elgg_is_admin_logged_in()){
			// Remove menu builder (unused)
			elgg_unregister_menu_item("page", "appearance:menu_items");
			// Add to Admin > appearance menu
			elgg_register_admin_menu_item('configure', 'main_theme_config', 'appearance');
		}
		
	}
	
	// Rewrite breadcrumbs : use a more user-friendly logic
	// Structure du Fil : Accueil (site) > Container (group/user page owner) > Subtype > Content > action
	// Default structure : Tool > Tool for page owner > Content > Subcontent	=> Home > Page owner (group or user) > Tool for page owner > Content > Subcontent
	// Group structure : All groups > Page owner (group or user)	=> Home > Page owner (group or user)
	// Target structure : Home > Page owner (group or user) > Tool for page owner > Content > Subcontent
	// @todo : Insert Home at first, replace 1st entry with page owner, rename owner tool using context
	if (elgg_get_viewtype() == 'default') {
		global $CONFIG;
		$context = elgg_get_context();
		if (is_array($CONFIG->breadcrumbs)) {
			
			/*
			// Pour intervenir sur le dernier élément du fil d'Ariane
			$last = sizeof($CONFIG->breadcrumbs) - 1;
			error_log("LAST : $last" . print_r($CONFIG->breadcrumbs[$last], true));
			if ($CONFIG->breadcrumbs[$last]['title'] == elgg_echo('groups')) $CONFIG->breadcrumbs[$last]['title'] = $CONFIG->breadcrumbs[$last]['title'];
			*/
			
			// Remove "Tool home" entry - except for groups (all groups link)
			if (!in_array($context, array('groups', 'profile'))) {
				unset ($CONFIG->breadcrumbs[0]);
			}
			
			// Rename "Owner tool" to the tool name (except for groups - keep group title)
			//$CONFIG->breadcrumbs[1]['title'] = elgg_echo(elgg_get_context()) . ' ' . $CONFIG->breadcrumbs[1]['title'];
			if (!in_array($context, array('groups', 'profile'))) $CONFIG->breadcrumbs[1]['title'] = elgg_echo($context);
			
			// Insert page owner only if it's a user or group (not a site..), and it's not set by the context
			$page_owner = elgg_get_page_owner_entity();
			if ($page_owner instanceof ElggGroup) {
				if (!elgg_in_context('groups')) {
					$group_url = $CONFIG->url . 'groups/profile/' . $page_owner->guid . '/' . elgg_get_friendly_title($page_owner->name);
					array_unshift($CONFIG->breadcrumbs, array('title' => $page_owner->name, 'link' => $group_url) );
					array_unshift($CONFIG->breadcrumbs, array('title' => elgg_echo('groups'), 'link' => 'groups/all') );
				}
			} else if ($page_owner instanceof ElggUser) {
				array_unshift($CONFIG->breadcrumbs, array('title' => $page_owner->name, 'link' => $CONFIG->url . 'profile/' . $page_owner->username) );
				array_unshift($CONFIG->breadcrumbs, array('title' => elgg_echo('adf_platform:directory'), 'link' => $CONFIG->url . 'members') );
			}
			
			// Insert home link in all cases
			array_unshift($CONFIG->breadcrumbs, array('title' => elgg_echo('adf_platform:homepage'), 'link' => $CONFIG->url));
			
		} else {
			//$CONFIG->breadcrumbs[] = array('title' => $CONFIG->sitename, 'link' => $CONFIG->url);
			$CONFIG->breadcrumbs[] = array('title' => elgg_echo('adf_platform:homepage'), 'link' => $CONFIG->url);
			
			// Corrections selon le contexte
			if (elgg_in_context('profile')) {
				// Annuaire => Nom du membre
				$page_owner = elgg_get_page_owner_entity();
				$CONFIG->breadcrumbs[] = array('title' => elgg_echo('adf_platform:directory'), 'link' => $CONFIG->url . 'members');
				$CONFIG->breadcrumbs[] = array('title' => $page_owner->name);
			} else if (elgg_in_context('members')) {
				// Membres => Annuaire
				$CONFIG->breadcrumbs[] = array('title' => elgg_echo('adf_platform:directory'));
			} else {
				// Par défaut : contexte
				$CONFIG->breadcrumbs[] = array('title' => elgg_echo(elgg_get_context()), 'link' => $CONFIG->url . $context);
			}
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
	/* Pour remplacer par une page spécifique
	$replace_home = elgg_get_plugin_setting('replace_home', 'adf_public_platform');
	if ($replace_home != 'yes') {
		$homepage_test = @fopen($CONFIG->url . $replace_home, 'r'); 
		if ($homepage_test) {
			fclose($$homepage_test);
			forward($CONFIG->url . $replace_home);
		}
	} else {}
	*/
	include(dirname(__FILE__) . '/pages/adf_platform/homepage.php');
	return true;
}


// Remplace la page d'accueil publique par une page spécifique : le mieux reste de retravailler le layout "default" ou "walled_garden"
function adf_platform_public_index() {
	global $CONFIG;
	/*
	$replace_public_home = elgg_get_plugin_setting('replace_public_home', 'adf_public_platform');
	$homepage_test = @fopen($CONFIG->url . $replace_public_home, 'r'); 
	if ($homepage_test) {
		fclose($homepage_test);
		include($CONFIG->url . $replace_public_home);
	}
	*/
	$replace_public_home = elgg_get_plugin_setting('replace_public_home', 'adf_public_platform');
	switch($replace_public_home) {
		case 'cmspages':
			include(dirname(__FILE__) . '/pages/adf_platform/public_homepage.php');
			break;
		case 'default':
		default:
			include(dirname(__FILE__) . '/pages/adf_platform/public_homepage.php');
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
	$back_to_last = $_SESSION['last_forward_from'];
	if(!empty($back_to_last)) {
		//register_error("Redirection vers $back_to_last");
		forward($back_to_last);
	}
	// Sinon, pour aller sur la page indiquée à la connexion (accueil par défaut)
	$loginredirect = elgg_get_plugin_setting('redirect', 'adf_public_platform');
	// On vérifie que l'URL est bien valide - Attention car on n'a plus rien si URL erronée !
	if (!empty($loginredirect)) { forward($CONFIG->url . $loginredirect); }
	forward();
}

function adf_platform_public_forward_login_hook($hook_name, $entity_type, $return_value, $parameters) {
	global $CONFIG;
	//register_error("TEST : " . $_SESSION['last_forward_from'] . " // " . $parameters['current_url']);
	// Si jamais la valeur de retour n'est pas définie, on le fait
	if (empty($_SESSION['last_forward_from'])) $_SESSION['last_forward_from'] = $parameters['current_url'];
	if (!elgg_is_logged_in()) return $CONFIG->url . 'login';
	return null;
}

/*
 * Performs some actions after registration
*/
function adf_platform_register_handler($event, $object_type, $object) {
	global $CONFIG;
	// Groupe principal (à partir du GUID de ce groupe)
	$homegroup_guid = elgg_get_plugin_setting('homegroup_guid', 'adf_public_platform');
	$homegroup_autojoin = elgg_get_plugin_setting('homegroup_autojoin', 'adf_public_platform');
	if (elgg_is_active_plugin('groups') && !empty($homegroup_guid) && ($homegroup = get_entity($homegroup_guid)) && in_array($homegroup_autojoin, array('yes', 'force'))) {
		$user = elgg_get_logged_in_user_entity();
		// Si pas déjà fait, on l'inscrit
		if (!$homegroup->isMember($user)) { $homegroup->join($user); }
	}
}



// Ajoute les notifications lorsqu'on rejoint un groupe
function adf_public_platform_group_join($event, $object_type, $relationship) {
	if (elgg_is_logged_in()) {
		if (($relationship instanceof ElggRelationship) && ($event == 'create') && ($object_type == 'member')) {
			add_entity_relationship($relationship->guid_one, 'notifyemail', $relationship->guid_two);
		}
	}
	return true;
}

// Retire les notifications lorsqu'on quitte un groupe
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


if (!function_exists('messages_get_unread')) {
	/**
	 * Returns the unread messages in a user's inbox
	 *
	 * @param int $user_guid GUID of user whose inbox we're counting (0 for logged in user)
	 * @param int $limit Number of unread messages to return (default = 10)
	 *
	 * @return array
	 */
	function messages_get_unread($user_guid = 0, $limit = 10) {
		if (!$user_guid) {
			$user_guid = elgg_get_logged_in_user_guid();
		}
		$db_prefix = elgg_get_config('dbprefix');

		// denormalize the md to speed things up.
		// seriously, 10 joins if you don't.
		$strings = array('toId', $user_guid, 'readYet', 0, 'msg', 1);
		$map = array();
		foreach ($strings as $string) {
			$id = get_metastring_id($string);
			$map[$string] = $id;
		}

		$options = array(
	//		'metadata_name_value_pairs' => array(
	//			'toId' => elgg_get_logged_in_user_guid(),
	//			'readYet' => 0,
	//			'msg' => 1
	//		),
			'joins' => array(
				"JOIN {$db_prefix}metadata msg_toId on e.guid = msg_toId.entity_guid",
				"JOIN {$db_prefix}metadata msg_readYet on e.guid = msg_readYet.entity_guid",
				"JOIN {$db_prefix}metadata msg_msg on e.guid = msg_msg.entity_guid",
			),
			'wheres' => array(
				"msg_toId.name_id='{$map['toId']}' AND msg_toId.value_id='{$map[$user_guid]}'",
				"msg_readYet.name_id='{$map['readYet']}' AND msg_readYet.value_id='{$map[0]}'",
				"msg_msg.name_id='{$map['msg']}' AND msg_msg.value_id='{$map[1]}'",
			),
			'owner_guid' => $user_guid,
			'limit' => $limit,
		);

		return elgg_get_entities_from_metadata($options);
	}
}


if (elgg_is_active_plugin('au_subgroups')) {
	function adf_platform_list_groups_submenu($group, $level = 1, $member_only = false, $user = null) {
		if ($member_only && !$user) { $user = elgg_get_logged_in_user_entity(); }
		$menuitem = '';
		$class = "subgroup subgroup-$level";
		$children = au_subgroups_get_subgroups($group, 0);
		if (!$children) { return ''; }
		foreach ($children as $child) {
			if ($member_only) {
				if (!$child->isMember($user)) { continue; }
			}
			$menuitem .= '<li class="' . $class . '"><a href="' . $child->getURL() . '">' . '<img src="' . $child->getIconURL('tiny') . '" alt="' . str_replace('"', "''", $child->name) . ' (' . elgg_echo('adf_platform:groupicon') . '" />' . $child->name . '</a></li>';
			$menuitem .= adf_platform_list_groups_submenu($child, $level + 1);
		}
		return $menuitem;
	}
}


/* Returns groups that are wether owned (created) or operated by the user
 * $user_guid default to logged in user
 * $mode accepts : all (owned+operated), owned, operated
 * Note : only 'all' mode returns an indexed array !
 */
function esope_get_owned_groups($user_guid = false, $mode = 'all') {
	if (!$user_guid) $user_guid = elgg_get_logged_in_user_guid();
	if ($mode != 'operated') $owned = elgg_get_entities(array('type' => 'group', 'owner_guid' => $user_guid, 'limit' => false));
	if ($mode == 'owned') return $owned;
	if (elgg_is_active_plugin('group_operators')) {
		$operated = elgg_get_entities_from_relationship(array('types'=>'group', 'limit'=>false, 'relationship_guid'=> $user_guid, 'relationship'=>'operator', 'inverse_relationship'=>false));
		if ($mode == 'operated') return $operated;
		// Ajout avec possibilité de dédoublonnage par la clef
		foreach ($owned as $ent) {
			$groups[$ent->guid] = $ent;
		}
		// Puis ajout dédoublonné des groupes supplémentaires
		foreach ($operated as $ent) {
			if (!isset($groups[$ent->guid])) $groups[$ent->guid] = $ent;
		}
	} else $groups = $owned;
	return $groups;
}

/* Sort groups by grouptype
 * @return Array ($grouptype => array($groups))
 * Note : 'default' grouptype == empty grouptype (don't use as a grouptype value if empty field allowed))
 */
function adf_platform_sort_groups_by_grouptype($groups) {
	$sorted = array('default' => array());
	foreach ($groups as $group) {
		if (!empty($group->grouptype)) {
			$sorted[$group->grouptype][] = $group;
		} else {
			$sorted['default'][] = $group;
		}
	}
	return $sorted;
}


/* Renders a page content into a suitable page for iframe or lightbox use
 * $content = HTML content
 * $title = title override
 * $embed_mode = 
 		- iframe (use elgg headers), 
 		- inner (no header), 
 		- regular = elgg regular way
 * $headers = extend header (CSS, JS, META, etc.)
 */
function elgg_render_embed_content($content = '', $title = '', $embed_mode = 'iframe', $headers) {
	global $CONFIG;
	$lang = $CONFIG->language;

	// Set default title
	if (empty($title)) $title = $CONFIG->sitename . ' (';
	$vars['title'] = $title;
	
	switch ($embed_mode) {
		
		// Return a regular elgg page view - used for dynamic page return switching
		case 'elgg':
			echo elgg_view_page($title, $content);
			break;
			
		// Return embed for use in Elgg inner-page container (lightbox, AJAX-fetched, etc.)
		case 'inner':
			header('Content-Type: text/html; charset=utf-8');
			echo $content;
			break;
			
		// Return embed for use in an iframe, widget, embed in external site
		case 'iframe':
		default:
			header('Content-Type: text/html; charset=utf-8');
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="' . $lang . '" lang="' . $lang . '">
			' . "<head>
				<title>$title</title>
				" . elgg_view('page/elements/head', $vars) . "
				" . $headers . "
				<style>
				html { background:#FFFFFF; }
				body { border-top: 0; padding: 2px 4px; }
				</style>
			</head>
			<body>
				" . $content . "
			</body>
			</html>";
			break;
	}
	
	// Stop doing anything after rendering
	exit;
}


/* Returns a multi-level HTML list from an $content[] = array($path => $content)
 * $path is structured like /path/to/folder
 * $content is what will be returned in the list element
 */
function elgg_make_list_from_path($content = array()) {
	$return = '';
	$prev_level = 0;
	if (is_array($content)) foreach ($content as $path => $display) {
		$path = explode('/', $path);
		$curr_level = count($path);
		if ($curr_level > $prev_level) $return .= '<ul>';
		else if ($curr_level < $prev_level) $return .= '</ul>';
		//$return .= '<li>' . end($path) . ' : ' . $display . '</li>';
		$return .= '<li>' . $display . '</li>';
		$prev_level = $curr_level;
	}
	return $return;
}


// Fonctions liées à Profile_manager
if (elgg_is_active_plugin('profile_manager')) {
	
	/* Renvoie une autorisation d'accéder ou non
	 * Peut s'appuyer sur une autorisation explicite, ou une interdiction
	 * L'interdiction prend le dessus sur l'autorisation
	 * forward par défaut, return true/false possible
	 * admin bypass
	 */
	function esope_profile_type_gatekeeper($allowed = array(), $forbidden= array(), $user = false, $forward = true, $admin_bypass = true) {
		if (!elgg_instanceof($user, 'user')) $user = elgg_get_logged_in_user_entity();
		$profile_type = esope_get_user_profile_type($user);
		if ($admin_bypass && $user->isAdmin()) return true;
		if (!is_array($allowed)) $allowed = array($allowed);
		if (!is_array($forbidden)) $forbidden = array($forbidden);
		if (in_array($profile_type, $allowed) && !in_array($profile_type, $forbidden)) return true;
		register_error(elgg_echo('noaccess'));
		if ($forward) forward();
		return false;
	}
	
	/* Renvoie le nom du profil en clair, ou false si aucun trouvé/valide */
	function esope_get_user_profile_type($user = false) {
		if (!elgg_instanceof($user, 'user')) $user = elgg_get_logged_in_user_entity();
		$profile_type = false;
		// Type de profil
		if ($profile_type_guid = $user->custom_profile_type) {
			if (($custom_profile_type = get_entity($profile_type_guid)) && ($custom_profile_type instanceof ProfileManagerCustomProfileType)) {
				$profile_type = $custom_profile_type->metadata_name;
			}
		}
		return $profile_type;
	}
	
	/* Returns guid for a specific profile type (false if not found) */
	function esope_get_profiletype_guid($profiletype) {
		$profile_types = esope_get_profiletypes();
		if ($profile_types) foreach ($profile_types as $guid => $name) {
			if ($name == $profiletype) { return $guid; }
		}
		return false;
	}

	/* Returns all profile types as $profiletype_guid => $profiletype_name */
	function esope_get_profiletypes() {
		$profile_types_options = array(
				"type" => "object", "subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
				"owner_guid" => elgg_get_site_entity()->getGUID(), "limit" => false,
			);
		if ($custom_profile_types = elgg_get_entities($profile_types_options)) {
			foreach($custom_profile_types as $type) {
				$profiletypes[$type->guid] = $type->metadata_name;
			}
		}
		return $profiletypes;
	}
	
	/* Returns all members of a specific profile_type */
	function esope_get_members_by_profiletype($profiletype = '', $options = null) {
		$returnvalue = false;
		$profiletype_guid = esope_get_profiletype_guid($profiletype);
		if ($profiletype_guid) {
			$options['type'] = 'user';
			$options['limit'] = false;
			if (!empty($profiletype)) {
				$options['metadata_names'] = 'custom_profile_type';
				$options['metadata_values'] = $profiletype_guid;
				$options['inverse_relationship'] = true;
			}
			$returnvalue = elgg_get_entities_from_metadata($options);
		}
		return $returnvalue;
	}
	
	/* Returns all members who do have NO profile type */
	function esope_get_members_without_profiletype($options = null) {
		$returnvalue = array();
		$members = elgg_get_entities(array('type' => 'user', 'limit' => false));
		foreach ($members as $ent) {
			if (empty($ent->custom_profile_type)) $returnvalue[$ent->guid] = $ent;
		}
		return $returnvalue;
	}
	
	/* Returns a list of members of a specific profile_type */
	function esope_list_members_by_profiletype($profiletype = '', $options = null) {
		$returnvalue = false;
		$profiletype_guid = esope_get_profiletype_guid($profiletype);
		if ($profiletype_guid) {
			$options['type'] = 'user';
			if (!empty($profiletype)) {
				$options['metadata_name_value_pairs'] = array('name' =>'custom_profile_type', 'value' => $profiletype_guid);
				$options['inverse_relationship'] = true;
			}
			$returnvalue = elgg_list_entities_from_metadata($options);
		}
		return $returnvalue;
	}
	
}



