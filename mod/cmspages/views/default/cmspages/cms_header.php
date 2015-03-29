<?php
// Init custom CMS menu based on categories
cmspages_set_categories_menu();

echo elgg_view('cmspages/view', array('pagetype' => 'cms-header'));

echo '<div id="transverse"><div class="interne"><nav>';
echo elgg_view_menu('cmspages_categories', array('class' => 'elgg-menu-hz menu-navigation', 'sort_by' => 'weight'));
echo '</nav></div></div>';

