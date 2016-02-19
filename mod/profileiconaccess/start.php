<?php

namespace AU\ProfileIconAccess;

const PLUGIN_ID = 'profileiconaccess';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

/**
 * Init
 */
function init() {

	elgg_extend_view('css/elgg', 'css/profileiconaccess');
	elgg_extend_view('core/avatar/upload', 'forms/profileiconaccess');

	// register our access save action
	elgg_register_action('profileiconaccess', __DIR__ . '/actions/profileiconaccess.php');

	// add some custom js
	$js = elgg_get_simplecache_url('js', 'profileiconaccess/js');
	elgg_register_simplecache_view('js/profileiconaccess/js');
	elgg_register_js('profileiconaccess.js', $js);

	elgg_register_plugin_hook_handler('entity:icon:url', 'user', __NAMESPACE__ . '\\usericon_url', 999);
}

/**
 * determine the url for the user icon
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return type
 */
function usericon_url($hook, $type, $return, $params) {

	$user = $params['entity'];

	$options = array(
		'guid' => $user->guid,
		'metadata_name' => 'iconaccess',
		'limit' => 0
	);

	// See if we can access the metadata with normal access
	$metadata = elgg_get_metadata($options);

	// we may not have the metadata because it may not be set - in which case it's public
	// so look again with the access ignored and see if we have it then
	$ignore = elgg_set_ignore_access();
	$check = elgg_get_metadata($options);
	elgg_set_ignore_access($ignore);

	// if we have metadata in $check and not in $metadata, it's because we're not allowed to see it
	if (!$metadata && $check) {
		$size = $params['size'];
		return "_graphics/icons/user/default{$size}.gif";
	}
	
	return $return;
}
