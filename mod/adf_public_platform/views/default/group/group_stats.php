<?php
$group = $vars['entity'];

$dbprefix = elgg_get_config("dbprefix");
// Get timeframe in seconds
$timeframe = elgg_extract('timeframe', $vars, false);
if (!empty($timeframe) && is_int($timeframe)) {
	$timeframe = time() - $timeframe;
} else {
	$timeframe =  time() - (180 * 24 * 60 * 60);
}

$ia = elgg_get_ignore_access();
elgg_set_ignore_access(true);
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
		echo '<div class="group-oldactivity">';
		$latest_action = elgg_view_friendly_time($latest_river[0]->posted);
		if ($latest_river[0]->posted > 0) echo '<i class="fa fa-warning"></i> ' . elgg_echo('esope:group:oldactivity', array($latest_action));
		else  echo '<i class="fa fa-warning"></i> ' . elgg_echo('esope:group:norecentactivity');
		//echo elgg_get_friendly_time($latest_river[0]->posted);
		echo '</div>';
	}
}

elgg_set_ignore_access($ia);

