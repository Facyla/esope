<?php

$embed_type = get_input("embed_type");
$id = get_input("id");

//elgg_entity_gatekeeper($guid, "object", 'collection');

echo elgg_view("transitions/embed", array('id' => $id, 'embed_type' => $embed_type));

