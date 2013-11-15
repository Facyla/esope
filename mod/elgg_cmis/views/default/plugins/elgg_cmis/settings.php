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
<p>
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('elgg_cmis:title');?></legend>
		
		<label for="params[cmis_url]"><?php echo elgg_echo('elgg_cmis:cmis_url');?></label><br/>
		<input type="text" name="params[cmis_url]" value="<?php echo $vars['entity']->cmis_url;?>" /><br/>
		
		<label for="params[cmis_soap_url]"><?php echo elgg_echo('elgg_cmis:cmis_soap_url');?></label><br/>
		<input type="text" name="params[cmis_soap_url]" value="<?php echo $vars['entity']->cmis_soap_url;?>" /><br/>
		
		<label for="params[cmis_atom_url]"><?php echo elgg_echo('elgg_cmis:cmis_atom_url');?></label><br/>
		<input type="text" name="params[cmis_atom_url]" value="<?php echo $vars['entity']->cmis_atom_url;?>" /><br/>
		
		<label><?php echo elgg_echo('elgg_cmis:debugmode'); ?></label><br/>
		<?php echo elgg_view('input/dropdown', array( 'name' => 'params[debugmode]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->debugmode )); ?><br/>
		
	</fieldset>
</p>

