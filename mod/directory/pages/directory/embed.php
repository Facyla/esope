<?php
gatekeeper();
//elgg_entity_gatekeeper($guid, "object", 'directory');

$id = get_input("id");

echo elgg_view("directory/embed", array('id' => $id));

