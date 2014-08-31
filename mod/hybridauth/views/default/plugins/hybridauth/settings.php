<?php
global $CONFIG;
$providers = array('twitter' => 'Twitter', 'linkedin' => 'LinkedIn', 'google' => 'Google', 'facebook' => 'Facebook');

$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
$no_yes_opt = array_reverse($yes_no_opt);

// Default required settings
?>
<p>
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('hybridauth:settings:main'); ?></legend>
		<?php
		echo '<p><label>' . elgg_echo('hybridauth:settings:login') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[login_enable]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->{'login_enable'} )) . '</p>';
		echo '<p><label>' . elgg_echo('hybridauth:settings:register') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[register_enable]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->{'register_enable'} )) . '<br /><em>' . elgg_echo('hybridauth:settings:register:details') . '</em></p>';
		?>
	</fieldset>
	<br />
	
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('hybridauth:settings:providers'); ?></legend>
		<?php
		// Liste des providers
		foreach ($providers as $key => $name) {
			echo '<h4><img src="' . $CONFIG->url . 'mod/hybridauth/graphics/' . $key . '.png" style="float:left; margin-right:16px;" />' . $name . '&nbsp;: ';
			echo '<label>' . elgg_echo('hybridauth:available:'.$key) . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params['.$key.'_enable]', 'options_values' => $no_yes_opt, 'value' => $vars['entity']->{$key.'_enable'} )) . '</h4>';
			echo '<p><label>' . elgg_echo('hybridauth:apikey:'.$key) . '</label> ' . elgg_view('input/text', array( 'name' => 'params['.$key.'_apikey]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->{$key.'_apikey'}, 'js' => 'style="width:50%;"' )) . '</p>';
			echo '<p><label>' . elgg_echo('hybridauth:secret:'.$key) . '</label> ' . elgg_view('input/text', array( 'name' => 'params['.$key.'_secret]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->{$key.'_secret'}, 'js' => 'style="width:50%;"' )) . '</p>';
		}
		?>
		
	</fieldset>
</p>

