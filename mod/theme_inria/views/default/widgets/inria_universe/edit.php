<?php
/**
 * Elgg pages widget edit
 *
 * @package ElggPages
 */

$widget_id = $vars['entity']->guid;

// set default value
if (!isset($vars['entity']->tool)) { $vars['entity']->tool = 'all'; }

$options_values = array(
		// val => title
		//'all' => elgg_echo('theme_inria:topbar:all'),
		'forge' => elgg_echo('theme_inria:topbar:forge'),
		'notepad' => elgg_echo('theme_inria:topbar:notepad'),
		'framadate' => elgg_echo('theme_inria:topbar:framadate'),
		'webinar' => elgg_echo('theme_inria:topbar:webinar'),
		'ftp' => elgg_echo('theme_inria:topbar:ftp'),
		'share' => elgg_echo('theme_inria:topbar:share'),
		'confcall' => elgg_echo('theme_inria:topbar:confcall'),
		'evo' => elgg_echo('theme_inria:topbar:evo'),
		'mailinglist' => elgg_echo('theme_inria:topbar:mailinglist'),
		'mailer' => elgg_echo('theme_inria:topbar:mailer'),
		'mission' => elgg_echo('theme_inria:topbar:mission'),
		'mission2' => elgg_echo('theme_inria:topbar:mission2'),
		'hollydays' => elgg_echo('theme_inria:topbar:hollydays'),
		'annuaire' => elgg_echo('theme_inria:topbar:annuaire'),
		'tickets' => elgg_echo('theme_inria:topbar:tickets'),
	);

/* 1 tools at a time mode
$params = array(
	'name' => 'params[tool]',
	'id' => 'num_display_'.$widget_id,
	'value' => $vars['entity']->tool,
	'options_values' => $options_values,
);
$inria_tool = elgg_view('input/dropdown', $params);
?>
<div>
	<label for="inria_tool_<?php echo $widget_id; ?>"><?php echo elgg_echo('theme_inria:inria_tool'); ?>:</label>
	<?php echo $inria_tool; ?>
</div>
<?php
*/

// Multi-tool mode
$no_yes_opt = array( elgg_echo('option:no') => 'no', elgg_echo('option:yes') => 'yes' );
foreach ($options_values as $opt => $name) {
	?>
	<div class="inria-tool-widget">
		<label for="inria_tool_<?php echo $widget_id . '_' . $opt; ?>"><?php echo $name; ?>&nbsp;:</label>
		<?php echo elgg_view('input/radio', array('name' => 'params['.$opt.']', 'value' => $vars['entity']->{$opt}, 'options' => $no_yes_opt, 'align' => 'horizontal')); ?>
	</div>
	<?php
}
echo '<br />';
?>

