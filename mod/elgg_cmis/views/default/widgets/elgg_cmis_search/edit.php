<?php
/**
 * Elgg CMIS search widget edit
 *
 * @package ElggPages
 */

$widget_id = $vars['entity']->guid;
?>
<div>
	<label for="folder_<?php echo $widget_id; ?>"><?php echo elgg_echo('elgg_cmis:search') . elgg_view('input/text', array('name' => 'params[search]', 'value' => $vars['entity']->search)); ?>:</label>
</div>

