<?php
/**
 * River item footer
 *
 * @uses $vars['item'] ElggRiverItem
 * @uses $vars['responses'] Alternate override for this item
 */

// allow river views to override the response content
$responses = elgg_extract('responses', $vars, false);
if ($responses) {
	echo $responses;
	return;
}

$item = $vars['item'];
/* @var ElggRiverItem $item */
$object = $item->getObjectEntity();

// Iris : allow comments on responses (top object)
$top_object = esope_get_top_object_entity($object);
$container = esope_get_container_entity($object);
/*
$top_object = $object;
//error_log($object->guid .' // container='.$subtype . ' // object='.$object->getSubtype().' == '.print_r($vars['item'], true));
if (in_array($subtype, array('comment', 'discussion_reply', 'groupforumtopic'))) {
	while(elgg_instanceof($container, 'object')) {
		if (elgg_instanceof($container, 'object')) { $top_object = $container; }
		$parent_container = $container->getContainerEntity();
		if ($parent_container) { $container = $parent_container; }
	}
}
*/
// @TODO Handle comments
$subtype = $object->getSubtype();
if (in_array($subtype, array('comment', 'discussion_reply', 'groupforumtopic'))) {
//if ($top_object->guid != $object->guid) {
	// Avoid listing comments on users, groups, sites...
	$comment_count = $object->countComments();
	//if ($comment_count) {
	// Iris : pas de listing ici
	/*
	if ($comment_count && elgg_instanceof($object, 'object')) {
		$comments = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'comment',
			'container_guid' => $object->getGUID(),
			'limit' => 3,
			'order_by' => 'e.time_created desc',
			'distinct' => false,
		));

		// why is this reversing it? because we're asking for the 3 latest
		// comments by sorting desc and limiting by 3, but we want to display
		// these comments with the latest at the bottom.
		$comments = array_reverse($comments);

		echo elgg_view_entity_list($comments, array('list_class' => 'elgg-river-comments'));

		if ($comment_count > count($comments)) {
			$url = $object->getURL();
			$params = array(
				'href' => $url,
				'text' => elgg_echo('river:comments:all', array($comment_count)),
				'is_trusted' => true,
			);
			$link = elgg_view('output/url', $params);
			echo "<div class=\"elgg-river-more\">$link</div>";
		}
	}
	*/

	// inline comment form
	if ($top_object->canComment()) {
		$form_vars = array('id' => "comments-add-{$object->getGUID()}-{$top_object->guid}", 'class' => 'hidden');
		$body_vars = array('entity' => $top_object, 'inline' => true);
		echo elgg_view_form('comment/save', $form_vars, $body_vars);
	}
	return true;
} else  if ($subtype == 'thewire') {
		$form_vars = array('class' => 'thewire-form', 'action' => 'action/thewire/add');
		$thewire_form .= '<div id="comments-add-' . $object->getGUID() . '-' . $top_object->guid . '" class="thewire-reply-inline hidden">';
		$wire_container = $object->getContainerEntity();
		if (elgg_instanceof($wire_container, 'group')) {
			$thewire_form .= elgg_view_form('thewire/group_add', $form_vars, array('entity' => $wire_container, 'post' => $object));
		} else {
			$thewire_form .= elgg_view_form('thewire/add', $form_vars, array('post' => $object));
		}
		$thewire_form .= '</div>';
		echo $thewire_form;
}


// annotations and comments do not have responses
//if ($item->annotation_id != 0 || !$object || $object instanceof ElggComment) {
if ($item->annotation_id != 0 || !$object || $object instanceof ElggComment) { return; }

$comment_count = $object->countComments();

// Avoid listing comments on users, groups, sites...
//if ($comment_count) {
/*
//if ($comment_count && elgg_instanceof($object, 'object')) {
	$comments = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'comment',
		'container_guid' => $object->getGUID(),
		'limit' => 3,
		'order_by' => 'e.time_created desc',
		'distinct' => false,
	));

	// why is this reversing it? because we're asking for the 3 latest
	// comments by sorting desc and limiting by 3, but we want to display
	// these comments with the latest at the bottom.
	$comments = array_reverse($comments);

	echo elgg_view_entity_list($comments, array('list_class' => 'elgg-river-comments'));

	if ($comment_count > count($comments)) {
		$url = $object->getURL();
		$params = array(
			'href' => $url,
			'text' => elgg_echo('river:comments:all', array($comment_count)),
			'is_trusted' => true,
		);
		$link = elgg_view('output/url', $params);
		echo "<div class=\"elgg-river-more\">$link</div>";
	}
}
*/

// inline comment form
// @TODO handle forum replies (status = open|closed)
if ($object->canComment()) {
	$form_vars = array('id' => "comments-add-{$object->getGUID()}-{$top_object->guid}", 'class' => 'hidden');
	$body_vars = array('entity' => $object, 'inline' => true);
	echo elgg_view_form('comment/save', $form_vars, $body_vars);
}

