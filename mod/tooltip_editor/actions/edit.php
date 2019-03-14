<?php

$token = get_input('token');
$params = get_input('params');

if (empty($token) || !is_array($params)) {
	register_error(elgg_echo('tooltip_editor:invalid:token'));
	forward(REFERER);
}

// see if we have an existing annotation
// not using annotations just to keep it light
$annotations = elgg_get_annotations(array(
	'guid' => elgg_get_site_entity()->guid,
	'annotation_names' => array('tooltip-editor-' . $token),
	'limit' => 1
));

if ($annotations) {
	$annotation = $annotations[0];
	$annotation->value = serialize($params);
	$annotation->access_id = ACCESS_PUBLIC;
	$annotation->save();
}
else {
	elgg_get_site_entity()->annotate('tooltip-editor-' . $token, serialize($params), ACCESS_PUBLIC);
}

system_message(elgg_echo('tooltip_editor:update:success'));
forward(REFERER);