<?php
/**
 * Elgg CMIS authentication settings
 */

$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );

// Default required settings
//if (empty($vars['entity']->cmis_url)) $vars['entity']->cmis_url = '';
if (empty($vars['entity']->cmis_soap_url)) $vars['entity']->cmis_soap_url = 'cmisws/RepositoryService';
if (empty($vars['entity']->cmis_atom_url)) $vars['entity']->cmis_atom_url = 'cmisatom';
?>

<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
	<legend><?php echo elgg_echo('elgg_cmis:title');?></legend>
	
	<p><label for="params[cmis_url]"><?php echo elgg_echo('elgg_cmis:cmis_url');?> 
	<input type="text" name="params[cmis_url]" value="<?php echo $vars['entity']->cmis_url;?>" /></label></p>
	
	<p><label for="params[cmis_soap_url]"><?php echo elgg_echo('elgg_cmis:cmis_soap_url');?> 
	<input type="text" name="params[cmis_soap_url]" value="<?php echo $vars['entity']->cmis_soap_url;?>" /></label></p>
	
	<p><label for="params[cmis_atom_url]"><?php echo elgg_echo('elgg_cmis:cmis_atom_url');?> 
	<input type="text" name="params[cmis_atom_url]" value="<?php echo $vars['entity']->cmis_atom_url;?>" /></label></p>
	
	<p><label><?php echo elgg_echo('elgg_cmis:debugmode'); ?> 
	<?php echo elgg_view('input/dropdown', array( 'name' => 'params[debugmode]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->debugmode )); ?></label></p>
	
</fieldset>
<br />

<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
	<legend><?php echo elgg_echo('elgg_cmis:widgets'); ?></legend>
	
	<p><label><?php echo elgg_echo('elgg_cmis:widget:cmis_mine'); ?> 
	<?php echo elgg_view('input/dropdown', array( 'name' => 'params[widget_mine]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->widget_mine )); ?></label></p>
	
	<p><label><?php echo elgg_echo('elgg_cmis:widget:cmis'); ?> 
	<?php echo elgg_view('input/dropdown', array( 'name' => 'params[widget_cmis]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->widget_cmis )); ?></label></p>
	
	<p><label><?php echo elgg_echo('elgg_cmis:widget:cmis_folder'); ?> 
	<?php echo elgg_view('input/dropdown', array( 'name' => 'params[widget_folder]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->widget_folder )); ?></label></p>
	
	<p><label><?php echo elgg_echo('elgg_cmis:widget:cmis_search'); ?> 
	<?php echo elgg_view('input/dropdown', array( 'name' => 'params[widget_search]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->widget_search )); ?></label></p>
	
	<p><label><?php echo elgg_echo('elgg_cmis:widget:cmis_insearch'); ?> 
	<?php echo elgg_view('input/dropdown', array( 'name' => 'params[widget_insearch]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->widget_insearch )); ?></label></p>
	
</fieldset>

