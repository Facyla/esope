<?php

$guid = (int) get_input("guid");

//elgg_entity_gatekeeper($guid, "object", 'collection');

// Get collection by GUID or name
$collection = get_entity($guid);
if (!elgg_instanceof($collection, 'object', 'collection')) { $collection = collections_get_entity_by_name($guid); }

echo elgg_view("collections/embed", array("entity" => $entity));

