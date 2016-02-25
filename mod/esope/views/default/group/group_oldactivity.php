<?php
$group = $vars['entity'];
if (!elgg_instanceof($group, 'group')) return;

$full = elgg_extract('full_view', $vars, false);

$ia = elgg_set_ignore_access(true);

// Ssi le groupe a été manuellement archivé
$groups_archive = elgg_get_plugin_setting('groups_archive', 'esope');
if ($groups_old_display != 'no') {
	if ($group->status == 'archive') {
		echo '<span class="group-archive group-archive-' . $vars['size']. '" title="' . elgg_echo('esope:group:archive:details') . '">';
		echo elgg_echo('esope:group:archive');
		echo '</span>';
	}
}


// Ssi le groupe a déjà un certain temps d'existence
$groups_old_display = elgg_get_plugin_setting('groups_old_display', 'esope');
if ($groups_old_display != 'no') {
	$dbprefix = elgg_get_config("dbprefix");
	$time = time();
	// Get timeframe in seconds
	$timeframe = elgg_extract('timeframe', $vars, false);
	if (!empty($timeframe) && is_int($timeframe)) {
		$timeframe = $time - $timeframe;
	} else {
		$groups_old_timeframe = elgg_get_plugin_setting('groups_old_timeframe', 'esope');
		if (!empty($groups_old_timeframe)) {
			$timeframe =  $time - $groups_old_timeframe;
		} else {
			$timeframe =  $time - (180 * 24 * 60 * 60); // 6 months
		}
	}
	// Note : besoin de vérifier car developpers utilise un ElggGroup non enregistré
	if ($group->guid) {
		$latest_river = elgg_get_river(array(
				'limit' => 1,
				'joins' => array("JOIN {$dbprefix}entities e1 ON e1.guid = rv.object_guid"),
				'wheres' => array(
						"(e1.container_guid = {$group->guid})",
						//"rv.posted <= $timeframe",
					),
			));
	}

	// Ssi le groupe a déjà un certain temps d'existence
	if ($group->time_created < $timeframe) {
		// Si pas de contenu ou si le dernier contenu est plus ancien qu'un certain temps => on prévient...
		if (!$latest_river || ($latest_river[0]->posted < $timeframe)) {
			if ($timeframe != $time) {
				$days_frame = ceil($timeframe / 3600*24);
				echo '<span class="group-oldactivity group-oldactivity-' . $vars['size']. '" title="' . elgg_echo('esope:group:inactive:details', array($days_frame)) . '">';
			} else {
				echo '<span class="group-oldactivity group-oldactivity-' . $vars['size']. '" title="' . elgg_echo('esope:group:inactive:details:never') . '">';
			}
			//echo '<i class="fa fa-warning"></i> ';
			echo elgg_echo('esope:group:inactive');
			echo '</span>';
		}
	}
}

elgg_set_ignore_access($ia);

