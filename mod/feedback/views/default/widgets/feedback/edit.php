<?php
/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 *
 * for Elgg 1.8 by iionly
 * iionly@gmx.de
 *
 * Widget edit view
 */

// set default value
if (!isset($vars['entity']->num_display)) { $vars['entity']->num_display = 4; }
if (!isset($vars['entity']->status)) { $vars['entity']->status = 'open'; }


$params = [
		'name' => 'params[num_display]',
		'value' => $vars['entity']->num_display,
		'options' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
	];
$num_opt = elgg_view('input/select', $params);

$status_opt = [
	'open' => elgg_echo('feedback:status:open'), 
	'closed' => elgg_echo('feedback:status:closed'),
	'all' => elgg_echo('feedback:admin:title'), 
	];
$params = [
		'name' => 'params[status]',
		'value' => $vars['entity']->status,
		'options_values' => $status_opt,
	];
$status_select = elgg_view('input/select', $params);
?>

<div>
	<label><?php echo elgg_echo('feedback:numbertodisplay') . ' ' . $num_opt; ?></label>
</div>

<div>
	<label><?php echo elgg_echo('feedback:status') . ' ' . $status_select; ?></label>
</div>

<div class="clearfloat"></div>

