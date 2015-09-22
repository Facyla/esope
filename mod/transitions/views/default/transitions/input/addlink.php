<?php
/* Entity selector : can use a search (like embed or newsletter) and select an existing contents (using its GUID)
 */

$address = elgg_extract('address', $vars);
$comment = elgg_extract('comment', $vars);

echo '<div class="transitions-edit-contributed-link">';
	echo '<a href="javascript:void(0);" class="transitions-edit-removelink" title="' . elgg_echo('transitions:addlink:remove') . '" style="float:right; margin-left: 2ex;"><i class="fa fa-trash"></i></a>';

	echo elgg_view('input/text', array('name' => 'links[]', 'value' => $address, 'placeholder' => elgg_echo('transitions:links:placeholder')));
	echo elgg_view('input/text', array('name' => 'links_comment[]', 'value' => $comment, 'placeholder' => elgg_echo('transitions:links_comment:placeholder')));
echo '</div>';


