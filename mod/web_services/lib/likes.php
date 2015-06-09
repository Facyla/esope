<?php
 
 /**
 * Web service to like an entity
 *
 * @param string $entity_guid guid of object to like
 *
 * @return bool
 */
function likes_add($entity_guid, $username = false) {
	$return['success'] = false;
	if (!$username) {
		$user = elgg_get_logged_in_user_entity();
	} else {
		$user = get_user_by_username($username);
	}
	if (!$user) { throw new InvalidParameterException('registration:usernamenotvalid'); }
	if (elgg_annotation_exists($entity_guid, 'likes')) {
		$msg = elgg_echo("likes:alreadyliked");
		throw new InvalidParameterException($msg);
	}
	// Let's see if we can get an entity with the specified GUID
	$entity = get_entity($entity_guid);
	if (!elgg_instanceof($entity, 'object')) {
		$msg = elgg_echo('InvalidParameterException:NonElggObject');
		throw new InvalidParameterException($msg);
	}
	if (elgg_annotation_exists($entity_guid, 'likes', $user->guid)) { throw new InvalidParameterException("likes:alreadyliked"); }
	// limit likes through a plugin hook (to prevent liking your own content for example)
	if (!$entity->canAnnotate(0, 'likes')) {
		$msg = elgg_echo("likes:notallowed");
		throw new InvalidParameterException($msg);
	}
	
	$annotation = create_annotation($entity->guid,
		'likes',
		"likes",
		"",
		$user->guid,
		$entity->access_id);
	// tell user annotation didn't work if that is the case
	if (!$annotation) {
		$msg = elgg_echo("likes:failure");
		throw new InvalidParameterException($msg);
	}
	
	//add_to_river('annotation/annotatelike', 'likes', $user->guid, $entity->guid, "", 0, $annotation);
	if ($topic->owner_guid != $user->guid) { likes_notify_user($entity->getOwnerEntity(), $user, $entity); }
	$return['message'] = elgg_echo("likes:likes");
	$return['success'] = true;
	return $return;
}

expose_function('likes.add',
	"likes_add",
	array(
		'entity_guid' => array ('type' => 'int'),
		'username' => array ('type' => 'string', 'required'=>false),
	),
	elgg_echo('web_services:likes:add'),
	'POST',
	true,
	true);


/**
 * Web service to unlike an entity
 *
 * @param string $entity_guid guid of object to like
 *
 * @return string Action result message
 */
function likes_delete($entity_guid, $username = false) {
	$return['success'] = false;
	$return['message'] = elgg_echo("likes:notdeleted");
	if (!$username) {
		$user = elgg_get_logged_in_user_entity();
	} else {
		$user = get_user_by_username($username);
	}
	if (!$user) { throw new InvalidParameterException('registration:usernamenotvalid'); }
	$entity = get_entity($entity_guid);
	if (!elgg_instanceof($entity, 'object')) {
		$msg = elgg_echo('InvalidParameterException:NonElggObject');
		throw new InvalidParameterException($msg);
	}
	if (!elgg_annotation_exists($entity_guid, 'likes', $user->guid)) {
		$msg = elgg_echo("likes:alreadyunliked");
		throw new InvalidParameterException($msg);
	}
	$likes = elgg_get_annotations(array(
		'guid' => $entity_guid,
		'annotation_owner_guid' => $user->guid,
		'annotation_name' => 'likes',
	));
	if ($likes && $likes[0]->canEdit($user->guid)) {
		$likes[0]->delete();
		$return['message'] = elgg_echo("likes:deleted");
		$return['success'] = true;
	}
	return $return;
}

expose_function('likes.delete',
	"likes_delete",
	array(
		'entity_guid' => array ('type' => 'int'),
		'username' => array ('type' => 'string', 'required'=>false),
	),
	elgg_echo('web_services:likes:delete'),
	'POST',
	true,
	true);


/**
 * Web service to count number of likes
 *
 * @param string $entity_guid guid of object 
 *
 * @return integer Nb of likes for this entity
 */
function likes_count_number_of_likes($entity_guid) {
	$entity = get_entity($entity_guid);
	// Only valid objects accept likes
	if (!elgg_instanceof($entity, 'object')) {
		$msg = elgg_echo('InvalidParameterException:NonElggObject');
		throw new InvalidParameterException($msg);
	}
	$return['count'] = likes_count($entity);
	$return['success'] = true;
	return $return;
}

expose_function('likes.count',
	"likes_count_number_of_likes",
	array('entity_guid' => array('type' => 'int')),
	elgg_echo('web_services:likes:count'),
	'POST',
	true,
	true);


/**
 * Web service to get users who liked an entity
 *
 * @param string $entity_guid guid of object 
 *
 * @return array List of annotations, or error message
 */
function likes_getusers($entity_guid) {
	$return['success'] = false;
	$entity = get_entity($entity_guid);
	// Only valid objects accept likes
	if (!elgg_instanceof($entity, 'object')) {
		$msg = elgg_echo('InvalidParameterException:NonElggObject');
		throw new InvalidParameterException($msg);
	}
	$likes_count = likes_count($entity);
	$return['count'] = $likes_count;
	if ($likes_count > 0) {
		$list = elgg_get_annotations(array('guid' => $entity_guid, 'annotation_name' => 'likes', 'limit' => 99));
		foreach($list as $singlelike) {
			$return[$singlelike->id]['userid'] = $singlelike->owner_guid;
			$return[$singlelike->id]['time_created'] = $singlelike->time_created;
			$return[$singlelike->id]['access_id'] = $singlelike->access_id;
		}
	} else {
		$return['message'] = elgg_echo('likes:userlikedthis', array($likes_count));
	}
	$return['success'] = true;
	return $return;
}

expose_function('likes.getusers',
	"likes_getusers",
	array('entity_guid' => array ('type' => 'int')),
	elgg_echo('web_services:likes:getusers'),
	'POST',
	true,
	true);



// Web Services depending of annotation_like plugin (implements annotation likes for forum replies and comments)
if (elgg_is_active_plugin('annotation_like')) {
	
	function likes_annotation_add($an_id, $username = false) {
		$return['success'] = false;
		$annotation = elgg_get_annotation_from_id($an_id);
		// Limit to group replies, and generic comments
		$valid_annotations = array('group_topic_post', 'generic_comment');
		if (!in_array($annotation->name, $valid_annotations)) {
			$msg = elgg_echo('web_services:likes_annotation:invalidAnnotation');
			throw new InvalidParameterException($msg);
		}
		$al = new AnnotationLike($an_id);
		if (!$al->isValid()) {
			$msg = elgg_echo('web_services:likes_annotation:invalidAnnotationLike');
			throw new InvalidParameterException($msg);
		}
		if (!$username) {
			$user = elgg_get_logged_in_user_entity();
		} else {
			$user = get_user_by_username($username);
		}
		if (!$user) { throw new InvalidParameterException('registration:usernamenotvalid'); }
		
		if ($al->like($user->guid)) {
			$return['message'] = elgg_echo("annotations:like:success");
			$return['success'] = true;
		}
		return $return;
	}
	
	expose_function('likes_annotation.add',
		"likes_annotation_add",
		array(
			'annotation_id' => array ('type' => 'int'),
			'username' => array ('type' => 'string', 'required'=>false),
		),
		elgg_echo('web_services:likes_annotation:add'),
		'POST',
		true,
		true);
	
	
	function likes_annotation_delete($an_id, $username = false) {
		$return['success'] = false;
		$annotation = elgg_get_annotation_from_id($an_id);
		// Limit to group replies, and generic comments
		$valid_annotations = array('group_topic_post', 'generic_comment');
		if (!in_array($annotation->name, $valid_annotations)) {
			$msg = elgg_echo('web_services:likes_annotation:invalidAnnotation');
			throw new InvalidParameterException($msg);
		}
		$al = new AnnotationLike($an_id);
		if (!$al->isValid()) {
			$msg = elgg_echo('web_services:likes_annotation:invalidAnnotationLike');
			throw new InvalidParameterException($msg);
		}
		if (!$username) {
			$user = elgg_get_logged_in_user_entity();
		} else {
			$user = get_user_by_username($username);
		}
		if (!$user) { throw new InvalidParameterException('registration:usernamenotvalid'); }
		
		if ($al->cancel($userid)){
			$return['message'] = elgg_echo("annotations:cancel_like:success");
			$return['success'] = true;
		}
		return $return;
	}
	
	expose_function('likes_annotation.delete',
		"likes_annotation_delete",
		array(
			'annotation_id' => array ('type' => 'int'),
			'username' => array ('type' => 'string', 'required'=>false),
		),
		elgg_echo('web_services:likes_annotation:delete'),
		'POST',
		true,
		true);
	
	
	function likes_annotation_count_number_of_likes($an_id) {
		$return['success'] = false;
		$annotation = elgg_get_annotation_from_id($an_id);
		// Limit to group replies, and generic comments
		$valid_annotations = array('group_topic_post', 'generic_comment');
		if (!in_array($annotation->name, $valid_annotations)) {
			$msg = elgg_echo('web_services:likes_annotation:invalidAnnotation');
			throw new InvalidParameterException($msg);
		}
		$al = new AnnotationLike($an_id);
		if (!$al->isValid()) {
			$msg = elgg_echo('web_services:likes_annotation:invalidAnnotationLike');
			throw new InvalidParameterException($msg);
		}
		
		$likes_count = $al->count();
		$return['count'] = $likes_count;
		if ($likes_count > 1) {
			$return['message'] = elgg_echo('likes:userslikedthis', array($likes_count));
		} else {
			$return['message'] = elgg_echo('likes:userlikedthis', array($likes_count));
		}
		$return['success'] = true;
		return $return;
	}
	
	expose_function('likes_annotation.count',
		"likes_annotation_count_number_of_likes",
		array('annotation_id' => array ('type' => 'int')),
		elgg_echo('web_services:likes_annotation:count'),
		'POST',
		true,
		true);
	
	
	function likes_annotation_getusers($an_id) {
		$return['success'] = false;
		$annotation = elgg_get_annotation_from_id($an_id);
		// Limit to group replies, and generic comments
		$valid_annotations = array('group_topic_post', 'generic_comment');
		if (!in_array($annotation->name, $valid_annotations)) {
			$msg = elgg_echo('web_services:likes_annotation:invalidAnnotation');
			throw new InvalidParameterException($msg);
		}
		$al = new AnnotationLike($an_id);
		if (!$al->isValid()) {
			$msg = elgg_echo('web_services:likes_annotation:invalidAnnotationLike');
			throw new InvalidParameterException($msg);
		}
		
		$likes_count = $al->count();
		$return['count'] = $likes_count;
		if ($likes_count > 0) {
			$list = elgg_get_annotations(array('guid' => $entity_guid, 'annotation_name' => 'annotation_like', 'annotation_value' => $an_id, 'limit' => 99));
			foreach($list as $singlelike) {
				$return[$singlelike->id]['userid'] = $singlelike->owner_guid;
				$return[$singlelike->id]['time_created'] = $singlelike->time_created;
				$return[$singlelike->id]['access_id'] = $singlelike->access_id;
			}
		} else {
			$return['message'] = elgg_echo('likes:userlikedthis', array($likes_count));
		}
		$return['success'] = true;
		return $return;
	}
	
	expose_function('likes_annotation.getusers',
		"likes_annotation_getusers",
		array('annotation_id' => array ('type' => 'int')),
		elgg_echo('web_services:likes_annotation:getusers'),
		'POST',
		true,
		true);
	
}



