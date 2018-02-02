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

// Iris v2 : use entity type icon, *not owner, except in email digest where an image is required
$subject = $item->getSubjectEntity();
$object = $item->getObjectEntity();

//echo print_r(implode(', ', elgg_get_context_stack()), true);
//echo $subject->getType() . '-' . $object->getType() . ' / ';

$is_digest = false;
if (elgg_in_context('digest') || elgg_in_context('cron')) { $is_digest = true; }


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

// These cases generate an image
if (elgg_instanceof($object, 'user')) {
	$profile_type = esope_get_user_profile_type($object);
	if (empty($profile_type)) { $profile_type = 'external'; }
	$icon = '<span class="elgg-avatar elgg-avatar-' . $size . ' elgg-profile-type-' . $profile_type . '"><img src="' . $object->getIconUrl(array('size' => $size)) . '" alt="' . $object->getType() . ' ' . $object->getSubtype() . '" style="' . $style . '" /></a>';
	
} else if (elgg_instanceof($object, 'group')) {
	// Replce group icon by user icon in river digest
	if (!$is_digest) {
		$icon = '<img src="' . $object->getIconUrl(array('size' => $size)) . '" alt="' . $object->getType() . ' ' . $object->getSubtype() . '" style="' . $style . '" />';
	} else {
		if (elgg_instanceof($subject, 'user')) {
			$profile_type = esope_get_user_profile_type($object);
			if (empty($profile_type)) { $profile_type = 'external'; }
			$icon = '<span class="elgg-avatar elgg-avatar-' . $size . ' elgg-profile-type-' . $profile_type . '"><img src="' . $object->getIconUrl(array('size' => $size)) . '" alt="' . $object->getType() . ' ' . $object->getSubtype() . '" style="' . $style . '" /></a>';
		}
	}

	
} else if (elgg_instanceof($object, 'object', 'file')) {
	$icon = '<img src="' . $object->getIconUrl(array('size' => $size)) . '" alt="object ' . $object->getSubtype() . '" style="' . $style . '" />';
	
} else {
	// Iris v2 : always use images for digest, so it can display correctly in emails
	if ($is_digest) {
		if (elgg_instanceof($subject, 'user')) {
			$profile_type = esope_get_user_profile_type($subject);
			if (empty($profile_type)) { $profile_type = 'external'; }
			$icon = '<span class="elgg-avatar elgg-avatar-' . $size . ' elgg-profile-type-' . $profile_type . '"><img src="' . $subject->getIconUrl(array('size' => $size)) . '" alt="' . $subject->username . ' ' . $subject->name . '" style="' . $style . '" /></a>';
		} else {
			//$icon = '<img src="' . $subject->getIconUrl(array('size' => $size)) . '" alt="' . $subject->getType() . ' ' . $subject->getSubtype() . '" style="' . $style . '" />';
		}
	} else {
		if (elgg_instanceof($object, 'object')) {
			$icon = '<span class="' . $size . '">' . elgg_echo('esope:icon:'.$object->getSubtype()) . '</span>';
		} else if (elgg_instanceof($object, 'site')) {
			$icon = '<span class="' . $size . '"><i class="fa fa-sign-in"></i></span>';
		} else {
			$icon = '<img src="' . $object->getIconUrl(array('size' => $size)) . '" alt="' . $object->getType() . ' ' . $object->getSubtype() . '" style="' . $style . '" />';
		}
	}
}

if ($icon) 
echo elgg_view('output/url', array(
		'href' => $object->getURL(),
		'text' => $icon,
));

