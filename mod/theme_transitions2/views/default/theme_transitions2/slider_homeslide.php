<?php
$guid = elgg_extract('guid', $vars);
$cmspage = cmspages_get_entity($guid);
$slide_content = '';
if (elgg_instanceof($cmspage, 'object', 'cmspage')) {
	$slide_content .= '<img src="' . $cmspage->getFeaturedImageURL('original') . '" class="transitions2-slide-image" />';
	$slide_content .= '<div class="transitions2-slide-text">';
	$slide_content .= '<div class="transitions2-slide-text-inner">';
	$slide_content .= '<h3>' . $cmspage->pagetitle . '</h3>';
	//$slide_content .= strip_tags($cmspage->description);
	$slide_content .= $cmspage->description;
	$slide_content .= '</div>';
	$slide_content .= '</div>';
}
echo $slide_content;


