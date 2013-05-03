<?php
$yes_no_opt = array( 'yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );

echo ' <p><label>' . elgg_echo('videos:register_objects') . '</label> ' . elgg_view('input/dropdown', array( 'name' => 'params[register_objects]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->register_objects )) . '</p>';
?>

<br />

