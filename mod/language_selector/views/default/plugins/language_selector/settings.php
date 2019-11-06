<?php 
$yesno_options = array(
	"yes" => elgg_echo("option:yes"),
	"no" => elgg_echo("option:no")
);

$noyes_options = array_reverse($yesno_options);
	
?>
<table>
	<tr>
		<td>
			<?php echo elgg_echo("language_selector:admin:settings:min_completeness"); ?><br />
		</td>
		<td>
			<?php echo elgg_view("input/text", array("name" => "params[min_completeness]", "value" => $vars['entity']->min_completeness, "size" => 2, "maxlength" => 2)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('language_selector:admin:settings:show_in_header'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[show_in_header]", "options_values" => $noyes_options, "value" => $vars['entity']->show_in_header)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('language_selector:admin:settings:autodetect'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[autodetect]", "options_values" => $noyes_options, "value" => $vars['entity']->autodetect)); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo elgg_echo('language_selector:admin:settings:show_images'); ?>
		</td>
		<td>
			<?php echo elgg_view("input/dropdown", array("name" => "params[show_images]", "options_values" => $yesno_options, "value" => $vars['entity']->show_images)); ?>
		</td>
	</tr>
</table>		