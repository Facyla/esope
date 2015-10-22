<?php
/* Entity selector : can use a search (like embed or newsletter) and select an existing contents (using its GUID)
 */

$actor_guid = elgg_extract('actor_guid', $vars);

echo '<p><a href="' . elgg_get_site_url() . 'catalogue/embed/actor/actor-' . $vars['guid'] . '" class="elgg-lightbox elgg-button elgg-button-action">' . elgg_echo('transitions:addactor:select') . '</a></p>';
// Fill field with lightbox
echo elgg_view('input/hidden', array('name' => 'actor_guid', 'value' => $actor_guid, 'id' => 'transitions-embed-actor-' . $vars['guid']));
echo '<blockquote id="transitions-embed-details-actor-' . $vars['guid'] . '">' . elgg_echo('transitions:addactor:noneselected') . '</blockquote>';

//echo elgg_view('input/text', array('name' => 'actor_guid', 'style' => "max-width:10em;"));

