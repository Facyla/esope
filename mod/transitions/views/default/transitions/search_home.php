<?php
$category = get_input('category', '');
$actor_type = get_input('actor_type', '');

$categories = transitions_get_category_opt(null, false);

$category_opt = transitions_get_category_opt(null, true, true);


echo '<div class="transitions-search-menu">';

echo '<form method="POST" action="' . elgg_get_site_url() . 'catalogue/" id="transitions-search-home">';
	echo elgg_view('input/text', array('name' => "q", 'placeholder' => elgg_echo('transitions:search:placeholder')));
	
	//echo elgg_view('input/submit', array('value' => "Go"));
	echo elgg_view('input/submit', array('value' => elgg_echo('transitions:search:go')));
echo '</form>';

echo '<div class="clearfloat"></div>';

//echo '<a href="' . elgg_get_site_url() . 'catalogue/" class="elgg-button transitions-all">' . elgg_echo('transitions:category:nofilter') . '</a>';
foreach($categories as $name => $trans_name) {
	echo '<a href="' . elgg_get_site_url() . 'catalogue/' . $name . '" class="elgg-button transitions-' . $name . '">' . $trans_name . '</a>';
}

echo '</div>';

//echo elgg_view('search/header');



