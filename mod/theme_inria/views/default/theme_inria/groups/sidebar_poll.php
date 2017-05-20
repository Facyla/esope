<?php
/**
 * Iris sidebar poll view
 *
 */

elgg_load_library('elgg:poll');
elgg_require_js('elgg/poll/poll');

$group = elgg_get_page_owner_entity();

if (poll_activated_for_group($group)) {
	elgg_push_context('widgets');
	$all_link = elgg_view('output/url', array(
		'href' => "groups/content/$group->guid/poll/all",
		'text' => elgg_echo('poll:group_poll') . ' &nbsp; <i class="fa fa-angle-right"></i>',
		'is_trusted' => true,
	));
	$new_link = elgg_view('output/url', array(
		'href' => "poll/add/$group->guid",
		'text' => '+', //elgg_echo('poll:addpost'),
		'class' => "add-plus float-alt",
		'is_trusted' => true,
	));

	$options = array('type' => 'object', 'subtype'=>'poll', 'limit' => 4, 'container_guid' => elgg_get_page_owner_guid());
	$content = '';
	if ($poll_found = elgg_get_entities($options)) {
		foreach ($poll_found as $poll) {
			$content .= elgg_view('poll/widget', array('entity' => $poll));
		}
	}
	elgg_pop_context();
	if (!$content) {
	  $content = '<p>'.elgg_echo("group:poll:empty").'</p>';
	}


	echo '<div class="workspace-subtype-header">';
		echo $new_link;
		echo '<h3>' . $all_link . '</h3>';
	echo '</div>';
	echo '<div class="workspace-subtype-content">';
		echo $content;
	echo '</div>';
}

