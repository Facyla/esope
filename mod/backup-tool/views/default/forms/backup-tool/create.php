<?php
//display backup options
echo elgg_view("forms/backup-tool/backup-options");

//display submit button
echo elgg_view("input/submit",array('value'=>elgg_echo('create')));
