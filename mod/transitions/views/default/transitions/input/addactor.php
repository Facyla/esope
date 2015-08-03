<?php
/* Entity selector : can use a search (like embed or newsletter) and select an existing contents (using its GUID)
 */

// @TODO autocomplete field ?

echo '<a href="' . elgg_get_site_url() . 'transitions/embed/actor/actor-' . $vars['guid'] . '" class="elgg-lightbox">Sélectionner</a>';
// Fill field with lightbox
echo elgg_view('input/hidden', array('name' => 'actor_guid', 'id' => 'transitions-embed-actor-' . $vars['guid']));
echo '<div id="transitions-embed-details-actor-' . $vars['guid'] . '"></div>';

//echo elgg_view('input/text', array('name' => 'actor_guid', 'style' => "max-width:10em;"));

