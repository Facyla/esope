<?php
// Accept name and/or metadata values
$name = $vars['name'];
$metadata = $vars['metadata'];
if (empty($name)) $name = $metadata;
if (empty($metadata)) $metadata = $name;

// Allow empty select (except if we chose multiselect, as we can choose no value)
if ($vars['addempty'] && !$vars['multiple']) {
	$meta_values = knowledge_database_build_options($metadata, true);
} else {
	$meta_values = knowledge_database_build_options($metadata, false);
}


//$value = $vars['entity']->{$name};
$value = $vars['entity']->{$name};
//echo print_r($value, true);

// Allow multiple select
if ($vars['multiple']) {
	$selector = elgg_view('input/multiselect', array('name' => $name, 'value' => $value, 'options_values' => $meta_values, 'style' => "max-width:20ex;"));
} else {
	$selector = elgg_view('input/select', array('name' => $name, 'value' => $value, 'options_values' => $meta_values, 'style' => "max-width:20ex;"));
}

echo '<label>' . ucfirst(elgg_echo("knowledge_database:metadata:$metadata")) . ' ' . $selector . '</label>';

