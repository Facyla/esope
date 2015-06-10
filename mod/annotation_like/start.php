<?php
/**
 * require taiyakan_core
 *	
 */

require_once dirname(__FILE__) . '/lib/annotation_like.php';

elgg_register_event_handler('init','system','annotation_like_init');

elgg_register_action("annotation_like/like", elgg_get_plugins_path() . "annotation_like/actions/like.php");
elgg_register_action("annotation_like/cancel", elgg_get_plugins_path() . "annotation_like/actions/cancel_like.php");


function annotation_like_init(){
	
	//elgg_extend_view("js/initialise_elgg", "annotation/js");
	
	if (elgg_is_active_plugin('groups') && elgg_is_active_plugin('notifications')){
		// Group forum notify any annotation on create.
		// If you set annotation_like on group forum and enable notification plugin,
		// you should control notification.
		elgg_register_plugin_hook_handler('object:notifications','object','annotation_like_notification_intercept');
		
	}
	
	// Likable annotations menu
	elgg_register_plugin_hook_handler('register', 'menu:annotation', 'annotation_like_annotation_menu_setup', 400);
	
	// TODO like notification
	// register_elgg_event_handler('create', 'annotation', 'annotation_like_create_handler');
	
	elgg_register_plugin_hook_handler('unit_test', 'system', 'annotation_like_unittest');
}


// Block notifications
function annotation_like_notification_intercept($hook, $entity_type, $returnvalue, $params) {
	// Returning true means "cancel notification"
	if (AnnotationLike::changed()) { return true; }
	return null;
}


function annotation_like_unittest($hook, $type, $value, $params) {
	error_reporting(E_ALL ^ E_NOTICE);
	//$value = array();
	$value[] = elgg_get_plugins_path() . 'annotation_like/tests/annotation_like.php';
	return $value;
}


/**
 * Add annotation_like and counter to annotation menu at end of the menu
 */
function annotation_like_annotation_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) { return $return; }

	$annotation = $params['annotation'];
	
	// Limit to group replies, and generic comments
	$valid_annotations = array('group_topic_post', 'generic_comment');
	if (!in_array($annotation->name, $valid_annotations)) { return $return; }
	
	$an_id = $annotation->id;
	$al = new AnnotationLike($an_id);
	if (!$al->isValid()) { return $return; }
	
	// annotation_like button
	if ($al->liked(elgg_get_logged_in_user_guid())) {
		$like_text = '<a class="liked"
			 href="' . elgg_add_action_tokens_to_url($vars['url'] . 'action/annotation_like/cancel?id=' . $an_id) . '"
			 title="' . elgg_echo('likes:remove') . '"
			 data-href="' . elgg_add_action_tokens_to_url($vars['url'] . 'action/annotation_like/like?id=' . $an_id) . '"
			 data-text="' . elgg_echo('annotations:like') . '">' . elgg_view_icon('thumbs-up-alt') . '</a>';
	} else {
		$like_text = '<a class="like"
			 href="' . elgg_add_action_tokens_to_url($vars['url'] . 'action/annotation_like/like?id=' . $an_id) . '"
			 title="' . elgg_echo('likes:add') . '"
			 data-href="' . elgg_add_action_tokens_to_url($vars['url'] . 'action/annotation_like/cancel?id=' . $an_id) . '"
			 data-text="' . elgg_echo('annotations:cancel_like') . '">' . elgg_view_icon('thumbs-up') . '</a>';
	}
	$options = array(
		'name' => 'annotation_like',
		'text' => $like_text,
		'href' => false,
		'priority' => 1000,
	);
	$return[] = ElggMenuItem::factory($options);

	// annotation_likes count
	$al_count = $al->count();
	if ($al_count) {
		$count_text = '<span class="counter">' . $al_count .'</span>';
		if ($al_count > 1) {
			$count_text = elgg_echo('likes:userslikedthis', array($count_text));
		} else {
			$count_text = elgg_echo('likes:userlikedthis', array($count_text));
		}
		$count_text = '<span class="counter-holder">' . $count_text . '</span>';
		$options = array(
			'name' => 'annotation_likes_count',
			'text' => $count_text,
			'href' => false,
			'priority' => 1001,
		);
		$return[] = ElggMenuItem::factory($options);
	}
	
	return $return;
}



