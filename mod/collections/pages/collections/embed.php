<?php

$guid = (int) get_input("guid");

//elgg_entity_gatekeeper($guid, "object", 'collection');

$entity = get_entity($guid);

echo elgg_view("collections/embed", array("entity" => $entity));

