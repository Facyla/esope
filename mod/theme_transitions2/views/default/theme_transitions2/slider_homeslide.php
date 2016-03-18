<?php
$guid = elgg_extract('guid', $vars);

$slide_content = '';

// Assume GUID are for mainly for transitions objects
if (is_numeric($guid)) {
	$object = get_entity($guid);
	if (elgg_is_active_plugin('transitions') && elgg_instanceof($object, 'object', 'transitions')) {
		$excerpt = '<p><em>' . $object->excerpt . '</em></p><p>' . elgg_get_excerpt($object->description) . '</p>';
		$slide_content .= '<a href="' . $object->getURL() . '">';
		$slide_content .= '<img src="' . $object->getIconURL('gallery') . '" class="transitions2-slide-image" />';
		$slide_content .= '<div class="transitions2-slide-text">';
		$slide_content .= '<div class="transitions2-slide-text-inner">';
		$slide_content .= '<h3>' . $object->title . '</h3>';
		//$slide_content .= strip_tags($cmspage->description);
		$slide_content .= $excerpt;
		$slide_content .= '</div>';
		$slide_content .= '</div>';
		$slide_content .= '</a>';
	}
}

// Assume everything else is a cmspage object (strings + non-matching GUIDs)
if (empty($slide_content)) {
	$object = cmspages_get_entity($guid);
	if (elgg_is_active_plugin('cmspages') && elgg_instanceof($object, 'object', 'cmspage')) {
		$slide_content .= '<a href="' . $object->getURL() . '">';
		$slide_content .= '<img src="' . $object->getFeaturedImageURL('original') . '" class="transitions2-slide-image" />';
		$slide_content .= '<div class="transitions2-slide-text">';
		$slide_content .= '<div class="transitions2-slide-text-inner">';
		$slide_content .= '<h3>' . $object->pagetitle . '</h3>';
		//$slide_content .= strip_tags($cmspage->description);
		$slide_content .= $object->description;
		$slide_content .= '</div>';
		$slide_content .= '</div>';
		$slide_content .= '</a>';
	}
}

echo $slide_content;


