<?php
/* Entity selector : can use a search (like embed or newsletter) and select an existing contents (using its GUID)
 */

elgg_load_js("lightbox");
elgg_load_css("lightbox");
elgg_require_js("collections/embed");

$value = $vars['value'];

echo '<a href="' . elgg_get_site_url() . 'collection/embed/' . $guid . '" class="elgg-longtext-control elgg-lightbox">' . elgg_echo("collections:select_entity") . '</a>';

// @TODO autocomplete field ?

echo elgg_view('input/text', array('name' => 'entities[]', 'value' => $value));


