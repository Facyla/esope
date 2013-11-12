<?php
/**
 * Elgg CMIS authentication settings
 */

$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );

//$user_cmis_url = $vars['entity']->getUserSetting("elgg_cmis_user_cmis_url", elgg_get_page_owner_guid());
$cmis_login = $vars['entity']->getUserSetting("cmis_login", elgg_get_page_owner_guid());
$cmis_password = $vars['entity']->getUserSetting("cmis_password", elgg_get_page_owner_guid());

?>
<p>
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('elgg_cmis:title');?></legend>
		
		<!--
		<label for="params[user_cmis_url]"><?php echo elgg_echo('elgg_cmis:user_cmis_url');?></label><br/>
		<input type="text" name="params[user_cmis_url]" value="<?php echo $user_cmis_url;?>" /><br/>
		//-->
		
		<label for="params[cmis_login]"><?php echo elgg_echo('elgg_cmis:cmis_login');?></label><br/>
		<input type="text" name="params[cmis_login]" value="<?php echo $cmis_login; ?>" /><br/>
		
		<label for="params[elgg_cmis:cmis_password]"><?php echo elgg_echo('elgg_cmis:cmis_password');?></label><br/>
		<input type="text" name="params[cmis_password]" value="<?php echo $cmis_password; ?>" /><br/>
		
	</fieldset>
</p>

