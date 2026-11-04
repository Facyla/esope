<?php

echo elgg_view_field([
	'#type' => 'grouppicker',
	'#help' => elgg_echo('entity_attachments:picker:help'),
	'name' => 'params[linked_group][entity_guid]',
	'limit' => 1,
	'required' => true,
]);
