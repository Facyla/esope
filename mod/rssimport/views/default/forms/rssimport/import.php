<?php

//	create form for import
echo elgg_view('input/hidden', array('name' => 'rssimportImport', 'id' => 'rssimportImport', 'value' => ''));
echo elgg_view('input/hidden', array('name' => 'feedid', 'id' => 'feedid', 'value' => $vars['entity']->guid));
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('rssimport:import:selected')));
	