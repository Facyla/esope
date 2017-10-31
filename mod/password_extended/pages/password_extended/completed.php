<?php

gatekeeper();

$guid = elgg_get_logged_in_user_guid();

$entity = get_user($guid);
if (!elgg_instanceof($entity, 'user')) {
    logout();
    register_error(elgg_echo('password_extended:usernotfound'));
    forward(REFERER);
}

// Set the title appropriately
$title = elgg_echo('password_extended:finished');
$content = elgg_view_title($title);

$content .= "<br>". elgg_echo('password:finished_message',[$entity->username]);

$params = array(
    'content' => $content,
    'sidebar' => $sidebar,
);
$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);