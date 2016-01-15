<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne
 * @copyright slyhne 2010-2015
 * @link http://tiger-inc.eu
 * @version 1.10
 */

elgg_register_event_handler('init','system','market_init');

function market_init() {

	elgg_register_library('market', elgg_get_plugins_path() . 'market/lib/market.php');

	// Add a site navigation item
	$item = new ElggMenuItem('market', elgg_echo('market:title'), 'market/category');
	elgg_register_menu_item('site', $item);

	// Extend owner block menu
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'market_owner_block_menu');
	elgg_register_plugin_hook_handler('register', 'menu:page', 'market_page_menu');

	// Extend system CSS with our own styles
	elgg_extend_view('css/elgg','market/css');
	elgg_extend_view('css/admin','market/admincss');

	// register the market's JavaScript
	$market_js = elgg_get_simplecache_url('js', 'market');
	elgg_register_simplecache_view('js/market');
	elgg_register_js('market', $market_js, 'footer');

	// Add a new widget
	elgg_register_widget_type(
			'market',
			elgg_echo('market:widget'),
			elgg_echo('market:widget:description')
			);

	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('market','market_page_handler');

	// override the default url to view a market object
	elgg_register_plugin_hook_handler('entity:url', 'object', 'market_set_url');

	// Register entity type
	elgg_register_entity_type('object', 'market');

	// Register granular notification for this type
	elgg_register_notification_event('object', 'market', array('create'));

	// Listen to notification events and supply a more useful message
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'market_notify_message');

	// Setup cron job to delete old market posts
	elgg_register_plugin_hook_handler('cron', 'daily', 'market_expire_cron_hook');

	// Register actions
	$action_url = elgg_get_plugins_path() . "market/actions/";
	elgg_register_action("market/save", "{$action_url}save.php");
	elgg_register_action("market/delete", "{$action_url}delete.php");
	elgg_register_action("market/delete_img", "{$action_url}delete_img.php");

}

// market page handler; allows the use of fancy URLs
function market_page_handler($page) {

	$pages = dirname(__FILE__) . '/pages/market';

	if (!isset($page[1])) {
		$page[1] = 'all';
	}
	if (!isset($page[2])) {
		$page[2] = 'all';
	}
	
	// Show market sidebar at top of sidebar
	elgg_extend_view("page/elements/sidebar", "market/sidebar", 100);

	$page_type = $page[0];
	switch ($page_type) {
		case 'owned':
			set_input('username', $page[1]);
			include "$pages/owned.php";
			break;
		/*
		case 'friends':
			set_input('username' , $page[1]);
			include "$pages/friends.php";
			break;
		*/
		case 'view':
			set_input('marketpost', $page[1]);
			include "$pages/view.php";
			break;
		case 'image':
			set_input('guid', $page[1]);
			set_input('imagenum', $page[2]);
			set_input('size', $page[3]);
			set_input('tu', $page[4]);
			include "$pages/image.php";
			break;
		case 'imagepopup':
			set_input('guid', $page[1]);
			set_input('imagenum', $page[2]);
			include "$pages/imagepopup.php";
			break;
		case 'add':
			elgg_load_library('market');
			include "$pages/add.php";
			break;
		case 'edit':
			elgg_load_library('market');
			set_input('guid', $page[1]);
			include "$pages/edit.php";
			break;
		case 'category':
			set_input('cat', $page[1]);
			set_input('type', $page[2]);
			include "$pages/category.php";
			break;
		case 'terms':
			include "$pages/terms.php";
			break;
		default:
			set_input('cat', $page[1]);
			set_input('type', $page[2]);
			include "$pages/category.php";
			break;
	}
	return true;
}

// Populates the ->getURL() method for market objects
function market_set_url($hook, $type, $url, $params) {
	$entity = $params['entity'];
	if (elgg_instanceof($entity, 'object', 'market')) {
		$friendly_title = elgg_get_friendly_title($entity->title);
		return "market/view/{$entity->guid}/{$friendly_title}";
	}
}

// Add to the user block menu
function market_owner_block_menu($hook, $type, $return, $params) {

	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "market/owned/{$params['entity']->username}";
		$item = new ElggMenuItem('market', elgg_echo('market'), $url);
		$return[] = $item;
	}

	return $return;

}
/**
 * Add a page menu menu.
 *
 * @param string $hook
 * @param string $type
 * @param array  $return
 * @param array  $params
 */
function market_page_menu($hook, $type, $return, $params) {
	if (elgg_is_logged_in()) {
		// only show buttons in market pages
		if (elgg_in_context('market')) {
			$user = elgg_get_logged_in_user_entity();
			$page_owner = elgg_get_page_owner_entity();
			if (!$page_owner) {
				$page_owner = elgg_get_logged_in_user_entity();
			}
			
			if ($page_owner != $user) {
				$usertitle = elgg_echo('market:user', array($page_owner->name));
				$return[] = new ElggMenuItem('market_owner', $usertitle, 'market/owned/' . $page_owner->username);
				//$friendstitle = elgg_echo('market:user:friends', array($page_owner->name));
				//$return[] = new ElggMenuItem('2userfriends', $friendstitle, 'market/friends/' . $page_owner->username);
			} else {
				$return[] = new ElggMenuItem('market_owner', elgg_echo('market:mine'), 'market/owned/' . $user->username);
			}
		}
	}

	return $return;
}

// Cron function to delete old market posts
function market_expire_cron_hook($hook, $entity_type, $returnvalue, $params) {

	elgg_load_library('market');

	$market_ttl = elgg_get_plugin_setting('market_expire','market');
	if ($market_ttl == 0) {
		return true;
	}
	$time_limit = strtotime("-$market_ttl months");

	$ret = elgg_set_ignore_access(TRUE);
	
	$entities = elgg_get_entities(array(
					'type' => 'object',
					'subtype' => 'market',
					'created_time_upper' => $time_limit,
					));

	foreach ($entities as $entity) {
		$date = date('j/n-Y', $entity->time_created);
		$title = $entity->title;
		$owner = $entity->getOwnerEntity();
		notify_user($owner->guid,
				elgg_get_site_entity()->guid,
				elgg_echo('market:expire:subject'),
				elgg_echo('market:expire:body', array($owner->name, $title, $date, $market_ttl)),
				NULL,
				'site');
		// Delete market post incl. pictures
		market_delete_post($entity);
	}
	
	$ret = elgg_set_ignore_access(FALSE);
	
}

/**
 * Returns the body of a notification message
 *
 * @param string $hook
 * @param string $entity_type
 * @param string $returnvalue
 * @param array  $params
 */
function market_notify_message($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	$to_entity = $params['to_entity'];
	$method = $params['method'];
	if (($entity instanceof ElggEntity) && ($entity->getSubtype() == 'market')) {
		$descr = elgg_get_excerpt($entity->description);
		$title = $entity->title;
		$owner = $entity->getOwnerEntity();
		$market_type = elgg_echo("market:type:{$entity->market_type}");

		return elgg_echo('market:notification', array(
			$owner->name,
			$market_type,
			$title,
			$descr,
			$entity->getURL()
		));
	}
	return null;
}
