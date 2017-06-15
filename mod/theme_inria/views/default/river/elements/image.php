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

//if ((elgg_in_context('widgets') || elgg_in_context('activity')) && !elgg_instanceof($object, 'object', 'file')) {
if ( (elgg_instanceof($object, 'object') || elgg_instanceof($object, 'site')) 
	&& !elgg_instanceof($object, 'object', 'file') 
	&& (elgg_in_context('widgets') || elgg_in_context('activity') || elgg_in_context('main') || elgg_in_context('profile'))
	) {
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
		$icon = '<img src="' . $object->getIconUrl(array('size' => $size)) . '" alt="object ' . $object->getSubtype() . '" style="' . $style . '" />';
	} else {
		$icon = '<span class="' . $size . '">' . elgg_echo('esope:icon:'.$object->getSubtype()) . '</span>';
	}
} else if (elgg_instanceof($object, 'site')) {
	// join site
	//$icon = '<img src="' . $subject->getIconUrl(array('size' => $size)) . '" alt="' . $subject->getType() . ' ' . $subject->getSubtype() . '" style="' . $style . '" />';
	$icon = '<span class="' . $size . '"><i class="fa fa-sign-in"></i></span>';
} else {
	//$icon = elgg_view_entity_icon($object, $size);
	//$icon = '<span class="' . $size . '"><i class="fa fa-sign-in"></i></span>';
	$icon = '<img src="' . $object->getIconUrl(array('size' => $size)) . '" alt="' . $object->getType() . ' ' . $object->getSubtype() . '" style="' . $style . '" />';
}

echo elgg_view('output/url', array(
		'href' => $object->getURL(),
		'text' => $icon,
));
