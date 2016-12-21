<?php
// Select file through a select
// param 'entities'

// Convert files to a valid select options array
if (!isset($vars['options_values']) && !empty($vars['entities'])) {
	$vars['options_values'][''] = elgg_echo('option:none');
	foreach ($vars['entities'] as $ent) {
		$title = $ent->title;
		if (empty($title)) { $title = $ent->name; }
		if (empty($title)) { $title = elgg_echo('esope:untitled'); }
		$vars['options_values'][$ent->guid] = $title;
	}
	unset($vars['entities']);
}

echo elgg_view('input/select', $vars);

