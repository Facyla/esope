<?php
/**
 * User blog widget edit view
 */

$widget_id = $vars['entity']->guid;

$profiletype = dossierdepreuve_get_user_profile_type($vars['entity']->owner_guid);
if ($profile_type != 'learner') {
	$myadmin_groups = theme_compnum_myadmin_groups($vars['entity']->getOwnerEntity());
	$groups_opt[] = 'Tous';
	if ($myadmin_groups) foreach ($myadmin_groups as $ent) { $groups_opt[$ent->guid] = $ent->name; }
	$params = array(
			'name' => 'params[group_guid]', 'id' => 'group_select_'.$widget_id,
			'value' => $vars['entity']->group_guid, 'options_values' => $groups_opt,
		);
	$group_select = elgg_view('input/dropdown', $params);
	?>

	<div>
		<label for="group_select<?php echo $widget_id; ?>"><?php echo elgg_echo('dossierdepreuve:widget:group_select'); ?>:</label>
		<?php echo $group_select; ?>
	</div>
	<?php
}

