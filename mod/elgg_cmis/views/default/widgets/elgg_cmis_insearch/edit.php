<?php
/**
 * Elgg CMIS search widget edit
 *
 * @package ElggPages
 */

$widget_id = $vars['entity']->guid;
?>
<div>
	<label for="insearch_<?php echo $widget_id; ?>"><?php echo elgg_echo('elgg_cmis:widget:insearch') . elgg_view('input/text', array('name' => 'params[insearch]', 'value' => $vars['entity']->insearch)); ?>:</label>
</div>

