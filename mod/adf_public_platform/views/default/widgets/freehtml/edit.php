<?php 
$widget = $vars["entity"];
?>
<div>
	<?php echo elgg_echo("esope:widgets:freehtml:title"); ?><br /> 
	<?php echo elgg_view("input/text", array("name" => "params[title]", "value" => $widget->title)); ?>
	<?php echo elgg_echo("esope:widgets:freehtml:content"); ?><br /> 
	<?php echo elgg_view("input/longtext", array("name" => "params[html_content]", "value" => $widget->html_content, 'class' => "elgg-input-rawtext simple-editor")); ?>
</div>

<?php echo elgg_view('input/color', array('name' => 'params[backgroundcolor]', 'value' => $vars['entity']->backgroundcolor)); ?>

