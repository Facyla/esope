<?php
/**
 * Iris sidebar agenda view
 *
 */

$group = elgg_get_page_owner_entity();

if ($group->event_calendar_enable == 'yes') {
	elgg_push_context('widgets');
	$all_link = elgg_view('output/url', array(
		'href' => "groups/content/$group->guid/event_calendar/all",
		'text' => elgg_echo('workspace:event_calendar') . ' &nbsp; <i class="fa fa-angle-right"></i>',
		'is_trusted' => true,
	));
	if ($group->canWriteToContainer()) {
		$new_link = elgg_view('output/url', array(
			'href' => "event_calendar/add/$group->guid",
			'text' => '+', 
			'title' => elgg_echo('event_calendar:add'),
			'class' => "add-plus float-alt",
			'is_trusted' => true,
		));
	}

	$options = array('type' => 'object', 'subtype'=>'poll', 'limit' => 4, 'container_guid' => elgg_get_page_owner_guid());
	$content = '';
	
	$content .= elgg_view('event_calendar/calendar', array('original_start_date' => time(), 'filter' => '', 'group_guid' => $group->guid, 'region' => ''));
	
	
	$content .= elgg_view('event_calendar/groupprofile_calendar');
	elgg_pop_context();
	
	//if (!$content) { $content = '<p>'.elgg_echo("group:poll:empty").'</p>'; }


	echo '<div class="iris-sidebar-content">';
		echo '<div class="workspace-subtype-header">';
			echo $new_link;
			echo '<h3>' . $all_link . '</h3>';
		echo '</div>';
		echo '<div class="workspace-subtype-content">';
			echo $content;
		echo '</div>';
	echo '</div>';
}

