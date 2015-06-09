<?php
/**
 * Elgg LDAP authentication settings
 */

$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));
$yes_no_opt = array_reverse($no_yes_opt);

// Set defaults
if (empty($vars['entity']->allow_registration)) $vars['entity']->allow_registration = 'yes';
if (empty($vars['entity']->updateprofile)) $vars['entity']->updateprofile = 'yes';
if (empty($vars['entity']->updatename)) $vars['entity']->updatename = 'no';

if (empty($vars['entity']->mail_field_name)) $vars['entity']->mail_field_name = 'mail';
if (empty($vars['entity']->username_field_name)) $vars['entity']->username_field_name = 'inriaLogin';
if (empty($vars['entity']->status_field_name)) $vars['entity']->status_field_name = 'inriaEntrystatus';
if (empty($vars['entity']->generic_register_email)) $vars['entity']->generic_register_email = 'noreply@inria.fr';

?>

<fieldset style="border: 1px solid; padding: 1ex; margin: 1ex 0 3ex 0;">
	<legend><?php echo elgg_echo('ldap_auth:settings:main');?></legend>
	
	<p><label><?php echo elgg_echo('ldap_auth:settings:allow_registration') . ' ' . elgg_view('input/dropdown', array( 'name' => 'params[allow_registration]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->allow_registration)); ?></label></p>
	
	<p><label><?php echo elgg_echo('ldap_auth:settings:updateprofile') . ' ' . elgg_view('input/dropdown', array( 'name' => 'params[updateprofile]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->updateprofile)); ?></label></p>
	
	<p><label><?php echo elgg_echo('ldap_auth:settings:updatename') . ' ' . elgg_view('input/dropdown', array( 'name' => 'params[updatename]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->updatename)); ?></label></p>
	
</fieldset>


<fieldset style="border: 1px solid; padding: 1ex; margin: 1ex 0 3ex 0;">
	<legend><?php echo elgg_echo('ldap_auth:settings:fields');?></legend>
	
	<p><label><?php echo elgg_echo('elgg_ldap:mail_field_name');?> 
		<input type="text" name="params[mail_field_name]" value="<?php echo $vars['entity']->mail_field_name;?>" /></label></p>
	
	<p><label><?php echo elgg_echo('elgg_ldap:username_field_name');?> 
		<input type="text" name="params[username_field_name]" value="<?php echo $vars['entity']->username_field_name;?>" /></label></p>
	
	<p><label><?php echo elgg_echo('elgg_ldap:status_field_name');?> 
		<input type="text" name="params[status_field_name]" value="<?php echo $vars['entity']->status_field_name;?>" /></label></p>
	
	<p><label><?php echo elgg_echo('elgg_ldap:generic_register_email');?> 
		<input type="text" name="params[generic_register_email]" value="<?php echo $vars['entity']->generic_register_email;?>" /></label></p>
	
</fieldset>

