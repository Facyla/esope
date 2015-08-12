<?php
gatekeeper();
//elgg_entity_gatekeeper($guid, "object", 'collection');

$id = get_input("id");

echo elgg_view("collections/embed", array('id' => $id));

