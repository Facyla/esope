<?php
/**
 * adf_public_platform aka ESOPE
 * 
 * ESOPE - Elgg Social Opensource Public Environment
 * @author Florian DANIEL - Facyla
 * 
 */

elgg_register_event_handler('init', 'system', 'adf_platform_init'); // Init

// Menu doit être chargé en dernier pour overrider le reste
//elgg_register_event_handler("init", "system", "adf_platform_pagesetup", 999); // Menu
elgg_register_event_handler("pagesetup", "system", "adf_platform_pagesetup"); // Menu

// Gestion des notifications par mail lors de l'entrée dans un groupe
elgg_register_event_handler('create','member','adf_public_platform_group_join', 800);
// Suppression des notifications lorsqu'on quitte le groupe
elgg_register_event_handler('delete','member','adf_public_platform_group_leave', 800);


/**
 * Init adf_platform plugin.
 */
function adf_platform_init() {
	global $CONFIG;
	
	// Nouvelles vues
	elgg_extend_view('groups/sidebar/members','groups/sidebar/online_groupmembers');
	
	
	// CSS & JS SCRIPTS
	elgg_extend_view('css/elgg', 'adf_platform/css');
	elgg_extend_view('css/admin', 'adf_platform/admin_css');
	// Nouveau thème : 
	elgg_extend_view('css/elgg', 'css/jquery-ui-1.10.2');
	elgg_extend_view('css/elgg', 'adf_platform/css/style');
	elgg_extend_view('css/ie', 'adf_platform/css/ie');
	elgg_extend_view('css/ie6', 'adf_platform/css/ie6');
	// Accessibilité
	elgg_extend_view('css','accessibility/css');
	// Sécurité
	// Important : Enable this only if you don't need to include iframes in other websites !!
	$framekiller = elgg_get_plugin_setting('framekiller', 'adf_public_platform', 100); // Include early
	if ($framekiller == 'yes') {
		elgg_extend_view('page/elements/head','security/framekiller');
	}
	
	// Replace jQuery lib
	elgg_register_js('jquery', '/mod/adf_public_platform/vendors/jquery-1.7.2.min.js', 'head');
	// Add / Replace jQuery UI
	elgg_register_js('jquery-ui', '/mod/adf_public_platform/vendors/jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.min.js', 'head');
	// Theme-specific JS (accessible menu)
	elgg_register_simplecache_view('js/adf_platform_theme');
	$theme_js = elgg_get_simplecache_url('js', 'adf_platform_theme');
	elgg_register_js('adf_platform.fonction', $theme_js, 'head');
	elgg_load_js('adf_platform.fonction');
	// Passe le datepicker en français
	elgg_register_js('jquery.datepicker.fr', 'mod/adf_public_platform/vendors/ui.datepicker-fr.js', 'head');
	elgg_load_js('jquery.datepicker.fr');
	// Webdesign : Floatable elements (.is-floatable, .floating)
	elgg_register_js('floatable.elements', 'mod/adf_public_platform/vendors/floatable-elements.js', 'footer');
	elgg_load_js('floatable.elements');
	// Ajout un member picker avec sélection unique pour les messages
	// @TODO : not functional yet
	//elgg_register_js('elgg.messagesuserpicker', 'mod/adf_public_platform/vendors/ui.messagesuserpicker.js', 'head');
	
	// register the color picker's JavaScript
	elgg_register_simplecache_view('js/input/color_picker');
	$colorpicker_js = elgg_get_simplecache_url('js', 'input/color_picker');
	elgg_register_js('elgg.input.colorpicker', $colorpicker_js);
	
	// register the color picker's CSS
	elgg_register_simplecache_view('css/input/color_picker');
	$colorpicker_css = elgg_get_simplecache_url('css', 'input/color_picker');
	elgg_register_css('elgg.input.colorpicker', $colorpicker_css);
	
	
	// Pour faire apparaître le menu dans le menu "apparence" - mais @todo intégrer dans un form
	//elgg_register_admin_menu_item('configure', 'adf_theme', 'appearance');
	
	
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
	
	// Remplacement page d'accueil
	if (elgg_is_logged_in()) {
		// Remplacement page d'accueil par tableau de bord personnel
		// PARAM : Désactivé si vide, activé avec paramètre de config si non vide
		$replace_home = elgg_get_plugin_setting('replace_home', 'adf_public_platform');
		if (!empty($replace_home)) { elgg_register_plugin_hook_handler('index','system','adf_platform_index'); }
	} else {
		// Remplacement page d'accueil publique - ssi si pas en mode walled_garden
		// PARAM : Désactivé si vide, activé avec paramètre de config si non vide
		$replace_public_home = elgg_get_plugin_setting('replace_public_homepage', 'adf_public_platform');
		if (!$CONFIG->walled_garden) {
			if ($replace_public_home != 'no') {
				elgg_register_plugin_hook_handler('index','system','adf_platform_public_index');
			}
		}
	}
	
	// Modification des menus standards des widgets
	elgg_unregister_plugin_hook_handler('register', 'menu:widget', 'elgg_widget_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:widget', 'adf_platform_elgg_widget_menu_setup');
	// Modification des menus des groupes
	//elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'event_calendar_owner_block_menu');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'adf_platform_owner_block_menu', 1000);
	// Modification de la page de listing des sous-groupes
	if (elgg_is_active_plugin('au_subgroups')) {
		// route some urls that go through 'groups' handler
		elgg_unregister_plugin_hook_handler('route', 'groups', 'au_subgroups_groups_router');
		elgg_register_plugin_hook_handler('route', 'groups', 'adf_platform_subgroups_groups_router', 499);
	}
	
	// Public pages - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'adf_public_platform_public_pages');
	
	// Modification du Fil d'Ariane
	elgg_register_plugin_hook_handler('view', 'navigation/breadcrumbs', 'adf_platform_alter_breadcrumb');
	
	// Permet de rendre le profil non public, si réglage activé
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
	
	
	// NEW & REWRITTEN ACTIONS
	// Modification de l'invitation de contacts dans les groupes (réglage : contacts ou tous)
	// Permet notamment de forcer l'inscription
	if (elgg_is_active_plugin('groups')) {
		elgg_unregister_action('groups/invite');
		elgg_register_action("groups/invite", elgg_get_plugins_path() . 'adf_public_platform/actions/groups/membership/invite.php');
	}
	// ESOPE search endpoint
	elgg_register_action("esope/esearch", elgg_get_plugins_path() . 'adf_public_platform/actions/esope/esearch.php');
	// Manually reset login failure counter
	elgg_register_action("admin/reset_login_failures", elgg_get_plugins_path() . 'adf_public_platform/actions/admin/reset_login_failures.php');
	
	
	// NEW & REWRITTEN PAGE HANDLERS
	// Note : modification de pages de listing (non gérables par des vues)
	// @dev : Related functions are in lib/adf_public/platform/page_handlers.php
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
	// Pour les messages
	elgg_unregister_page_handler('messages', 'messages_page_handler');
	elgg_register_page_handler('messages', 'adf_platform_messages_page_handler');
	// Esope custom search - @TODO currently alpha version
	elgg_register_page_handler('esearch', 'esope_esearch_page_handler');
	// Ajout gestionnaire pour les dossiers
	/* @TODO : add setting + see if we want this by default or not
	if (elgg_is_active_plugin('file_tools') && elgg_is_logged_in()) {
		elgg_register_page_handler('folders','maghrenov_folder_handler');
	}
	*/
	
	// MODIFICATION DES WIDGETS : (DES)ACTIVATION ET TITRES
	require_once(dirname(__FILE__) . '/lib/adf_public_platform/widgets.php');
	
	
	// Group tools priority - see credits in group_tools_priority/settings view
	$views = elgg_get_config('views');
	$tools = $views->extensions['groups/tool_latest'];
	foreach ($tools as $old_priority => $view) {
		elgg_unextend_view('groups/tool_latest', $view);
		$priority = ($new_priority = elgg_get_plugin_setting("tools:$view", 'groups')) ? $new_priority : $old_priority;
		elgg_extend_view('groups/tool_latest', $view, $priority);
	}
	elgg_extend_view('plugins/groups/settings', 'group_tools_priority/settings');
	
}


// Include hooks & page_handlers functions (lightens this file)
require_once(dirname(__FILE__) . '/lib/adf_public_platform/page_handlers.php');
require_once(dirname(__FILE__) . '/lib/adf_public_platform/hooks.php');



function adf_platform_pagesetup(){
	$context = elgg_get_context();
	
	if (elgg_is_logged_in()) {
		$own = elgg_get_logged_in_user_entity();
		
		// ESOPE : remove personnal tools from user tools (removes creation button) - only if owner if a user !! (otherwise we would remove group tools...)
		$remove_user_tools = elgg_get_plugin_setting('remove_user_tools', 'adf_public_platform');
		if ($remove_user_tools && elgg_instanceof(elgg_get_page_owner_entity(), 'user')) {
			/* Note : removing personnal tools means remove the add button, not the filter
			global $CONFIG;
			print_r($CONFIG->menus['title']);
			*/
			$remove_user_tools = explode(',', $remove_user_tools);
			if (in_array($context, $remove_user_tools)) elgg_unregister_menu_item('title', 'add');
		}
		
		// Helps finding quickly the good name for existing menus...
		//global $CONFIG; echo print_r($CONFIG->menus['page']); // debug
		
		// Retire les demandes de contact des messages
		if ($context == "messages") { elgg_unregister_menu_item("page", "friend_request"); }
		
		// Fusionne les menus contacts et annuaire (+ les autres menus liés)
		if (in_array($context, array('friends', 'members', 'friendsof', 'friend_request', 'collections'))) {
			
			// Supprime les collections, si demandé
			$remove_collections = elgg_get_plugin_setting('remove_collections', 'adf_public_platform');
			if ($remove_collections == 'yes') elgg_unregister_menu_item("page", "friends:view:collections");
			// Supprime les Contacts de
			elgg_unregister_menu_item("page", "friends:of");
			elgg_unregister_page_handler("friendsof");
			
			// Ajoute lien vers l'annuaire
			elgg_register_menu_item("page", array(
					'name' => 'members', 'href' => $CONFIG->url . 'members', 
					'text' => elgg_echo('adf_platform:directory'), 
					"section" => "directory",
				));
			
			// Ajoute lien vers les contacts
			elgg_register_menu_item("page", array(
					'name' => 'friends', 'href' => $CONFIG->url . 'friends/' . $own->username, 
					'text' => elgg_echo('friends'), 
					'contexts' => array('members'), 
				));
				
			// Ajoute lien vers les invitations
			if (elgg_is_active_plugin('invitefriends')) {
				$params = array(
					'name' => 'invite', 'text' => elgg_echo('friends:invite'), 'href' => $CONFIG->url . 'invite',
					'contexts' => array('members'), // Uniquement members pour ne pas overrider le comportement normal
				);
				elgg_register_menu_item('page', $params);
			}
		}
		
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
	
	/* Rewrite breadcrumbs : use a more user-friendly logic
	 * Structure du Fil : Accueil (site) > Container (group/user page owner) > Subtype > Content > action
	 * Default structure : Tool > Tool for page owner > Content > Subcontent	=> Home > Page owner (group or user) > Tool for page owner > Content > Subcontent
	 * Group structure : All groups > Page owner (group or user)	=> Home > Page owner (group or user)
	 * Target structure : Home > Page owner (group or user) > Tool for page owner > Content > Subcontent
	 * @todo : Insert Home at first, replace 1st entry with page owner, rename owner tool using context
	 */
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
			
			// Insert page owner only if it's a user or group (not a site..), and it's not set by the context
			$page_owner = elgg_get_page_owner_entity();
			if ($page_owner instanceof ElggGroup) {
				
				/*
				$is_edit = false;
				$last = end($CONFIG->breadcrumbs);
				if ($last['title'] == elgg_echo('edit')) { $is_edit = true; }
				*/
				
				// Remove "Tool home" entry - except for groups (all groups link) and profiles
				if (!in_array($context, array('groups', 'profile'))) {
					// Removes tool entry
					//if ($CONFIG->breadcrumbs[1]['title'] == $page_owner->name) 
						unset ($CONFIG->breadcrumbs[0]);
					// Rename "Owner tool" to the tool name (displays Tool name within its container, instead the container name)
					$CONFIG->breadcrumbs[1]['title'] = elgg_echo($context);
				}
			
				if (!elgg_in_context('groups')) {
					$group_url = $CONFIG->url . 'groups/profile/' . $page_owner->guid . '/' . elgg_get_friendly_title($page_owner->name);
					array_unshift($CONFIG->breadcrumbs, array('title' => $page_owner->name, 'link' => $group_url) );
					array_unshift($CONFIG->breadcrumbs, array('title' => elgg_echo('groups'), 'link' => 'groups/all') );
				}
				
			} else if ($page_owner instanceof ElggUser) {
				// Adds Directory > Member if page owner is a user // doesn't really makes the breadcrumb clearer
				//array_unshift($CONFIG->breadcrumbs, array('title' => $page_owner->name, 'link' => $CONFIG->url . 'profile/' . $page_owner->username) );
				//array_unshift($CONFIG->breadcrumbs, array('title' => elgg_echo('adf_platform:directory'), 'link' => $CONFIG->url . 'members') );
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

// Redirection après login
function adf_platform_public_forward_login_hook($hook_name, $entity_type, $return_value, $parameters) {
	global $CONFIG;
	//register_error("TEST : " . $_SESSION['last_forward_from'] . " // " . $parameters['current_url']);
	// Si jamais la valeur de retour n'est pas définie, on le fait
	if (empty($_SESSION['last_forward_from'])) $_SESSION['last_forward_from'] = $parameters['current_url'];
	if (!elgg_is_logged_in()) return $CONFIG->url . 'login';
	return null;
}

/* Performs some actions after registration */
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



// Ajoute -ou pas- les notifications lorsqu'on rejoint un groupe
function adf_public_platform_group_join($event, $object_type, $relationship) {
	if (elgg_is_logged_in()) {
		if (($relationship instanceof ElggRelationship) && ($event == 'create') && ($object_type == 'member')) {
			global $NOTIFICATION_HANDLERS;
			$groupjoin_enablenotif = elgg_get_plugin_setting('groupjoin_enablenotif', 'adf_public_platform');
			if (empty($groupjoin_enablenotif) || ($groupjoin_enablenotif != 'no')) {
				switch($groupjoin_enablenotif) {
					case 'site':
						add_entity_relationship($relationship->guid_one, 'notifysite', $relationship->guid_two);
						break;
					case 'all':
						foreach($NOTIFICATION_HANDLERS as $method => $foo) {
							add_entity_relationship($relationship->guid_one, "notify{$method}", $relationship->guid_two);
						}
						break;
					case 'email':
					default:
						add_entity_relationship($relationship->guid_one, 'notifyemail', $relationship->guid_two);
				}
			} else if ($groupjoin_enablenotif == 'no') {
				// loop through all notification types
				foreach($NOTIFICATION_HANDLERS as $method => $foo) {
					remove_entity_relationship($relationship->guid_one, "notify{$method}", $relationship->guid_two);
				}
			}
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
			// Remove framekiller view (would break out of widgets)
			elgg_unextend_view('page/elements/head', 'security/framekiller');
			header('Content-Type: text/html; charset=utf-8');
			echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="' . $lang . '" lang="' . $lang . '">
			' . "<head>
				<title>$title</title>
				" . elgg_view('page/elements/head', $vars) . "
				" . $headers . "
				<style>
				html, html body { background:#FFFFFF !important; }
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
	
	// Add new input types
	$group_options = array("output_as_tags" => true, "admin_only" => true);
	// Select with multiple option (displayed as a block, not a dropdown)
	// @debug : this input can't be used with profile manager (because of reading values method) - use multiselect instead
	// Group profile types selector (do smthg with selected members profile types)
	add_custom_field_type("custom_group_field_types", 'group_profiletypes', elgg_echo('custom_fields:group_profiletypes'), $group_options);
	// Color picker
	add_custom_field_type("custom_group_field_types", 'color', elgg_echo('custom_fields:color'), $group_options);
	// Group selector (scope=all|member)
	add_custom_field_type("custom_group_field_types", 'groups_select', elgg_echo('custom_fields:groups_select'), $group_options);
	// Members select (friends picker) - scope=all|friends|groupmembers
	add_custom_field_type("custom_group_field_types", 'members_select', elgg_echo('custom_fields:members_select'), $group_options);
	// Percentage - interval=10
	add_custom_field_type("custom_group_field_types", 'percentage', elgg_echo('custom_fields:percentage'), $group_options);
	
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
	
	function esope_set_user_profile_type($user = false, $profiletype = '') {
		if (!elgg_instanceof($user, 'user')) $user = elgg_get_logged_in_user_entity();
		$profiletype_guid = null;
		if (!empty($profiletype)) {
			$profiletype_guid = esope_get_profiletype_guid($profiletype);
		}
		$user->custom_profile_type = $profiletype_guid;
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
	
	/* Return a selector with profile_manager options
	 * That's for use in a multi-criteria search form
	 * Params :
	   - metadata : meta name
	   - name : field name
	   - value : set a specific value
	   - empty : add empty value in options
	   - 
	 */
	function esope_make_search_field_from_profile_field($params) {
		$metadata = $params['metadata'];
		if (empty($metadata)) return false;
		$empty = elgg_extract('empty', $params, true);
		$value = elgg_extract('value', $params, get_input($metadata, false)); // Auto-select current value
		$name = elgg_extract('name', $params, $metadata); // Defaults to metadata name
		$search_field = '';
		
		$field_a = elgg_get_entities_from_metadata(array('types' => 'object', 'subtype' => 'custom_profile_field', 'metadata_names' => 'metadata_name', 'metadata_values' => $metadata));
		if ($field_a) {
			$field = $field_a[0];
			$options = $field->getOptions();
			$valtype = $field->metadata_type;
			if (in_array($valtype, array('longtext', 'plaintext', 'rawtext'))) $valtype = 'text';
			// Multiple option become select or radio
			if ($options) {
				$valtype = 'dropdown';
				if ($empty) $options['empty option'] = '';
				$options = array_reverse($options);
			}
			$search_field .= elgg_view("input/$valtype", array('name' => $name, 'options' => $options, 'value' => $value));
		}
		return $search_field;
	}
	
}


// Esope search page handler
function esope_esearch_page_handler($page) {
	$base = elgg_get_plugins_path() . 'adf_public_platform/pages/adf_platform';
	require_once "$base/esearch.php";
	return true;
}

/* Esope search function : 
 * Just call echo esope_search() for a listing
 * Get entities with $results_ents = esope_search('entities');
 */
function esope_esearch($params = array()) {
	global $CONFIG;
	$max_results = 500;
	$debug = false;
	$q = sanitize_string(get_input("q"));
	$type = sanitize_string(get_input("entity_type"));
	$subtype = sanitize_string(get_input("entity_subtype"));
	$owner_guid = get_input("owner_guid");
	$container_guid = get_input("container_guid");
	$limit = (int) get_input("limit", 0);
	$offset = (int) get_input("offset", 0);
	$sort = get_input("sort");
	$order = get_input("order");
	// Metadata search : $metadata[name]=value
	$metadata = get_input("metadata");
	$metadata_case_sensitive = get_input("metadata_case_sensitive", false);
	$metadata_name_value_pairs_operator = get_input("metadata_name_value_pairs_operator", 'AND');
	$order_by_metadata = get_input('order_by_metadata');
	
	// Some cleanup on types and subtypes
	if (empty($type)) $type = 'object';
	if (!empty($subtype) && ($type != 'object')) $subtype = null;
	if (empty($subtype) && ($type == 'object')) {
		$registered = get_registered_entity_types(); // Returns all subtypes, even non-objects
		foreach ($registered as $registered_type => $registered_subtypes) {
			foreach ($registered_subtypes as $registered_subtype) {
				$subtype[] = $registered_subtype;
			}
		}
	}
	
	$result = array();
	if ($debug) echo "Search : $q $type $subtype ($owner_guid/$container_guid) $limit $offset $sort $order<br />";
	if ($debug) echo "Metadata : $industry $multiselect " . print_r($metadata, true) . "<br />";
	// show hidden (unvalidated) users
	//$hidden = access_get_show_hidden_status();
	//access_show_hidden_entities(true);

	// Recherche par nom / username / titre / description, selon les cas
	if ($q) {
		switch($type) {
			case 'user':
				$joins[] = "INNER JOIN " . elgg_get_config("dbprefix") . "users_entity ue USING(guid)";
				$wheres[] = "(ue.name like '%" . $q . "%' OR ue.username like '%" . $q . "%')";
				break;
			case 'group':
				$joins[] = "INNER JOIN " . elgg_get_config("dbprefix") . "groups_entity ge USING(guid)";
				$wheres[] = "(ge.name like '%" . $q . "%' OR ge.description like '%" . $q . "%')";
				break;
			case 'site':
				$joins[] = "INNER JOIN " . elgg_get_config("dbprefix") . "sites_entity se USING(guid)";
				$wheres[] = "(se.name like '%" . $q . "%' OR se.description like '%" . $q . "%')";
				break;
			case 'object':
				$joins[] = "INNER JOIN " . elgg_get_config("dbprefix") . "objects_entity oe USING(guid)";
				$wheres[] = "(oe.title like '%" . $q . "%' OR oe.description like '%" . $q . "%')";
				break;
		}
	}

	// Build metadata name-value pairs from input array
	if ($metadata) foreach ($metadata as $name => $value) {
		if (!empty($name) && !empty($value)) {
			$metadata_name_value_pairs[] = array('name' => $name, 'value' => $value);
		}
	}

	// Paramètres de la recherche
	$search_params = array(
			'types' => $type,
			'subtypes' => $subtype,
			'owner_guid' => $owner_guid,
			'container_guid' => $container_guid,
			'metadata_name_value_pairs' => $metadata_name_value_pairs,
			'metadata_case_sensitive' => $metadata_case_sensitive,
			'metadata_name_value_pairs_operator' => $metadata_name_value_pairs_operator,
			'order_by_metadata' => $order_by_metadata,
			'limit' => $limit,
			'offset' => $offset,
			'sort' => $sort,
			'order' => $order,
			'joins' => $joins,
			'wheres' => $wheres,
		);
	
	$search_params['count'] = true;
	$count = elgg_get_entities_from_metadata($search_params);
	if ($count > $max_results) {
		$alert = '<span class="esope-morethanmax">' . elgg_echo('esope:search:morethanmax') . '</span>';
	}
	if ($search_params['limit'] > $max_results) $search_params['limit'] = $max_results;
	$search_params['count'] = false;
	$entities = elgg_get_entities_from_metadata($search_params);
	// Limit to something that can be handled
	$entities = array_slice($entities, 0, $max_results);
	
	if ($params['returntype'] == 'entities') {
		return $entities;
	} else {
		$search_params['full_view'] = false;
		$search_params['pagination'] = false;
		$search_params['list_type'] = 'list'; // gallery/list
		elgg_push_context('search');
		elgg_push_context('widgets');
		$return = '';
		if ($params['count']) { $return .= '<span class="esope-results-count">' . elgg_echo('esope:search:nbresults', array($count)) . '</span>'; }
		$return .= elgg_view_entity_list($entities, $search_params, $offset, $max_results, false, false, false);
		if ($alert) $return .= $alert;
		elgg_pop_context('widgets');
		elgg_pop_context('search');
	}
	
	if (empty($return)) $return = '<span class="esope-noresult">' . elgg_echo('esope:search:noresult') . '</span>';
	
	return $return;
}


// Adaptation du code dispo sur OpenClassrooms
// Fonction de cryptage réversible : on utilise la même fonction pour coder/décode
// Idéalement la longueur de $key >= $text
function esope_vernam_crypt($text, $key){
	$keyl = strlen($key);
	$textl = strlen($text);
	// Pad or cut key to fit text length
	if ($keyl < $textl){
		$key = str_pad($key, $textl, $key, STR_PAD_RIGHT);
	} elseif ($keyl > $textl){
		$diff = $keyl - $textl;
		$key = substr($key, 0, -$diff);
	}
	$crypted = $text ^ $key;
	//echo strlen($key) . " : " . $key . " / " . strlen($text) . " : " . $text . " => " . $crypted;
	return $crypted;
}

// Récupération des pages de plus haut niveau (d'un groupe ou user)
function esope_get_top_pages($container) {
	global $CONFIG;
	$top_pages = elgg_get_entities(array('type' => 'object', 'subtype' => 'page_top', 'container_guid' => $container->guid, 'limit' => 0, 'joins' => "INNER JOIN {$CONFIG->dbprefix}objects_entity as oe", 'order_by' => 'oe.title asc'));
	return $top_pages;
}

// Récupération des sous-pages directes d'une page
function esope_get_subpages($parent) {
	global $CONFIG;
	$subpages = elgg_get_entities_from_metadata(array('type' => 'object', 'subtype' => 'page', 'metadata_name' => 'parent_guid', 'metadata_value' => $parent->guid, 'limit' => 0, 'joins' => "INNER JOIN {$CONFIG->dbprefix}objects_entity as oe", 'order_by' => 'oe.title asc'));
	return $subpages;
}

// Listing des sous-pages directes d'une page
// @TODO : recursivity is not very good because generated content can be easily huge
// So when using full_view, we'll echo directly instead of returning content
// @TODO : list all pages and organize/sort, then rendering
function esope_list_subpages($parent, $internal_link = false, $full_view = false) {
	$content = '';
	$subpages = esope_get_subpages($parent);
	if ($subpages) foreach ($subpages as $subpage) {
		if ($internal_link == 'internal') $href = '#page_' . $subpage->guid;
		else if ($internal_link == 'url') $href = $subpage->getURL();
		else $href = false;
		if ($full_view) {
			echo '<h3>' . elgg_view('output/url', array('href' => $href, 'text' => $subpage->title, 'name' => 'page_' . $subpage->guid)) . '</h3>';
			echo elgg_view("output/longtext", array("value" => $subpage->description));
			echo '<p style="page-break-after:always;"></p>';
			echo esope_list_subpages($subpage, $internal_link, $full_view);
		} else {
			$content .= '<li>' . elgg_view('output/url', array('href' => $href, 'text' => $subpage->title, ));
			$content .= esope_list_subpages($subpage, $internal_link);
			$content .= '</li>';
		}
	}
	if (!$full_view && !empty($content)) $content = '<ul>' . $content . '</ul>';
	return $content;
}


/* Makes all name titles uppercase, including composed names and special delimiters (Jean-Paul O'Brien)
 * Credits goes to jmarois at http://www.php.net/manual/en/function.ucwords.php
*/
function esope_uppercase_name($string) {
	$string = ucwords(strtolower($string));
	$delimiters = array('-', '\'');
	foreach ($delimiters as $delimiter) {
		if (strpos($string, $delimiter)!==false) {
			$string = implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
		}
	}
	return $string;
}


/* Generates a unique id per page rendering
 * Description : This function basically increments a counter on a unique prefix, to generate ids on a given page
 * Usage : This is useful for all dynamic / reusable elements that require a unique id for dynamic addressing
 *   ie form fields, JS scripts, views with specific elements, etc.
 * Note : unique ids remain reasonably short, and human-readable (diff with uniqid() native PHP fonction))
 * Caution : cannot be used for styling, as ids will may change on each page load...
 * Param :
 *  - $prefix default can be overrided if needed
 */
function esope_unique_id($prefix = 'esope_unique_id_') {
	global $esope_unique_id;
	if (!isset($esope_unique_id)) {
		$esope_unique_id = 1;
	} else {
		$esope_unique_id++;
	}
	return $prefix . $esope_unique_id;
}

// Determines wether a given link is internal or external
// Note : based on domain, won't work for subdir install
function esope_is_external_link($url) {
	global $CONFIG;
	$elements = parse_url($url);
	$base_elements = parse_url($CONFIG->url);
	if ($elements['host'] != $base_elements['host']) return true;
	return false;
}


if (elgg_is_active_plugin('file_tools')) {
	
	// Recursive function that lists folders and their content
	// bool $view_files : display folder files
	function esope_view_folder_content($folder, $view_files = true) {
		$content = '';
		$folder_content = '';
		$folder_description = '';
		$files_content = '';
		// Folder link
		$folder_title_link = '<a href="' . $CONFIG->url . 'file/group/' . $folder['folder']->container_guid . '/all#' . $folder['folder']->guid . '">' . $folder['folder']->title . '</a>';
		// Folder description
		if (!empty($folder['folder']->description)) $folder_description .= ' <em>' . $folder['folder']->description . '</em>';
		
		// Determine folder content
		if ($view_files) {
			$files_content = esope_view_folder_files($folder['folder']->container_guid, $folder['folder']);
		}
		
		// Folders has children folders
		if ($folder['children']) {
			foreach ($folder['children'] as $children) { $folder_content .= esope_view_folder_content($children); }
		}
		
		// Folder icon : tell if subfolders (-open-o), or if only content inside (-o)
		$folder_icon = 'fa-folder';
		if (!empty($folder_content)) {
			$folder_icon .= '-open-o';
		} else {
			if (!empty($files_content)) { $folder_icon .= '-o'; }
		}
		$folder_icon = '<i class="fa ' . $folder_icon . '"></i> ';
		
		// Add file content if asked
		if ($view_files) {
			// Handle empty folder case (no file inside, nor subfolder)
			if (empty($files_content) && empty($folder_content)) { $files_content .= '<li>' . elgg_echo('file:none') . '</li>'; }
			$folder_content .= $files_content;
		}
		
		// Compose rendered folder content
		$content .= '<li><strong>' . $folder_icon . $folder_title_link. '</strong>' . $folder_description;
		if (!empty($folder_content)) { $content .= '<ul>' . $folder_content . '</ul>'; }
		$content .= '</li>';
		
		return $content;
	}

	// List files in a specific folder
	function esope_view_folder_files($container_guid, $folder = false) {
		$sort_by = elgg_get_plugin_setting("sort", "file_tools");
		$direction = elgg_get_plugin_setting("sort_direction", "file_tools");
		$options = array('type' => 'object', 'subtype' => 'file', 'container_guid' => $container_guid, 'limit' => false);
		$options['joins'] = array("JOIN " . elgg_get_config("dbprefix") . "objects_entity oe ON oe.guid = e.guid");
		if($sort_by == "simpletype") {
			$options["order_by_metadata"] = array("name" => "mimetype", "direction" => $direction);
		} else {
			$options["order_by"] = $sort_by . " " . $direction;
		}
		if ($folder) {
			// Display only files in this folder
			$options["relationship"] = FILE_TOOLS_RELATIONSHIP;
			$options["relationship_guid"] = $folder->guid;
			$options["inverse_relationship"] = false;
			$files = elgg_get_entities_from_relationship($options);
		} else {
			// Display only files in main folder
			$options['wheres'] = "NOT EXISTS (
				SELECT 1 FROM " . elgg_get_config("dbprefix") . "entity_relationships r 
				WHERE r.guid_two = e.guid AND r.relationship = '" . FILE_TOOLS_RELATIONSHIP . "')";
			$files = elgg_get_entities($options);
		}
	
		if ($files) {
			elgg_set_context('widgets');
			// Note : méthode qui permet de n'afficher que des <li> (sans <ul>)
			foreach ($files as $ent) {
				$files_content .= '<li idf="folder-file-' . $ent->guid . '" class="folder-file">' 
				. '<a href="' . $ent->getURL() . '"> ' 
				. '<img src="' . $ent->getIconURL('small') . '" style="width:2ex;" /> '
				. $ent->title . '</a>' 
				. '</li>';
			}
			elgg_pop_context();
		}
		return $files_content;
	}
	
}

/* User profile visbility gatekeeper
 * Forwards to home if public profile is not allowed
 * $user : defaults to page owner
 */
function esope_user_profile_gatekeeper($user = false) {
	// No user profile gatekeeper if viewer is logged in
	if (elgg_is_logged_in()) return true;
	
	// Defaults to page owner, so most cases where we need to protect user profile are handled
	if (!$user) $user = elgg_get_page_owner_entity();
	
	if (elgg_instanceof($user, 'user')) {
		// Selon le réglage par défaut, le profil est visible ou masqué par défaut
		$public_profiles_default = elgg_get_plugin_setting('public_profiles_default', 'adf_public_platform');
		if (empty($public_profiles_default)) { $public_profiles_default = 'no'; }
	
		// Le profil n'est accessible que si l'user ou à défaut le site en a décidé ainsi, sinon => forward
		if ($public_profiles_default == 'no') {
			// Opt-in : profil restreint par défaut
			if ($user->public_profile != 'yes') {
				register_error(elgg_echo('adf_public_platform:noprofile'));
				forward($home);
			}
		} else {
			// Opt-out : profil public par défaut
			if ($user->public_profile == 'no') {
				register_error(elgg_echo('adf_public_platform:noprofile'));
				forward($home);
			}
		}
	}
}


