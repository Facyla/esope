<?php
/**
 * Elgg CMIS authentication settings
 * Enable user mode / site mode
 * Set CMIS server settings
 * Set credentials for site mode
 * Enable widgets
 */

$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));

// Default required settings
//if (empty($vars['entity']->cmis_url)) $vars['entity']->cmis_url = '';
if (empty($vars['entity']->cmis_soap_url)) { $vars['entity']->cmis_soap_url = 'cmisws/RepositoryService'; }
if (empty($vars['entity']->cmis_atom_url)) { $vars['entity']->cmis_atom_url = 'cmisatom'; }
?>

<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
	<legend><?php echo elgg_echo('elgg_cmis:title');?></legend>
	
	<p><label for="params[cmis_url]"><?php echo elgg_echo('elgg_cmis:cmis_url');?> 
	<input type="text" name="params[cmis_url]" value="<?php echo $vars['entity']->cmis_url . '" /></label></p>'; ?>
	
	<p><label for="params[cmis_soap_url]"><?php echo elgg_echo('elgg_cmis:cmis_soap_url');?> 
	<input type="text" name="params[cmis_soap_url]" value="<?php echo $vars['entity']->cmis_soap_url . '" /></label></p>'; ?>
	
	<p><label for="params[cmis_atom_url]"><?php echo elgg_echo('elgg_cmis:cmis_atom_url');?> 
	<input type="text" name="params[cmis_atom_url]" value="<?php echo $vars['entity']->cmis_atom_url . '" /></label></p>'; ?>
	
	<?php echo '<p><label>' . elgg_echo('elgg_cmis:settings:usercmis') . elgg_view('input/select', array( 'name' => 'params[usercmis]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->usercmis)) . '</label><br /><em>' . elgg_echo('elgg_cmis:settings:usercmis:details') . '</em></p>';
	
	echo '<p><label>' . elgg_echo('elgg_cmis:settings:backend') . elgg_view('input/select', array( 'name' => 'params[backend]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->backend)) . '</label><br /><em>' . elgg_echo('elgg_cmis:settings:backend:details') . '</em></p>';
	?>
	
	<?php echo '<p><label>' . elgg_echo('elgg_cmis:debugmode');
	echo elgg_view('input/select', array( 'name' => 'params[debugmode]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->debugmode)) . '</label></p>'; ?>
	
</fieldset>
<br />

<?php
// Backend specific settings
if ($vars['entity']->backend == 'yes') {
	?>
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('elgg_cmis:settings:backend:legend'); ?></legend>
		<?php
		echo '<p><label for="params[cmis_username]">' . elgg_echo('elgg_cmis:cmis_login') . elgg_view('input/text', array('name' => 'params[cmis_username]', 'value' => $vars['entity']->cmis_username)) . '</label></p>';
		
		echo '<p><label for="params[cmis_password]">' . elgg_echo('elgg_cmis:cmis_password') . elgg_view('input/text', array('name' => 'params[cmis_password]', 'value' => $vars['entity']->cmis_password)) . '</label></p>'; 
		
		echo '<p><label for="params[filestore_path]">' . elgg_echo('elgg_cmis:settings:filestore_path') . elgg_view('input/text', array('name' => 'params[filestore_path]', 'value' => $vars['entity']->filestore_path)) . '</label></p>';
		?>
	</fieldset>
	<br />
	<?php
}


// User mode specific settings
if ($vars['entity']->usercmis == 'yes') {
	?>
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('elgg_cmis:settings:usercmis:legend'); ?></legend>
		<p><strong><?php echo elgg_echo('elgg_cmis:widgets'); ?></strong></p>
	
		<?php
		echo '<p><label>' . elgg_echo('elgg_cmis:widget:cmis_mine');
		echo elgg_view('input/select', array( 'name' => 'params[widget_mine]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->widget_mine )) . '</label></p>';

		echo '<p><label>' . elgg_echo('elgg_cmis:widget:cmis');
		echo elgg_view('input/select', array( 'name' => 'params[widget_cmis]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->widget_cmis )) . '</label></p>';

		echo '<p><label>' . elgg_echo('elgg_cmis:widget:cmis_folder');
		echo elgg_view('input/select', array( 'name' => 'params[widget_folder]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->widget_folder )) . '</label></p>';

		echo '<p><label>' . elgg_echo('elgg_cmis:widget:cmis_search');
		echo elgg_view('input/select', array( 'name' => 'params[widget_search]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->widget_search )) . '</label></p>';

		echo '<p><label>' . elgg_echo('elgg_cmis:widget:cmis_insearch');
		echo elgg_view('input/select', array( 'name' => 'params[widget_insearch]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->widget_insearch )) . '</label></p>';
		?>
	
	</fieldset>
	<?php
}


