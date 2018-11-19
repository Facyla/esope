<?php
// Displays the embeddable SOAP iframe in an Elgg page
$title = elgg_echo('elgg_cmis:soap:title');
$content = '';

$content .= '<div id="cmis-iframe"><iframe id="cmis-embed" class="cmis-embed" src="' . elgg_get_site_url() . 'cmisembed"></iframe></div>';

$content = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => false));
echo elgg_view_page($title, $content);

