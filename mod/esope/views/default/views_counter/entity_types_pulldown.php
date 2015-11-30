<?php
	/**
	 * @file views/default/views_counter/entity_types_pulldown.php
	 * @brief Displays a pulldown with the entity types and subtypes that the views counter plugin may be added on
	 */

	$entity_type = ($vars['entity_type']) ? ($vars['entity_type']) : 'users';
	// Get the added types for add a views counter
	/*
	$valid_types = get_valid_types_for_views_counter();
	*/
	$valid_types = unserialize(elgg_get_plugin_setting('add_views_counter','views_counter'));
	if ($valid_types[0] == 'null') unset($valid_types[0]);
?>

<label>
	<?php
		echo elgg_echo('views_counter:select_type');
		echo elgg_view('input/dropdown',array('name'=>'entity_type','options' => $valid_types, 'value' => $entity_type));
	?>
</label>
