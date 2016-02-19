<?php

namespace AU\RSSImport;

//
//	this function parses the URL to figure out what context and owner it belongs to, so we can generate
// 	a return URL 
//
//	URL is in the form of <baseurl>/rssimport/<container_guid>/<context> where context is "blog", "bookmarks", or "page"
//	Generate a url of <baseurl>/<context>/owner/<owner_name> for personal stuff
//	<baseurl>/<context>/group/<guid>/all for group stuff
function rssimport_get_return_url() {

	$base_path = parse_url(elgg_get_site_url(), PHP_URL_PATH);
	$current_path = parse_url(current_page_url(), PHP_URL_PATH);
	if ($base_path != '/') {
		$current_path = str_replace($base_path, '', $current_path);
	} else {
		$current_path = substr($current_path, 1);
	}
	$parts = explode('/', $current_path);

	// get our owner entity
	$entity = get_entity($parts[1]);

	if ($entity instanceof \ElggGroup) {
		$owner_type = 'group';
		$username = $entity->guid . '/all';
	} elseif ($entity instanceof \ElggUser) {
		$owner_type = 'owner';
		$username = $entity->username;
	}

	$backurl = elgg_get_site_url() . $parts[2] . '/' . $owner_type . '/' . $username;

	//return array of link text and url
	$linktext = elgg_echo('rssimport:back:to:' . $parts[2]);
	return array($linktext, $backurl);
}


// Returns a list of links from an importable item
function rssimport_get_source($item) {
	$return = '';
	$items_sources = $item->get_item_tags('', 'source');
	if ($items_sources) {
		foreach ($items_sources as $source) {
			$return[] .= '<a href="' . $source['attribs']['']['url'] . '">' . $source['data'] . '</a>';
		}
		return implode(', ', $return);
	}
	return false;
}

// Convenient function to add the source if it is defined
function rssimport_add_source($item) {
	$item_source = rssimport_get_source($item);
	if ($item_source) {
		return '<p class="rss-source">' . elgg_echo('rssimport:source') . '&nbsp;: ' . $item_source . '<p>';
	}
	return '';
}


/**
 * Import content on cron
 * @param type $period
 */
function cron_import($period) {
	// change context for permissions
	elgg_push_context('rssimport_import');
	elgg_set_ignore_access(true);

	// get array of imports we need to look at
	$options = array(
		'types' => array('object'),
		'subtypes' => array('rssimport'),
		'limit' => 0,
		'metadata_name_value_pairs' => array(
			'name' => 'cron',
			'value' => $period
		)
	);


	$batch = new \ElggBatch('elgg_get_entities_from_metadata', $options);

	foreach ($batch as $rssimport) {
		if (!$rssimport->isContentImportable($rssimport->import_into)) {
			continue;
		}

		if (!RSSImport::groupGatekeeper($rssimport->getContainerEntity(), $rssimport->import_into, false)) {
			continue;
		}
        
        // need to log in as the rssimport owner in case notifications are enabled
        $logged_in_user = elgg_get_logged_in_user_entity();
        
        // also need to prevent any login/logout forwards that can interrupt us
        elgg_register_plugin_hook_handler('forward', 'all', __NAMESPACE__ . '\\prevent_forward');
        
        $owner = $rssimport->getOwnerEntity();
        if ($owner) {
            login($owner);
        }

		//get the feed
		$feed = $rssimport->getFeed();
		$history = array();
		$items = $feed->get_items(0, 0);
		if (is_array($items)) {
            foreach ($items as $item) {
                if (!$rssimport->isAlreadyImported($item) && !$rssimport->isBlacklisted($item)) {
                    $history[] = $rssimport->importItem($item);
                }
            }
		}

		$rssimport->addToHistory($history);
        
        if ($owner) {
            logout();
        }
        
        if ($logged_in_user) {
            login($logged_in_user);
        }
        
        elgg_unregister_plugin_hook_handler('forward', 'all', __NAMESPACE__ . '\\prevent_forward');
	}

	elgg_set_ignore_access(false);
	elgg_pop_context();
}

/**
 * determine whether to send notifications from imports
 */
function notify_on_import() {
    static $notify;
    
    if (!is_null($notify)) {
        return $notify;
    }
    
    $setting = elgg_get_plugin_setting('notify', PLUGIN_ID);
    
    $notify = ($setting === 'yes');
    
    return $notify;
}