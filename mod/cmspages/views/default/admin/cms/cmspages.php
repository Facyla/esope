<?php
global $CONFIG;
system_message(elgg_echo('cmspages:configredirect'));
forward($CONFIG->url . 'cmspages');

