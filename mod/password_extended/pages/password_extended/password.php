<?php

$guid = elgg_get_logged_in_user_guid();
if(!$guid){
    logout();
    register_error(elgg_echo('password_extended:current_password:failed'));
    forward(REFERER);
}

$username = get_input('username');
$password = get_input('password');

// Get the specified vacancy post
$entity = get_user($guid);
if (!elgg_instanceof($entity, 'user')) {
    logout();
    register_error(elgg_echo('password_extended:usernotfound'));
    forward(REFERER);
}

// Display it
// Set the title appropriately
$title = elgg_echo('password_extended:renew_password');
$content = elgg_view_title($title);
// add the form to the main column
$content .= elgg_view_form('renew_password', ['enctype' => 'multipart/form-data'], [ 'guid'=> $guid, 'password' => $password ]);


$params = array(
    'content' => $content,
    'sidebar' => $sidebar,
);
$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);
