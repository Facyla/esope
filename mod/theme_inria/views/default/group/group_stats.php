<?php
$group = $vars['entity'];
if (!elgg_instanceof($group, 'group')) { return; }

$ia = elgg_set_ignore_access(true);

/*
// Ssi le groupe a été manuellement archivé
$groups_archive = elgg_get_plugin_setting('groups_archive', 'esope');
if ($groups_old_display != 'no') {
	if ($group->status == 'archive') {
		echo '<div class="group-archive">';
		echo '<i class="fa fa-warning"></i> ' . elgg_echo('esope:group:archive');
		echo '</div>';
	}
}
*/

// Ssi le groupe a déjà un certain temps d'existence
//$groups_old_display = elgg_get_plugin_setting('groups_old_display', 'esope');
//if ($groups_old_display != 'no') {
$dbprefix = elgg_get_config("dbprefix");
// Get timeframe in seconds
$timeframe = elgg_extract('timeframe', $vars, false);
if (!empty($timeframe) && is_int($timeframe)) {
	$timeframe = time() - $timeframe;
	} else {
		$groups_old_timeframe = elgg_get_plugin_setting('groups_old_timeframe', 'esope');
		if (!empty($groups_old_timeframe)) {
			$timeframe =  time() - $groups_old_timeframe;
	} else {
		$timeframe =  time() - (180 * 24 * 60 * 60);
	}
}

$latest_river = elgg_get_river(array(
		'limit' => 1,
		'joins' => array("JOIN {$dbprefix}entities e1 ON e1.guid = rv.object_guid"),
		'wheres' => array(
				"(e1.container_guid = $group->guid)",
				//"rv.posted <= $timeframe",
			),
	));


// Ssi le groupe a déjà un certain temps d'existence
if ($group->time_created < $timeframe) {
	// Si pas de contenu ou si le dernier contenu est plus ancien qu'un certain temps => on prévient...
	if (!$latest_river || ($latest_river[0]->posted < $timeframe)) {
		echo '<div class="inria-group-oldactivity">';
		$latest_action = elgg_view_friendly_time($latest_river[0]->posted);
		if ($latest_river[0]->posted > 0) echo '<i class="fa fa-warning"></i> ' . elgg_echo('theme_inria:group:oldactivity', array($latest_action));
		else echo '<i class="fa fa-warning"></i> ' . elgg_echo('theme_inria:group:norecentactivity');
		//echo elgg_get_friendly_time($latest_river[0]->posted);
		echo '</div>';
	}
}
//}

elgg_set_ignore_access($ia);

