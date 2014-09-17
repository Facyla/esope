<?php 
$widget = $vars["entity"];


elgg_load_js('elgg.input.colorpicker');
elgg_load_css('elgg.input.colorpicker');
?>
<div>
	<?php echo elgg_echo("esope:widgets:freehtml:content"); ?><br /> 
	<?php echo elgg_view("input/longtext", array("name" => "params[html_content]", "value" => $widget->html_content, 'class' => "elgg-input-rawtext simple-editor")); ?>
</div>

<?php echo elgg_view('input/color', array('name' => 'params[backgroundcolor]', 'value' => $vars['entity']->backgroundcolor)); ?>

