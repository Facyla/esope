<?php
/* Entity selector : can use a search (like embed or newsletter) and select an existing contents (using its GUID)
 */

$actor_guid = elgg_extract('actor_guid', $vars);
$name = elgg_extract('name', $vars, 'actor_guid');

echo '<div class="transitions-edit-contributed-actor">';
	echo '<a href="javascript:void(0);" class="transitions-edit-removeactor" title="' . elgg_echo('transitions:addactor:remove') . '" style="float:right; margin-left: 2ex;"><i class="fa fa-trash"></i></a>';

	echo '<p><a href="' . elgg_get_site_url() . 'catalogue/embed/actor/actor-' . $vars['guid'] . '" class="elgg-lightbox elgg-button elgg-button-action elgg-button-transitions-select"><i class="fa fa-search"></i> ' . elgg_echo('transitions:addactor:select') . '</a></p>';
	// Fill field with lightbox
	echo elgg_view('input/hidden', array('name' => $name, 'value' => $actor_guid, 'id' => 'transitions-embed-actor-' . $vars['guid']));
	echo '<blockquote id="transitions-embed-details-actor-' . $vars['guid'] . '">' . elgg_echo('transitions:addactor:noneselected') . '</blockquote>';

echo '</div>';
