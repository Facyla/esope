<?php
/**
 * User blog widget display view
 */
global $CONFIG;

echo '<div class="elgg-cmis-widget elgg-cmis-widget-mine"><iframe src="' . $CONFIG->url . 'cmis/repo/list/document/mine?embed=iframe">' . elgg_echo('elgg_cmis:loading') . '</iframe></div>';

