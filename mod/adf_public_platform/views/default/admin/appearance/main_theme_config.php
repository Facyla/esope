<?php
global $CONFIG;
system_message('adf_platform:configredirect');
forward($CONFIG->url . 'admin/plugin_settings/adf_public_platform');

