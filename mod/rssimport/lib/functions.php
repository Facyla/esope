<?php

/* This function returns an array of all imports for the logged in user */
function get_user_rssimports($user = NULL, $options = array()){
	if (!$user) { return false; }
	
	$defaults = array(
			'types' => array('object'),
			'subtypes' => array('rssimport'),
			'owner_guids' => array($user->guid),
			'metadata_name_value_pairs' => array('name' => 'import_into', 'value' => 'blog'),
			'limit' => 0
	);
	
	$options = array_merge($defaults, $options);
	
	return elgg_get_entities_from_metadata($options);
}

/* This function adds a list of item ids (passed as array $items)
 * and adds them to the blacklist for the given import
 * These items won't be imported on cron, or visible by default
 */
function rssimport_add_to_blacklist($items, $rssimport){
	foreach ($items as $item_id) {
		$rssimport->annotate('rssimport_blacklist', $item_id);
	}
}


/* This function annotates an rssimport object with the most recent import
 * stores a string of guids that were created
 */
function rssimport_add_to_history($array, $rssimport){
	//create comma delimited string of new guids
	if (is_array($array)) {
		if (count($array) > 0) {
			$history = implode(',', $array);
			$rssimport->annotate('rssimport_history', $history, ACCESS_PRIVATE, $rssimport->owner_guid);		
		}
	}	
}

/* Checks if an item has been imported previously
 * was a unique function, now a wrapper for rssimport_check_for_duplicates()
 */
function rssimport_already_imported($item, $rssimport){
	return rssimport_check_for_duplicates($item, $rssimport);
}


/* BLOG IMPORT - This function saves a blog post from an rss item */
function rssimport_blog_import($item, $rssimport) {
	$blog = new ElggBlog();
	$blog->subtype = "blog";
	//$blog->owner_guid = $rssimport->owner_guid;
	$blog->owner_guid = rssimport_get_owner_guid($rssimport);
	$blog->container_guid = $rssimport->container_guid;
	$blog->access_id = $rssimport->defaultaccess;
	$blog->title = $item->get_title();
	$author = $item->get_author();
	
	// Blog post content and excerpt
	$content = $item->get_content();
	$blog->excerpt = elgg_get_excerpt($content);
	// Filter content
	$parse_permalink = parse_url($item->get_permalink());
	$parse_rss_url = parse_url($rssimport->description);
	$blogbody = rssimport_filter_content($content, $parse_rss_url['host']);
	// Tags extraits du contenu filtré, s'il y a lieu
	$extracted_tags = rssimport_filter_content($content, $parse_rss_url['host'], true);
	$blogbody .= "<br /><br />";
	$blogbody .= "<hr><br />";
	$blogbody .= elgg_echo('rssimport:original') . ": <a href=\"" . $item->get_permalink() . "\">" . $item->get_permalink() . "</a> <br />";
	
	// some feed items don't have an author to get, check first 
	if (is_object($author)) {
		$blogbody .= elgg_echo('rssimport:by') . ": " . $author->get_name() . "<br />";
	}
	// ESOPE : add real data source, if defined
	$blogbody .= rssimport_add_source($item);
	
	$blogbody .= elgg_echo('rssimport:posted') . ": " . $item->get_date('F j, Y, g:i a');
	$blog->description = $blogbody;
	
	//add feed tags to default tags and remove duplicates
	$tagarray = string_to_tag_array($rssimport->defaulttags);
	$tagarray = array_merge($tagarray, $extracted_tags); // N'accepte que des array, pas de null
	foreach ($item->get_categories() as $category) { $tagarray[] = $category->get_label(); }
	$tagarray = array_unique($tagarray);
	$tagarray = array_filter($tagarray); // Remove empty values
	$tagarray = array_values($tagarray);
	
	// Now let's add tags. We can pass an array directly to the object property! Easy.
	if (is_array($tagarray)) { $blog->tags = $tagarray; }
	
	//whether the user wants to allow comments or not on the blog post
	// do we want to make this selectable?
	$blog->comments_on = true;
		// Now save the object
	$blog->save();
	
	//add metadata
	$token = rssimport_create_comparison_token($item);
	$blog->rssimport_token = $token;
	$blog->rssimport_id = $item->get_id();
	$blog->rssimport_permalink = $item->get_permalink();
	$blog->status = 'published';
	
	$blog->time_created = strtotime($item->get_date()) ? strtotime($item->get_date()) : time();
	$blog->save(); // have to save again to set the new time_created
	
	return $blog->guid;
}


/* BOOKMARK IMPORT - Imports a feed item into a bookmark */
function rssimport_bookmarks_import($item, $rssimport){
	// flag to prevent saving if there are issues
	$error = false;
	
	$bookmark = new ElggObject;
	$bookmark->subtype = "bookmarks";
	//$bookmark->owner_guid = $rssimport->owner_guid;
	$bookmark->owner_guid = rssimport_get_owner_guid($rssimport);
	$bookmark->container_guid = $rssimport->container_guid;
	$bookmark->title = $item->get_title();
	$bookmark->address = $item->get_permalink();
	
	// Bookmark content
	$content = $item->get_description();
	// Filter content
	$parse_permalink = parse_url($item->get_permalink());
	$parse_rss_url = parse_url($rssimport->description);
	$bookmarkbody = rssimport_filter_content($content, $parse_rss_url['host']);
	// Tags extraits du contenu filtré, s'il y a lieu
	$extracted_tags = rssimport_filter_content($content, $parse_rss_url['host'], true);
	// ESOPE : add real data source, if defined
	$bookmarkbody .= rssimport_add_source($item);
	$bookmark->description = $bookmarkbody;
	
	$bookmark->access_id = $rssimport->defaultaccess;
	
	// merge default tags with any from the feed
	$tagarray = string_to_tag_array($rssimport->defaulttags);
	$tagarray = array_merge($tagarray, $extracted_tags); // N'accepte que des array, pas de null
	foreach ($item->get_categories() as $category) { $tagarray[] = $category->get_label(); }
	$tagarray = array_unique($tagarray);
	$tagarray = array_filter($tagarray); // Remove empty values
	$tagarray = array_values($tagarray);
	$bookmark->tags = $tagarray;
	
	//if no errors save it
	if (!$error) {
		$bookmark->save();
		
		//add metadata
		$token = rssimport_create_comparison_token($item);
		$bookmark->rssimport_token = $token;
		$bookmark->rssimport_id = $item->get_id();
		$bookmark->rssimport_permalink = $item->get_permalink();
		$bookmark->time_created = strtotime($item->get_date()) ? strtotime($item->get_date()) : time();
		$bookmark->save(); // save again to set time_created
		
		return $bookmark->guid;
	}
}


/* PAGE IMPORT - Imports an RSS item into a page object */
function rssimport_page_import($item, $rssimport){
	//check if we have a parent page yet
	$options = array();
	$options['type_subtype_pairs'] = array('object' => 'page_top');
	$options['container_guids'] = array($rssimport->container_guid);
	$options['metadata_name_value_pairs'] = array(array('name' => 'rssimport_feedpage', 'value' => $rssimport->title), array('name' => 'rssimport_url', 'value' => $rssimport->description));
	$testpage = elgg_get_entities_from_metadata($options);
	
	if (!$testpage) {
		//create our parent page
		$parent = new ElggObject();
		$parent->subtype = 'page_top';
		$parent->container_guid = $rssimport->container_guid;
		//$parent->owner_guid = $rssimport->owner_guid;
		$parent->owner_guid = rssimport_get_owner_guid($rssimport);
		$parent->access_id = $rssimport->defaultaccess;
		$parent->parent_guid = 0;
		$parent->write_access_id = ACCESS_PRIVATE;
		$parent->title = $rssimport->title;
		$parent->description = $rssimport->description;
		//set default tags
		$tagarray = string_to_tag_array($rssimport->defaulttags);
		$parent->tags = $tagarray;
		$parent->save();
		
		$parent->annotate('page', $parent->description, $parent->access_id, $parent->owner_guid);
		
		$parent_guid = $parent->guid;
		
		//add our identifying metadata
		$parent->rssimport_feedpage = $rssimport->title;
		$parent->rssimport_url = $rssimport->description;
	} else{
		$parent_guid = $testpage[0]->guid;
	}
	
	//initiate our object
	$page = new ElggObject();
	$page->subtype = 'page';
	$page->container_guid = $rssimport->container_guid;
	//$page->owner_guid = $rssimport->owner_guid;
	$page->owner_guid = rssimport_get_owner_guid($rssimport);
	$page->access_id = $rssimport->defaultaccess;
	$page->parent_guid = $parent_guid;
	$page->write_access_id = ACCESS_PRIVATE;
	$page->title = $item->get_title();
	$author = $item->get_author();
	// Page content
	$content = $item->get_content();
	// Filter content
	$parse_permalink = parse_url($item->get_permalink());
	$parse_rss_url = parse_url($rssimport->description);
	$pagebody = rssimport_filter_content($content, $parse_rss_url['host']);
	// Tags extraits du contenu filtré, s'il y a lieu
	$extracted_tags = rssimport_filter_content($content, $parse_rss_url['host'], true);
	$pagebody .= "<br /><br />";
	$pagebody .= "<hr><br />";
	$pagebody .= elgg_echo('rssimport:original') . ": <a href=\"" . $item->get_permalink() . "\">" . $item->get_permalink() . "</a> <br />";
	if (is_object($author)) {
		$pagebody .= elgg_echo('rssimport:by') . ": " . $author->get_name() . "<br />";
	}
	// ESOPE : add real data source, if defined
	$pagebody .= rssimport_add_source($item);
	//$pagebody .= elgg_echo('rssimport:posted') . ": " . $item->get_date('F j, Y, g:i a');
	$date_format = elgg_echo('rssimport:date:format');
	$pagebody .= elgg_echo('rssimport:posted') . ": " . $item->get_date($date_format);
	
	$page->description = $pagebody;
	
	//set default tags
	$tagarray = string_to_tag_array($rssimport->defaulttags);
	$tagarray = array_merge($tagarray, $extracted_tags); // N'accepte que des array, pas de null
	foreach ($item->get_categories() as $category) { $tagarray[] = $category->get_label(); }
	$tagarray = array_unique($tagarray);
	$tagarray = array_filter($tagarray); // Remove empty values
	$tagarray = array_values($tagarray);

	// Now let's add tags. We can pass an array directly to the object property! Easy.
	if (is_array($tagarray)) { $page->tags = $tagarray; }
	
	$page->save();
	
	$page->annotate('page', $page->description, $page->access_id, $page->owner_guid);
	
	//add our identifying metadata
	$token = rssimport_create_comparison_token($item);
	$page->rssimport_token = $token;
	$page->rssimport_id = $item->get_id();
	$page->rssimport_permalink = $item->get_permalink();
	$page->time_created = strtotime($item->get_date()) ? strtotime($item->get_date()) : time();
	$page->save(); // save again to set proper time_created
	
	return $page->guid;
}

/* Checks if a blog post exists for a user that matches a feed item
 * Return true if there is a match
 */
function rssimport_check_for_duplicates($item, $rssimport){
	// normalize subtype for pages
	$subtype = $rssimport->import_into;
	if ($subtype == 'pages') { $subtype = 'page'; }
	
	// look for id first - less resource intensive
	// this will filter out anything that has already been imported
	$options = array();
	$options['container_guids'] = $rssimport->container_guid;
	$options['type_subtype_pairs'] = array('object' => $subtype);
	$options['metadata_name_value_pairs'] = array('name' => 'rssimport_id', 'value' => $item->get_id());
	$blogs = elgg_get_entities_from_metadata($options);
	if (!empty($blogs)) { return true; }
	
	// look for permalink
	// this will filter out anything that has already been imported
	$options = array();
	$options['container_guids'] = $rssimport->container_guid;
	$options['type_subtype_pairs'] = array('object' => $subtype);
	$options['metadata_name_value_pairs'] = array('name' => 'rssimport_permalink', 'value' => $item->get_permalink());
	$blogs = elgg_get_entities_from_metadata($options);
	if (!empty($blogs)) { return true; }
	
	//check by token - this will filter out anything that was a repost on the feed
	$token = rssimport_create_comparison_token($item);
	$options = array();
	$options['container_guids'] = $rssimport->container_guid;
	$options['type_subtype_pairs'] = array('object' => $subtype);
	$options['metadata_name_value_pairs'] = array('name' => 'rssimport_token', 'value' => $token);
	$blogs = elgg_get_entities_from_metadata($options);
	if (!empty($blogs)) { return true; }
	
	return false;
}


/**
 * 	Creates a hash of various feed item variables for
 * 	easy comparison to feed created blogs
 */
function rssimport_create_comparison_token($item){
	$author = $item->get_author();
	$pretoken = $item->get_title();
	$pretoken .= $item->get_content();
	if (is_object($author)) { $pretoken .= $author->get_name(); }
	return md5($pretoken);
}

/**
 * Convenience function to tell if a feed can be imported to a content type
 * 
 * @staticvar type $blog_enabled
 * @staticvar type $bookmarks_enabled
 * @staticvar type $pages_enabled
 * @param type $rssimport
 * @return boolean 
 */
function rssimport_content_importable($rssimport) {
	/* ESOPE : Replaced by function that tells if import is allowed for each tool
	// this will be called multiple times, remember which plugins are enabled
	static $blog_enabled;
	static $bookmarks_enabled;
	static $pages_enabled;
	
	// use static vars so we only have to call elgg_is_active_plugin once
	if ($blog_enabled === NULL) {
		$blog_enabled = elgg_is_active_plugin('blog');
	}
	if ($bookmarks_enabled === NULL) {
		$bookmarks_enabled = elgg_is_active_plugin('bookmarks');
	}
	if ($pages_enabled === NULL) {
		$pages_enabled = elgg_is_active_plugin('pages');
	}
	*/
	$blog_enabled = rssimport_tool_enabled('blog');
	$bookmarks_enabled = rssimport_tool_enabled('bookmarks');
	$pages_enabled = rssimport_tool_enabled('pages');
	
	// only import if the receiving content type's plugin is active
	if (!($rssimport->import_into == 'blog' && $blog_enabled)
		&& !($rssimport->import_into == 'bookmarks' && $bookmarks_enabled)
		&& !($rssimport->import_into == 'pages' && $pages_enabled)
		) {
		return false;
	}
	return true;
}


/**
 * Cron : Trigger imports
 *	use $params['period'] to find out which we are on
 *	eg; $params['period'] = 'hourly'
 */
function rssimport_cron($hook, $entity_type, $returnvalue, $params){
	// change context for permissions
	$context = elgg_get_context();
	elgg_set_context('rssimport_cron');
	$ia = elgg_set_ignore_access(true);
	
	// get array of imports we need to look at
	$options = array(
			'types' => array('object'),
			'subtypes' => array('rssimport'),
			'limit' => 0,
			'metadata_name_value_pairs' => array('name' => 'cron', 'value' => $params['period'])
		);
	
	// using ElggBatch because there may be many, many groups in teh installation
	// try to avoid oom errors
	$batch = new ElggBatch('elgg_get_entities_from_metadata', $options, 'rssimport_import_feeds', 25);
	
	elgg_set_ignore_access($ia);
	elgg_set_context($context);
}


/* Returns an array of groups that a user is a member of
 * and can post content to
 * returns false if there are no groups the user can post to
 */
function rssimport_get_postable_groups($user) {
	return $user->getGroups('', 0, 0);
}


/* this function parses the URL to figure out what context and owner it belongs to, so we can generate
 * a return URL 
 * 
 * URL is in the form of <baseurl>/rssimport/<container_guid>/<context> where context is "blog", "bookmarks", or "page"
 * Generate a url of <baseurl>/<context>/owner/<owner_name> for personal stuff
 * <baseurl>/<context>/group/<guid>/all for group stuff
 */
function rssimport_get_return_url(){
	
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
			
	if ($entity instanceof ElggGroup) {
		$owner_type = 'group';
		$username = $entity->guid . '/all';
	} elseif ($entity instanceof ElggUser) {
		$owner_type = 'owner';
		$username = $entity->username;
	}
	
	$backurl = elgg_get_site_url() . $parts[2] . '/' . $owner_type . '/' . $username;
	
	//return array of link text and url
	$linktext = elgg_echo('rssimport:back:to:' . $parts[2]);
	return array($linktext, $backurl);
}


/**
 * returns true/false whether rssimport is allowed for a given group
 * default - forwards with error message if not allowed
 * 
 * @param ElggGroup $group
 * @param bool $forward
 * @param string $import_into
 * @return bool
 */
function rssimport_group_gatekeeper($group, $import_into, $forward = TRUE) {
	if (!elgg_instanceof($group, 'group')) {
		return TRUE;
	}
	
	$attribute = 'rssimport_' . $import_into . '_enable';
	if ($group->$attribute != 'no') {
		return TRUE;
	}
	
	// it's disabled, forward if necessary, otherwise return false
	if ($forward) {
		register_error(elgg_echo('rssimport:group:disabled'));
		forward($group->getURL());
	}
	
	return FALSE;
}


/* Imports full feeds - called on cron */
function rssimport_import_feeds($rssimport, $getter, $options){
	if (!rssimport_content_importable($rssimport)) { return; }
	
	if (!rssimport_group_gatekeeper($rssimport->getContainerEntity(), $rssimport->import_into, FALSE)) { return; }
	
	//get the feed
	$feed = rssimport_simplepie_feed($rssimport->description);
	
	$history = array();
	foreach ($feed->get_items(0,0) as $item) {
		if (!rssimport_check_for_duplicates($item, $rssimport) && !rssimport_is_blacklisted($item, $rssimport)) {
			$history[] = rssimport_import_item($item, $rssimport);
		}
	}
	
	rssimport_add_to_history($history, $rssimport);
}


/* Imports a single item of a feed
 * returns the guid of
 */
function rssimport_import_item($item, $rssimport) { 
	switch ($rssimport->import_into) {
		case "blog":
			$history = rssimport_blog_import($item, $rssimport);
			break;
		case "pages":
			$history = rssimport_page_import($item, $rssimport);
			break;
		case "bookmarks":
			$history = rssimport_bookmarks_import($item, $rssimport);
			break;
		default:	// when in doubt, send to a blog
			$history = rssimport_blog_import($item, $rssimport);
			break;
	}
	
	return $history;
}



/* this function includes the simplepie class if it doesn't exist */
function rssimport_include_simplepie() {
	if (!class_exists('SimplePie')) {
		require_once elgg_get_plugins_path() . 'rssimport/lib/simplepie-1.3.1.php';
	}
}


// returns true if the item has been blacklisted by the current user
function rssimport_is_blacklisted($item, $rssimport) {
	$options = array(
		'annotation_names' => array('rssimport_blacklist'),
		'annotation_values' => array($item->get_id(true)),
		'guids' => $rssimport->guid
	);
	
	return (bool) elgg_get_annotations($options);
}

/* this function removes an item from the blacklist */
function rssimport_remove_from_blacklist($items, $rssimport){
	$options = array(
			'annotation_names' => array('rssimport_blacklist'),
			'annotation_values' => $items,
			'guids' => $rssimport->guid
		);
	
	$annotations = elgg_get_annotations($options);
	foreach ($annotations as $annotation) { $annotation->delete(); }
}

/* removes a single item from an array
 * resets keys
 */
function rssimport_removeFromArray($value, $array) {
	if (!is_array($array)) { return $array; }
	if (!in_array($value, $array)) { return $array; }
	
	for ($i=0; $i<count($array); $i++) {
		if ($value == $array[$i]) {
			unset($array[$i]);
			$array = array_values($array);
		}
	}
	return $array;
}


// allows write permissions when we are adding metadata to an object
function rssimport_permissions_check($hook, $type, $return, $params){
	if (elgg_get_context() == 'rssimport_cron') { return true; }
	
	if ($type == 'object' && $params['entity']->getSubtype() == 'rssimport') {
		return $params['entity']->getContainerEntity()->canEdit();
	}
	
	return null;
}


/* Set cache for simplepie if it doesn't exist */
function rssimport_set_simplepie_cache(){
	$cache_location = elgg_get_config('dataroot') . 'simplepie_cache/';
	if (!file_exists($cache_location)) {
		mkdir($cache_location, 0777);
	}
	
	return $cache_location;
}

/* Sets up our simplepie feed with caching enabled */
function rssimport_simplepie_feed($url) {
	rssimport_include_simplepie();
	$cache_location = rssimport_set_simplepie_cache();
	
	$feed = new SimplePie();
	$feed->set_feed_url($url);
	$feed->set_cache_location($cache_location);
	$feed->handle_content_type();
	$feed->init();
	
	return $feed;
}

/* prevent notifications from being sent during an import */
function rssimport_prevent_notification($hook, $type, $return, $params) {
	if (elgg_get_context() == 'rssimport_cron') {
		$notify = elgg_get_plugin_setting('notifications', 'rssimport');
		// True blocks notification process
		if ($notify == 'no') { return TRUE; }
	}
	// Don't change default behaviour
	return $return;
}



/* ESOPE IMPROVEMENTS */

/* Tells if rssimport is enabled for a given tool (finer control over available import tools)
 * Use active plugin + rssimport admin config
 */
function rssimport_tool_enabled($tool) {
	global ${'rss_import_' . $tool . '_enabled'};
	// Activation relies on : plugin activated + allowed in plugin settings
	// use static vars so we only have to call is_plugin_enabled once
	if (!isset(${'rss_import_' . $tool . '_enabled'})) {
		if (elgg_is_active_plugin($tool) && (elgg_get_plugin_setting($tool . '_enable', 'rssimport') == 'yes')) {
			${'rss_import_' . $tool . '_enabled'} = true;
		} else {
			${'rss_import_' . $tool . '_enabled'} = false;
		}
	}
	return ${'rss_import_' . $tool . '_enabled'};
}

/* Sets the desired owner for the imported content
 * Defaults to container (=> group if in a group, user otherwise)7*/
function rssimport_get_owner_guid($rssimport) {
	if (!elgg_instanceof($rssimport, 'object')) { return 0; }
	$ownership = elgg_get_plugin_setting('ownership', 'rssimport');
	switch($ownership) {
		case 'owner':
			return $rssimport->owner_guid;
		case 'container':
		default:
			return $rssimport->container_guid;
	}
}


/* Returns a list of links from an importable item
 * Liste de liens vers la ou les sources de l'article (URL originelle généralement)
 */
function rssimport_get_source($item) {
	// Source originelle du flux, si définie
	//$source = $item->data['child']['']['source'][0]['attribs']['']['url']; // Plus compact si 1 seul élément
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


/* Convenient function to add the source if it is defined */
function rssimport_add_source($item) {
	$item_source = rssimport_get_source($item);
	if ($item_source) {
		return '<p class="rss-source">' . elgg_echo('rssimport:source') . '&nbsp;: '. $item_source . '<p>';
	}
	return '';
}


/* Returns filtered content depending on source
 * $content : content to be filtered
 * $filter : filter name or full domain name of imported RSS feed
 * $extract_tags : return only extracted tags
 */
function rssimport_filter_content($content, $filter = 'auto', $extract_tags = false) {
	if ($extract_tags) {
		return rssimport_filter_extract_tags($content, $params = array('filter' => $filter));
	} else {
		return rssimport_filter_extract_content($content, $params = array('filter' => $filter));
	}
}

/* Returns filtered content depending on source
 * $content : content to be filtered
 * $filter : filter name or full domain name of imported RSS feed
 */
function rssimport_filter_extract_content($content, $params = array('filter' => 'auto')) {
	switch($filter) {
		case 'diigo':
		case 'www.diigo.com':
		case 'groups.diigo.com':
			//error_log("DEBUG rssimport lib : DIIGO");
			/* Process pour Diigo :
			 * Notes : on n'a pas toujours la liste ni l'auteur, d'où découpe un peu complexe..
			 1. on coupe sur le séparateur des tags	// <p><strong>Tags:</strong>
			 2. pour avoir le contenu, partie 0, on enlève le début et les autres parties inutiles (sur Diigo on n'est censé avoir qu'un paragraphe)
				 // <p><strong>Comments:</strong>	// <ul><li>	// </li></ul>	// </p>
			*/
			$parts = explode('<p><strong>Tags:</strong>', $content);
			$content = str_replace(array('<p><strong>Comments:</strong>', '<ul><li>', '</li></ul>', '</p>'), '', $parts[0]);
			break;
		case 'scoop.it':
		case 'www.scoop.it':
		case 'auto':
		default:
			// nothing yet..
			// @TODO trigger filtering hook
			return elgg_trigger_plugin_hook('filter:content', 'rssimport', $params, $content);
	}
	// Returned filtered content
	return $content;
}

/* Returns filtered tags depending on source
 * $content : content to be filtered
 * $filter : filter name or full domain name of imported RSS feed
 */
function rssimport_filter_extract_tags($content, $filter = 'auto') {
	switch($filter) {
		case 'diigo':
		case 'www.diigo.com':
		case 'groups.diigo.com':
			//error_log("DEBUG rssimport lib : DIIGO");
			/* Process pour Diigo :
			 * Notes : on n'a pas toujours la liste ni l'auteur, d'où découpe un peu complexe..
			 1. on coupe sur le séparateur des tags	// <p><strong>Tags:</strong>
			 2. pour avoir les tags, partie 1, on coupe au premier <p>, séparateur de fin des tags	// </p>
			 3. on enlève toutes les balises HTML de ce qui reste (partie 0), après avoir préparé et nettoyé la chaîne
			 4. on explode sur ',' pour avoir un array de tags
			*/
			$parts = explode('<p><strong>Tags:</strong>', $content);
			//error_log("DEBUG rssimport lib : part1 = " . print_r($parts, true));
			$tags_parts = explode('</p>', $parts[1]);
			// On remplace les fins de liens par des marqueurs pour couper de manière certaine chacun des tags
			// + un peu de nettoyage
			$tags_string = str_replace(array('</a>', "\t", "\n", "\r"), array(',', '', '', ''), $tags_parts[0]);
			// On enlève les restes de balises (<a> non fermés)
			$tags_string = strip_tags($tags_string);
			// On enlève tabulations et retours à la ligne
			$tags_string = str_replace(array('\t', '\n', '\r'), '', $tags_string);
			$tags = explode(',', $tags_string);
			$tags = array_map("trim", $tags);
			//error_log("DEBUG rssimport lib : TAGS = " . implode(',', $tags));
			break;
		case 'scoop.it':
		case 'www.scoop.it':
		case 'auto':
		default:
			// Trigger filtering hook (no extracted tag by default)
			return elgg_trigger_plugin_hook('filter:tags', 'rssimport', $params, false);
	}
	if (!$tags) {
		$tags = array();
	} else if (!is_array($tags)) {
		$tags = array($tags);
	}
	return $tags;
}


