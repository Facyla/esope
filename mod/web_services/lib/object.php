<?php

/**
 * Web service for read a post
 *
 * @param string $guid		 GUID of a blog entity
 * @param string $username Username of reader (Send NULL if no user logged in)
 * @param string $password Password for authentication of username (Send NULL if no user logged in)
 *
 * @return string $title			 Title of post
 * @return string $content		 Text of post
 * @return string $excerpt		 Excerpt
 * @return string $tags				Tags of post
 * @return string $owner_guid	GUID of owner
 * @return string $access_id	 Access level of post (0,-2,1,2)
 * @return string $comments_on On/Off
 */
function object_get_post($guid, $username) {
	$return = array();
	$object = get_entity($guid);

	if (!elgg_instanceof($object, 'object', 'blog')
		&& !elgg_instanceof($object, 'object', 'page')
		&& !elgg_instanceof($object, 'object', 'page_top')) {
		$return['content'] = elgg_echo('object:error:post_not_found');
		return $return;
	}

	$user = get_user_by_username($username);
	if ($user) {
		if (!has_access_to_entity($object, $user)) {
			$return['content'] = elgg_echo('object:error:post_not_found');
			return $return;
		}
	} else {
		if($object->access_id!=2) {
			$return['content'] = elgg_echo('object:error:post_not_found');
			return $return;
		}
	}

	$return['title'] = htmlspecialchars($object->title);
	$return['content'] = strip_tags($object->description);
	$return['excerpt'] = $object->excerpt;
	$return['tags'] = $object->tags;
	$return['owner_guid'] = $object->owner_guid;
	$return['access_id'] = $object->access_id;
	$return['comments_on'] = $object->comments_on;
	return $return;
}

expose_function('object.get_post',
	"object_get_post",
	array('guid' => array ('type' => 'string'),
			'username' => array ('type' => 'string', 'required' => false),
		),
	elgg_echo('web_services:object:get_post'),
	'GET',
	true,
	true
);
