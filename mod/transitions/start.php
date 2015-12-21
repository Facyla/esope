<?php
/**
 * Transitions
 *
 * @package Transitions
 *
 * @todo
 * - Either drop support for "publish date" or duplicate more entity getter
 * functions to work with a non-standard time_created.
 * - Pingbacks
 * - Notifications
 * - River entry for posts saved as drafts and later published
 */

elgg_register_event_handler('init', 'system', 'transitions_init');

/**
 * Init transitions plugin.
 */
function transitions_init() {

	elgg_register_library('elgg:transitions', elgg_get_plugins_path() . 'transitions/lib/transitions.php');
	
	$js = elgg_get_simplecache_url('js', 'transitions/transitions');
	elgg_register_js('elgg.transitions', $js, 'head');
	
	// add a site navigation item
	$item = new ElggMenuItem('transitions', elgg_echo('transitions:transitions'), 'catalogue/all');
	elgg_register_menu_item('site', $item);

	elgg_register_event_handler('upgrade', 'upgrade', 'transitions_run_upgrades');

	// add to the main css
	elgg_extend_view('css/elgg', 'transitions/css');
	
	// routing of urls
	elgg_register_page_handler('catalogue', 'catalogue_page_handler');
	// Required for retro-compatibility with plugin name
	// (and automatic links, eg. edit and delete)
	elgg_register_page_handler('transitions', 'transitions_page_handler');
	
	// Adds menu to page owner block
	elgg_register_plugin_hook_handler('output:before', 'layout', 'transitions_add_ical_link');
	
	// Override icons
	elgg_register_plugin_hook_handler("entity:icon:url", "object", "transitions_icon_hook");

	// override the default url to view a transitions object
	elgg_register_plugin_hook_handler('entity:url', 'object', 'transitions_set_url');

	// notifications
	elgg_register_notification_event('object', 'transitions', array('publish'));
	elgg_register_plugin_hook_handler('prepare', 'notification:publish:object:transitions', 'transitions_prepare_notification');

	// add transitions link to
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'transitions_owner_block_menu');

	// pingbacks
	//elgg_register_event_handler('create', 'object', 'transitions_incoming_ping');
	//elgg_register_plugin_hook_handler('pingback:object:subtypes', 'object', 'transitions_pingback_subtypes');

	// Register for search.
	elgg_register_entity_type('object', 'transitions');

	// Add group option
	add_group_tool_option('transitions', elgg_echo('transitions:enabletransitions'), true);
	elgg_extend_view('groups/tool_latest', 'transitions/group_module');

	// add a transitions widget
	elgg_register_widget_type('transitions', elgg_echo('transitions'), elgg_echo('transitions:widget:description'));

	// register actions
	$action_path = elgg_get_plugins_path() . 'transitions/actions/transitions';
	// Quickform is a light contribution form that quickly creates a draft
	elgg_register_action('transitions/save', "$action_path/save.php");
	elgg_register_action('transitions/auto_save_revision', "$action_path/auto_save_revision.php");
	elgg_register_action('transitions/delete', "$action_path/delete.php");
	
	// Note : add , 'public' to allow onyone to use action
	elgg_register_action('transitions/quickform', "$action_path/save.php");
	elgg_register_action('transitions/addtag', "$action_path/addtag.php");
	elgg_register_action('transitions/addlink', "$action_path/addlink.php");
	elgg_register_action('transitions/addactor', "$action_path/addactor.php");
	elgg_register_action('transitions/addrelation', "$action_path/addrelation.php");
	
	// TEMPORARY HACK TO ALLOW USING BOTH URL
	// Quickform is a light contribution form that quickly creates a draft
	elgg_register_action('catalogue/save', "$action_path/save.php");
	elgg_register_action('catalogue/auto_save_revision', "$action_path/auto_save_revision.php");
	elgg_register_action('catalogue/delete', "$action_path/delete.php");
	elgg_register_action('catalogue/quickform', "$action_path/save.php");
	elgg_register_action('catalogue/addtag', "$action_path/addtag.php");
	elgg_register_action('catalogue/addlink', "$action_path/addlink.php");
	elgg_register_action('catalogue/addactor', "$action_path/addactor.php");
	elgg_register_action('catalogue/addrelation', "$action_path/addrelation.php");


	// entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'transitions_entity_menu_setup');

	// ecml
	elgg_register_plugin_hook_handler('get_views', 'ecml', 'transitions_ecml_views_hook');
}


// Temporary redirect after page handler string change
function transitions_page_handler($page) {
	forward("catalogue/" . implode('/', $page));
}

/**
 * Dispatches transitions pages.
 * URLs take the form of
 *  All transitions:       catalogue/all
 *  User's transitions:    catalogue/owner/<username>
 *  Friends' transitions:   catalogue/friends/<username>
 *  User's archives: catalogue/archives/<username>/<time_start>/<time_stop>
 *  Transitions post:       catalogue/view/<guid>/<title>
 *  New post:        catalogue/add/<guid>
 *  Edit post:       catalogue/edit/<guid>/<revision>
 *  Preview post:    catalogue/preview/<guid>
 *  Group transitions:      catalogue/group/<guid>/all
 *
 * Title is ignored
 *
 * @todo no archives for all transitions or friends
 *
 * @param array $page
 * @return bool
 */
function catalogue_page_handler($page) {

	elgg_load_library('elgg:transitions');

	// push all transitions breadcrumb
	elgg_push_breadcrumb(elgg_echo('transitions:transitions'), "catalogue/all");

	if (!isset($page[0])) {
		$page[0] = 'all';
	}

	$page_type = $page[0];
	switch ($page_type) {
		case 'owner':
			$user = get_user_by_username($page[1]);
			if (!$user) {
				forward('', '404');
			}
			$params = transitions_get_page_content_list($user->guid);
			break;
		case 'friends':
			$user = get_user_by_username($page[1]);
			if (!$user) {
				forward('', '404');
			}
			$params = transitions_get_page_content_friends($user->guid);
			break;
		case 'archive':
			$user = get_user_by_username($page[1]);
			if (!$user) {
				forward('', '404');
			}
			$params = transitions_get_page_content_archive($user->guid, $page[2], $page[3]);
			break;
		case 'view':
			$params = transitions_get_page_content_read($page[1]);
			break;
		case 'add':
			elgg_gatekeeper();
			if (empty($page[1])) $page[1] = elgg_get_logged_in_user_guid();
			$params = transitions_get_page_content_edit($page_type, $page[1]);
			break;
		case 'edit':
			elgg_gatekeeper();
			$params = transitions_get_page_content_edit($page_type, $page[1], $page[2]);
			break;
		case 'group':
			$group = get_entity($page[1]);
			if (!elgg_instanceof($group, 'group')) {
				forward('', '404');
			}
			if (!isset($page[2]) || $page[2] == 'all') {
				$params = transitions_get_page_content_list($page[1]);
			} else {
				$params = transitions_get_page_content_archive($page[1], $page[3], $page[4]);
			}
			break;
		case 'icon':
			if (isset($page[1])) { set_input("guid",$page[1]); }
			if (isset($page[2])) { set_input("size",$page[2]); }
			include(elgg_get_plugins_path() . "transitions/pages/transitions/icon.php");
			return true;
			break;
		case 'download':
			// The username should be the file we're getting
			if (isset($page[1])) { set_input("guid",$page[1]); }
			if (isset($page[2])) { set_input("name",$page[2]); }
			include(elgg_get_plugins_path() . "transitions/pages/transitions/attachment.php");
			return true;
			break;
		case 'embed':
			if (isset($page[1])) { set_input("embed_type",$page[1]); }
			if (isset($page[2])) { set_input("id",$page[2]); }
			include(elgg_get_plugins_path() . "transitions/pages/transitions/embed.php");
			return true;
			break;
		case 'all':
			//$params = transitions_get_page_content_list();
		default:
			if ($page[0] != 'all') { set_input("category",$page[0]); }
			if (isset($page[1])) { set_input("q",$page[1]); }
			include(elgg_get_plugins_path() . "transitions/pages/transitions/index.php");
			return true;
	}

	if (isset($params['sidebar'])) {
		$params['sidebar'] .= elgg_view('transitions/sidebar', array('page' => $page_type));
	} else {
		$params['sidebar'] = elgg_view('transitions/sidebar', array('page' => $page_type));
	}

	$params['class'] = "transitions-$page_type";
	if (in_array($page_type, array('add', 'edit', 'view'))) {
		$body = elgg_view_layout('one_column', $params);
	} else {
		$body = elgg_view_layout('content', $params);
	}

	echo elgg_view_page($params['title'], $body);
	return true;
}


// Adds ICAL link to current page
function transitions_add_ical_link() {
	$context = elgg_get_context();
	//echo $context; // debug : check eligible context
	if (in_array($context, array('transitions', 'main', 'collections', 'search'))) {
		$url = current_page_url();
		if (substr_count($url, '?')) { $url .= "&view=ical"; } else { $url .= "?view=ical"; }
		$url = elgg_format_url($url);
		elgg_register_menu_item("extras", array(
			"name" => "ical",
			"href" => $url,
			"text" => '<i class="fa fa-calendar-o"></i>',
			'title' => elgg_echo('transitions:ical'),
			"priority" => 500,
		));
	}
}

/**
 * Format and return the URL for transitions.
 *
 * @param string $hook
 * @param string $type
 * @param string $url
 * @param array  $params
 * @return string URL of transitions.
 */
function transitions_set_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'transitions')) {
		$friendly_title = elgg_get_friendly_title($entity->title);
		return "catalogue/view/{$entity->guid}/$friendly_title";
	}
}

/**
 * Add a menu item to an ownerblock
 */
function transitions_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "catalogue/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('transitions', elgg_echo('transitions'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->transitions_enable != "no") {
			$url = "catalogue/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('transitions', elgg_echo('transitions:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}

/**
 * Add particular transitions links/info to entity menu
 */
function transitions_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'catalogue') {
		return $return;
	}

	if ($entity->status != 'published') {
		// draft status replaces access
		foreach ($return as $index => $item) {
			if ($item->getName() == 'access') {
				unset($return[$index]);
			}
		}

		$status_text = elgg_echo("status:{$entity->status}");
		$options = array(
			'name' => 'published_status',
			'text' => "<span>$status_text</span>",
			'href' => false,
			'priority' => 150,
		);
		$return[] = ElggMenuItem::factory($options);
	}

	return $return;
}

/**
 * Prepare a notification message about a published transitions
 *
 * @param string                          $hook         Hook name
 * @param string                          $type         Hook type
 * @param Elgg\Notifications\Notification $notification The notification to prepare
 * @param array                           $params       Hook parameters
 * @return Elgg\Notifications\Notification
 */
function transitions_prepare_notification($hook, $type, $notification, $params) {
	$entity = $params['event']->getObject();
	$owner = $params['event']->getActor();
	$recipient = $params['recipient'];
	$language = $params['language'];
	$method = $params['method'];

	$notification->subject = elgg_echo('transitions:notify:subject', array($entity->title), $language);
	$notification->body = elgg_echo('transitions:notify:body', array(
		$owner->name,
		$entity->title,
		$entity->getExcerpt(),
		$entity->getURL()
	), $language);
	$notification->summary = elgg_echo('transitions:notify:summary', array($entity->title), $language);

	return $notification;
}

/**
 * Register transitions with ECML.
 */
function transitions_ecml_views_hook($hook, $entity_type, $return_value, $params) {
	$return_value['object/transitions'] = elgg_echo('transitions:transitions');

	return $return_value;
}

/**
 * Upgrade from 1.7 to 1.8.
 */
function transitions_run_upgrades($event, $type, $details) {
	$transitions_upgrade_version = elgg_get_plugin_setting('upgrade_version', 'transitions');

	if (!$transitions_upgrade_version) {
		 // When upgrading, check if the ElggTransitions class has been registered as this
		 // was added in Elgg 1.8
		if (!update_subtype('object', 'transitions', 'ElggTransitions')) {
			add_subtype('object', 'transitions', 'ElggTransitions');
		}

		elgg_set_plugin_setting('upgrade_version', 1, 'transitions');
	}
}

// Define object icon : custom or default
function transitions_icon_hook($hook, $entity_type, $returnvalue, $params) {
	if (!empty($params) && is_array($params)) {
		$entity = $params["entity"];
		if (elgg_instanceof($entity, "object", "transitions")) {
			$size = $params["size"];
			if (!empty($entity->icontime)) {
				$icontime = "{$entity->icontime}";
				$filehandler = new ElggFile();
				$filehandler->owner_guid = $entity->getOwnerGUID();
				$filehandler->setFilename("transitions/" . $entity->getGUID() . $size . ".jpg");
				if ($filehandler->exists()) {
					return elgg_get_site_url() . "catalogue/icon/{$entity->getGUID()}/$size/$icontime.jpg";
				}
			}
			// Use default image instead
			if (!empty($entity->category)) {
				$file_name = $entity->category . '.jpg';
			} else {
				$file_name = 'default.jpg';
			}
			return elgg_get_site_url() . "mod/transitions/graphics/icons/$size/$file_name";
		}
	}
}


/* Renvoie la liste des catégories
 * $addempty : for select dropdowns
 * $full : get all values (useful when not editing)
*/
function transitions_get_category_opt($value = '', $addempty = false, $full = false) {
	$list = array();
	if ($addempty) { $list[''] = elgg_echo('transitions:category:choose'); }
	$values = array('actor', 'project', 'experience', 'imaginary', 'tools', 'event', 'knowledge', 'challenge');
	foreach($values as $val) { $list[$val] = elgg_echo('transitions:category:' . $val); }
	if (elgg_is_admin_logged_in() || $full) {
		$list['editorial'] = elgg_echo('transitions:category:editorial');
		//$list['challenge'] = elgg_echo('transitions:category:challenge');
	}
	// Add current value
	if (!empty($value) && !isset($list[$value])) { $list[$value] = elgg_echo('transitions:category:' . $value); }
	return $list;
}

function transitions_get_actortype_opt($value = '', $addempty = false) {
	$list = array();
	if ($addempty) { $list[''] = elgg_echo('transitions:actortype:choose'); }
	$values = array('individual', 'collective', 'association', 'enterprise', 'education', 'collectivity', 'administration', 'plurinational');
	foreach($values as $val) { $list[$val] = elgg_echo('transitions:actortype:' . $val); }
	// Add current value
	if (!empty($value) && !isset($list[$value])) { $list[$value] = elgg_echo('transitions:actortype:' . $value); }
	return $list;
}

function transitions_get_lang_opt($value = '', $addempty = false, $full = false) {
	$list = array();
	if ($addempty) { $list[''] = ''; }
	
	// Use multilingual available translation codes if set
	if (elgg_is_active_plugin('multilingual')) { $values = multilingual_available_languages(); }
	if (empty($languages)) { $values = array('fr', 'en'); }
	
	if ($full) {
		$user_lang = get_language();
		// Language codes : sort by alphabetic order of chosen language + FR and EN featured on top of the list
		switch($user_lang) {
			case 'fr':
				$values = array('fr', 'en', 'ab', 'aa', 'af', 'sq', 'de', 'am', 'ar', 'hy', 'as', 'ay', 'az', 'ba', 'eu', 'bn', 'bi', 'be', 'bh', 'my', 'br', 'bg', 'ca', 'zh', 'si', 'ko', 'co', 'hr', 'da', 'dz', 'gd', 'es', 'eo', 'et', 'fo', 'fj', 'fi', 'fy', 'gl', 'cy', 'ka', 'el', 'gn', 'gu', 'ha', 'he', 'hi', 'hu', 'id', 'ia', 'iu', 'ik', 'ga', 'is', 'it', 'ja', 'jw', 'kl', 'kn', 'ks', 'kk', 'km', 'rw', 'ky', 'rn', 'ku', 'lo', 'la', 'lv', 'ln', 'lt', 'mk', 'ms', 'ml', 'mg', 'mt', 'mi', 'mr', 'mo', 'mn', 'na', 'nl', 'ne', 'no', 'ie', 'oc', 'or', 'om', 'ug', 'ur', 'uz', 'ps', 'pa', 'fa', 'pl', 'pt', 'qu', 'rm', 'ro', 'ru', 'sm', 'sg', 'sa', 'sr', 'sh', 'sn', 'sd', 'ss', 'sk', 'sl', 'so', 'st', 'su', 'sv', 'sw', 'tg', 'tl', 'ta', 'tt', 'cs', 'te', 'th', 'bo', 'ti', 'to', 'ts', 'tn', 'tr', 'tk', 'tw', 'uk', 'vi', 'vo', 'wo', 'xh', 'yi', 'yo', 'za', 'zu');
				break;
			case 'en':
				$values = array('en', 'fr', 'ab', 'om', 'aa', 'af', 'sq', 'am', 'ar', 'hy', 'as', 'ay', 'az', 'ba', 'eu', 'bn', 'dz', 'bh', 'bi', 'br', 'bg', 'my', 'be', 'km', 'ca', 'zh', 'co', 'hr', 'cs', 'da', 'nl', 'eo', 'et', 'fo', 'fj', 'fi', 'fy', 'gl', 'ka', 'de', 'el', 'kl', 'gn', 'gu', 'ha', 'he', 'hi', 'hu', 'is', 'id', 'ia', 'ie', 'iu', 'ik', 'ga', 'it', 'ja', 'jw', 'kn', 'ks', 'kk', 'rw', 'ky', 'rn', 'ko', 'ku', 'lo', 'la', 'lv', 'ln', 'lt', 'mk', 'mg', 'ml', 'ms', 'mt', 'mi', 'mr', 'mo', 'mn', 'na', 'ne', 'no', 'oc', 'or', 'ps', 'fa', 'pl', 'pt', 'pa', 'qu', 'rm', 'ro', 'ru', 'sm', 'sg', 'sa', 'gd', 'sr', 'sh', 'st', 'tn', 'sn', 'sd', 'si', 'ss', 'sk', 'sl', 'so', 'es', 'su', 'sw', 'sv', 'tl', 'tg', 'ta', 'tt', 'te', 'th', 'bo', 'ti', 'to', 'ts', 'tr', 'tk', 'tw', 'ug', 'uk', 'ur', 'uz', 'vi', 'vo', 'cy', 'wo', 'xh', 'yi', 'yo', 'za', 'zu');
				break;
			default:
				$values = array('fr', 'en', 'aa', 'ab', 'af', 'am', 'ar', 'as', 'ay', 'az', 'ba', 'be', 'bg', 'bh', 'bi', 'bn', 'bo', 'br', 'ca', 'co', 'cs', 'cy', 'da', 'de', 'dz', 'el', 'eo', 'es', 'et', 'eu', 'fa', 'fi', 'fj', 'fo', 'fy', 'ga', 'gd', 'gl', 'gn', 'gu', 'he', 'ha', 'hi', 'hr', 'hu', 'hy', 'ia', 'id', 'ie', 'ik', 'is', 'it', 'iu', 'ja', 'jw', 'ka', 'kk', 'kl', 'km', 'kn', 'ko', 'ks', 'ku', 'ky', 'la', 'ln', 'lo', 'lt', 'lv', 'mg', 'mi', 'mk', 'ml', 'mn', 'mo', 'mr', 'ms', 'mt', 'my', 'na', 'ne', 'nl', 'no', 'oc', 'om', 'or', 'pa', 'pl', 'ps', 'pt', 'qu', 'rm', 'rn', 'ro', 'ru', 'rw', 'sa', 'sd', 'sg', 'sh', 'si', 'sk', 'sl', 'sm', 'sn', 'so', 'sq', 'sr', 'ss', 'st', 'su', 'sv', 'sw', 'ta', 'te', 'tg', 'th', 'ti', 'tk', 'tl', 'tn', 'to', 'tr', 'ts', 'tt', 'tw', 'ug', 'uk', 'ur', 'uz', 'vi', 'vo', 'wo', 'xh', 'yi', 'yo', 'za', 'zh', 'zu');
		}
	}
	foreach($values as $val) { $list[$val] = elgg_echo($val); }
	// Add current value
	if (!empty($value) && !isset($list[$value])) { $list[$value] = elgg_echo($value); }
	return $list;
}


function transitions_get_country_opt($value = '', $addempty = false) {
	$list = array();
	if ($addempty) { $list[''] = ''; }
	// Country codes from http://www.textfixer.com/resources/country-dropdowns.php
	$values = array('ad', 'ae', 'af', 'ag', 'ai', 'al', 'am', 'an', 'ao', 'aq', 'ar', 'as', 'at', 'au', 'aw', 'ax', 'az', 'ba', 'bb', 'bd', 'be', 'bf', 'bg', 'bh', 'bi', 'bj', 'bm', 'bn', 'bo', 'br', 'bs', 'bt', 'bv', 'bw', 'by', 'bz', 'ca', 'cc', 'cd', 'cf', 'cg', 'ch', 'ci', 'ck', 'cl', 'cm', 'cn', 'co', 'cr', 'cu', 'cv', 'cx', 'cy', 'cz', 'de', 'dj', 'dk', 'dm', 'do', 'dz', 'ec', 'ee', 'eg', 'eh', 'er', 'es', 'et', 'fi', 'fj', 'fk', 'fm', 'fo', 'fr', 'ga', 'gb', 'gd', 'ge', 'gf', 'gg', 'gh', 'gi', 'gl', 'gm', 'gn', 'gp', 'gq', 'gr', 'gs', 'gt', 'gu', 'gw', 'gy', 'hk', 'hm', 'hn', 'hr', 'ht', 'hu', 'id', 'ie', 'il', 'im', 'in', 'io', 'iq', 'ir', 'is', 'it', 'je', 'jm', 'jo', 'jp', 'ke', 'kg', 'kh', 'ki', 'km', 'kn', 'kp', 'kr', 'kw', 'ky', 'kz', 'la', 'lb', 'lc', 'li', 'lk', 'lr', 'ls', 'lt', 'lu', 'lv', 'ly', 'ma', 'mc', 'md', 'me', 'mg', 'mh', 'mk', 'ml', 'mm', 'mn', 'mo', 'mp', 'mq', 'mr', 'ms', 'mt', 'mu', 'mv', 'mw', 'mx', 'my', 'mz', 'na', 'nc', 'ne', 'nf', 'ng', 'ni', 'nl', 'no', 'np', 'nr', 'nu', 'nz', 'om', 'pa', 'pe', 'pf', 'pg', 'ph', 'pk', 'pl', 'pm', 'pn', 'pr', 'ps', 'pt', 'pw', 'py', 'qa', 're', 'ro', 'rs', 'ru', 'rw', 'sa', 'sb', 'sc', 'sd', 'se', 'sg', 'sh', 'si', 'sj', 'sk', 'sl', 'sm', 'sn', 'so', 'sr', 'st', 'sv', 'sy', 'sz', 'tc', 'td', 'tf', 'tg', 'th', 'tj', 'tk', 'tl', 'tm', 'tn', 'to', 'tr', 'tt', 'tv', 'tw', 'tz', 'ua', 'ug', 'um', 'us', 'uy', 'uz', 'va', 'vc', 've', 'vg', 'vi', 'vn', 'vu', 'wf', 'ws', 'ye', 'yt', 'za', 'zm', 'zw');
	foreach($values as $val) { $list[$val] = elgg_echo($val); }
	// Add current value
	if (!empty($value) && !isset($list[$value])) { $list[$value] = elgg_echo($value); }
	return $list;
}


