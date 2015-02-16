<?php
// Note : does not add link in interface, as these are added through profile dropdown menu

$user_chat = elgg_get_plugin_setting('site_chat', 'group_chat');
if (!elgg_is_logged_in() || ($user_chat != 'yes')) { return; }


