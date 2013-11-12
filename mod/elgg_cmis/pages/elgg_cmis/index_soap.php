<?php
global $CONFIG;
$title = elgg_echo('elgg_cmis:title');
$content = '';

$content .= '<div id="cmis-iframe"><iframe id="cmis-embed" class="cmis-embed" src="' . $CONFIG->url . 'cmisembed"></iframe></div>';

$content = elgg_view_layout('one_column', array('content' => $content, 'sidebar' => false));
echo elgg_view_page($title, $content);

