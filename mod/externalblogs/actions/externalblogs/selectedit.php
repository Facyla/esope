<?php
/**
 * Elgg edit externablog action
 *
 */
/*
$guid = (int) get_input('guid');
$externalblog_param = get_input('externalblog_param');
$externalblog_ts = get_input('externalblog_ts');

// Let's see if we can get an entity with the specified GUID
$object = get_entity($guid);
if (!$object) {
  register_error('Pas de publication valide !');
  forward(REFERER);
}

$object->externalblog = $externalblog_param;
$object->externalblog_ts = $externalblog_ts;
$object->save();

system_message(elgg_echo("externablog:edited"));

// Forward back to the page where the user was
forward(REFERER);
*/

$entity_guid = (int) get_input('guid');
$externalblog_guid = (int) get_input('externalblog_guid');
$unselect = get_input('unselect', false);


// Let's see if we can get an entity with the specified GUID
$entity = get_entity($entity_guid);
if (!$entity) { register_error(elgg_echo("externalblogs:entitynotfound")); forward(REFERER); }

// We also need a valid externalblog
$externalblog = get_entity($externalblog_guid);
if (!elgg_instanceof($externablog, 'object', 'externablog')) { register_error(elgg_echo("externalblogs:notfound")); forward(REFERER); }

// limit externalblogs through a plugin hook (to prevent unwanted publication for example)
// plugins should register the error message to explain why externalblogging isn't allowed
if (!$externalblog->canEdit()) { forward(REFERER); }

$user = elgg_get_logged_in_user_entity();
// create_annotation($entity_guid, $name, $value, $value_type= '', $owner_guid=0, $access_id
//$annotation = create_annotation($entity->guid, 'externalblog', $externalblog_guid, "", $user->guid, $entity->access_id);
// add_entity_relationship($guid_one, $relationship, $guid_two)
//$ok = add_entity_relationship($entity->guid, 'externalblog', $externalblog_guid);
//make_attachment($guid_one, $guid_two)

// Changement d'action selon les paramètres passés : unselect
if ($unselect) {
	if (already_attached($externalblog->guid, $entity->guid)) {
		remove_attachment($externalblog->guid, $entity->guid);
	} else {
		register_error(elgg_echo("externalblogs:notblogged")); forward(REFERER);
	}
} else {
	if (!already_attached($externalblog->guid, $entity->guid)) {
		$ok = make_attachment($externalblog->guid, $entity->guid);
	} else {
		register_error(elgg_echo("externalblogs:alreadyblogged")); forward(REFERER);
	}
	if (!$ok) { register_error(elgg_echo("externalblogs:failure")); forward(REFERER); }
}


system_message(elgg_echo("externalblogs:externalbloged") . ' ' . $entity->title . ' in ' . $externalblog->title);

// Forward back to the page where the user 'externalbloged' the object
forward(REFERER);

