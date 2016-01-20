<?php
/**
 * Elgg Market Plugin
 * @package market (forked from webgalli's Classifieds Plugin)
 */

$selected_category = get_input('cat', 'all');

$categories = string_to_tag_array(elgg_get_plugin_setting('market_categories', 'market'));
array_unshift($categories , 'all');

if (!empty($categories)) {
	$url = elgg_get_site_url() . 'market/category/';
	echo "<ul>";
	foreach ($categories as $category) {
		echo "<li>";
		$selected = '';
		if ($selected_category == $category) {
			$selected = 'selected';
		}
		echo elgg_view('output/url', array(
					'href' => $url . $category,
					'text' => elgg_echo("market:category:$category"),
					'class' => "market-category-menu-item $selected",
					'is_trusted' => true,
					));
		echo "</li>";
	}
	echo "</ul>";
}

