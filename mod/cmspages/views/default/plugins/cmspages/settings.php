<?php

/* @todo : ce serait intéressant de pouvoir le définir indépendament d'externalblog aussi - on verra à l'usage
$layout_options = array( 
		'one_column' => elgg_echo('externalblog:settings:layout:one_column'), 
		'right_column' => elgg_echo('externalblog:settings:layout:right_column'), 
		'two_column' => elgg_echo('externalblog:settings:layout:two_column'), 
		'three_column' => elgg_echo('externalblog:settings:layout:three_column'), 
		'four_column' => elgg_echo('externalblog:settings:layout:four_column'), 
		'five_column' => elgg_echo('externalblog:settings:layout:five_column'), 
	);
*/
/*
$layout_options = array( 
		'' => elgg_echo('cmspages:settings:layout:default'), 
		'exbloglayout' => elgg_echo('cmspages:settings:layout:externalblog'), 
	);
echo '<br /><label style="clear:left;">' . elgg_echo('cmspages:settings:layout') . '</label>';
echo elgg_view('input/dropdown', array('name' => 'params[layout]', 'options_values' => $layout_options, 'value' => $vars['entity']->layout));
echo '<p>' . elgg_echo('cmspages:settings:layout:help') . '</p>';
*/

echo '<p>' . elgg_echo('cmspages:editurl') . ' <a href="' . $vars['url'] . 'cmspages/" class="elgg-button elgg-button-action">' . $vars['url'] . 'cmspages/</a></p>';

echo '<p><label style="clear:left;">' . elgg_echo('cmspages:settings:editors') . '</label>';
echo elgg_view('input/text', array('name' => 'params[editors]', 'value' => $vars['entity']->editors)) . '<br />';
echo elgg_echo('cmspages:settings:editors:help');
$editors = explode(',', $vars['entity']->editors);
// Affichage des éditeurs actuels
$users_count = elgg_get_entities(array('types' => 'user', 'guids' => $editors, 'count' => true));
if ($users_count > 0) {
	$users = elgg_get_entities(array('types' => 'user', 'guids' => $editors, 'limit' => 100));
	echo '<br /><strong>' . elgg_echo('cmspages:editors:list') . ' :</strong>';
	foreach ($users as $ent) {
		echo $ent->name . ' (' . $ent->guid . '), ';
	}
	if ($users_count > 100) echo '...';
}
echo '</p>';

/* Auteurs
echo '<p><label style="clear:left;">' . elgg_echo('cmspages:settings:authors') . '</label>';
echo elgg_view('input/text', array('name' => 'params[authors]', 'value' => $vars['entity']->authors)) . '<br />';
$editors = explode(',', $vars['entity']->authors);
echo elgg_echo('cmspages:settings:authors:help');
// Affichage des éditeurs actuels
$users_count = elgg_get_entities(array('types' => 'user', 'guids' => $authors, 'count' => true));
if ($users_count > 0) {
	$users = elgg_get_entities(array('types' => 'user', 'guids' => $authors, 'limit' => 100));
	echo '<br /><strong>' . elgg_echo('cmspages:authors:list') . ' :</strong>';
	foreach ($users as $ent) {
		echo $ent->name . ' (' . $ent->guid . '), ';
	}
	if ($users_count > 100) echo '...';
}
echo '</p>';
*/



