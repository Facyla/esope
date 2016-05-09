<?php
// @TODO : Add KDB info to object rendering

echo "!!! KDB FIELDS OUTPUT HERE !!!";

// Check if KDB fields apply in this context, and display them
$fields = knowledge_database_get_kdb_fields();
if (!$fields) { return; }

// Get edited entity
$entity = $vars['entity'];


$fields_config = array();
// Build full fields config array
foreach ($fields as $key) {
	$field_config = elgg_get_plugin_setting('field_' . $key, 'knowledge_database');
	$field_config = unserialize($field_config);
	$fields_config[$key] = $field_config;
	echo "FIELD : $field<br />";
}

//echo knowledge_database_render_fields($fields_config, array('entity' => $entity, 'role' => 'user', 'mode' => 'edit'));
echo knowledge_database_render_fields($fields_config, array('entity' => $entity, 'mode' => 'view'));


echo '<div class="clearfloat"></div>';

