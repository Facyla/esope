<?php
// Displays an embeddable SOAP iframe in an Elgg page
$title = elgg_echo('elgg_cmis:title');
$content = '';


// File repository backend
$content .= '<p><a href="' . elgg_get_site_url() . 'cmis/test">Backend test page</a></p>';


$content = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => false));
echo elgg_view_page($title, $content);

