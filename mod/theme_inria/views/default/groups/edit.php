<?php
/**
 * Edit/create a group wrapper
 *
 * @uses $vars['entity'] ElggGroup object
 */

$entity = elgg_extract('entity', $vars, null);

$form_vars = array(
	'enctype' => 'multipart/form-data',
	'class' => 'elgg-form-alt',
);

// Use custom layout for new groups
if (elgg_instanceof($entity, 'group')) {
	echo elgg_view_form('groups/edit', $form_vars, groups_prepare_form_vars($entity));
	return;
}

echo '<div class="iris-group-header-alt" style="background: #454C5F; margin-top:-2rem;">';
echo '<h2>' . elgg_echo('groups:add') . '</h2>';
echo '</div>';
echo '<div class="" style="margin-top: -7rem; z-index: 2;">';
	echo elgg_view_form('groups/edit', $form_vars, groups_prepare_form_vars($entity));
echo '</div>';

