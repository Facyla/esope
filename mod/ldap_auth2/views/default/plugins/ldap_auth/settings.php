<?php
/**
 * Elgg LDAP authentication settings
 */

$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );

if (empty($vars['entity']->username_field_name)) $vars['entity']->username_field_name = 'inriaLogin';
if (empty($vars['entity']->mail_field_name)) $vars['entity']->mail_field_name = 'inriaMail';
if (empty($vars['entity']->status_field_name)) $vars['entity']->status_field_name = 'inriaentrystatus';
if (empty($vars['entity']->generic_register_email)) $vars['entity']->generic_register_email = 'noreply@inria.fr';

// Default required settings
?>
<p>
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('ldap_auth:title');?></legend>
		
		<label><?php echo elgg_echo('ldap_auth:settings:updatename'); ?></label><br/>
		<?php echo elgg_view('input/dropdown', array( 'name' => 'params[updatename]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->updatename	 )); ?><br/>
		
		<label for="params[mail_field_name]"><?php echo elgg_echo('elgg_ldap:mail_field_name');?></label><br/>
		<input type="text" name="params[mail_field_name]" value="<?php echo $vars['entity']->mail_field_name;?>" /><br/>
		
		<label for="params[username_field_name]"><?php echo elgg_echo('elgg_ldap:username_field_name');?></label><br/>
		<input type="text" name="params[username_field_name]" value="<?php echo $vars['entity']->username_field_name;?>" /><br/>
		
		<label for="params[status_field_name]"><?php echo elgg_echo('elgg_ldap:status_field_name');?></label><br/>
		<input type="text" name="params[status_field_name]" value="<?php echo $vars['entity']->status_field_name;?>" /><br/>
		
		<label for="params[generic_register_email]"><?php echo elgg_echo('elgg_ldap:generic_register_email');?></label><br/>
		<input type="text" name="params[generic_register_email]" value="<?php echo $vars['entity']->generic_register_email;?>" /><br/>
		
	</fieldset>
</p>

