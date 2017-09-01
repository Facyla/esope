<?php
/**
 * Sub-pages
 *
 * @uses $vars['entity'] Page object
 */

$page = elgg_extract('entity', $vars, false);

$subpages = esope_list_subpages($page, 'url', false);

$add_subpage = '<a href="' . elgg_get_site_url() . 'pages/add/' . $page->guid . '" class="elgg-button elgg-button-action float-alt">' . elgg_echo('pages:newchild') . '</a>';
echo '<div class="esope-subpages-menu elgg-output">';
	if ($subpages) {
		echo $add_subpage;
		echo '<h3>' . elgg_echo('esope:pages:subpages') . '</h3>';
		echo $subpages;
	} else {
		echo '<p>' . $add_subpage . '<br /><br /></p>';
		echo '<div class="clearfloat"></div>';
	}
	echo '</div>';

