<?php
global $CONFIG;
system_message(elgg_echo('esope:configredirect'));
forward($CONFIG->url . 'admin/plugin_settings/esope');

