<?php
// Check if KDB fields apply in this context, and display them
$fields = knowledge_database_get_kdb_fields();
if (!$fields) { return; }

// Get edited entity
$entity = get_entity(get_input('guid'));

$fields_config = knowledge_database_get_kdb_fields_config();

//echo knowledge_database_render_fields($fields_config, array('entity' => $entity, 'role' => 'user', 'mode' => 'edit'));
echo knowledge_database_render_fields($fields_config, array('entity' => $entity));

/*
// Enable author autocomplete, based on previously used values for author
$autocomplete_author = esope_get_meta_values('kdb_author');
echo elgg_view('input/add_autocomplete', array('name' => 'kdb_author', 'autocomplete-data' => $autocomplete_author));

echo '<p><label>' . elgg_echo("knowledge_database:metadata:author") . ' ' . elgg_view('input/text', array('name' => 'kdb_author', 'value' => $entity->kdb_author)) . '</label>';
echo '<br /><em>' . elgg_echo('knowledge_database:metadata:author:details') . '</em></p>';

echo '</fieldset>';
*/


echo '<div class="clearfloat"></div>';

