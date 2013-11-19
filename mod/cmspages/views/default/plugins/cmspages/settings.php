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

echo '<p>Pour éditer les pages CMS, rendez-vous sur <a href="' . $vars['url'] . 'cmspages/">' . $vars['url'] . 'cmspages/</a></p>';

echo '<p><label style="clear:left;">' . elgg_echo('cmspages:settings:editors') . '</label>';
echo elgg_view('input/text', array('name' => 'params[editors]', 'value' => $vars['entity']->editors)) . '<br />';
echo elgg_echo('cmspages:settings:editors:help') . '<br /><strong>Liste des membres :</strong>';
$users_count = elgg_get_entities(array('types' => 'user', 'count' => true));
$users = elgg_get_entities(array('types' => 'user', 'limit' => 100));
foreach ($users as $ent) {
  echo $ent->name . ' (' . $ent->guid . '), ';
}
if ($users_count > 100) echo '...';
echo '</p>';

