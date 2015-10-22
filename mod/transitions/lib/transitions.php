<?php
/**
 * Transitions helper functions
 *
 * @package Transitions
 */


/**
 * Get page components to view a transitions post.
 *
 * @param int $guid GUID of a transitions entity.
 * @return array
 */
function transitions_get_page_content_read($guid = NULL) {

	$return = array();

	elgg_entity_gatekeeper($guid, 'object', 'transitions');

	$transitions = get_entity($guid);

	// no header or tabs for viewing an individual transitions
	$return['filter'] = '';

	elgg_set_page_owner_guid($transitions->container_guid);

	elgg_group_gatekeeper();

	$return['title'] = $transitions->title;

	$container = $transitions->getContainerEntity();
	$crumbs_title = $container->name;
	if (elgg_instanceof($container, 'group')) {
		elgg_push_breadcrumb($crumbs_title, "catalogue/group/$container->guid/all");
	} else {
		elgg_push_breadcrumb($crumbs_title, "catalogue/owner/$container->username");
	}

	elgg_push_breadcrumb($transitions->title);
	$return['content'] = elgg_view_entity($transitions, array('full_view' => true));
	// check to see if we should allow comments
	if ($transitions->comments_on != 'Off' && $transitions->status == 'published') {
		$return['content'] .= elgg_view_comments($transitions);
	}

	return $return;
}

/**
 * Get page components to list a user's or all transitions.
 *
 * @param int $container_guid The GUID of the page owner or NULL for all transitions
 * @return array
 */
function transitions_get_page_content_list($container_guid = NULL) {

	$return = array();

	$return['filter_context'] = $container_guid ? 'mine' : 'all';

	$options = array(
		'type' => 'object',
		'subtype' => 'transitions',
		'full_view' => false,
		'no_results' => elgg_echo('transitions:none'),
		'preload_owners' => true,
		'distinct' => false,
	);

	$current_user = elgg_get_logged_in_user_entity();

	if ($container_guid) {
		// access check for closed groups
		elgg_group_gatekeeper();

		$options['container_guid'] = $container_guid;
		$container = get_entity($container_guid);
		if (!$container) {

		}
		$return['title'] = elgg_echo('transitions:title:user_transitions', array($container->name));

		$crumbs_title = $container->name;
		elgg_push_breadcrumb($crumbs_title);

		if ($current_user && ($container_guid == $current_user->guid)) {
			$return['filter_context'] = 'mine';
		} else if (elgg_instanceof($container, 'group')) {
			$return['filter'] = false;
		} else {
			// do not show button or select a tab when viewing someone else's posts
			$return['filter_context'] = 'none';
		}
	} else {
		$options['preload_containers'] = true;
		$return['filter_context'] = 'all';
		$return['title'] = elgg_echo('transitions:title:all_transitions');
		elgg_pop_breadcrumb();
		elgg_push_breadcrumb(elgg_echo('transitions:transitions'));
	}

	elgg_register_title_button();

	$return['content'] = elgg_list_entities($options);

	return $return;
}

/**
 * Get page components to list of the user's friends' posts.
 *
 * @param int $user_guid
 * @return array
 */
function transitions_get_page_content_friends($user_guid) {

	$user = get_user($user_guid);
	if (!$user) {
		forward('catalogue/all');
	}

	$return = array();

	$return['filter_context'] = 'friends';
	$return['title'] = elgg_echo('transitions:title:friends');

	$crumbs_title = $user->name;
	elgg_push_breadcrumb($crumbs_title, "catalogue/owner/{$user->username}");
	elgg_push_breadcrumb(elgg_echo('friends'));

	elgg_register_title_button();

	$options = array(
		'type' => 'object',
		'subtype' => 'transitions',
		'full_view' => false,
		'relationship' => 'friend',
		'relationship_guid' => $user_guid,
		'relationship_join_on' => 'container_guid',
		'no_results' => elgg_echo('transitions:none'),
		'preload_owners' => true,
		'preload_containers' => true,
	);

	$return['content'] = elgg_list_entities_from_relationship($options);

	return $return;
}

/**
 * Get page components to show transitions with publish dates between $lower and $upper
 *
 * @param int $owner_guid The GUID of the owner of this page
 * @param int $lower      Unix timestamp
 * @param int $upper      Unix timestamp
 * @return array
 */
function transitions_get_page_content_archive($owner_guid, $lower = 0, $upper = 0) {

	$owner = get_entity($owner_guid);
	elgg_set_page_owner_guid($owner_guid);

	$crumbs_title = $owner->name;
	if (elgg_instanceof($owner, 'user')) {
		$url = "catalogue/owner/{$owner->username}";
	} else {
		$url = "catalogue/group/$owner->guid/all";
	}
	elgg_push_breadcrumb($crumbs_title, $url);
	elgg_push_breadcrumb(elgg_echo('transitions:archives'));

	if ($lower) {
		$lower = (int)$lower;
	}

	if ($upper) {
		$upper = (int)$upper;
	}

	$options = array(
		'type' => 'object',
		'subtype' => 'transitions',
		'full_view' => false,
		'no_results' => elgg_echo('transitions:none'),
		'preload_owners' => true,
		'distinct' => false,
	);

	if ($owner_guid) {
		$options['container_guid'] = $owner_guid;
	}

	if ($lower) {
		$options['created_time_lower'] = $lower;
	}

	if ($upper) {
		$options['created_time_upper'] = $upper;
	}

	$content = elgg_list_entities($options);

	$title = elgg_echo('date:month:' . date('m', $lower), array(date('Y', $lower)));

	return array(
		'content' => $content,
		'title' => $title,
		'filter' => '',
	);
}

/**
 * Get page components to edit/create a transitions post.
 *
 * @param string  $page     'edit' or 'new'
 * @param int     $guid     GUID of transitions post or container
 * @param int     $revision Annotation id for revision to edit (optional)
 * @return array
 */
function transitions_get_page_content_edit($page, $guid = 0, $revision = NULL) {

	elgg_require_js('elgg/transitions/save_draft');

	$return = array(
		'filter' => '',
	);

	$vars = array();
	$vars['id'] = 'transitions-post-edit';
	$vars['class'] = 'elgg-form-alt';
	$vars["enctype"] = "multipart/form-data";

	$sidebar = '';
	if ($page == 'edit') {
		$transitions = get_entity((int)$guid);

		$title = elgg_echo('transitions:edit');

		if (elgg_instanceof($transitions, 'object', 'transitions') && $transitions->canEdit()) {
			$vars['entity'] = $transitions;

			$title .= ": \"$transitions->title\"";

			if ($revision) {
				$revision = elgg_get_annotation_from_id((int)$revision);
				$vars['revision'] = $revision;
				$title .= ' ' . elgg_echo('transitions:edit_revision_notice');

				if (!$revision || !($revision->entity_guid == $guid)) {
					$content = elgg_echo('transitions:error:revision_not_found');
					$return['content'] = $content;
					$return['title'] = $title;
					return $return;
				}
			}

			$body_vars = transitions_prepare_form_vars($transitions, $revision);

			elgg_push_breadcrumb($transitions->title, $transitions->getURL());
			elgg_push_breadcrumb(elgg_echo('edit'));
			
			elgg_require_js('elgg/transitions/save_draft');

			$content = elgg_view_form('transitions/save', $vars, $body_vars);
			$sidebar = elgg_view('transitions/sidebar/revisions', $vars);
		} else {
			$content = elgg_echo('transitions:error:cannot_edit_post');
		}
	} else {
		elgg_push_breadcrumb(elgg_echo('transitions:add'));
		$body_vars = transitions_prepare_form_vars(null);

		$title = elgg_echo('transitions:add');
		$content = elgg_view_form('transitions/save', $vars, $body_vars);
	}

	$return['title'] = $title;
	$return['content'] = $content;
	$return['sidebar'] = $sidebar;
	return $return;
}

/**
 * Pull together transitions variables for the save form
 *
 * @param ElggTransitions       $post
 * @param ElggAnnotation $revision
 * @return array
 */
function transitions_prepare_form_vars($post = NULL, $revision = NULL) {

	// input names => defaults
	$values = array(
		'title' => NULL,
		'description' => NULL,
		'status' => 'published',
		'access_id' => ACCESS_DEFAULT,
		'comments_on' => 'On',
		'excerpt' => NULL,
		'tags' => NULL,
		'container_guid' => NULL,
		'guid' => NULL,
		'draft_warning' => '',
		
		// Transitions² specific fields
		'attachment' => '',
		'url' => '',
		'category' => '',
		'lang' => '',
		'resource_lang' => '',
		// Conditionnal fields
		'territory' => '', // +geolocation
		'actor_type' => '',
		'start_date' => '',
		'end_date' => '',
		'start' => '',
		'end' => '',
		'rss_feed' => '',
	);

	if ($post) {
		foreach (array_keys($values) as $field) {
			if (isset($post->$field)) {
				$values[$field] = $post->$field;
			}
		}

		if ($post->status == 'draft') {
			$values['access_id'] = $post->future_access;
		}
	}

	if (elgg_is_sticky_form('transitions')) {
		$sticky_values = elgg_get_sticky_values('transitions');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}
	
	elgg_clear_sticky_form('transitions');

	if (!$post) {
		return $values;
	}

	// load the revision annotation if requested
	if ($revision instanceof ElggAnnotation && $revision->entity_guid == $post->getGUID()) {
		$values['revision'] = $revision;
		$values['description'] = $revision->value;
	}

	// display a notice if there's an autosaved annotation
	// and we're not editing it.
	$auto_save_annotations = $post->getAnnotations(array(
		'annotation_name' => 'transitions_auto_save',
		'limit' => 1,
	));
	if ($auto_save_annotations) {
		$auto_save = $auto_save_annotations[0];
	} else {
		$auto_save = false;
	}

	if ($auto_save && $auto_save->id != $revision->id) {
		$values['draft_warning'] = elgg_echo('transitions:messages:warning:draft');
	}

	return $values;
}


function transitions_remove_icon(ElggTransitions $transitions){
	$result = false;
	
	if(!empty($transitions) && elgg_instanceof($transitions, "object", "transitions", "ElggTransitions")){
		if(!empty($transitions->icontime)){
			if($icon_sizes = elgg_get_config('icon_sizes')){
				$fh = new ElggFile();
				$fh->owner_guid = $transitions->getOwnerGUID();
				$prefix = "transitions/" . $transitions->getGUID();
				// Remove original icon (if set)
				$fh->setFilename($prefix . 'original');
				if($fh->exists()){ $fh->delete(); }
				// Remove custom sizes
				foreach($icon_sizes as $name => $info){
					$fh->setFilename($prefix . $name . ".jpg");
					if($fh->exists()){ $fh->delete(); }
				}
			}
			
			unset($transitions->icontime);
			$result = true;
		} else {
			$result = true;
		}
	}
	
	return $result;
}


function transitions_remove_attachment(ElggTransitions $transitions, $name = 'attachment'){
	$result = false;
	
	if(!empty($transitions) && elgg_instanceof($transitions, "object", "transitions", "ElggTransitions")){
		if(!empty($transitions->{$name})){
			if($icon_sizes = elgg_get_config('icon_sizes')){
				$fh = new ElggFile();
				$fh->owner_guid = $transitions->getOwnerGUID();
				$prefix = "transitions/" . $transitions->getGUID();
				// Remove original icon (if set)
				$fh->setFilename($prefix . $transitions->{$name});
				if($fh->exists()){ $fh->delete(); }
			}
			unset($transitions->{$name});
			unset($transitions->{$name . '_name'});
			$result = true;
		} else {
			$result = true;
		}
	}
	
	return $result;
}


