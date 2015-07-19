<?php
/* Entity selector : can use a search (like embed or newsletter) and select an existing contents (using its GUID)
 */

// @TODO autocomplete field ?
echo elgg_view('input/text', array('name' => 'actor_guid', 'style' => "max-width:10em;"));

