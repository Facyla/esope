<?php
/**
 * Elgg river image
 *
 * Displayed next to the body of each river item
 *
 * @uses $vars['item']
 */

$item = $vars['item'];
/* @var ElggRiverItem $item */

$subject = $item->getSubjectEntity();

// Iris v2 : @TODO : entity type icon, not owner
$subject = $item->getObjectEntity();
if (elgg_in_context('widgets')) {
	echo elgg_view_entity_icon($subject, 'tiny');
} else {
	echo elgg_view_entity_icon($subject, 'small');
}
