<?php
/**
 * Elgg LDAP authentication settings
 */

$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );

// Default required settings
?>
<p>
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('ldap_auth:title');?></legend>
		
		<?php /*
		<label for="params[ldap_url]"><?php echo elgg_echo('elgg_ldap:ldap_url');?></label><br/>
		<input type="text" name="params[ldap_url]" value="<?php echo $vars['entity']->ldap_url;?>" /><br/>
		*/ ?>
		
		<label><?php echo elgg_echo('ldap_auth:settings:updatename'); ?></label><br/>
		<?php echo elgg_view('input/dropdown', array( 'name' => 'params[updatename]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->updatename	 )); ?><br/>
		
	</fieldset>
</p>

