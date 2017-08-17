<?php
/**
 * List replies with optional add form
 *
 * @uses $vars['entity']        ElggEntity the group discission
 * @uses $vars['show_add_form'] Display add form or not
 */

$show_add_form = elgg_extract('show_add_form', $vars, true);

echo '<div id="group-replies" class="elgg-comments">';

$replies = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'discussion_reply',
	'container_guid' => $vars['topic']->getGUID(),
	'reverse_order_by' => true,
	'distinct' => false,
	'url_fragment' => 'group-replies',
));

if ($replies) {
	echo '<h3 id="comments">' . elgg_echo('comments') . '</h3>';
	echo $replies;
}

if ($show_add_form) {
	$form_id = esope_unique_id('iris-comments-');
	echo elgg_view('output/url', array('href' => '#' . $form_id, 'rel' => 'toggle', 'text' => elgg_echo('comment:toggle'), 'class' => 'elgg-button elgg-button-action elgg-button-comment-toggle'));
	$form_vars = array('class' => 'mtm hidden', 'id' => $form_id);
	echo elgg_view_form('discussion/reply/save', $form_vars, $vars);
}

echo '</div>';
