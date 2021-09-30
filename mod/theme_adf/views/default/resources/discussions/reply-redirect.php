<?php
$guid = get_input('guid');
$container_guid = get_input('container_guid');

$new_url = elgg_get_site_url() . "comment/view/$guid/$container_guid";

register_error(elgg_echo('theme_adf:discussion-reply:redirect'), [$new_menu]);

forward($new_url);

