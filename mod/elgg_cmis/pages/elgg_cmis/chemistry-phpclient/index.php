<?php
// Displays an embeddable SOAP iframe in an Elgg page
$title = elgg_echo('elgg_cmis:title');
$content = '';


// File repository backend
$content .= '<p><a href="' . elgg_get_site_url() . 'cmis/test">Backend test page</a></p>';

// Main CMIS repository (used with personal credentials)
$content .= '<p><a href="' . elgg_get_site_url() . 'cmis/repo">Main CMIS repository (personal credentials)</a></p>';

// SOAP
$content .= '<p><a href="' . elgg_get_site_url() . 'cmis/soap">SOAP page</a></p>';

// Embeddable SOAP
$content .= '<p><a href="' . elgg_get_site_url() . 'cmis/embed">Embeddable SOAP page</a></p>';


$content = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => false));
echo elgg_view_page($title, $content);

