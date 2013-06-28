<?php

$default = 'page, page_top, blog, groupforumtopic, bookmarks, file';

echo '<label for="pdf_export-validsubtypes">' . elgg_echo('pdf_export:validsubtypes') . '</label>';

echo elgg_view('input/text', array(
	'name' => 'params[validsubtypes]',
	'id' => 'pdf_export-validsubtypes',
	'value' => $vars['entity']->validsubtypes ? $vars['entity']->validsubtypes : $default,
));

echo elgg_view('output/longtext', array(
	'value' => elgg_echo('pdf_export:validsubtypes:default', array($default)),
	'class' => 'elgg-subtext'
));
