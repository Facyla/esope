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

// Iris v2 : use entity type icon, *not owner
$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();

if (elgg_in_context('widgets')) {
	$size = 'tiny';
	$style = 'max-width:16px; max-height:16px;';
} else {
	$size = 'small';
	$style = 'max-width:40px; max-height:40px;';
}


// Small view
if (elgg_instanceof($object, 'object')) {
	//if (elgg_instanceof($object, 'object', 'file') && ($object->$simpletype == "image")) {
	if (elgg_instanceof($object, 'object', 'file')) {
		echo '<img src="' . $object->getIconUrl(array('size' => $size)) . '" alt="object ' . $object->getSubtype() . '" style="' . $style . '" />';
	} else {
		echo '<span class="' . $size . '">' . elgg_echo('esope:icon:'.$object->getSubtype()) . '</span>';
	}
} else if (elgg_instanceof($object, 'site')) {
	// join site
	echo '<img src="' . $subject->getIconUrl(array('size' => $size)) . '" alt="' . $subject->getType() . ' ' . $subject->getSubtype() . '" style="' . $style . '" />';
} else {
	//echo elgg_view_entity_icon($object, $size);
	echo '<img src="' . $object->getIconUrl(array('size' => $size)) . '" alt="' . $object->getType() . ' ' . $object->getSubtype() . '" style="' . $style . '" />';
}


