<?php

//	create form for import
echo '<div class="hidden rssimport-feeditems"></div>';
echo elgg_view('input/hidden', array('name' => 'feedid', 'id' => 'feedid', 'value' => $vars['entity']->guid));
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('rssimport:import:selected')));
	