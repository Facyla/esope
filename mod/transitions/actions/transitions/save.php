<?php
/**
 * Save transitions entity
 *
 * Can be called by clicking save button or preview button. If preview button,
 * we automatically save as draft. The preview button is only available for
 * non-published drafts.
 *
 * Drafts are saved with the access set to private.
 *
 * @package Transitions
 */

// start a new sticky form session in case of failure
elgg_make_sticky_form('transitions');

elgg_load_library('elgg:transitions');

if (elgg_is_active_plugin('theme_transitions2')) {
	$is_admin = theme_transitions2_user_is_content_admin();
} else {
	$is_admin = elgg_is_admin_logged_in();
}

/* Direct registration ?
$register_first = !elgg_is_logged_in();
if ($register_first) {
	$
}
*/

// save or preview
$save = (bool)get_input('save');

// store errors to pass along
$error = FALSE;
$error_forward_url = REFERER;
$user = elgg_get_logged_in_user_entity();

// edit or create a new entity
$guid = get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'transitions') && $entity->canEdit()) {
		$transitions = $entity;
	} else {
		register_error(elgg_echo('transitions:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}

	// save some data for revisions once we save the new edit
	$revision_text = $transitions->description;
	$new_post = $transitions->new_post;
} else {
	$transitions = new ElggTransitions();
	$transitions->subtype = 'transitions';
	$transitions->owner_guid = elgg_get_logged_in_user_guid();
	$transitions->container_guid = elgg_get_logged_in_user_guid();
	$new_post = TRUE;
}

// set the previous status for the hooks to update the time_created and river entries
$old_status = $transitions->status;

// set defaults and required values.
// Note : access is always public + comments are always enabled
$values = array(
	'title' => '',
	'description' => '',
	'status' => 'draft',
	//'access_id' => ACCESS_PUBLIC,
	//'comments_on' => 'On',
	'excerpt' => '',
	'tags' => '',
	'container_guid' => (int)get_input('container_guid'),
	// File attachment and icon : not a regular metadata (would be overridden when saving)
	'url' => '',
	'category' => '',
	'lang' => '',
	'resource_lang' => '',
	'collection' => '',
);

/* Conditional fields (based on category)
 * ssi category "actor" : territory + geolocation, actor_type
 * ssi category "project" : territory + geolocation, start_date + relation to actors
 * ssi category "event" : start_date, end_date, territory + geolocation
 */
$category = get_input('category', '');
if (!empty($category)) {
	// Territory + geolocation
	if (in_array($category, array('actor', 'project', 'event'))) {
		$values['territory'] = '';
	}
	// Actor type
	if (in_array($category, array('actor'))) {
		$values['actor_type'] = '';
	}
	// Text dates
	if (in_array($category, array('project'))) {
		$values['start'] = '';
		$values['end'] = '';
	}
	// Dates and Times
	if (in_array($category, array('event'))) {
		$values['start_date'] = '';
		$values['start_time'] = '';
		$values['end_date'] = '';
		$values['end_time'] = '';
	}
	// Challenge => news feed (to be displayed)
	if (in_array($category, array('challenge'))) {
		$values['rss_feed'] = '';
		$values['challenge_elements'] = '';
	}
}


// fail if a required entity isn't set
//$required = array('title', 'description');
$required = array('title', 'category');

// load from POST and do sanity and access checking
foreach ($values as $name => $default) {
	if ($name === 'title') {
		$value = htmlspecialchars(get_input('title', $default, false), ENT_QUOTES, 'UTF-8');
	} else {
		$value = get_input($name, $default);
	}

	if (in_array($name, $required) && empty($value)) {
		$error = elgg_echo("transitions:error:missing:$name");
	}

	if ($error) {
		break;
	}

	switch ($name) {
		case 'tags':
			$values[$name] = string_to_tag_array($value);
			break;

		case 'excerpt':
			if ($value) {
				$values[$name] = elgg_get_excerpt($value);
			}
			break;

		case 'container_guid':
			// this can't be empty or saving the base entity fails
			if (!empty($value)) {
				if (can_write_to_container($user->getGUID(), $value)) {
					$values[$name] = $value;
				} else {
					$error = elgg_echo("transitions:error:cannot_write_to_container");
				}
			} else {
				unset($values[$name]);
			}
			break;

		default:
			$values[$name] = $value;
			break;
	}
}

// Set some fixed values
$values['access_id'] = ACCESS_PUBLIC;
$values['comments_on'] = 'On';

// if preview, force status to be draft
if ($save == false) {
	$values['status'] = 'draft';
}

// if draft, set access to private and cache the future access
if ($values['status'] == 'draft') {
	$values['future_access'] = $values['access_id'];
	$values['access_id'] = ACCESS_PRIVATE;
}

// Geocode new location
if (!empty($values['territory']) && ($values['territory'] != $transitions->territory)) {
	$geo_location = elgg_trigger_plugin_hook('geocode', 'location', array('location' => $values['territory']), false);
	$lat = (float)$geo_location['lat'];
	$long = (float)$geo_location['long'];
	if ($lat && $long) { $transitions->setLatLong($lat, $long); }
}

// Adjust dates and optional time
// Note : mktime($hour, $minute, $second, $month, $day, $year);
// Optional times : set to exact time
if (in_array($category, array('event'))) {
	$year = date('Y', $values['start_date']);
	$month = date('n', $values['start_date']);
	$day = date('j', $values['start_date']);
	$hour = floor($values['start_time']/60);
	$minute = ($values['start_time'] - 60*$hour);
	$values['start_date'] = mktime($hour, $minute, 0, $month, $day, $year);
	//echo "{$values['start_date']} à {$values['start_time']} => $day/$month/$year à $hour:$minute<br />";
	unset($values['start_time']);
	
	$year = date('Y', $values['end_date']);
	$month = date('n', $values['end_date']);
	$day = date('j', $values['end_date']);
	$hour = floor($values['end_time']/60);
	$minute = ($values['end_time'] - 60*$hour);
	$values['end_date'] = mktime($hour, $minute, 0, $month, $day, $year);
	//echo "{$values['end_date']} à {$values['end_time']} => $day/$month/$year à $hour:$minute<br />";
	unset($values['end_time']);
}
/* Now we consider these dates as free text input, and changed to 'start' and 'end'
if (in_array($category, array('project'))) {
	// Dates : set full days from 00:00 to 23:59
	$year = date('Y', $values['start_date']);
	$month = date('n', $values['start_date']);
	$day = date('j', $values['start_date']);
	$values['start_date'] = mktime(0, 0, 0, $month, $day, $year);
	
	$year = date('Y', $values['end_date']);
	$month = date('n', $values['end_date']);
	$day = date('j', $values['end_date']);
	$values['end_date'] = mktime(23, 59, 0, $month, $day, $year);
}
*/

// assign values to the entity, stopping on error.
if (!$error) {
	foreach ($values as $name => $value) {
		$transitions->$name = $value;
	}
}

// Handle admin-reserved fields
if ($is_admin) {
	$tags_contributed = get_input('tags_contributed', null);
	$new_tags_contributed = array();
	// Replace existing tags
	if (!empty($tags_contributed)) {
		$new_tags = string_to_tag_array($tags_contributed);
		//$new_tags_contributed = (array)$entity->tags_contributed;
		foreach($new_tags as $tag) { $new_tags_contributed[] = $tag; }
		$new_tags_contributed = array_unique($tags_contributed);
		$new_tags_contributed = array_filter($tags_contributed);
	}
	$entity->tags_contributed = $new_tags_contributed;
	
	/*
	$links_invalidates = get_input('links_invalidates');
	// Add new contradictory link
	if (!empty($links_invalidates)) {
		$links_invalidates = str_replace(array("\n", "\r"), ',', $links_invalidates);
		$links_invalidates = string_to_tag_array($links_invalidates);
		$links_invalidates = array_unique($links_invalidates);
		$links_invalidates = array_filter($links_invalidates);
		$entity->links_invalidates = $links_invalidates;
	}
	$links_supports = get_input('links_supports');
	// Add new support link
	if (!empty($links_supports)) {
		$links_supports = str_replace(array("\n", "\r"), ',', $links_supports);
		$links_supports = string_to_tag_array($links_supports);
		$links_supports = array_unique($links_supports);
		$links_supports = array_filter($links_supports);
		$entity->links_supports = $links_supports;
	}
	*/
	$links = (array) get_input('links');
	$links_comment = (array) get_input('links_comment');
	/*
	// Dédoublonnage : pas besoin pour admins...
	$contributed_links = array();
	$contributed_links_comment = array();
	if ($links) foreach ($links as $k => $link) {
		if (!in_array($link, $contributed_links) || ($links_comment[$k] != $contributed_links_comment[$k])) {
			$contributed_links[] = $link;
			$contributed_links[] = $links_comment[$k];
		}
	}
	$entity->links = $contributed_links;
	$entity->links_comment = $contributed_links_comment;
	*/
	$entity->links = $links;
	$entity->links_comment = $links_comment;
	
	// Manage contributed actors
	$actor_guids = (array) get_input('actor_guid');
	$contributed_actors_ent = elgg_get_entities_from_relationship(array(
			'type' => 'object',
			'subtype' => 'transitions',
			'relationship' => 'partner_of',
			'relationship_guid' => $entity->guid,
			'inverse_relationship' => true,
			'limit' => 0,
		));
	// Remove deleted relationships
	if ($contributed_actors_ent) {
		foreach($contributed_actors_ent as $ent) {
			if (!in_array($ent->guid, $actor_guids)) {
				remove_entity_relationship($ent->guid, 'partner_of', $entity->guid);
			}
		}
	}
	// Add missing relationship
	foreach ($actor_guids as $actor_guid) {
		$actor = get_entity($actor_guid);
		if (elgg_instanceof($actor, 'object', 'transitions') && ($actor->category == 'actor')) {
			add_entity_relationship($actor_guid, 'partner_of', $entity->guid);
		}
	}
	
	$owner_username = get_input('owner_username', '');
	if (!empty($owner_username)) {
		$new_owner = get_user_by_username($owner_username);
		if (elgg_instanceof($new_owner, 'user')) {
			$entity->owner_guid = $new_owner->guid;
			$entity->container_guid = $new_owner->guid;
		}
	}
	
	$featured = get_input('featured', '');
	// Set incremental status
	if (!empty($featured)) {
		if ($featured == 'featured') {
			$entity->featured = 'featured';
		} else if ($featured == 'background') {
			$entity->featured = 'background';
		} else {
			$entity->featured = null;
		}
	}
	
}

// only try to save base entity if no errors
if (!$error) {
	if ($transitions->save()) {
		
		// Icon upload
		if(get_input("remove_icon") == "yes"){
			// remove existing icons
			transitions_remove_icon($transitions);
		} else {
			//$has_uploaded_icon = (!empty($_FILES['icon']['type']) && substr_count($_FILES['icon']['type'], 'image/'));
			// Autres dimensions, notamment recadrage pour les vignettes en format carré définies via le thème
			$icon_sizes = elgg_get_config("icon_sizes");
			if ($icon_file = get_resized_image_from_uploaded_file("icon", 100, 100)) {
				// create icon
				$prefix = "transitions/" . $transitions->getGUID();
				$fh = new ElggFile();
				$fh->owner_guid = $transitions->getOwnerGUID();
				foreach($icon_sizes as $icon_name => $icon_info){
					if($icon_file = get_resized_image_from_uploaded_file("icon", $icon_info["w"], $icon_info["h"], $icon_info["square"], $icon_info["upscale"])){
						$fh->setFilename($prefix . $icon_name . ".jpg");
						if($fh->open("write")){
							$fh->write($icon_file);
							$fh->close();
						}
					}
				}
				$transitions->icontime = time();
			}
		}

		// Attachment upload
		if(get_input("remove_attachment") == "yes"){
			// remove existing icons
			transitions_remove_attachment($transitions);
		} else {
			//if ($attachment_file = get_uploaded_file('attachment')) {
			//if (($attachment_file = get_uploaded_file('attachment')) && ($_FILES['attachment']['size'] > 0)) {
			// Empty file => Array ( [name] => [type] => [tmp_name] => [error] => 4 [size] => 0 )
			if (isset($_FILES['attachment']['name']) && !empty($_FILES['attachment']['name']) && ($attachment_file = get_uploaded_file('attachment'))) {
				// create file
				$prefix = "transitions/" . $transitions->getGUID();
				$fh = new ElggFile();
				$fh->owner_guid = $transitions->getOwnerGUID();
				$attachment_url = 'attachment_' . time();
				$attachment_name = htmlspecialchars($_FILES['attachment']['name'], ENT_QUOTES, 'UTF-8');
				$fh->setFilename($prefix . $attachment_url);
				if($fh->open("write")){
					$fh->write($attachment_file);
					$fh->close();
				}
				$transitions->attachment = $attachment_url;
				$transitions->attachment_name = $attachment_name;
			}
		}
		
		// remove sticky form entries
		elgg_clear_sticky_form('transitions');

		// remove autosave draft if exists
		$transitions->deleteAnnotations('transitions_auto_save');

		// no longer a brand new post.
		$transitions->deleteMetadata('new_post');

		// if this was an edit, create a revision annotation
		if (!$new_post && $revision_text) {
			$transitions->annotate('transitions_revision', $revision_text);
		}

		system_message(elgg_echo('transitions:message:saved'));

		$status = $transitions->status;

		// add to river if changing status or published, regardless of new post
		// because we remove it for drafts.
		if (($new_post || $old_status == 'draft') && $status == 'published') {
			elgg_create_river_item(array(
				'view' => 'river/object/transitions/create',
				'action_type' => 'create',
				'subject_guid' => $transitions->owner_guid,
				'object_guid' => $transitions->getGUID(),
			));

			elgg_trigger_event('publish', 'object', $transitions);

			// reset the creation time for posts that move from draft to published
			if ($guid) {
				$transitions->time_created = time();
				$transitions->save();
			}
		} elseif ($old_status == 'published' && $status == 'draft') {
			elgg_delete_river(array(
				'object_guid' => $transitions->guid,
				'action_type' => 'create',
			));
		}

		if ($transitions->status == 'published' || $save == false) {
			forward($transitions->getURL());
		} else {
			forward("catalogue/edit/$transitions->guid");
		}
	} else {
		register_error(elgg_echo('transitions:error:cannot_save'));
		forward($error_forward_url);
	}
} else {
	register_error($error);
	forward($error_forward_url);
}
