<?php
$category = get_input('category', '');
$actor_type = get_input('actor_type', '');

$categories = transitions_get_category_opt(null, false);

$lang_opt = transitions_get_lang_opt(null, true);
$actortype_opt = transitions_get_actortype_opt(null, true);
$category_opt = transitions_get_category_opt(null, true);


echo '<div class="transitions-search-menu">';

echo '<a href="?category=all" class="elgg-button transitions-all">' . elgg_echo('transitions:category:nofilter') . '</a>';
foreach($categories as $name => $category) {
	echo '<a href="?category=' . $name . '" class="elgg-button transitions-' . $name . '">' . $category . '</a>';
}

echo '<div class="clearfloat"></div><br />';

echo '<form>';
	echo '<label>' . elgg_echo('transitions:category') . elgg_view('input/select', array('name' => 'category', 'options_values' => $category_opt, 'value' => $category)) . '</label>';
	echo ' &nbsp; ';
	echo '<label>' . elgg_echo('transitions:actortype') . elgg_view('input/select', array('name' => 'actor_type', 'options_values' => $actortype_opt, 'value' => $actor_type)) . '</label>';

	echo elgg_view('input/text', array('name' => "q", 'style' => 'width:20em;'));
	
	echo elgg_view('input/submit', array('value' => "Rechercher"));
echo '</form>';

echo '</div>';

//echo elgg_view('search/header');



