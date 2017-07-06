<?php
/**
 * Edit/create a group wrapper
 *
 * @uses $vars['entity'] ElggGroup object
 */

$entity = elgg_extract('entity', $vars, null);
$parent_group = elgg_extract("au_subgroup_of", $vars);

$form_vars = array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-alt',
);

// Use custom layout for new groups
if (elgg_instanceof($entity, 'group')) {
	echo elgg_view_form('groups/edit', $form_vars, groups_prepare_form_vars($entity)+['au_subgroup_of' => $parent_group]);
	return;
}

$parent_group_guid = get_input('au_subgroup_parent_guid');
if ($parent_group_guid) { $parent_group = get_entity($parent_group_guid); }

echo '<div class="iris-group-header-alt">';
if ($parent_group) echo '<h2>' . elgg_echo('theme_inria:workspace:groups:add') . '</h2>';
else echo '<h2>' . elgg_echo('groups:add') . '</h2>';
echo '</div>';
echo '<div class="" style="margin-top: -7rem; z-index: 2;">';
	echo elgg_view_form('groups/edit', $form_vars, groups_prepare_form_vars($entity)+['au_subgroup_of' => $parent_group]);
echo '</div>';

