<?php
$group = $vars['entity'];

$dbprefix = elgg_get_config("dbprefix");

$timeframe =  time() - (180 * 24 * 60 * 60);

$latest_river = elgg_get_river(array(
		'limit' => 1,
		'joins' => array("JOIN {$dbprefix}entities e1 ON e1.guid = rv.object_guid"),
		'wheres' => array(
				"(e1.container_guid = $group->guid)",
				"rv.posted <= $timeframe",
			),
	));


// Si le dernier contenu date de plus de 6 mois => on prévient...
if ($latest_river) {
	echo '<div class="inria-group-oldactivity">';
	$latest_action = elgg_view_friendly_time($latest_river[0]->posted);
	echo '<i class="fa fa-warning"></i> ' . elgg_echo('theme_inria:group:oldactivity', array($latest_action));
	//echo elgg_get_friendly_time($latest_river[0]->posted);
	echo '</div>';
	
}

