<?php

$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );
$default = 'page, page_top, blog, groupforumtopic, bookmarks, file';

// Enable export PDF enabled for subtypes
echo '<label for="pdf_export-validsubtypes">' . elgg_echo('pdf_export:validsubtypes') . '</label>';
echo elgg_view('input/text', array(
	'name' => 'params[validsubtypes]',
	'id' => 'pdf_export-validsubtypes',
	'value' => $vars['entity']->validsubtypes ? $vars['entity']->validsubtypes : $default,
));
// @TODO : List subtypes registered on this site (not default !)
echo elgg_view('output/longtext', array(
	'value' => elgg_echo('pdf_export:validsubtypes:default', array($default)),
	'class' => 'elgg-subtext'
));


// Allow to disable intro on generated PDF (useful metadata)
echo '<p><label>' . elgg_echo('pdf_export:disableintro') . elgg_view('input/dropdown', array( 'name' => 'params[disableintro]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->disableintro )) . '</label></p>';


