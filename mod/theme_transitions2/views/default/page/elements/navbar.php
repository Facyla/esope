<?php
/**
 * Aalborg theme navbar
 * 
 */

// drop-down login
echo elgg_view('core/account/login_dropdown');

?>

<a class="elgg-button-nav" rel="toggle" data-toggle-selector=".elgg-nav-collapse" href="#">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>

<div class="elgg-nav-collapse">
	<?php
	// Transitions² : use custom site menu
	$menu = elgg_get_plugin_setting('menu_site', 'theme_transitions2');
	if (empty($menu)) $menu = 'site';
	echo elgg_view_menu($menu, array('class' => "elgg-menu-site elgg-menu-site-default clearfix"));
	?>
</div>
