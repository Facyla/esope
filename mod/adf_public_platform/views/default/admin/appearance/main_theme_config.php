<?php
global $CONFIG;
system_message(elgg_echo('adf_platform:configredirect'));
forward($CONFIG->url . 'admin/plugin_settings/adf_public_platform');

