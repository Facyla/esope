<?php
/**
 * Friend widget display view
 *
 */

// owner of the widget
$owner = $vars['entity']->getOwnerEntity();

// the number of friends to display
$num = (int) $vars['entity']->num_display;

// get the correct size
$size = $vars['entity']->icon_size;

if (elgg_instanceof($owner, 'user')) {
	$html = $owner->listFriends('', $num, array(
		'size' => $size,
		'list_type' => 'gallery',
		'pagination' => false
	));
	$count = $owner->getFriends('', 99999);
	if (count($count) > $num) $html .= '<span class="elgg-widget-more"><a href="' . $vars['url'] . 'friends/' . $owner->username . '">' . elgg_echo('more:friends') . '</a></span>';
	if ($html) {
		echo $html;
	}
}
