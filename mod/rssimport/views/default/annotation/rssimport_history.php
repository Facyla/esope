<?php

$history = $vars['annotation'];
$ids = explode(',', $history->value);

echo '<div class="rssimport_history_item">';
echo "<h4>" . elgg_echo('rssimport:imported:on') . " " . date(elgg_echo('rssimport:date:format'), $history->time_created) . "<h4>";

//create links to each entity imported on that occasion
foreach ($ids as $id) {
	$entity = get_entity($id);
	if (!$entity) {
		continue;
	}
	echo elgg_view_entity($entity, array(
		'full_view' => false
	));
}


echo elgg_view('output/url', array(
	'href' => "action/rssimport/undoimport?id=" . $history->id,
	'text' => elgg_echo('rssimport:undo:import'),
	'is_action' => true,
	'confirm' => elgg_echo('rssimport:undo:import:confirm'),
	'class' => 'elgg-button elgg-button-action'
));
echo '</div>';
