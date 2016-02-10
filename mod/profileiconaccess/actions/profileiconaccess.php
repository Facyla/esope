<?php

namespace AU\ProfileIconAccess;

$guid = (int) get_input('guid');
$access = (int) get_input('access');
$user = get_user($guid);

if (!user || !$user->canEdit()) {
  register_error(elgg_echo('profileiconaccess:error'));
  forward();
}

$id = create_metadata($user->guid, 'iconaccess', $access, 'integer', $user->guid, $access);

if ($id) {
  system_message(elgg_echo('profileiconaccess:success'));
}
else {
  register_error(elgg_echo('profileiconaccess:error'));
}

forward(REFERER);