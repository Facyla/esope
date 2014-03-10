<?php
/**
 * Elgg Webservices plugin 
 * 
 * @package Webservice
 * @author Mark Harding
 *
 */

/**
 * Heartbeat web service
 *
 * @return string $response Hello
 */
function site_test() {
	$response['success'] = true;
	$response['message'] = elgg_echo('web_services:core:site_test:response');
	return $response;
} 

expose_function('site.test',
	"site_test",
	array(),
	elgg_echo('web_services:core:site_test'),
	'GET',
	false,
	false);


/**
 * Web service to get site information
 *
 * @return string $url URL of Elgg website
 * @return string $sitename Name of Elgg website
 * @return string $language Language of Elgg website
 * @return string $enabled_services List of enabled services
 */
function site_getinfo() {
	$site = elgg_get_config('site');

	$siteinfo['url'] = elgg_get_site_url();
	$siteinfo['sitename'] = $site->name;
	$siteinfo['language'] = elgg_get_config('language');
	$siteinfo['enabled_services'] = $enabled = unserialize(elgg_get_plugin_setting('enabled_webservices', 'web_services'));
	
	//return OAuth info
	if(elgg_is_active_plugin('oauth',0) == true){
		$siteinfo['OAuth'] = elgg_echo('web_services:core:oauthok');
	} else {
		$siteinfo['OAuth'] = elgg_echo('web_services:core:nooauth');
	}
	return $siteinfo;
} 

expose_function('site.getinfo',
	"site_getinfo",
	array(),
	elgg_echo('web_services:core:getinfo'),
	'GET',
	false,
	false);

/**
 * Retrive river feed
 *
 * @return array $river_feed contains all information for river
 */			
function site_river_feed($limit = 15, $offset = 0){
	global $jsonexport;
	$db_prefix = elgg_get_config('dbprefix');
	
	// Note : items are added to the global var while listing items (see json view for details)
	$content = elgg_list_river(array(
		'limit' => $limit,
		'offset' => $offset,
		'pagination' => false,
	));
	return $jsonexport['activity'];
}

expose_function('site.river_feed',
	"site_river_feed",
	array('limit' => array('type' => 'int', 'required' => 'no'),
		'offset' => array('type' => 'int', 'required' => 'no')),
	elgg_echo('web_services:core:getinfo'),
	'GET',
	true,
	true);


/**
 * Performs a search of the elgg site
 *
 * @return array $results search result
 */
 
function site_search($query, $offset, $limit, $sort, $order, $search_type, $entity_type, $entity_subtype, $owner_guid, $container_guid){
	
	$params = array(
		'query' => $query,
		'offset' => $offset,
		'limit' => $limit,
		'sort' => $sort,
		'order' => $order,
		'search_type' => $search_type,
		'type' => $entity_type,
		'subtype' => $entity_subtype,
		//'tag_type' => $tag_type,
		'owner_guid' => $owner_guid,
		'container_guid' => $container_guid,
		);
	
	$types = get_registered_entity_types();
	
	foreach ($types as $type => $subtypes) {
		$results = elgg_trigger_plugin_hook('search', $type, $params, array());
		if ($results === FALSE) {
			// someone is saying not to display these types in searches.
			continue;
		}
		
		if($results['count']) {
			foreach($results['entities'] as $single) {
				if($type == 'group' || $type== 'user') {
					$result['title'] = $single->name;	
				} else {
					$result['title'] = $single->title;
				}
				$result['guid'] = $single->guid;
				$result['type'] = $single->type;
				$result['subtype'] = get_subtype_from_id($single->subtype);
				$result['avatar_url'] = get_entity_icon_url($single,'small');
				
				$return[$type][$single->guid] = $result;
			}
		}
	}
	return $return;
}

expose_function('site.search',
	"site_search",
	array(	'query' => array('type' => 'string'),
		'offset' =>array('type' => 'int', 'required'=>false, 'default' => 0),
		'limit' =>array('type' => 'int', 'required'=>false, 'default' => 10),
		'sort' =>array('type' => 'string', 'required'=>false, 'default' => 'relevance'),
		'order' =>array('type' => 'string', 'required'=>false, 'default' => 'desc'),
		'search_type' =>array('type' => 'string', 'required'=>false, 'default' => 'all'),
		'entity_type' =>array('type' => 'string', 'required'=>false, 'default' => ELGG_ENTITIES_ANY_VALUE),
		'entity_subtype' =>array('type' => 'string', 'required'=>false, 'default' => ELGG_ENTITIES_ANY_VALUE),
		'owner_guid' =>array('type' => 'int', 'required'=>false, 'default' => ELGG_ENTITIES_ANY_VALUE),
		'container_guid' =>array('type' => 'int', 'required'=>false, 'default' => ELGG_ENTITIES_ANY_VALUE),
	),
	elgg_echo('web_services:core:getinfo'),
	'GET',
	false,
	false);


// Authentication token renewal api (requires success on auth.gettoken api call)
// This should be used to renew auth token without logging in again after token expires
// So should be called about every 5-12 minutes (token expires after 15 minutes)

function auth_renewtoken($username = false) {
	// check if username is an email address
	if (is_email_address($username)) {
		$users = get_user_by_email($username);
		// check if we have a unique user
		if (is_array($users) && (count($users) == 1)) {
			$username = $users[0]->username;
		}
	}
	if ($user = get_user_by_username($username)) {
		$token = create_user_token($username);
		if ($token) { return $token; }
	}
	
	throw new SecurityException(elgg_echo('SecurityException:tokenrenewalfailed'));
}

// Token rewewal function for API calls
expose_function(
	"auth.renewtoken",
	"auth_renewtoken",
	array(
		'username' => array ('type' => 'string'),
	),
	elgg_echo('web_services:core:auth_renewtoken'),
	'POST',
	true,
	true
);


