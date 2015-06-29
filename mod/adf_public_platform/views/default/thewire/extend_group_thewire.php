<?php
/* Adds a Wire to the group (access reserved to group members)
*/

$add_wire = elgg_get_plugin_setting('groups_add_wire', 'adf_public_platform');
if ($add_wire != 'yes') { return; }

$action = elgg_get_site_url() . "action/thewire/add";

$post = get_entity(get_input('guid'));
echo elgg_view_form('thewire/group_add', array('class' => 'thewire-form', 'action' => $action), array('post' => $post));
echo elgg_view('input/urlshortener');

