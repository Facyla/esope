<?php

$remove_all_url = elgg_get_site_url() . 'action/site_notifications/remove_all';
$remove_all_url = elgg_add_action_tokens_to_url($remove_all_url);
$remove_all_url = elgg_view('output/url', array(
	'href' => $remove_all_url,
	'text' => elgg_echo('theme_inria:site_notifications:delete_all'),
	'class' => 'elgg-button elgg-button-action',
	'confirm' => elgg_echo('theme_inria:site_notifications:delete_all:confirm'),
	'is_action' => true,
));

echo '<p>
	' . $remove_all_url . '
	<br />
	<em>' . elgg_echo('theme_inria:site_notifications:delete_all:details') . '</em>
	</p>';


