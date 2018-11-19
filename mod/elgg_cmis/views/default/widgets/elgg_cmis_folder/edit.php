<?php
/**
 * Elgg CMIS folder widget edit
 *
 * @package ElggPages
 */

$widget_id = $vars['entity']->guid;

?>
<div>
	<label for="folder_<?php echo $widget_id; ?>"><?php echo elgg_echo('elgg_cmis:widget:folder') . elgg_view('input/text', array('name' => 'params[folder]', 'value' => $vars['entity']->folder)); ?>:</label>
</div>

