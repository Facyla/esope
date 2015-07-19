<?php

$id = get_input("id");

//elgg_entity_gatekeeper($guid, "object", 'collection');

echo elgg_view("collections/embed", array('id' => $id));

