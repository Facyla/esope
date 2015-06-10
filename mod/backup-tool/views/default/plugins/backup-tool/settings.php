<?php

$backup_dir = $vars['entity']->backup_dir;
$backup_name = $vars['entity']->name ? $vars['entity']->name : "backup";

echo "<p>";
echo elgg_echo("backup-tool:settings:backup_dir");
echo elgg_view("input/text",array('name'=>'params[backup_dir]','value'=>$backup_dir));
echo "</p>";

echo "<p>";
echo elgg_echo("backup-tool:settings:backup_name");
echo elgg_view("input/text",array('name'=>'params[backup_name]','value'=>$backup_name));
echo "</p>";