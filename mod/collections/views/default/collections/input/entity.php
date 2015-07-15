<?php

echo '<div class="collection-edit-entity">
		<a href="javascript:void(0);" class="collection-edit-delete-entity" title="' . elgg_echo('collections:edit:deleteentity') . '" style="float:right; margin-left: 2ex;"><i class="fa fa-trash"></i></a>
		<label>' . elgg_echo('collections:edit:entities') . ' ' . elgg_view('input/entity_select', array('name' => 'entities[]', 'value' => $vars['value'])) . '</label>
		<label>' . elgg_echo('collections:edit:entities_comment') . ' ' . elgg_view('input/plaintext', array('name' => 'entities_comment[]', 'value' => $vars['value'])) . '</label>
	</div>';


