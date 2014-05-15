<p>
<?php 

	// set default value if user hasn't set it
	$param = $vars['entity']->tasks;
	if (!isset($param)) 
	{
		$param = "2 * 2 = ?|4\n2 * 3 = ?|6";
		$vars['entity']->tasks = $param;
	}

	echo elgg_echo('vazco_text_captcha:tasks'); 
	
	echo '<br/>';
	
	echo elgg_view('input/plaintext', array(
			'name' => 'params[tasks]',
			'value' => $param
		));
?>
</p>
