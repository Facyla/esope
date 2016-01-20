<?php
/**
 * Market Categories pages menu
 *
 * @uses $vars['type']
 */
 
if (elgg_get_plugin_setting('market_type', 'market') == 'no') {
	return true;
}

$category = get_input('cat', 'all', true);
$selected_type = get_input('type', 'all', true);

if (empty($category)) {
	 $category = 'all';
}

//set the url
$url = elgg_get_site_url() . "market/category/$category/";
$types = array('all', 'buy', 'sell', 'swap', 'free');
foreach ($types as $type) {
	$tabs[] = array(
		'title' => elgg_echo("market:type:{$type}"),
		'url' => $url . $type,
		'selected' => $selected_type == $type,
	);
}

echo elgg_view('navigation/tabs', array('tabs' => $tabs));



