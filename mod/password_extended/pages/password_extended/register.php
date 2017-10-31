

<?php

$content = elgg_view_form('register');
$params = array(
    'title' => 'Register',
    'filter' => '',
    'content' => $content
);

$body = elgg_view_layout('one_column', $params);

echo elgg_view_page('', $body);

?>

