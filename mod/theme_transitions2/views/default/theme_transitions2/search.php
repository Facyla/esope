<?php

$categories = transitions_get_category_opt(null, false);

$lang_opt = transitions_get_lang_opt(null, true);
$actortype_opt = transitions_get_actortype_opt(null, true);
$category_opt = transitions_get_category_opt(null, true);


echo '<div class="transitions-search-menu">';

echo '<a href="' . full_url() . '" class="elgg-button transitions-all">' . elgg_echo('transitions:category:nofilter') . '</a>';
foreach($categories as $name => $category) {
	echo '<a href="?category=' . $name . '" class="elgg-button transitions-' . $name . '">' . $category . '</a>';
}

echo '<form>';
	echo elgg_view('input/select', array('name' => 'category', 'options_values' => $category_opt));
	echo elgg_view('input/select', array('name' => 'actor_type', 'options_values' => $actortype_opt));

	echo elgg_view('input/submit', array('value' => "Rechercher"));
echo '</form>';

echo '</div>';

//echo elgg_view('search/header');



