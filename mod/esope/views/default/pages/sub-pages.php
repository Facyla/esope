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
	echo '<h3>' . elgg_echo('esope:pages:subpages') . '</h3>';
	echo $subpages;
	echo '</div>';
}

