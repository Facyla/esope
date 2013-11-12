<?php
/**
 * Elgg CMIS author widget edit
 *
 * @package ElggPages
 */

$widget_id = $vars['entity']->guid;


?>
<div>
	<label for="folder_<?php echo $widget_id; ?>"><?php echo elgg_echo('elgg_cmis:author') . elgg_view('input/text', array('name' => 'params[author]', 'value' => $vars['entity']->author)); ?>:</label>
</div>

