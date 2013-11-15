<?php
$widget_id = $vars['entity']->guid;

?>
<div>
	<label for="search_<?php echo $widget_id; ?>"><?php echo elgg_echo('elgg_cmis:search') . elgg_view('input/text', array('name' => 'params[search]', 'value' => $vars['entity']->search)); ?>:</label>
</div>

<div>
	<label for="folder_<?php echo $widget_id; ?>"><?php echo elgg_echo('elgg_cmis:folder') . elgg_view('input/text', array('name' => 'params[folder]', 'value' => $vars['entity']->folder)); ?>:</label>
</div>

<div>
	<label for="author_<?php echo $widget_id; ?>"><?php echo elgg_echo('elgg_cmis:author') . elgg_view('input/text', array('name' => 'params[author]', 'value' => $vars['entity']->author)); ?>:</label>
</div>

<div>
	<label for="insearch_<?php echo $widget_id; ?>"><?php echo elgg_echo('elgg_cmis:insearch') . elgg_view('input/text', array('name' => 'params[insearch]', 'value' => $vars['entity']->insearch)); ?>:</label>
</div>


