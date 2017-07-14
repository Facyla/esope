<?php
/**
 * Sub-pages
 *
 * @uses $vars['entity'] Page object
 */


$page = elgg_extract('entity', $vars, false);


$subpages = esope_list_subpages($page, 'url', false);

if ($subpages) {
	echo '<div class="esope-subpages-menu elgg-output">';
	echo '<a href="' . elgg_get_site_url() . 'pages/add/' . $page->guid . '" class="elgg-button elgg-button-action float-alt">' . elgg_echo('pages:newchild') . '</a>';
	echo '<h3>' . elgg_echo('esope:pages:subpages') . '</h3>';
	echo $subpages;
	echo '</div>';
} else {
	echo '<p><a href="' . elgg_get_site_url() . 'pages/add/' . $page->guid . '" class="elgg-button elgg-button-action">' . elgg_echo('pages:newchild') . '</a></p>';
}

