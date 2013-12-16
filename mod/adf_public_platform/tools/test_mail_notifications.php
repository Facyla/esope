<?php
require_once dirname(dirname(dirname(__FILE__))) . '/engine/start.php';

admin_gatekeeper();

global $CONFIG;

$content = '<h4>This is a test content for notifications</h4><p>' . elgg_view('developpers/ipsum') . '</p><p><a href="' . $CONFIG->url . '">A regular link</a></p>';

echo elgg_view('html_email_handler/notification/body', array('message' => $content));

