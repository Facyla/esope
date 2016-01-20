<?php
/**
 * Elgg Market Plugin
 * @package market
 */

elgg_load_library('market');
 
// start a new sticky form session in case of failure
elgg_make_sticky_form('market');

// store errors to pass along
$error = FALSE;
$error_forward_url = REFERER;
$user = elgg_get_logged_in_user_entity();

// edit or create a new entity
$guid = get_input('guid');

if ($guid) {
	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'market') && $entity->canEdit()) {
		$post = $entity;
	} else {
		register_error(elgg_echo('market:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}
} else {
	$post = new ElggObject();
	$post->subtype = 'market';
	$new_post = true;
}

$values = array(
	'title' => '',
	'marketcategory' => '',
	'market_type' => '',
	'location' => '',
	'custom' => '',
	'description' => '',
	'price' => '',
	'access_id' => ACCESS_DEFAULT,
	'tags' => '',
	'container_guid' => (int)get_input('container_guid'),
	);

// fail if a required entity isn't set
$required = array('title', 'marketcategory', 'market_type', 'description');

// load from POST and do sanity and access checking
foreach ($values as $name => $default) {
	if ($name === 'title') {
		$value = htmlspecialchars(get_input('title', $default, false), ENT_QUOTES, 'UTF-8');
	} else {
		$value = get_input($name, $default);
	}

	if (in_array($name, $required) && empty($value)) {
		$error = elgg_echo("market:error:missing:$name");
	}

	if ($error) {
		break;
	}

	switch ($name) {
		case 'tags':
			$values[$name] = string_to_tag_array($value);
			break;

		case 'container_guid':
			// this can't be empty or saving the base entity fails
			if (!empty($value)) {
				if (can_write_to_container($user->getGUID(), $value)) {
					$values[$name] = $value;
				} else {
					$error = elgg_echo("market:error:cannot_write_to_container");
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

// assign values to the entity, stopping on error.
if (!$error) {
	foreach ($values as $name => $value) {
		$post->$name = $value;
	}
}

// only try to save base entity if no errors
if (!$error) {
	if ($post->save()) {
		// remove sticky form entries
		elgg_clear_sticky_form('market');

		system_message(elgg_echo('market:posted'));

		// add to river if changing status or published, regardless of new post
		// because we remove it for drafts.
		if ($new_post) {
			elgg_create_river_item(array(
					'view' => 'river/object/market/create',
					'action_type' => 'create',
					'subject_guid' => $user->guid,
					'object_guid' => $post->guid,
					));
		}

		// Image 1 upload
		if ((isset($_FILES['upload1']['name'])) && (substr_count($_FILES['upload1']['type'],'image/'))) {
			$imgdata1 = get_uploaded_file('upload1');
			market_add_image($post, $imgdata1, 1);
		}
		// Image 2 upload
		if ((isset($_FILES['upload2']['name'])) && (substr_count($_FILES['upload2']['type'],'image/'))) {
			$imgdata2 = get_uploaded_file('upload2');
			market_add_image($post, $imgdata2, 2);
		}
		// Image 3 upload
		if ((isset($_FILES['upload3']['name'])) && (substr_count($_FILES['upload3']['type'],'image/'))) {
			$imgdata3 = get_uploaded_file('upload3');
			market_add_image($post, $imgdata3, 3);
		}
		// Image 4 upload
		if ((isset($_FILES['upload4']['name'])) && (substr_count($_FILES['upload4']['type'],'image/'))) {
			$imgdata4 = get_uploaded_file('upload4');
			market_add_image($post, $imgdata4, 4);
		}
		forward($post->getURL());
	} else {
		register_error(elgg_echo('market:error:cannot_save'));
		forward($error_forward_url);
	}
} else {
	register_error($error);
	forward($error_forward_url);
}

