<?php
/**
 * Elgg CAS authentication settings
 * Available settings :
 	- cas_host
 	- cas_port
 	- cas_context
 	- ca_cert_path
 * Advanced settings :
 	- cas_real_hosts
 	- cas_db
 	- cas_db_user
 	- cas_db_password
 	- cas_db_table
 	- cas_driver_options
 * Following settings should not be edited :
 	- rebroadcast_node_1
 	- rebroadcast_node_2
 	- serviceUrl
 	- serviceUrl2
 */

$no_yes_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));
$no_yes_auto_opt = $no_yes_opt;
$no_yes_auto_opt['auto'] = elgg_echo('option:auto');

// Default required settings
if (empty($vars['entity']->cas_port)) $vars['entity']->cas_port = 443;
if (empty($vars['entity']->cas_context)) $vars['entity']->cas_context = '/cas';
?>
<p>
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('elgg_cas:title');?></legend>
		
		<label for="params[cas_host]"><?php echo elgg_echo('elgg_cas:cas_host');?></label><br/>
		<input type="text" name="params[cas_host]" value="<?php echo $vars['entity']->cas_host;?>" /><br/>
		
		<label for="params[cas_port]"><?php echo elgg_echo('elgg_cas:cas_port');?></label><br/>
		<input type="text" name="params[cas_port]" value="<?php echo $vars['entity']->cas_port;?>" /><br/>
		
		<label for="params[elgg_cas:cas_context]"><?php echo elgg_echo('elgg_cas:cas_context');?></label><br/>
		<input type="text" name="params[cas_context]" value="<?php echo $vars['entity']->cas_context;?>" /><br/>
		
		<label for="params[elgg_cas:ca_cert_path]"><?php echo elgg_echo('elgg_cas:ca_cert_path');?></label><br/>
		<input type="text" name="params[ca_cert_path]" value="<?php echo $vars['entity']->ca_cert_path;?>" /><br/>
		
		<p><label><?php echo elgg_echo('elgg_cas:settings:autologin'); ?><br/>
		<?php echo elgg_view('input/dropdown', array('name' => 'params[autologin]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->autologin )); ?></label>
		<br/><em></em>
		</p>
		
		<p><label><?php echo elgg_echo('elgg_cas:settings:casregister'); ?></label><br/>
		<?php echo elgg_view('input/dropdown', array('name' => 'params[casregister]', 'options_values' => $no_yes_auto_opt, 'value' => $vars['entity']->casregister )); ?>
		<br/><em><?php echo elgg_echo('elgg_cas:settings:casregister:details'); ?></em>
		</p>
		
		<p><label><?php echo elgg_echo('elgg_cas:settings:enable_webservice'); ?></label><br/>
		<?php echo elgg_view('input/dropdown', array('name' => 'params[enable_ws_auth]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->enable_ws_auth )); ?></p>
		
		<p><label><?php echo elgg_echo('elgg_cas:settings:cas_library'); ?></label><br/>
		<?php echo elgg_view('input/dropdown', array('name' => 'params[cas_library]', 'options_values' => array('1.3.2' => 'CAS-1.3.2', '1.3.3' => 'CAS-1.3.3'), 'value' => $vars['entity']->cas_library)); ?></p>
		
	</fieldset>
</p>

