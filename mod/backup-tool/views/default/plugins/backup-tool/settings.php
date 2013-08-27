<?php

$backup_dir = $vars['entity']->backup_dir;

echo "<p>";
echo elgg_echo("backup-tool:settings:backup_dir");
echo elgg_view("input/text",array('name'=>'params[backup_dir]','value'=>$backup_dir));
echo "</p>";