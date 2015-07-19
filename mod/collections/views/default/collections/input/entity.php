<?php

$guid = $vars['entity_guid'];
$comment = $vars['entity_comment'];

elgg_load_js("lightbox");
elgg_load_css("lightbox");
elgg_require_js("collections/embed");

echo '<div class="collection-edit-entity">';

echo '<a href="javascript:void(0);" class="collection-edit-delete-entity" title="' . elgg_echo('collections:edit:deleteentity') . '" style="float:right; margin-left: 2ex;"><i class="fa fa-trash"></i></a>';

//echo '<label>' . elgg_echo('collections:edit:entities') . ' ' . elgg_view('input/entity_select', array('name' => 'entities[]', 'value' => $guid)) . '</label>';
echo '<a href="' . elgg_get_site_url() . 'collection/embed/' . $guid . '" class="elgg-longtext-control elgg-lightbox">' . elgg_echo("collections:select_entity") . '</a>';
// @TODO autocomplete field ?
echo elgg_view('input/text', array('name' => 'entities[]', 'value' => $guid));

echo '<label>' . elgg_echo('collections:edit:entities_comment') . ' ' . elgg_view('input/plaintext', array('name' => 'entities_comment[]', 'value' => $comment)) . '</label>';

echo '</div>';


