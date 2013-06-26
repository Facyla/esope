<?php
/**
 * Friend widget options
 *
 */
$widget_id = $vars['entity']->guid;

// Selon le profil : tous les contacts, formateurs, stagiaires, OF de rattachement...
$profiletype = dossierdepreuve_get_user_profile_type($vars['entity']->getOwnerEntity());

$scope_opt['all'] = elgg_echo('dossierdepreuve:widget:scope:all');
switch ($profiletype) {
	case 'learner':
		//$scope_opt[] = 'tutors';
		//$scope_opt[] = 'organisations';
		break;
	case 'tutor':
	case 'evaluator':
		//$scope_opt[] = 'learners';
		$scope_opt['organisations'] = elgg_echo('dossierdepreuve:widget:scope:organisations');
		break;
	case 'organisation':
		//$scope_opt[] = 'learners';
		$scope_opt['tutors'] = elgg_echo('dossierdepreuve:widget:scope:tutors');
		break;
	case 'other_administrative':
		$scope_opt['learners'] = elgg_echo('dossierdepreuve:widget:scope:learners');
		$scope_opt['tutors'] = elgg_echo('dossierdepreuve:widget:scope:tutors');
		$scope_opt['organisations'] = elgg_echo('dossierdepreuve:widget:scope:organisations');
		break;
	default:
		// Tous les contacts seulement
}
// Scope selector
if (sizeof($scope_opt) > 1) {
	$params = array(
			'name' => 'params[scope]', 'id' => 'scope_'.$widget_id,
			'value' => $vars['entity']->scope, 'options_values' => $scope_opt,
		);
	$scope_dropdown = elgg_view('input/dropdown', $params);
}



/*
// set default value for display number
if (!isset($vars['entity']->num_display)) { $vars['entity']->num_display = 12; }
// Number selector
$params = array(
	'name' => 'params[num_display]', 'id' => 'num_display_'.$widget_id,
	'value' => $vars['entity']->num_display,
	'options' => array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 15, 20, 30, 50, 100),
);
$display_dropdown = elgg_view('input/dropdown', $params);
*/


// handle upgrade to 1.7.2 from previous versions
if ($vars['entity']->icon_size == 1) { $vars['entity']->icon_size = 'small'; } 
elseif ($vars['entity']->icon_size == 2) { $vars['entity']->icon_size = 'tiny'; }

// set default value for icon size
if (!isset($vars['entity']->icon_size)) { $vars['entity']->icon_size = 'small'; }
// Icon size selector
$params = array(
	'name' => 'params[icon_size]',
	'id' => 'icon_size_'.$widget_id,
	'value' => $vars['entity']->icon_size,
	'options_values' => array(
		'small' => elgg_echo('friends:small'),
		'tiny' => elgg_echo('friends:tiny'),
	),
);
$size_dropdown = elgg_view('input/dropdown', $params);

// Sélecteur utile seulement si on a plus d'un choix !
if ($scope_dropdown) {
	?>
	<p>
		<label for="scope_display_<?php echo $widget_id; ?>"><?php echo elgg_echo('dossierdepreuve:friends:scope'); ?>:</label>
		<?php echo $scope_dropdown; ?>
	</p>
	<?php
}

/*
?>
<p>
	<label for="num_display_<?php echo $widget_id; ?>"><?php echo elgg_echo('friends:num_display'); ?>:</label>
	<?php echo $display_dropdown; ?>
</p>
<?php
*/
?>

<p>
	<label for="icon_size_<?php echo $widget_id; ?>"><?php echo elgg_echo('friends:icon_size'); ?>:</label>
	<?php echo $size_dropdown; ?>
</p>
