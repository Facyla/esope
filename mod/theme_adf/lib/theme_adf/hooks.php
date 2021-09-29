<?php

// Pour configurer les widgets par défaut
/**
 * Register user dashboard with default widgets
 *
 * @param unknown_type $hook
 * @param unknown_type $type
 * @param unknown_type $return
 * @param unknown_type $params
 * @return array
 */
/*
function theme_adf_default_widgets(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	
	$return[] = array(
		'name' => elgg_echo('naturalconnect:index:title'),
		'widget_context' => 'naturalconnect',
		'widget_columns' => 7,
		'event' => 'create',
		'entity_type' => 'user',
		'entity_subtype' => ELGG_ENTITIES_ANY_VALUE,
	);

	return $return;
}
*/

/*
function stripe_load_stripe_js(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	$return[] = '<script src="https://js.stripe.com/v3/"></script>';
}

// Head - Définition des link et meta
function theme_adf_head_page_hook(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	
	// Favicon
	$favicon = elgg_get_site_url() . 'mod/theme_adf/graphics/favicon.png';
	
	// Remove unused favicon definitions
	unset($return['links']['icon-16']);
	unset($return['links']['icon-32']);
	unset($return['links']['icon-64']);
	unset($return['links']['icon-128']);
	unset($return['links']['icon-vector']);
	unset($return['links']['apple-touch-icon']);
	
		// Set main favicon
	$return['links']['shortcut-icon'] = array('rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => $favicon);
	$return['links']['icon-ico'] = array('rel' => 'icon', 'href' => $favicon);
	// Set apple touch icon
	$return['links']['apple-touch-icon'] = array('rel' => 'apple-touch-icon', 'href' => $favicon);
	
	//$return['metas']['og:image'] = array('name' => 'og:image', 'content' => elgg_get_site_url() . 'mod/naturalconnect/graphics/naturalconnect-favicon.png');
	//$return['metas']['description'] = array('name' => 'description', 'content' => ""));
	
	
	// Custom fonts
	//$return['links']['google-font-open-sans'] = array(
	//		'rel' => 'stylesheet', 'type' => 'text/css',
	//		'href' => 'https://fonts.googleapis.com/css?family=Open+Sans:300,600',
	//	);
	
	return $return;
}
*/


// Set topbar elements (user menu)
function theme_adf_topbar_menu(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	
	//echo '<pre>' . print_r($return, true) . '</pre>';
	
	$user = elgg_get_logged_in_user_entity();

	// Modification des éléments existants
	foreach($return as $k => $item) {
		
		// @TODO site_notifications : remplacer lien par popup (cf. plugin notifier) 
		// avec liste des notifs + lien réglages + lien toutes les notifications
		//echo "{$item->getName()} / ";
		
		
		// No submenu
		/*
		$return[$k]->setSection('default');
		$return[$k]->setParentName('');
		*/
		// All in submenu
		//if ($item->getName() != 'account') { $return[$k]->setSection('default'); $return[$k]->setParentName('account'); }
		
		// Remove unwanted entries
		if (in_array($return[$k]->getName(), ['friends'])) { unset($return[$k]); continue; }
		
		switch($item->getName()) {
			/*
			case 'profile':
				$return[$k]->setTooltip(elgg_echo('profile'));
				$return[$k]->setLinkClass('');
				$return[$k]->setText('<span class="ni-icon-menu-title">' . $own->name . '</span>');
				$return[$k]->setPriority(0);
				break;
			*/
			case 'account':
				$return[$k]->setText($user->name);
				break;
			
			default:
				//$return[$k]->setText($item->getWeight() . ' - ' . $item->getName() . ' - ' . $item->getText());
		}
	}
	
	return $return;
}


// Site : Menu de navigation
function theme_adf_site_menu(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	//$return = []; // Start a new, clear menu
	$new_menu = [];
	$own = elgg_get_logged_in_user_entity();
	
	
	$allowed_items = ['groups', 'members'];
	// groups / members / activity
	// survey / blog / bookmarks / file / pages / thewire / newsletter / discussions / event / 
	// thinkcities / Les Petites Annonces / chat / senx_interface / senx_warp10 / 
	
	// Modification des éléments existants
	foreach($return as $k => $item) {
		//echo "{$item->getName()} $k / ";
		
		// Remove unwanted items
		if (!in_array($item->getName(), $allowed_items)) {
			continue;
		}
		
		switch($item->getName()) {
			case 'groups':
				$item->setPriority(200);
				//$item->setText($item->getText() . '&nbsp;<i class="fa fa-caret-down"></i>');
				$item->setText(elgg_echo('theme_adf:menu:groups') . '&nbsp;<i class="fa fa-caret-down"></i>');
				break;
			case 'members':
				$item->setPriority(600);
				$item->setText(elgg_echo('theme_adf:menu:members') . '&nbsp;<i class="fa fa-caret-down"></i>');
				break;
			case 'event':
				$item->setPriority(800);
				break;
		}
		
		$new_menu[$k] = $item;
	}
	
	// Annuaire - Membres du site
	/*
	$item = new ElggMenuItem('network', elgg_echo('naturalconnect:network'), '/network');
	if (elgg_in_context('members') || elgg_in_context('groups') || elgg_in_context('group_chat')) { $item->setSelected(); }
	$return[] = $item;
	*/
	
	// Accueil : page de présentation et recherche de contenus
	/*
	$item = new ElggMenuItem('home', elgg_echo('theme_adf:menu:home'), '/');
	//if (current_page_url() = elgg_get_site_url()) { $item->setSelected(); }
	$item->setPriority(0);
	$new_menu[] = $item;
	*/
	
	// Contributions : page de présentation et recherche de contenus
	//$item = new ElggMenuItem('contributions', elgg_echo('theme_adf:menu:contributions'), '/contributions');
	$item = new ElggMenuItem('search', elgg_echo('theme_adf:menu:search'), '/search');
	//if (elgg_in_context('members') || elgg_in_context('groups') || elgg_in_context('group_chat')) { $item->setSelected(); }
	$item->setPriority(500);
	$new_menu[] = $item;
	// Add submenus
	//$search_form = elgg_view_form('search', [], []);
	$q = get_input('q');
	$search_form = '<form action="' . elgg_get_site_url() . 'search" method="GET" style="display: flex; font-size: 1.4em; font-weight: 600;">
		<input type="text" name="q" value="' . $q . '" placeholder="' . elgg_echo('theme_adf:menu:search:placeholder') . '" style="flex: 1 1 auto;">
		<input type="submit" value="' . elgg_echo('theme_adf:menu:search:submit') . '" style="flex: 0 0 10rem;">
	</form>';
	$item = new ElggMenuItem('search-form', $search_form, false);
	$item->setParentName('search');
	$new_menu[] = $item;
	
	// Aide : page de présentation et recherche de contenus
	$help_url = elgg_get_plugin_setting('help_url', 'theme_adf');
	if (!empty($help_url)) {
		$item = new ElggMenuItem('help', elgg_echo('theme_adf:menu:help') . '&nbsp;<i class="fa fa-caret-down"></i>', $help_url);
		//if (elgg_in_context('members') || elgg_in_context('groups') || elgg_in_context('group_chat')) { $item->setSelected(); }
		$item->setPriority(900);
		$new_menu[] = $item;
		
		// Add submenus
		$item = new ElggMenuItem('help-home', elgg_echo('theme_adf:menu:help'), $help_url);
		$item->setParentName('help');
		$new_menu[] = $item;
		
		$help_url = elgg_get_plugin_setting('help_faq', 'theme_adf');
		if (!empty($help_url)) {
			$item = new ElggMenuItem('help', elgg_echo('theme_adf:menu:help') . '&nbsp;<i class="fa fa-caret-down"></i>', $help_url);
			$item->setParentName('help');
			$new_menu[] = $item;
		}
		
		$help_url = elgg_get_plugin_setting('help_firststeps', 'theme_adf');
		if (!empty($help_url)) {
			$item = new ElggMenuItem('help', elgg_echo('theme_adf:menu:firststeps') . '&nbsp;<i class="fa fa-caret-down"></i>', $help_url);
			$item->setParentName('help');
			$new_menu[] = $item;
		}
		
		if (elgg_is_active_plugin('feedback')) {
			// Add submenus
			$item = new ElggMenuItem('help-feedback', elgg_echo('theme_adf:menu:feedback'), '/feedback/');
			$item->setParentName('help');
			$new_menu[] = $item;
		}
	}
	
	// Evénements
	/*
	if (elgg_is_active_plugin('event_manager')) {
		$item = new ElggMenuItem('contributions', elgg_echo('theme_adf:menu:contributions'), '/contributions');
		//if (elgg_in_context('members') || elgg_in_context('groups') || elgg_in_context('group_chat')) { $item->setSelected(); }
		$item->setPriority(500);
		$new_menu[] = $item;
	}
	*/
	
	// Groups sub-menus : accès à tous les groupes => classement par type + recherche + ceux mis en avant + ceux recommandés)
	// all groups
	$item = new ElggMenuItem("groups-directory", elgg_echo('theme_adf:menu:groups:search'), "groups/all");
	$item->setParentName('groups');
	$new_menu[] = $item;
	// Global view
	$item = new ElggMenuItem("home-dashboard", elgg_echo('theme_adf:menu:dashboard'), "/");
	$item->setParentName('groups');
	$new_menu[] = $item;
	// my groups
	$mygroups_ents = elgg_get_entities([
		'type' => 'group', 
		'relationship' => 'member',
		'relationship_guid' => $own->guid,
		'limit' => false,
		]);
	foreach($mygroups_ents as $group) {
		$item = new ElggMenuItem("group-{$group->guid}", $group->name, $group->getURL());
		$item->setParentName('groups');
		$new_menu[] = $item;
	}
	
	// Members sub-menu :
	// members directory
	$item = new ElggMenuItem("members-directory", elgg_echo('theme_adf:menu:members_adf'), "members");
	$item->setParentName('members');
	$new_menu[] = $item;
	// contacts
	$item = new ElggMenuItem("friends", elgg_echo('theme_adf:menu:friends'), "friends/{$own->username}");
	$item->setParentName('members');
	$new_menu[] = $item;
	// invitation
	$item = new ElggMenuItem("invitation", elgg_echo('theme_adf:menu:friends:invite'), "friends/{$own->username}/invite");
	$item->setParentName('members');
	$new_menu[] = $item;
	
	
	// Note submenu : setParentName('MenuItemName')
	
	
	
	return $new_menu;
}


// Footer menu - unused (static view)
/*
function theme_adf_footer_menu(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	$return = []; // Clear menu
	// Crédits
	$return[] = new ElggMenuItem('credits', elgg_echo('naturalconnect:credits'), '/p/credits');
	
	// Mentions légales
	$return[] = new ElggMenuItem('terms', elgg_echo('naturalconnect:terms'), '/p/terms');
	
	// Lien naturalidees.com
	$return[] = new ElggMenuItem('naturalidees', 'natural idées,', '//naturalidees.com/');
	
	// Lien Facebook
	$return[] = new ElggMenuItem('facebook', '<i class="fa fa-fw fa-facebook"></i>', '//www.facebook.com/naturalidees');
	// Lien Twitter
	$return[] = new ElggMenuItem('twitter', '<i class="fa fa-fw fa-twitter"></i>', '//twitter.com/naturalidees');
	// Lien Linkedin
	$return[] = new ElggMenuItem('linkedin', '<i class="fa fa-fw fa-linkedin"></i>', '//www.linkedin.com/company/natural-id%C3%A9es');
	// Lien Pinterest
	$return[] = new ElggMenuItem('pinterest', '<i class="fa fa-fw fa-pinterest"></i>', '//www.pinterest.fr/naturalidees/');
	// Lien Youtube
	$return[] = new ElggMenuItem('youtube', '<i class="fa fa-fw fa-youtube"></i>', '//www.youtube.com/channel/UCrdYA4twMOPbHUUMJboSKoA');
	
	// Open external links in new tab/window
	foreach($return as $k => $item) {
		if (substr($item->getHref(), 0, 2) == '//') {
			$return[$k]->setData('target', '_blank');
		}
	}
	//echo '<pre>'.print_r($return, true).'</pre>'; exit; // dev/debug
	return $return;
}
*/


// Head - Définition des link et meta
function theme_adf_head_page_hook(\Elgg\Hook $hook) {
	$return = $hook->getValue();
	
	// Favicon
	$favicon_base = elgg_get_site_url() . 'mod/theme_adf/graphics/';
	$favicon = $favicon_base . 'favicon-128.png';
	
	// Remove unused favicon definitions
	unset($return['links']['icon-16']);
	unset($return['links']['icon-32']);
	unset($return['links']['icon-64']);
	unset($return['links']['icon-128']);
	unset($return['links']['icon-vector']);
	unset($return['links']['apple-touch-icon']);
	
	// Set main favicon
	$return['links']['shortcut-icon'] = array('rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => $favicon_base . 'favicon-64.ico');
	$return['links']['icon-ico'] = array('rel' => 'icon', 'href' => $favicon_base . 'favicon.ico');
	// Set apple touch icon
	$return['links']['apple-touch-icon'] = array('rel' => 'apple-touch-icon', 'href' => $favicon);
	// Set alternate sizes
	$return['links']['icon-16'] = array('rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => $favicon_base . 'favicon-16.png');
	$return['links']['icon-32'] = array('rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => $favicon_base . 'favicon-32.png');
	$return['links']['icon-64'] = array('rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => $favicon_base . 'favicon-64.png');
	$return['links']['icon-128'] = array('rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => $favicon_base . 'favicon-128.png');
	
	//$return['metas']['og:image'] = array('name' => 'og:image', 'content' => elgg_get_site_url() . 'mod/naturalconnect/graphics/naturalconnect-favicon.png');
	//$return['metas']['description'] = array('name' => 'description', 'content' => ""));
	
	/*
	// Custom fonts
	$return['links']['google-font-open-sans'] = array(
			'rel' => 'stylesheet', 'type' => 'text/css',
			'href' => 'https://fonts.googleapis.com/css?family=Open+Sans:300,600',
		);
	*/
	
	return $return;
}

// Ajout d'un onglet avec l'activité dans mes groupes
function theme_adf_activity_groups_tab(\Elgg\Hook $hook) {
	$user = $hook->getUserParam();
	if (!$user instanceof ElggUser) { return; }
	$vars = $hook->getParam('vars');
	$selected = $hook->getParam('selected');
	$type = $hook->getType();

	$items = $hook->getValue();
	$items[] = ElggMenuItem::factory([
		'name' => 'groups',
		'text' => elgg_echo('theme_adf:activity:groups:tab'),
		'href' => (isset($vars['groups_link'])) ? $vars['groups_link'] : "$type/groups",
		'selected' => ($selected == 'groups'),
		'priority' => 200,
	]);
	return $items;
}


