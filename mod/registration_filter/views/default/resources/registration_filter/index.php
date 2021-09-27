<?php

//elgg_push_breadcrumb(elgg_echo('groups'), elgg_generate_url('collection:group:group:all'));

$content = elgg_view('registration_filter/registration_filter_rules');

echo elgg_view_page(elgg_echo('registration_filter:whitelist'), [
	'content' => $content,
	'class' => 'elgg-river-layout',
]);
