<?php
/**
 * Wire group container filter form body
 *
 */
?>

<div class="" style="">
	<form method="POST" action="">
		<?php
		$add_group_container = get_input('add_group_container', 'no');
		echo '<p><label>' . elgg_echo('thewire:filter:add_group_container') . ' ' . elgg_view('input/select', array('name' => 'add_group_container', 'value' => $add_group_container, 'options_values' => array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')))) . '</label></p>';
		echo '<p>' . elgg_view('input/submit', array('value' => elgg_echo('filter'), 'class' => 'elgg-button elgg-button-submit')) . '</p>';
		?>
	</form>
</div>
