<?php
/**
 * adf_public_platform aka ESOPE
 * 
 * ESOPE - Elgg Social Opensource Public Environment
 * @author Florian DANIEL - Facyla
 * 
 */

elgg_register_event_handler('init', 'system', 'esope_init'); // Init

// Menu doit être chargé en dernier pour overrider le reste
//elgg_register_event_handler("init", "system", "adf_platform_pagesetup", 999); // Menu
elgg_register_event_handler("pagesetup", "system", "adf_platform_pagesetup"); // Menu


/**
 * Init ESOPE plugin.
 */
function esope_init() {
	global $CONFIG;
	global $ESOPE;
	if (!isset($ESOPE)) { $ESOPE = new stdClass; }
	
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
	$framekiller = elgg_get_plugin_setting('framekiller', 'adf_public_platform');
	if ($framekiller == 'yes') {
		elgg_extend_view('page/elements/head','security/framekiller');
	}
	// Commentaires
	elgg_extend_view('page/elements/comments', 'comments/public_notice', 1000);
	// Join groups at registration
	elgg_extend_view('register/extend', 'forms/groups/register_join_groups', 600);
	// Extend groups sidebar (below owner_block and search)
	elgg_extend_view('groups/sidebar/members', 'groups/sidebar/cmspages_extend', 100);
	
	elgg_extend_view('css/digest/core', 'css/digest/esope');
	
	$forum_autorefresh = elgg_get_plugin_setting('discussion_autorefresh', 'adf_public_platform');
	if ($forum_autorefresh == 'yes') {
		elgg_extend_view('object/groupforumtopic', 'adf_platform/forum_autorefresh');
	}
	
	// Extend group invite form
	// Requires to be placed at the end of the form, because we will end the form and start a new one...
	elgg_extend_view('forms/groups/invite', 'forms/esope/group_invite_before', 100);
	elgg_extend_view('forms/groups/invite', 'forms/esope/group_invite', 1000);
	
	
	// Ajout interface de chargement
	// Important : plutôt charger la vue lorsqu'elle est utile, car permet de la pré-définir comme active
	//elgg_extend_view('page/elements/footer', 'adf_platform/loader');
	
	// Replace jQuery lib
	elgg_register_js('jquery', 'mod/adf_public_platform/vendors/jquery-1.7.2.min.js', 'head');
	// Add / Replace jQuery UI
	elgg_register_js('jquery-ui', 'mod/adf_public_platform/vendors/jquery-ui-1.10.2.custom/js/jquery-ui-1.10.2.custom.min.js', 'head');
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
	/* Replaced by jquery colorpicker, which works and is full-featured
	elgg_register_simplecache_view('js/input/color_picker');
	$colorpicker_js = elgg_get_simplecache_url('js', 'input/color_picker');
	elgg_register_js('elgg.input.colorpicker', $colorpicker_js);
	// register the color picker's CSS
	elgg_register_simplecache_view('css/input/color_picker');
	$colorpicker_css = elgg_get_simplecache_url('css', 'input/color_picker');
	elgg_register_css('elgg.input.colorpicker', $colorpicker_css);
	*/
	// jquery colorpicker (fully featured color picker)
	$jquery_colorpicker_base = 'mod/adf_public_platform/vendors/colorpicker/';
	elgg_register_js('jquery.colorpicker', $jquery_colorpicker_base . 'jquery.colorpicker.js', 'head');
	elgg_register_js('jquery.colorpicker-i18n', $jquery_colorpicker_base . 'i18n/jquery.ui.colorpicker-fr.js', 'head');
	elgg_register_js('jquery.colorpicker-pantone', $jquery_colorpicker_base . 'swatches/jquery.ui.colorpicker-pantone.js', 'head');
	elgg_register_js('jquery.colorpicker-rgbslider', $jquery_colorpicker_base . 'parts/jquery.ui.colorpicker-rgbslider.js', 'head');
	elgg_register_js('jquery.colorpicker-memory', $jquery_colorpicker_base . 'parts/jquery.ui.colorpicker-memory.js', 'head');
	elgg_register_js('jquery.colorpicker-cmyk', $jquery_colorpicker_base . 'parsers/jquery.ui.colorpicker-cmyk-parser.js', 'head');
	elgg_register_js('jquery.colorpicker-cmyk-percentage', $jquery_colorpicker_base . 'parsers/jquery.ui.colorpicker-cmyk-percentage-parser.js', 'head');
	elgg_register_css('jquery.colorpicker', $jquery_colorpicker_base . 'jquery.colorpicker.css');
	
	
	if (elgg_is_active_plugin('profile_manager')) {
		esope_register_custom_field_types();
	}
	
	// Pour faire apparaître le menu dans le menu "apparence" - mais @todo intégrer dans un form
	//elgg_register_admin_menu_item('configure', 'adf_theme', 'appearance');
	
	
	// REMPLACEMENT DE HOOKS DU CORE OU DE PLUGINS, et d'EVENTS
	// Related functions are in lib/adf_public/platform/hooks.php
	
	// Affichage des dates
	elgg_register_plugin_hook_handler('format', 'friendly:time','esope_friendly_time_hook');
	
	// Gestion des notifications par mail lors de l'entrée dans un groupe
	elgg_register_event_handler('create','member','adf_public_platform_group_join', 800);
	// Suppression des notifications lorsqu'on quitte le groupe
	elgg_register_event_handler('delete','member','adf_public_platform_group_leave', 800);
	
	// Gestion des actions post-inscription
	elgg_register_plugin_hook_handler('register', 'user', 'esope_create_user_hook');
	// Gestion des actions post-login
	elgg_register_event_handler('login','user','esope_login_user_action', 800);
	
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
	
	// Page d'accueil
	if (elgg_is_logged_in()) {
		// Remplacement page d'accueil par tableau de bord personnel
		// PARAM : Désactivé si 'no', ou activé avec paramètre de config optionnel
		$replace_home = elgg_get_plugin_setting('replace_home', 'adf_public_platform');
		if ($replace_home != 'no') { elgg_register_plugin_hook_handler('index','system','adf_platform_index'); }
	} else {
		// Remplacement page d'accueil publique - ssi si pas en mode walled_garden
		//if (isset($CONFIG->site) && ($CONFIG->site instanceof ElggSite) && $CONFIG->site->checkWalledGarden()) {
		if ($CONFIG->walled_garden) {
			// NOTE : In walled garden mode, the walled garden page layout is used, not index hook
		} else {
			// PARAM : Désactivé si 'no', ou activé avec paramètre de config
			$replace_public_home = elgg_get_plugin_setting('replace_public_homepage', 'adf_public_platform');
			if ($replace_public_home != 'no') { elgg_register_plugin_hook_handler('index','system','adf_platform_public_index'); }
		}
	}
	
	// Modification du menu des membres
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'esope_user_hover_menu');
	
	// Modification des menus standards des widgets
	elgg_unregister_plugin_hook_handler('register', 'menu:widget', 'elgg_widget_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:widget', 'adf_platform_elgg_widget_menu_setup');
	
	// Modification des menus des groupes et membres (ajout/suppression)
	//elgg_unregister_plugin_hook_handler('register', 'menu:owner_block', 'event_calendar_owner_block_menu');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'adf_platform_owner_block_menu', 1000);
	// Tri avant affichage des menus des groupes et membres
	elgg_register_plugin_hook_handler('prepare', 'menu:owner_block', 'adf_platform_sort_menu_alpha');
	
	// Modification de la page de listing des sous-groupes
	if (elgg_is_active_plugin('au_subgroups')) {
		// route some urls that go through 'groups' handler
		elgg_unregister_plugin_hook_handler('route', 'groups', 'au_subgroups_groups_router');
		elgg_register_plugin_hook_handler('route', 'groups', 'adf_platform_subgroups_groups_router', 499);
		
		/* au_subgroups prevents users from being invited to subgroups they can't join
		 * BUT this breaks the process for all invited users even if only one of them cannot join...
		 * SO esope approach is to disable the original hook 
		 * AND handle the au_subgroup case by filtering the passed GUID to in the invite action
		 *    which avoids breaking the whole process for some users (especially if we register them directly into the group)
		 */
		elgg_unregister_plugin_hook_handler('action', 'groups/invite', 'au_subgroups_group_invite');
		elgg_register_plugin_hook_handler('action', 'groups/invite', 'esope_au_subgroups_group_invite');
	}
	
	// Sélection du menu messages (lorsque filtre unread utilisé)
	elgg_register_plugin_hook_handler('prepare', 'menu:page', 'esope_prepare_menu_page_hook', 1000);
	elgg_register_plugin_hook_handler('prepare', 'menu:site', 'esope_prepare_menu_page_hook');
	
	// Public pages - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'adf_public_platform_public_pages');
	
	// Modification du Fil d'Ariane
	//elgg_register_plugin_hook_handler('view', 'navigation/breadcrumbs', 'adf_platform_alter_breadcrumb');
	
	// Permet de rendre le profil non public, si réglage activé
	$public_profiles = elgg_get_plugin_setting('public_profiles', 'adf_public_platform');
	if ($public_profiles == 'yes') {
		// Verrouillage de certaines pages à haut niveau (via le page_handler) 
		// Attention : ça ne bloque pas un accès direct s'il existe des fichiers à la racine du plugin...
		elgg_register_plugin_hook_handler('route', 'all', 'adf_platform_route');
		// Réglage pour l'utilisateur
		elgg_extend_view("forms/account/settings", "adf_platform/account/public_profile", 50); // En haut des réglages
		// Hook pour modifier le nouveau réglage ajouté aux paramètres personnels
		elgg_register_plugin_hook_handler('usersettings:save', 'user', 'adf_platform_public_profile_hook');
		// @TODO : compléter par un blocage direct au niveau de l'entité elle-même pour les listings et autres photos 
		// (non bloquant mais avec contenu vide à la place)
	}
	
	// Ssi déconnecté, hook pour les redirections pour renvoyer sur le login
	if (!elgg_is_logged_in()) {
		elgg_register_plugin_hook_handler('forward', 'all', 'adf_platform_public_forward_login_hook');
	}
	// Hook pour ne pas rediriger sur un site externe
	elgg_register_plugin_hook_handler('forward', 'all', 'adf_platform_forward_hook', 600);
	
	
	// Email blocking interception system : works by replacing the registered hook, and use it after processing
	// * triggers a blocking hook that enables email blocking based on any property from email sender or recipient
	// * requires to add the hook trigger to the email notification handler
	// Wrap notification handler into custom function so we can intercept the sending process
	global $NOTIFICATION_HANDLERS;
	//$ESOPE->notification_handler_email = $NOTIFICATION_HANDLERS['email']->handler;
	register_notification_handler("email", "esope_notification_handler", array('original_handler' => $NOTIFICATION_HANDLERS['email']->handler));
	/* Usage note : block email by registering an early hook to email_block,system hook
	 * any non null return will block email sending.
	 * 1. add in start.php : elgg_register_plugin_hook_handler("email_block", "system", "esope_email_block_hook", 0);
	 * 2. add to hook functions :
			// Intercept sending to provide a blocking hook for plugins which handle email control through eg. roles or status
			function esope_email_block_hook($hook, $type, $return, $params) {
				$to = $params['to'];
				// Note : check under which conditions email should not be sent
				if (elgg_instanceof($to, 'user')) {
					if (false) {
						// Block email sending
						return true;
					}
				}
				// Do not change behaviour otherwise (= send email)
				return $return;
			}
	*/
	
	
	// NEW & REWRITTEN ACTIONS
	$action_url = elgg_get_plugins_path() . 'adf_public_platform/actions/';
	// Modification de l'invitation de contacts dans les groupes (réglage : contacts ou tous)
	// Permet notamment de forcer l'inscription
	if (elgg_is_active_plugin('groups')) {
		elgg_unregister_action('groups/invite');
		elgg_register_action("groups/invite", $action_url . 'groups/membership/invite.php');
	}
	// Replace bookmarks action (allow access level change when using alternate container)
	if (elgg_is_active_plugin('bookmarks')) {
		elgg_unregister_action('bookmarks/save');
		elgg_register_action("bookmarks/save", $action_url . 'bookmarks/save.php');
	}
	// ESOPE search endpoint
	elgg_register_action("esope/esearch", $action_url . 'esope/esearch.php');
	// Manually reset login failure counter
	elgg_register_action("admin/reset_login_failures", $action_url . 'admin/reset_login_failures.php');
	
	// HTML export action
	elgg_register_action("pages/html_export", $action_url . 'pages/html_export.php', 'public');
	
	// Modified to make pages top_level / sub-pages
	$pages_reorder = elgg_get_plugin_setting('pages_reorder', 'adf_public_platform');
	if ($pages_reorder == 'yes') {
		elgg_register_action("pages/edit", $action_url . 'pages/edit.php');
	}
	
	// Allow to remove completely an email address for a user
	elgg_register_action("admin/remove_user_email", $action_url . "admin/remove_user_email.php", "logged_in");
	
	
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
	// Pour modifier la page d'arrivée et mettre en place la recherche avancée
	elgg_unregister_page_handler('members', 'members_page_handler');
	elgg_register_page_handler('members', 'adf_platform_members_page_handler');
	// Pour pouvoir lister tous les articles d'un membre (option du thème désactivée par défaut)
	elgg_unregister_page_handler('blog', 'blog_page_handler');
	elgg_register_page_handler('blog', 'adf_platform_blog_page_handler');
	// Remplacement fonctions du blog
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
	
	// Esope page handler : all tools
	elgg_register_page_handler('esope', 'esope_page_handler');
	// @TODO page handlers for downloadable and SEO-friendly images/ and files/
	
	// Esope liked content
	if (elgg_is_active_plugin('likes')) {
		elgg_register_page_handler('likes', 'esope_likes_page_handler');
	}
	
	// Ajout gestionnaire pour les dossiers
	/* @TODO : add setting + see if we want this by default or not
	if (elgg_is_active_plugin('file_tools') && elgg_is_logged_in()) {
		elgg_register_page_handler('folders','esope_folder_handler');
	}
	*/
	
	// MODIFICATION DES WIDGETS : (DES)ACTIVATION ET TITRES
	require_once(dirname(__FILE__) . '/lib/esope/widgets.php');
	
	
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
require_once(dirname(__FILE__) . '/lib/esope/page_handlers.php');
require_once(dirname(__FILE__) . '/lib/esope/hooks.php');



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
					'name' => 'members', 'href' => elgg_get_site_url() . 'members', 
					'text' => elgg_echo('adf_platform:directory'), 
					"section" => "directory",
				));
			
			// Ajoute lien vers les contacts
			elgg_register_menu_item("page", array(
					'name' => 'friends', 'href' => elgg_get_site_url() . 'friends/' . $own->username, 
					'text' => elgg_echo('friends'), 
					'contexts' => array('members'), 
				));
				
			// Ajoute lien vers les invitations
			if (elgg_is_active_plugin('invitefriends')) {
				$params = array(
					'name' => 'invite', 'text' => elgg_echo('friends:invite'), 'href' => elgg_get_site_url() . 'invite',
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
			// Remove menu builder (too basic + not used)
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
		if (isset($CONFIG->breadcrumbs) && is_array($CONFIG->breadcrumbs)) {
			
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
					$group_url = elgg_get_site_url() . 'groups/profile/' . $page_owner->guid . '/' . elgg_get_friendly_title($page_owner->name);
					array_unshift($CONFIG->breadcrumbs, array('title' => $page_owner->name, 'link' => $group_url) );
					array_unshift($CONFIG->breadcrumbs, array('title' => elgg_echo('groups'), 'link' => 'groups/all') );
				}
				
			} else if (elgg_instanceof($page_owner, 'user')) {
				// Adds Directory > Member if page owner is a user // doesn't really makes the breadcrumb clearer
				//array_unshift($CONFIG->breadcrumbs, array('title' => $page_owner->name, 'link' => elgg_get_site_url() . 'profile/' . $page_owner->username) );
				//array_unshift($CONFIG->breadcrumbs, array('title' => elgg_echo('adf_platform:directory'), 'link' => elgg_get_site_url() . 'members') );
			}
			
			// Insert home link in all cases
			array_unshift($CONFIG->breadcrumbs, array('title' => elgg_echo('adf_platform:homepage'), 'link' => elgg_get_site_url()));
			
		} else {
			//$CONFIG->breadcrumbs[] = array('title' => $CONFIG->sitename, 'link' => elgg_get_site_url());
			$CONFIG->breadcrumbs[] = array('title' => elgg_echo('adf_platform:homepage'), 'link' => elgg_get_site_url());
			
			// Corrections selon le contexte
			if (elgg_in_context('profile')) {
				// Annuaire => Nom du membre
				$page_owner = elgg_get_page_owner_entity();
				$CONFIG->breadcrumbs[] = array('title' => elgg_echo('adf_platform:directory'), 'link' => elgg_get_site_url() . 'members');
				$CONFIG->breadcrumbs[] = array('title' => $page_owner->name);
			} else if (elgg_in_context('members')) {
				// Membres => Annuaire
				$CONFIG->breadcrumbs[] = array('title' => elgg_echo('adf_platform:directory'));
			} else {
				// Par défaut : contexte
				$CONFIG->breadcrumbs[] = array('title' => elgg_echo($context), 'link' => elgg_get_site_url() . $context);
			}
		}
		
		// Remove any HTML in breadcrumb title (and especially FA icons)
		foreach ($CONFIG->breadcrumbs as $k => $v) {
			$CONFIG->breadcrumbs[$k]['title'] = strip_tags($CONFIG->breadcrumbs[$k]['title']);
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
	if (!empty($loginredirect)) { forward(elgg_get_site_url() . $loginredirect); }
	forward();
}

// Redirection après login
function adf_platform_public_forward_login_hook($hook_name, $reason, $location, $parameters) {
	if (!elgg_is_logged_in()) {
		global $CONFIG;
		//register_error("TEST : " . $_SESSION['last_forward_from'] . " // " . $parameters['current_url']);
		// Si jamais la valeur de retour n'est pas définie, on le fait
		if (empty($_SESSION['last_forward_from'])) $_SESSION['last_forward_from'] = $parameters['current_url'];
		return elgg_get_site_url() . 'login';
	}
	return null;
}

// Vérification des URL de redirection : si redirection vers un REFERER HTTP externe, forward vers l'accueil
function adf_platform_forward_hook($hook_name, $reason, $location, $parameters) {
	global $CONFIG;
	$forward_url = $parameters['forward_url'];
	if ($forward_url == $_SERVER['HTTP_REFERER']) {
		if ((strpos($forward_url, 'http:') === 0) || (strpos($forward_url, 'https:') === 0)) {
			$site_url = elgg_get_site_url();
			if (strpos($forward_url, $site_url) !== 0) {
				return $site_url;
			}
		}
	}
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


// @TODO : Désactive les notifications "site" pour les commentaires
// voir sur quoi s'accrocher ?? doit être rétroactif sur tous les membres, et ne pas bloquer les réglages manuels. Donc exécuté une seule fois au démarrage du plugin, ou autre manière de gérer le pb.
/*
function adf_public_platform_comments_disable_site() {
	//add_entity_relationship($user->guid, 'block_comment_notify' . $method, $CONFIG->site_guid
}
*/


if (!function_exists('messages_get_unread')) {
	/**
	 * Returns the unread messages in a user's inbox
	 *
	 * @param int $user_guid GUID of user whose inbox we're counting (0 for logged in user)
	 * @param int $limit Number of unread messages to return (default = 10)
	 *
	 * @return array
	 */
	function messages_get_unread($user_guid = 0, $limit = 10, $count = false) {
		if (!$user_guid) {
			$user_guid = elgg_get_logged_in_user_guid();
		}
		$db_prefix = elgg_get_config('dbprefix');
		$offset = 0;
		
		// denormalize the md to speed things up.
		// seriously, 10 joins if you don't.
		$strings = array('toId', $user_guid, 'readYet', 0, 'msg', 1);
		$map = array();
		foreach ($strings as $string) {
			$id = get_metastring_id($string);
			$map[$string] = $id;
		}
		//echo '<pre>' . print_r($map, true) . '</pre>';

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
			'offset' => $offset,
			'count' => $count,
		);

		return elgg_get_entities_from_metadata($options);
	}
}


if (elgg_is_active_plugin('au_subgroups')) {
	function adf_platform_list_groups_submenu($group, $level = 1, $member_only = false, $user = null) {
		if ($member_only && !$user) { $user = elgg_get_logged_in_user_entity(); }
		$menuitem = '';
		$class = "subgroup subgroup-$level";
		$display_alphabetically = elgg_get_plugin_setting('display_alphabetically', 'au_subgroups');
		$if ($display_alphabetically != 'no') {
			$children = au_subgroups_get_subgroups($group, 0, true);
		} else {
			$children = au_subgroups_get_subgroups($group, 0, false);
		}
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
 * $mode accepts : all (owned+operated), owned (only), operated (only)
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
	if (empty($title)) $title = $CONFIG->sitename;
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
	
	// Nouveaux types de champs pour les profils et les groupes
	function esope_register_custom_field_types() {
		// Add new input types
		$group_options = array("output_as_tags" => true, "admin_only" => true);
		// Select with multiple option (displayed as a block, not a dropdown)
		// @debug : this input can't be used with profile manager (because of reading values method) - use multiselect instead
		// Plaintext - useful for CSS or raw HTML/JS code
		add_custom_field_type("custom_group_field_types", 'plaintext', elgg_echo('profile:field:plaintext'), $group_options);
		// Group profile types selector (do smthg with selected members profile types)
		add_custom_field_type("custom_group_field_types", 'group_profiletypes', elgg_echo('profile:field:group_profiletypes'), $group_options);
		// Color picker
		add_custom_field_type("custom_group_field_types", 'color', elgg_echo('profile:field:color'), $group_options);
		// Group selector (scope=all|member)
		add_custom_field_type("custom_group_field_types", 'groups_select', elgg_echo('profile:field:groups_select'), $group_options);
		// Members select (friends picker) - scope=all|friends|groupmembers
		add_custom_field_type("custom_group_field_types", 'members_select', elgg_echo('profile:field:members_select'), $group_options);
		// Percentage - interval=10
		add_custom_field_type("custom_group_field_types", 'percentage', elgg_echo('profile:field:percentage'), $group_options);
		
		/* Profile fields : 
		// registering profile field types
		$profile_options = array(
				"show_on_register" => true,
				"mandatory" => true,
				"user_editable" => true,
				"output_as_tags" => true,
				"admin_only" => true,
				"count_for_completeness" => true
			);
		add_custom_field_type("custom_group_field_types", ...
		*/
	}
	
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
			if (($type = get_entity($profile_type_guid)) && ($type instanceof ProfileManagerCustomProfileType)) {
				$profile_type = strtolower($type->metadata_name);
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

	/* Returns all profile types as $profiletype_guid => $profiletype_name
	 * Can also return translated name (for use in a dropdown input)
	 */
	function esope_get_profiletypes($use_translation = false) {
		$profile_types_options = array(
				"type" => "object", "subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
				"owner_guid" => elgg_get_site_entity()->getGUID(), "limit" => false,
			);
		if ($custom_profile_types = elgg_get_entities($profile_types_options)) {
			foreach($custom_profile_types as $type) {
				$profile_type = strtolower($type->metadata_name);
				if ($use_translation) {
					$profiletypes[$type->guid] = elgg_echo('profile:types:' . $profile_type);
				} else {
					$profiletypes[$type->guid] = $profile_type;
				}
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
		$metadata = trim($params['metadata']);
		if (empty($metadata)) { return false; }
		$empty = elgg_extract('empty', $params, true);
		$value = elgg_extract('value', $params, get_input($metadata, false)); // Auto-select current value
		$name = elgg_extract('name', $params, $metadata); // Defaults to metadata name
		$auto_options = elgg_extract('auto-options', $params, false);
		$search_field = '';
		
		$field_a = elgg_get_entities_from_metadata(array('types' => 'object', 'subtype' => 'custom_profile_field', 'metadata_names' => 'metadata_name', 'metadata_values' => $metadata));
		if ($field_a) {
			$field = $field_a[0];
			$options = $field->getOptions();
			$valtype = $field->metadata_type;
			// Failsafe to auto-discover options if none found ? - but would convert any text field to dropdown (not good)
			//if (empty($options)) { $options = esope_get_meta_values($metadata); }
			// Auto-discover valid values from existing metadata
			if ($auto_options) {
				$options = esope_get_meta_values($metadata);
				$valtype = 'dropdown';
			}
			if (in_array($valtype, array('longtext', 'plaintext', 'rawtext'))) { $valtype = 'text'; }
			// Multiple options become select (if radio, should also invert keys and values)
			if ($options) {
				$valtype = 'dropdown';
				// Add empty entry at the beginning of the array
				$options = array('empty option' => '') + $options;
			}
			$search_field .= elgg_view("input/$valtype", array('name' => $name, 'options' => $options, 'value' => $value));
		}
		return $search_field;
	}
	
}

/* Returns the wanted value based on both params and inputs
 * If $params is set (to whatever except false, but including ), it will be used
 * If not set, we'll use GET inputs
 * If still nothing, we'll use default value
 */
function esope_extract($key, $params = array(), $default = null, $sanitise = true) {
	// Try using params only if set : we want to get only defined values, so use strict mode, and no default yet
	$value = elgg_extract($key, $params, false, true);
	// Try get_input only if nothing was set in params
	if ($value === false) { $value = get_input($key, false); }
	// If there is neither $params not input, use default (but don't if anything was set, event empty !)
	if ($value === false) { $value = $default; }
	// Sanitise string
	if ($sanitise && is_string($value)) $value = sanitise_string($value);
	return $value;
}

/* Esope search function : 
 * Just call echo esope_esearch() for a listing
 * Get entities with $results_ents = esope_esearch(array('returntype' => 'entities'));
 * Basic use with few config will use GET inputs as parameters
 * $params :
 	- q : full search query
 	- entity_type : site | object | user | group
 	- entity_subtype : usually an object subtype
 	- owner_guid : owner of entity
 	- container_guid : container of entity
 	- metadata : list of metadata and values
   Note that search can be parametered both directly (params), or with URL. Params will override URL queries.
   Important : $params are NOT defaults, these are filters = if set to anything (except false), it will override GET inputs
 * $defaults : sets the defaults for any input value
 * max_results : let's override the max number of displayed results. 
   Note that a pagination should be implemented by any plugin using this function
 * TODO :
   - fulltext search in tags
   - fulltext search in comments
   - allow fulltext search in any metadata ? (warning !)
   - integrate (if search plugin active) search_highlight_words($words, $string)
 */
function esope_esearch($params = array(), $defaults = array(), $max_results = 500) {
	global $CONFIG;
	$debug = esope_extract('debug', $params, false);
	
	// Set defaults
	$esearch_defaults = array(
		'entity_type' => 'object', 
		'entity_subtype' => null, 
		'limit' => 0,
		'offset' => 0,
		'metadata_case_sensitive' => false,
		'metadata_name_value_pairs_operator' => 'AND',
		'count' => false,
	);
	if (is_array($defaults)) $defaults = array_merge($esearch_defaults, $defaults);
	else $defaults = $esearch_defaults;
	
	$q = esope_extract('q', $params, '');
	// Note : we use entity_type and entity_subtype for consistency with regular search
	$type = esope_extract('entity_type', $params, $defaults['entity_type']);
	$subtype = esope_extract('entity_subtype', $params, $defaults['entity_subtype']);
	$owner_guid = esope_extract('owner_guid', $params, $defaults['owner_guid']);
	$container_guid = esope_extract('container_guid', $params, $defaults['container_guid']);
	$limit = (int) esope_extract('limit', $params, $defaults['limit']);
	$offset = (int) esope_extract('offset', $params, $defaults['offset']);
	$sort = esope_extract('sort', $params, $defaults['sort']);
	$order = esope_extract('order', $params, $defaults['order']);
	// Metadata search : $metadata[name]=value
	$metadata = esope_extract('metadata', $params, $defaults['metadata']);
	$metadata_case_sensitive = esope_extract('metadata_case_sensitive', $params, $defaults['metadata_case_sensitive']);
	$metadata_name_value_pairs_operator = esope_extract('metadata_name_value_pairs_operator', $params, $defaults['metadata_name_value_pairs_operator']);
	$order_by_metadata = esope_extract('order_by_metadata', $params, $defaults['order_by_metadata']);
	$count = esope_extract('count', $params, $defaults['count']);
	
	/*
	$q = esope_extract('q', $params);
	$type = esope_extract('entity_type', $params, $default['types']);
	$subtype = esope_extract('entity_subtype', $params, $default['subtypes']);
	
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
	*/
	
	$result = array();
	if ($debug) {
		echo "Search : q=$q type=" . print_r($type, true) . " subtype=" . print_r($subtype, true) . '<br />';
		echo "Search : owner=$owner_guid / container=$container_guid limit=$limit offset=$offset sort=$sort order=$order<br />";
		echo "Metadata : " . print_r($metadata, true) . "<br />";
	}
	// show hidden (unvalidated) users
	//$hidden = access_get_show_hidden_status();
	//access_show_hidden_entities(true);

	// Recherche par nom / username / titre / description, selon les cas
	// @TODO ajouter par tag
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
			'metadata_name_value_pairs' => $metadata_name_value_pairs,
			'metadata_case_sensitive' => $metadata_case_sensitive,
			'metadata_name_value_pairs_operator' => $metadata_name_value_pairs_operator,
			'order_by_metadata' => $order_by_metadata,
			'limit' => $limit,
			'offset' => $offset,
			'sort' => $sort,
			'order' => $order,
		);
	if ($joins) $search_params['joins'] = $joins;
	if ($wheres) $search_params['wheres'] = $wheres;
	if ($owner_guid) $search_params['owner_guids'] = $owner_guid;
	if ($container_guid) $search_params['container_guids'] = $container_guid;
	
	// Perform search results count
	$search_params['count'] = true;
	if ($debug) echo '<pre>' . print_r($search_params, true) . '</pre>';
	$return_count = elgg_get_entities_from_metadata($search_params);
	if ($count) return $return_count;
	
	if ($return_count > $max_results) {
		$alert = '<span class="esope-morethanmax">' . elgg_echo('esope:search:morethanmax') . '</span>';
	}
	if ($search_params['limit'] > $max_results) $search_params['limit'] = $max_results;
	// Perform entities search
	$search_params['count'] = false;
	$entities = elgg_get_entities_from_metadata($search_params);
	// Limit to something that can be handled
	if (is_array($entities)) $entities = array_slice($entities, 0, $max_results);
	
	// Return array or listing
	if ($params['returntype'] == 'entities') {
		return $entities;
	} else {
		$search_params['full_view'] = false;
		$search_params['pagination'] = false;
		$search_params['list_type'] = 'list'; // gallery/list
		elgg_push_context('search');
		elgg_push_context('widgets');
		$return = '';
		if ($params['add_count']) {
			if ($return_count) $return .= '<span class="esope-results-count">' . elgg_echo('esope:search:nbresults', array($return_count)) . '</span>';
			else $return .= '<span class="esope-results-count">' . elgg_echo('esope:search:noresult') . '</span>';
		}
		$return .= elgg_view_entity_list($entities, $search_params, $offset, $max_results, false, false, false);
		if ($alert) $return .= $alert;
		elgg_pop_context('widgets');
		elgg_pop_context('search');
	}
	
	if (empty($return)) $return = '<span class="esope-noresult">' . elgg_echo('esope:search:noresult') . '</span>';
	
	return $return;
}


// Adaptation du code dispo sur OpenClassrooms
// Fonction de cryptage réversible : on utilise la même fonction pour coder/décoder
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
	//$subpages = elgg_get_entities_from_metadata(array('type' => 'object', 'subtype' => 'page', 'metadata_name' => 'parent_guid', 'metadata_value' => $parent->guid, 'limit' => 0, 'joins' => "INNER JOIN {$CONFIG->dbprefix}objects_entity as oe", 'order_by' => 'oe.title asc'));
	// Metadata search is way too long, filtering is much quicker alternative
	// Limit searched entities range with "guids" => $guids
	$md_name = get_metastring_id('parent_guid');
	$md_value = get_metastring_id($parent->guid);
	// Can't be empty or we'll get a bad error
	if (!empty($md_name) && !empty($md_value)) {
		$guids_row = get_data("SELECT entity_guid FROM {$CONFIG->dbprefix}metadata where name_id = $md_name and value_id = $md_value");
		foreach ($guids_row as $row) { $guids[] = $row->entity_guid; }
	}
	if ($guids) {
		$subpages = elgg_get_entities(array('type' => 'object', 'subtype' => 'page', 'container_guid' => $parent->container_guid, 'limit' => 0, 'joins' => "INNER JOIN {$CONFIG->dbprefix}objects_entity as oe", 'order_by' => 'oe.title asc', 'guids' => $guids));
		return $subpages;
	}
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
// @TODO : make id unique *per prefix*
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
	$base_elements = parse_url(elgg_get_site_url());
	if ($elements['host'] != $base_elements['host']) return true;
	return false;
}


if (elgg_is_active_plugin('file_tools')) {
	
	// Recursive function that lists folders and their content
	// bool $view_files : display folder files
	function esope_view_folder_content($folder, $view_files = true) {
		global $CONFIG;
		$content = '';
		$folder_content = '';
		$folder_description = '';
		$files_content = '';
		// Folder link
		$folder_title_link = '<a href="' . elgg_get_site_url() . 'file/group/' . $folder['folder']->container_guid . '/all#' . $folder['folder']->guid . '">' . $folder['folder']->title . '</a>';
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

/* User profile visibility gatekeeper
 * Forwards to home if public profile is not allowed
 * $user : defaults to page owner
 * $forward : allow to determine visibility, not actually forward
 * If no forward set, returns true if allowed, false if not allowed
 */
function esope_user_profile_gatekeeper($user = false, $forward = true) {
	$public_profiles = elgg_get_plugin_setting('public_profiles', 'adf_public_platform');

	// No user profile gatekeeper if viewer is logged in
	if (elgg_is_logged_in() || ($public_profiles == 'no')) return true;
	
	// Defaults to page owner, so most cases where we need to protect user profile are handled
	if (!$user) $user = elgg_get_page_owner_entity();
	
	if (elgg_instanceof($user, 'user')) {
		// Selon le réglage par défaut, le profil est visible ou masqué par défaut
		$public_profiles_default = elgg_get_plugin_setting('public_profiles_default', 'adf_public_platform');
		if (empty($public_profiles_default)) { $public_profiles_default = 'yes'; }
	
		// Le profil n'est accessible que si l'user ou à défaut le site en a décidé ainsi, sinon => forward
		if ($public_profiles_default == 'no') {
			// Opt-in : profil restreint par défaut
			if ($user->public_profile != 'yes') {
				if ($forward) {
					register_error(elgg_echo('adf_public_platform:noprofile'));
					forward();
				} else { return false; }
			}
		} else {
			// Opt-out : profil public par défaut
			if ($user->public_profile == 'no') {
				if ($forward) {
					register_error(elgg_echo('adf_public_platform:noprofile'));
					forward();
				} else { return false; }
			}
		}
	}
	// Don't block anything else than a user
	return true;
}


// Credits goes to rommel http://www.php.net/manual/fr/function.filesize.php
function esope_human_filesize($filepath, $decimals = 2) {
	$bytes = filesize($filepath);
	//$sz = elgg_echo('esope:filesize:units'); // Can be used for translations
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$sz[$factor];
}


/* Prepare JS string that can be added directly to the template config in tinymce
 * $templates : string usually set in plugins settings, formatted as : source::title::description
 * $source : can be an URL to the HTML template file, or cmspage, or object GUID
 */
function esope_tinymce_prepare_templates($templates, $type = 'url') {
	global $CONFIG;
	$templates = preg_replace('/\r\n|\n|\r/', '\n', $templates);
	$templates = explode('\n', $templates);
	$js_templates = '';
	foreach ($templates as $template) {
		$template = trim($template);
		if (!empty($template)) {
			$template = explode('::', $template);
			$source = trim($template[0]);
			// Escape double quotes for display text elements (which would break JS)
			// Note that json_encode result is wrapped into double quotes so it must be used directly in JS
			$title = json_encode(trim($template[1]));
			$description = json_encode(trim($template[2]));
			switch($type) {
				case 'cmspage':
					// Cmspages always respect friendly title formatting
					$source = elgg_get_friendly_title($source);
					$source = elgg_get_site_url() . 'p/' . $source . '?embed=inner&noedit=true';
					break;
				case 'guid':
					if ($ent = get_entity($source)) {
						// @TODO : provide a REST URL access to an entity description (with access rights)
						// Best we can get now would be exported JSON
						// Export description only : export/default/1073/attr/description/
						$source = elgg_get_site_url() . 'export/default/' . $source . '/attr/description/';
						if (empty($title)) $title = $ent->title;
						else if (empty($description)) $description = $ent->title;
					} else $source = false;
					break;
				case 'url':
				default:
					// Nothing yet
			}
			// Allow some failsafe behaviour
			if (empty($source)) continue;
			if (empty($title)) $title = $source;
			if (empty($description)) $description = $title;
			// Add config line to templates config
			$js_templates .= '{ title : ' . $title . ', src : "' . $source . '", description : ' . $description . ' }, ' . "\n";
		}
	}
	return $js_templates;
}


/* Return a list of valid users from a string
 * Input string can be a GUID or username list
 */
function esope_get_users_from_setting($setting) {
	$userlist = explode(',', trim($setting));
	$users = array();
	if ($userlist) foreach($userlist as $id) {
		$id = trim($id);
		if (($user = get_entity($id)) && elgg_instanceof($user, 'user')) {
			$users[$user->guid] = $user;
		} else if (($user = get_user_by_username($id)) && elgg_instanceof($user, 'user')) {
			$users[$user->guid] = $user;
		}
	}
	return $users;
}


/* Return distinct metadata values for a given metadata name
 * Quickest method uses a direct SQL query
 * Also default sort alphabetically
 */
function esope_get_meta_values($meta_name, $sort = true) {
	$dbprefix = elgg_get_config('dbprefix');
	$query = "SELECT DISTINCT ms.string FROM `" . $dbprefix . "metadata` as md 
		JOIN `" . $dbprefix . "metastrings` as ms ON md.value_id = ms.id 
		WHERE md.name_id IN (SELECT DISTINCT id FROM `" . $dbprefix . "metastrings` WHERE string = '$meta_name')";
	if ($sort) { $query .= ' ORDER BY ms.string ASC;'; }
	$query .= ';';
		//WHERE md.name_id = (SELECT id FROM `" . $dbprefix . "metastrings` WHERE string = '$meta_name');";
	$rows = get_data($query);
	foreach ($rows as $row) { $results[] = $row->string; }
	
	return $results;
	// Previous version is slower, and not so much clearer
	/*
	$meta_opt = array();
	$metadatas = elgg_get_metadata(array('metadata_names' => $meta_name, 'limit' => 0));
	if ($metadatas) {
		foreach($metadatas as $meta) {
			if (!in_array($meta->value, $meta_opt)) { $meta_opt[] = $meta->value; }
		}
	}
	return $meta_opt;
	*/
}

// http://reference.elgg.org/1.8/engine_2lib_2metadata_8php.html#a1614d620ec0b0d0b9531c68070ffb33c
// The "metadata_calculation" option causes this function to return the result of performing 
// a mathematical calculation on all metadata that match the query instead of returning
// SQL calculation functions : COUNT, MAX, MIN, AVG, SUM
// Returns the max value for a given metadata
function esope_get_meta_max($name = '', $subtype = '', $type = 'object') {
	if (!empty($name)) return elgg_get_metadata(array('types' => $type, 'subtypes' => $subtype, 'metadata_names' => $name, 'metadata_calculation' => "MAX"));
	return false;
}
// Returns the min value for a given metadata
function esope_get_meta_min($name = '', $subtype = '', $type = 'object') {
	if (!empty($name)) return elgg_get_metadata(array('types' => $type, 'subtypes' => $subtype, 'metadata_names' => $name, 'metadata_calculation' => "MIN"));
	return false;
}


/* Filter values by metadata query iterations
 * $values : list of GUIDs
 * $md_filter : metdata array, as in metadata_name_value_pairs
 */
function esope_filter_entity_guid_by_metadata(array $values, array $md_filter) {
	$values = implode(', ', $values);
	if (empty($values)) { return false; }
	$dbprefix = elgg_get_config('dbprefix');
	$select = "SELECT DISTINCT md.entity_guid FROM {$dbprefix}metadata as md ";
	$join .= "JOIN {$dbprefix}metastrings as msn ON md.name_id=msn.id ";
	$join .= "JOIN {$dbprefix}metastrings as msv ON md.value_id=msv.id ";
	switch($md_filter['operand']) {
		case '=':
		case '':
			$where = "msn.string = '{$md_filter['name']}' AND msv.string = '{$md_filter['value']}'";
			break;
		case 'LIKE':
			$where = "msn.string = '{$md_filter['name']}' AND msv.string {$md_filter['operand']} '{$md_filter['value']}'";
			break;
		default:
			$where = "msn.string = '{$md_filter['name']}' AND msv.string {$md_filter['operand']} {$md_filter['value']}";
	}
	
	//$search_results .= 'Filter MD query : <pre>' . $query . '</pre>';
	
	$results = get_data("$select $join WHERE $where AND md.entity_guid IN ($values);");
	if ($results) {
		$guids = array();
		foreach ($results as $row) { $guids[] = $row->entity_guid; }
		return $guids;
	}
	return false;
}



/* Renvoie un array d'emails, de GUID, etc. à partir d'un textarea ou d'un input text
 * e.g. 123, email;test \n hello => array('123', 'email', 'test', 'hello')
 * string $input
 * string|array('string') $separators (\n will always be a separator)
 * Séparateurs acceptés : retours à la ligne, virgules, points-virgules, pipe, etc.
 * Return : Tableau filtré, ou false
 */
function esope_get_input_array($input = false, $separators = array("\n", "\r", "\t", ",", ";", "|")) {
	if ($input) {
		if (is_array($separators)) {
			$main_sep = array_shift($separators);
			$input = str_replace($separators, $main_sep, $input);
			$input = explode($main_sep, $input);
		} else {
			$input = explode($separators, $input);
		}
		// Suppression des espaces
		$input = array_map('trim', $input);
		// Suppression des doublons
		$input = array_unique($input);
		// Supression valeurs vides
		$input = array_filter($input);
	}
	return $input;
}


/* Ajoute des valeurs dans un array de metadata (sans doublon)
 * $entity : the source/target entity
 * $meta : metadata to be updated
 * $add : value(s) to be added
 */
function esope_add_to_meta_array($entity, $meta = '', $add = array()) {
	if (!($entity instanceof ElggEntity) || empty($meta) || empty($add)) { return false; }
	$values = $entity->{$meta};
	// Make it an array, even empty
	if (!is_array($values)) {
		if (!empty($values)) $values = array($values);
		else $values = array();
	}
	// Allow multiple values to be added in one pass
	if (!is_array($add)) $add = array($add);
	foreach ($add as $new_value) {
		if (!in_array($new_value, $values)) { $values[] = $new_value; }
	}
	// Ensure unique values
	$values = array_unique($values);
	// Update entity
	if ($entity->{$meta} = $values) { return true; }
	return false;
}

/* Retire des valeurs d'un array de metadata (sans doublon)
 * $entity : the source/target entity
 * $meta : metadata to be updated
 * $remove : value(s) to be removed
 */
function esope_remove_from_meta_array($entity, $meta = '', $remove = array()) {
	if (!($entity instanceof ElggEntity) || empty($meta) || empty($remove)) { return false; }
	$values = $entity->{$meta};
	// Make it an array, even empty
	if (!is_array($values)) {
		if (!empty($values)) { $values = array($values); } else { $values = array(); }
	}
	// Allow multiple values to be removed in one pass
	if (!is_array($remove)) $remove = array($remove);
	foreach ($values as $key => $value) {
		if (in_array($value, $remove)) { unset($values[$key]); }
	}
	// Ensure unique values
	$values = array_unique($values);
	// Update entity
	if ($entity->{$meta} = $values) { return true; }
	return false;
}


/* Build options suitable array from settings
 * Allowed separators are *only* one option per line, or | separator (we want to accept commas and other into fields)
 * Accepts key::value and list of keys
 * e.g. val1 | val2, or val1::Name 1 | val2::Name 2
 * $input : the settings string
 * $addempty : add empty option
 * prefix : translation key prefix
 */
function esope_build_options($input, $addempty = true, $prefix = 'option') {
	$options = str_replace(array("\r", "\t", "|"), "\n", $input);
	$options = explode("\n", $options);
	$options_values = array();
	if ($addempty) $options_values[''] = "";
	if (is_array($options)) foreach($options as $option) {
		$option = trim($option);
		if (!empty($option)) {
			if (strpos($option, '::')) {
				$value = explode('::', $option);
				$key = trim($value[0]);
				$options_values[$key] = trim($value[1]);
			} else {
				$options_values[$option] = elgg_echo("$prefix:$option");
			}
		}
	}
	return $options_values;
}

/* Reverse function of esope_build_options
 * Converts an options_values array to a setting string
 */
function esope_build_options_string($options, $prefix = 'option') {
	$options_string = '';
	if (is_array($options)) foreach ($options as $key => $value) {
		if (!empty($options_string)) $options_string .= ' | ';
		$options_string .= $key . '::' . $value;
	}
	return $options_string;
}

/* Build multi-level array from string syntax
 * $input : the settings string
 * $separators : separators definition for each level (arrays allowed for each level)
 * Note : by default this will build a key => value(s) array, but will not eg. parse CSV-like format
 * $nokeys : do not use key:value mode, so it will split on 2nd separator level instead of trying to find keys
 *   Eg. will produce [] => "Some content" instead of "Some content" => true
 *   This allows CSV parsing, eg
 */
function esope_get_input_recursive_array($input, $separators = array(array("|", "\r", "\t"), '::', ','), $nokeys = false) {
	$return_array = array();
	$input = trim($input);
	
	// Note : we always break on "\n", but use replacement to do it recusively
	$options = str_replace($separators[0], "\n", $input);
	$options = explode("\n", $options);
	
	// Dont make arrays from basic values...
	if (sizeof($options) == 1) { return $input; }
	
	foreach ($options as $option) {
		$option = trim($option);
		if (empty($option)) continue;
		
		if ($separators[1]) {
			// Potential sublevel
			
			// No key mode : check if 2nd level separator is used, otherwise add to array
			if ($nokeys) {
				$new_separators = array_slice($separators, 1);
				
				// check for sub-level config
				if (is_array($separators[1])) {
					foreach ($separators[1] as $sep) {
						$pos = strpos($option, $sep);
						if ($pos !== false) break;
					}
				} else {
					$sep = $separators[1];
					$pos = strpos($option, $sep);
				}
				// If we have a sub-level, get nested array
				if ($pos !== false) {
					$return_array[] = esope_get_input_recursive_array($option, $new_separators, $nokeys);
				} else {
					$return_array[] = $option;
				}
				
			} else {
				$new_separators = array_slice($separators, 2);
			
				// check for sub-level config
				if (is_array($separators[1])) {
					foreach ($separators[1] as $sep) {
						$pos = strpos($option, $sep);
						if ($pos !== false) break;
					}
				} else {
					$sep = $separators[1];
					$pos = strpos($option, $sep);
				}
				
				// Get nested array if any
				if ($pos !== false) {
					$key = trim(substr($option, 0, $pos));
					$value = substr($option, $pos + strlen($sep));
					$return_array[$key] = esope_get_input_recursive_array($value, $new_separators, $nokeys);
				} else {
					$return_array[$option] = true;
				}
			}
			
		} else {
			// No sublevel : add option
			// Note : if using keys, we need to have value set because we're looking for rights with in_array
			// (which looks for values, not keys)
			if ($nokeys) $return_array[] = $option;
			else $return_array[$option] = true;
		}
	}
	return $return_array;
}

/* Build string syntax from multi-level array
 * $array : the settings array
 * $separators : separators definition for each level (only 1 separator per level)
 */
function esope_set_input_recursive_array($array, $separators = array("|", '::', ',')) {
	$return_string = '';
	if ($array) foreach ($array as $key => $value) {
		if (!empty($return_string)) $return_string .= $separators[0];
		if (is_array($value)) {
			// Need some recursitivity
			$new_separators = array_slice($separators, 2);
			$return_string .= $key . $separators[1] . esope_set_input_recursive_array($value, $new_separators);
		} else {
			$return_string .= $key;
		}
	}
	return $return_string;
}


/* Renvoie un array de groupes selon les critères featured et open membership
 *
 * string $mode : types de groupes = (default), ou featured
 * bool $filter : groupes en inscription libre seulement
 * bool $bypass : ne pas tenir compte des accès (mode admin)
 *
*/
function esope_get_joingroups($mode = '', $filter = false, $bypass = false) {
	// Admin : on ne tient pas compte des accès
	if ($bypass) { $ia = elgg_set_ignore_access(true); }
	switch($mode) {
		case 'featured':
			// Groupes en Une
			$groups = elgg_get_entities_from_metadata(array('metadata_name' => 'featured_group', 'metadata_value' => 'yes', 'type' => 'group', 'limit' => 0));
			break;
		default:
			// Tous groupes
			$groups = elgg_get_entities(array('type' => 'group', 'limit' => 0));
	}
	// Filtre des groupes en inscription libre
	if ($filter == 'open') {
		foreach ($groups as $k => $ent) {
			if (!$ent->isPublicMembership()) { unset($groups[$k]); }
		}
	}
	if ($bypass) { elgg_set_ignore_access($ia); }
	usort($groups, create_function('$a,$b', 'return strcmp($a->name,$b->name);')); 
	return $groups;
}


// Perform some post-login actions (join groups, etc.)
function esope_login_user_action($event, $type, $user) {
	if (elgg_instanceof($user, "user")) {
		if (!$user->isBanned()) {
			// Try to join groups asked at registration
			if ($user->join_groups) {
				foreach($user->join_groups as $group_guid) {
					if ($group = get_entity($group_guid)) {
						// Process only groups that haven't been joined yet
						if (!$group->isMember($user)) {
							if (!$group->join($user)) {
								// Handle subgroups cases
								if (elgg_is_active_plugin('au_subgroups')) {
									system_message(elgg_echo('esope:subgroups:tryjoiningparent', array($group->name)));
									while ($parent = au_subgroups_get_parent_group($group)) {
										//  Join only if parent group is public membership or if we have a join pending
										if (!$parent->isMember($user) && ($parent->isPublicMembership() || in_array($parent->guid, $user->join_groups))) {
											// Join group, or add to join list
											if (!$parent->join($user)) { $join_children[] = $parent->guid; }
										}
									}
									// Start joining from upper parents if needed
									if ($join_children) {
										$join_children = array_reverse($join_children);
										foreach($join_children as $children) { $children->join($user); }
									}
									// Try to join group again
									if ($group->join($user)) {}
								}
							}
						}
					}
				}
				// Update waiting list
				$user->join_groups = null;
			}
		}
	}
	return null;
}


/* Returns an array with images extracted from a text field
 * string $html : the HTML input content
 * bool $full_tag : return full <img /> tag, or only src if false
 */
function esope_extract_images($html, $full_tag = true) {
	/* 
	// Regex method : not as failsafe as we'd like to
	preg_match_all('/<img[^>]+>/i',$html,$out); 
	$images = $out[0];
	*/
	
	// DOM method : most failsafe
	if (function_exists('mb_convert_encoding')) {
		$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
	}
	$dom = new domDocument;
	$dom->loadHTML($html);
	$dom->preserveWhiteSpace = false;
	$images = $dom->getElementsByTagName('img');
	if ($full_tag) { return $images; }
	
	// Extract src
	$src = array();
	foreach ($images as $image) {
		$src[] = $image->getAttribute('src');
	}
	return $src;
}

/* Returns the first image found in a text string
 * string $html : the HTML input content
 * bool $full_tag : return full <img /> tag, or only src if false
 */
// @TODO set featured icon by using inline image and resizing it
function esope_extract_first_image($html, $full_tag = true) {
	$images = esope_extract_images($html, $full_tag);
	return $images[0];
}



// @TODO : make this more robust and fail-safe
// Add file to an entity (using a specific folder in datastore)
function esope_add_file_to_entity($entity, $input_name = 'file') {
	if (elgg_instanceof($entity, 'object') || elgg_instanceof($entity, 'user') || elgg_instanceof($entity, 'group') || elgg_instanceof($entity, 'site')) {
		/*
		$title = htmlspecialchars($_FILES['upload']['name'], ENT_QUOTES, 'UTF-8');
		
			// use same filename on the disk - ensures thumbnails are overwritten
			$filestorename = $file->getFilename();
			$filestorename = elgg_substr($filestorename, elgg_strlen($prefix));
		} else {
			$filestorename = elgg_strtolower(time().$_FILES['upload']['name']);
		}

		$file->setFilename($prefix . $filestorename);
		$mime_type = ElggFile::detectMimeType($_FILES['upload']['tmp_name'], $_FILES['upload']['type']);
	
			// hack for Microsoft zipped formats
		$info = pathinfo($_FILES['upload']['name']);
		$office_formats = array('docx', 'xlsx', 'pptx');
		if ($mime_type == "application/zip" && in_array($info['extension'], $office_formats)) {
			switch ($info['extension']) {
				case 'docx':
					$mime_type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
					break;
				case 'xlsx':
					$mime_type = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
					break;
				case 'pptx':
					$mime_type = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
					break;
			}
		}

		// check for bad ppt detection
		if ($mime_type == "application/vnd.ms-office" && $info['extension'] == "ppt") {
			$mime_type = "application/vnd.ms-powerpoint";
		}

		$file->setMimeType($mime_type);
		$file->originalfilename = $_FILES['upload']['name'];
		$file->simpletype = file_get_simple_type($mime_type);

		// Open the file to guarantee the directory exists
		$file->open("write");
		$file->close();
		move_uploaded_file($_FILES['upload']['tmp_name'], $file->getFilenameOnFilestore());
		*/
	
		$filename = $_FILES[$input_name]['name'];
		if ($uploaded_file = get_uploaded_file($input_name)) {
error_log("#3");
			// Remove previous file, if any
			// @TODO not tested... check it's working as expected
			if (!empty($entity->{$input_name})) {
				if (file_exists($filename)) { unlink($filename); }
			}

			// Create new file
			$prefix = "esope_files/{$input_name}/";
			$filehandler = new ElggFile();
			$filehandler->owner_guid = $entity->guid;
			$filehandler->setFilename($prefix . $filename);
			if ($filehandler->open("write")){
				$filehandler->write($uploaded_file);
				$filehandler->close();
			}
			$filename = $filehandler->getFilenameOnFilestore();
			$entity->{$input_name} = $filename;
			return true;
		}
	}
	return false;
}

// Remove existing file
function esope_remove_file_from_entity($entity, $input_name = 'file') {
	if (elgg_instanceof($entity, 'object') || elgg_instanceof($entity, 'user') || elgg_instanceof($entity, 'group') || elgg_instanceof($entity, 'site')) {
		if (!empty($entity->{$input_name})){
			$filehandler = new ElggFile();
			$filehandler->owner_guid = $entity->guid;
			$filehandler->setFilename($entity->{$input_name});
			if ($filehandler->exists()) {
				$filehandler->delete();
			}
			unset($entity->{$input_name});
			return true;
		} else {
			return true;
		}
	}
	return false;
}


/* Return the best translation for a given metadata
 * We prefer a direct translation
 * Then a translated string
 * And finally the name itself
 */
function esope_get_best_translation_for_metadata($name, $prefix = '', $translation = false) {
	// Real translation doesn't need any transformation
	if (!empty($translation) && ($translation != "$prefix:$name") && ($translation != $name)) return $translation;
	// Try translation system
	$translation = elgg_echo("$prefix:$name");
	// If translation is the translation key itself, use the key itself
	if ($translation == "$prefix:$name") $translation = ucfirst($name);
	return $translation;
}


// Prepare date for iCal
/* Note : we'll see what we exactly need : adjust time, add TZID to data, etc.
// Important : pour ical, soit la date est avec un Z final et est en UTC, soit elle comporte le TZID="Europe/Paris" puis la date sans le Z final
function esope_ts_to_ical($ts = 0, $tzone = 0.0) {
	// Add imezone info
	$tzid = ";TZID=" . date_default_timezone_get();
	// Use TZ correction to adjust UTC stamp
	$tsUTC = $ts + ($tzone * 3600);       
	$ts  = date("Ymd\THis\Z", $tsUTC);
	return $ts;
} 
*/




// Email blocking : triggers the email,system hook to enable email blocking based on any property from email sender or recipient
function esope_notification_handler(ElggEntity $from, ElggUser $to, $subject, $body, array $params = NULL) {
	/*
	error_log("ESOPE EMAIL : handler active");
	echo '<pre>' . print_r($NOTIFICATION_HANDLERS['email'], true) . '</pre>';
	
	global $CONFIG;
	echo '<pre>' . print_r($CONFIG->hooks['email']['system'], true) . '</pre>';
	
	
	echo '<pre>' . print_r($handler, true) . '</pre>';
	echo '<pre>' . print_r($from, true) . '</pre>';
	echo '<pre>' . print_r($to, true) . '</pre>';
	echo '<pre>' . print_r($subject, true) . '</pre>';
	echo '<pre>' . print_r($body, true) . '</pre>';
	echo '<pre>' . print_r($params, true) . '</pre>';
	*/
	// Trigger hook to enable email blocking for plugins which handle email control through eg. roles or status
	// Note : better avoid using the same hook because it requires to build the exact same params as in elgg_send_email, 
	// but other plugins may have changed them before (other sender, etc.), so let's just use another one.
	$result = elgg_trigger_plugin_hook('email_block', 'system', array('to' => $to, 'from' => $from, 'subject' => $subject, 'body' => $body, 'params' => $params), null);
	if ($result !== NULL) { return $result; }
	
	// If no blocking return received, get back to regular handler and process
	global $NOTIFICATION_HANDLERS;
	$handler = $NOTIFICATION_HANDLERS['email']->original_handler;
	return $handler($from, $to, $subject, $body, $params);
}

// Callback function to be used when comparing 2 menu items
// It is used to compare menu elements that include FontAwesome icons and/or starting spaces
function esope_menu_alpha_cmp($a, $b) {
	$a = trim(strip_tags($a->getText()));
	$b = trim(strip_tags($b->getText()));
	if ($a == $b) { return 0; }
	//return strcmp($a,$b);
	// Comparaison insensible à la case
	return strcasecmp($a,$b);
}


// Callback function to be used when comparing 2 annotations likes count
function esope_annotation_likes_cmp($a, $b) {
	$al = new AnnotationLike($a->id);
	$bl = new AnnotationLike($b->id);
	if (!$al->isValid() || !$bl->isValid()) { return 0; }
	$ac = $al->count();
	$bc = $bl->count();
	if ($ac == $bc) return 0;
	// Use reverse order : max on top
	return strcmp($bc, $ac);
}



/* @TODO : Build menu list from flat config file (without enclosing <ul>)
 * IMPORTANT : define top level entries first
 * Config syntax : name::url::class::parent_name
 * Translation string : esope:menu[:<parent_name>]:<name>
 * $menu = array(
 *    'entry_name' => array(
 *        'href' => 'URL',
 *        'class' => 'css class',
 *        'submenu' => array(),   // <= menu array
 *      ),
 *  )
 */
/*
function esope_build_menu($a, $b) {
	$menu = array();
	$entries = array();
	foreach ($entries as $name => $entry) {
		$menu[$name] = array(),
	}
	return $menu;
}
*/


// Returns a list of admin tools (used in esope/tools)
function esope_admin_tools_list() {
	$tools = array('group_admins', 'users_email_search', 'group_newsletters_default', 'test_mail_notifications', 'threads_disable', 'group_updates', 'spam_users_list', 'user_updates', 'clear_cmis_credentials', 'entity_fields', 'users_stats', 'group_publication_stats');
	return $tools;
}



