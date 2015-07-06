<?php
/* Entity selector : can use a search (like embed or newsletter) and select an existing contents (using its GUID)
 */

echo '<div class="collection-edit-slide">
		<a href="javascript:void(0);" class="collection-edit-delete-slide" title="' . elgg_echo('collections:edit:deleteslide') . '" style="float:right; margin-left: 2ex;"><i class="fa fa-trash"></i></a>
		<label>' . elgg_echo('collections:edit:slides') . ' ' . elgg_view('input/entity_select', array('name' => 'slides[]', 'value' => $vars['value'])) . '</label>
		<label>' . elgg_echo('collections:edit:slides_comment') . ' ' . elgg_view('input/longtext', array('name' => 'slides_comment[]', 'value' => $vars['value'])) . '</label>
	</div>';


