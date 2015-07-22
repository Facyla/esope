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
	// File attachment
	'attachment' => '',
	'url' => '',
	'category' => '',
	'resource_lang' => '',
	'lang' => '',
	// ssi category "actor" : territory + geolocation, actor_type
	'territory' => '', // +geolocation
	'actor_type' => '',
	// ssi category "project" : territory + geolocation, start_date + relation to actors
	'start_date' => '',
	// ssi category "event" : start_date, end_date, territory + geolocation
	'end_date' => '',
	// ssi challenge
	'rss_feed' => '',
);

// fail if a required entity isn't set
//$required = array('title', 'description');
$required = array('title');

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
	if ($lat && $long) {
		$transitions->setLatLong($lat, $long);
	}
}

// assign values to the entity, stopping on error.
if (!$error) {
	foreach ($values as $name => $value) {
		$transitions->$name = $value;
	}
}

// only try to save base entity if no errors
if (!$error) {
	if ($transitions->save()) {
		
		// handle icon upload
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
				// Save original image ?  not for icon ?
				/*
				$fh->setFilename($prefix . 'original');
				if($fh->open("write")){
					$fh->write($icon_file);
					$fh->close();
				}
				*/
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

		// handle icon upload
		if(get_input("remove_attachment") == "yes"){
			// remove existing icons
			transitions_remove_attachment($transitions);
		} else {
			//if ($attachment_file = get_uploaded_file('attachment')) {
			//if (($attachment_file = get_uploaded_file('attachment')) && ($_FILES['attachment']['size'] > 0)) {
			if (($attachment_file = get_uploaded_file('attachment')) && isset($_FILES['attachment']['name']) && !empty($_FILES['attachment']['name'])) {
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
			forward("transitions/edit/$transitions->guid");
		}
	} else {
		register_error(elgg_echo('transitions:error:cannot_save'));
		forward($error_forward_url);
	}
} else {
	register_error($error);
	forward($error_forward_url);
}
