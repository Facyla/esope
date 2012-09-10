<?php

$announcement = $vars['entity'];

?>

<div>
	<label><?php echo elgg_echo('Summary'); ?></label>
	<?php 
		
		echo elgg_view('input/text', array(
			'name' => 'title',
			'value' => $announcement->title,
			'required' => TRUE,
		));
		
	?>
</div>

<div>
	<label><?php echo elgg_echo('Body'); ?></label>
	<?php 
		echo elgg_view('input/longtext', array(
			'name' => 'description',
			'value' => $announcement->description,
		));
	?>
</div>
<div>
	<label><?php echo elgg_echo('access'); ?></label>
	<?php 
		echo elgg_view('input/access', array(
			'name' => 'access_id', 
			'value' => $announcement->access_id,
		));
	?>
</div>
<div>
	<?php 
		echo elgg_view('input/hidden', array(
			'name' => "container_guid", 
			'value' => $announcement->container_guid,
		));
		
		echo elgg_view('input/hidden', array(
			'name' => 'guid',
			'value' => $announcement->guid,
		));
		
		echo elgg_view('input/submit', array(
			'class' => 'right',
			'value' => elgg_echo('post'),
		));
	?>
</div>