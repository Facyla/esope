<?php
/* Entity selector : can use a search (like embed or newsletter) and select an existing contents (using its GUID)
 */

$value = $vars['value'];
$relation = $vars['relation'];

// @TODO autocomplete field ?
echo elgg_view('input/text', array('name' => 'entity_guid', 'style' => "max-width:10em;"));
echo elgg_view('input/hidden', array('name' => 'relation', 'value' => $relation));

