<?php
/**
 * User blog widget display view
 */
global $CONFIG;

$folder = $vars['entity']->folder;

if (!empty($folder)) {
	echo '<div class="elgg-cmis-widget elgg-cmis-widget-folder"><iframe src="' . $CONFIG->url . 'cmis/repo/list/document/folder/' . $folder . '?embed=iframe">' . elgg_echo('elgg_cmis:loading') . '</iframe></div>';
}

