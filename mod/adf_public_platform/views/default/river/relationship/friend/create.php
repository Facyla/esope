<?php
/**
 * Create friend river view
 */
$subject = $vars['item']->getSubjectEntity();
$object = $vars['item']->getObjectEntity();

if (elgg_get_context() == 'digest') {
	$subject_icon = '<div class="elgg-avatar elgg-avatar-tiny"><a href="' .  $subject->getURL() . '"><img src="' . $subject->getIconUrl('tiny') .  '" /></a></div>';
	$object_icon = '<div class="elgg-avatar elgg-avatar-tiny"><a href="' .  $object->getURL() . '"><img src="' . $object->getIconUrl('tiny') .  '" /></a></div>';
} else {
	$subject_icon = elgg_view_entity_icon($subject, 'tiny');
	$object_icon = elgg_view_entity_icon($object, 'tiny');
}

echo elgg_view('river/elements/layout', array(
	'item' => $vars['item'],
	'attachments' => $subject_icon . elgg_view_icon('arrow-right') . $object_icon,
));
