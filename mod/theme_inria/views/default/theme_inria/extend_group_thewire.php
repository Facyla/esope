<?php
/*
$entity = elgg_get_page_owner_entity();
// Display some group details only in owner_block
if (!elgg_in_context('group_profile')) { return; }
*/

global $CONFIG;
$action = $CONFIG->wwwroot . "action/thewire/add";

$post = get_entity(get_input('guid'));
echo elgg_view_form('thewire/group_add', array('class' => 'thewire-form', 'action' => $action), array('post' => $post));
echo elgg_view('input/urlshortener');

