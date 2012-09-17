<?php
/**
 * Elgg Microthemes
 *
 * @package ElggMicrothemes
 */
 
elgg_register_event_handler('init', 'system', 'microthemes_init');

/**
 * Initialize the microthemes plugin.
 *
 */
function microthemes_init(){
	
	// Register a page handler, so we can have nice URLs
	elgg_register_page_handler('microthemes', 'microthemes_page_handler');
	
	// Register some actions
	$action_base = elgg_get_plugins_path() . 'microthemes/actions/microthemes';
	elgg_register_action("microthemes/edit", "$action_base/edit.php");
	elgg_register_action("microthemes/delete", "$action_base/delete.php");
	elgg_register_action("microthemes/choose", "$action_base/choose.php");
	elgg_register_action("microthemes/clear", "$action_base/clear.php");
	
	// Register URL handlers for files
	elgg_register_entity_url_handler('object', 'microtheme', 'microthemes_url_override');
	elgg_register_plugin_hook_handler('entity:icon:url', 'object', 'microthemes_icon_url_override');
	
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'microthemes_user_hover_menu');
	
	elgg_register_event_handler('pagesetup', 'system', 'microthemes_pagesetup');
	
	// register the color picker's JavaScript
	$colorpicker_js = elgg_get_simplecache_url('js', 'input/color_picker');
	elgg_register_simplecache_view('js/input/color_picker');
	elgg_register_js('elgg.input.colorpicker', $colorpicker_js);
	
	// register the color picker's CSS
	$colorpicker_css = elgg_get_simplecache_url('css', 'input/color_picker');
	elgg_register_simplecache_view('css/input/color_picker');
	elgg_register_css('elgg.input.colorpicker', $colorpicker_css);
	
	elgg_register_menu_item('page', array(
		'name' => 'choose_profile_microtheme',
		'href' => "microthemes/owner/" . elgg_get_page_owner_entity()->username,
		'text' => elgg_echo('microthemes:profile:edit'),
		'contexts' => array('profile_edit'),
	));
	
	elgg_extend_view("page/elements/head", "microthemes/metatags");
}

/**
 * Dispatcher for microthemes.
 * URLs take the form of
 *  @todo All microthemes:        microthemes/all
 *  @todo User's microtheme:      microthemes/owner/<username>
 *  @todo Friends' microthemes:   microthemes/friends/<username>
 *  View CSS:               microthemes/css/<guid>/
 *  New microtheme:         microthemes/add/<guid> (container: user, group)
 *  Edit microtheme:        microthemes/edit/<guid>
 *  Group microthemes:      microthemes/group/<guid>/all
 *
 * @param array $page
 * @return bool
 */
function microthemes_page_handler($page) {
	elgg_push_context('microthemes');
	$page_base = elgg_get_plugins_path() . "microthemes/pages/microthemes";
	switch ($page[0]) {
		case 'css':
			include("$page_base/css.php");
			break;
		case 'add':
			include("$page_base/new.php");
			break;
		case 'edit':
			set_input('object_guid', $page[1]);
			include("$page_base/edit.php");
			break;
		case 'owner':
		case 'group':
			set_input('assign_to', $page[1]);
			include("$page_base/view.php");
			break;
		default:
			if (!get_input('assign_to')) {
				set_input('assign_to', elgg_get_logged_in_user_guid());
			}
			include("$page_base/view.php");
			break;
	}
	return true;
}


function microthemes_icon_url_override($hook, $entity_type, $returnvalue, $params) {
	$entity = $params['entity'];
	if ($entity->getSubtype() == 'microtheme') {
		return elgg_get_site_url() . 'mod/microthemes/thumbnail.php?guid=' . $entity->guid;
	}
	return $returnvalue;
}

function microthemes_pagesetup() {
	$owner = elgg_get_page_owner_entity();
	if ($owner && $owner->canEdit()) {
		elgg_register_menu_item('page', array(
			'name' => 'choose_profile_microtheme',
			'href' => "microthemes/owner/" . $owner->username,
			'text' => elgg_echo('microthemes:profile:edit'),
			'contexts' => array('profile_edit'),
		));
		elgg_register_menu_item('page', array(
			'name' => 'microthemes',
			'text' => elgg_echo('microthemes:group:edit'),
			'href' => "microthemes/group/" . $owner->guid,
			'context' => array('groups'),
		));
	}
}

function microthemes_user_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];
	if ($user->canEdit()) {
		$url = "microthemes/owner/$user->username";
		$item = new ElggMenuItem('microthemes:profile:edit', elgg_echo('microthemes:profile:edit'), $url);
		$item->setSection('action');
		$return[] = $item;
	}
	return $return;
}
