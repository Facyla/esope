<?php
$user = $vars['entity'];
$db_prefix = elgg_get_config('dbprefix');

if (!empty($user->learner_group_b2i)) {
	if ($learner_group = get_entity($user->learner_group_b2i)) {
		// @TODO : Ici on vérifie qu'il en est bien membre.
		// @TODO : Si le groupe a changé, on quitte le premier et on rejoint le nouveau
		echo '<h3><a href="' . $learner_group->getURL() . '">' . $learner_group->name . '</a></h3><br />';
		elgg_push_context('widgets');
		$mygroup_activity = elgg_list_river(array(
				'limit' => 5, 'pagination' => false,
				'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
				'wheres' => array("(e1.container_guid = {$learner_group->guid})"),
			));
		if (!$mygroup_activity) { $mygroup_activity = '<p>' . elgg_echo('dashboard:widget:group:noactivity') . '</p>'; }
		elgg_pop_context();
		echo $mygroup_activity;
	} else {
		echo '<p>' . elgg_echo('dossierdepreuve:learner_group:invalid') . '</p>';
		echo '<p>' . elgg_echo('dossierdepreuve:learner_group:none:help') . '</p>';
		echo '<p><a class="elgg-button elgg-button-action" href="' . $vars['url'] . 'groups/all?filter=newest">' . elgg_echo('dossierdepreuve:groups:join') . '</a></p>';
	}
} else {
	echo '<p>' . elgg_echo('dossierdepreuve:learner_group:none') . '</p>';
	echo '<p>' . elgg_echo('dossierdepreuve:learner_group:none:help') . '</p>';
	echo '<p><a class="elgg-button elgg-button-action" href="' . $vars['url'] . 'dossierdepreuve/gestion">' . elgg_echo('dossierdepreuve:groups:join') . '</a></p>';
}

