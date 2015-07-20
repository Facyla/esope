<?php
/* Entity selector : can use a search (like embed or newsletter) and select an existing contents (using its GUID)
 */

$value = $vars['value'];
$relation = $vars['relation'];

// @TODO autocomplete field ?

echo '<a href="' . elgg_get_site_url() . 'transitions/embed/entity/entity-' . $vars['guid'] . '" class="elgg-lightbox">Sélectionner</a>';
// Fill field with lightbox
echo elgg_view('input/hidden', array('name' => 'entity_guid', 'id' => 'transitions-embed-entity-' . $vars['guid']));
echo '<div id="transitions-embed-details-entity-' . $vars['guid'] . '"></div>';

//echo elgg_view('input/text', array('name' => 'entity_guid', 'style' => "max-width:10em;"));
echo elgg_view('input/hidden', array('name' => 'relation', 'value' => $relation));

