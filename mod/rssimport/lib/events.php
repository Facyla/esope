<?php

namespace AU\RSSImport;

function pagesetup() {
	// Get the page owner entity
	$createlink = false;
	$page_owner = elgg_get_page_owner_entity();

	$context = elgg_get_context();
	$rssimport_guid = get_input('rssimport_guid');
	$rssimport = get_entity($rssimport_guid);

	// Submenu items for group pages, if logged in and context is one of our imports
	if (elgg_is_logged_in()) {
		if (!$page_owner) {
			$page_owner = elgg_get_logged_in_user_entity();
			$createlink = true;
		}

		// if we're on a group page, check that the user is a member of the group
		if ($page_owner instanceof \ElggGroup) {
			if ($page_owner->isMember() && RSSImport::groupGatekeeper($page_owner, $context, FALSE)) {
				$createlink = true;
			}
		} else {
			// if we are the owner
			if ($page_owner->guid == elgg_get_logged_in_user_guid()) {
				$createlink = true;
			}
		}
	}

	if ($createlink) {
		$contexts = array('blog', 'pages', 'bookmarks');
		foreach ($contexts as $key => $c) {
			if (!RSSImport::isContentImportable($c)) {
				unset($contexts[$key]);
			}
		}
		elgg_register_menu_item('title', array(
			'name' => 'rssimport',
			'href' => 'rssimport/' . $page_owner->guid . '/' . $context,
			'text' => elgg_echo('rssimport:import:rss'),
			'link_class' => 'elgg-button elgg-button-action',
			'contexts' => $contexts
		));
	}

	// create "back" link on import page - go back to blogs/pages/etc.
	if (elgg_is_logged_in() && $context == "rssimport") {
		//have to parse URL to figure out what page type and owner to send them back to
		//this function does it, and returns an array('link_text','url')
		$linkparts = rssimport_get_return_url();

		$item = new \ElggMenuItem('rssimport_back', $linkparts[0], $linkparts[1]);
		elgg_register_menu_item('page', $item);
	}

	// create link to "View History" on import page
	if (elgg_is_logged_in() && $context == "rssimport" && $rssimport && $rssimport->canEdit()) {
		$item = new \ElggMenuItem('rssimport_history', elgg_echo('rssimport:view:history'), $rssimport->getURL() . "/history");
		elgg_register_menu_item('page', $item);
	}


	// create link to "View Import" on history page
	if (elgg_is_logged_in() && $context == "rssimport_history" && $rssimport) {
		$item = new \ElggMenuItem('rssimport_view', elgg_echo('rssimport:view:import'), $rssimport->getURL());
		elgg_register_menu_item('page', $item);
	}
}

/**
 * run our upgrades in order
 * 
 * @return boolean
 */
function upgrades() {
	if (!elgg_is_admin_logged_in()) {
		return true;
	}

	require_once __DIR__ . '/upgrades.php';
	run_function_once(__NAMESPACE__ . '\\upgrade20151008');
}
