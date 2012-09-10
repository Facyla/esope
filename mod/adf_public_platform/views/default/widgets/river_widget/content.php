<?php
/**
 * Activity widget content view
 */

$num = (int) $vars['entity']->num_display;

$options = array(
	'limit' => $num,
	'pagination' => false,
);

if (elgg_in_context('dashboard')) {
	if ($vars['entity']->content_type == 'friends') {
		$options['relationship_guid'] = elgg_get_page_owner_guid();
		$options['relationship'] = 'friend';
	}
} else {
	$options['subject_guid'] = elgg_get_page_owner_guid();
}

$content = elgg_list_river($options);
if (!$content) {
	$content = elgg_echo('river:none');
}

$content .= '<span class="elgg-widget-more"><a href="' . $vars['url'] . 'activity">Voir toute l\'activité du site</a></span>';

echo $content;
