<?php
// Check if KDB fields apply in this context, and display them
$fields_config = knowledge_database_get_kdb_fields_config();
if (!$fields_config) { return; }

// Get rendered entity
$entity = $vars['entity'];


//echo knowledge_database_render_fields($fields_config, array('entity' => $entity, 'role' => 'user', 'mode' => 'edit'));
echo knowledge_database_render_fields($fields_config, array('entity' => $entity, 'mode' => 'view'));


echo '<div class="clearfloat"></div>';

