<?php
$group = $vars['entity'];

$full = elgg_extract('full_view', $vars, false);

$dbprefix = elgg_get_config("dbprefix");
// Get timeframe in seconds
$timeframe = elgg_extract('timeframe', $vars, false);
if (!empty($timeframe) && is_int($timeframe)) {
	$timeframe = time() - $timeframe;
} else {
	$timeframe =  time() - (180 * 24 * 60 * 60);
}

$ia = elgg_set_ignore_access(true);
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
		$days_frame = ceil($timeframe / 3600*24);
		echo '<span class="group-oldactivity group-oldactivity-' . $vars['size']. '" title="' . elgg_echo('esope:group:inactive:details', array($days_frame)) . '">';
		//echo '<i class="fa fa-warning"></i> ';
		echo elgg_echo('esope:group:inactive');
		echo '</span>';
	}
}

elgg_set_ignore_access($ia);

