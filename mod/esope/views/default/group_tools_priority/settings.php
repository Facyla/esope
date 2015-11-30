<?php
/* Nice piece of code from Ismayil Khayredinov 
 * from http://community.elgg.org/plugins/1520344/1.0/group-tools-priority
 * @name Group Tools Priority
 * @description Change the order of group tool modules
 * @author Ismayil Khayredinov (ismayil@arckinteractive.com)
 * @website http://www.arckinteractive.com/
 * @copyright ArckInteractive LLC
 * @license GNU General Public License version 2
*/
$views = elgg_get_config('views');
$tools = $views->extensions['groups/tool_latest'];

echo '<br /><p>' . elgg_echo('esope:grouptools:priority') . '</p>';
foreach ($tools as $priority => $view) {
	if ($view != 'groups/tool_latest') {
		echo '<label>' . $view . '</label>';
		echo elgg_view('input/text', array(
			'name' => "params[tools:$view]",
			'value' => $priority
		));
	}
}

