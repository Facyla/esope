<?php
/**
 * Elgg topbar
 * The standard elgg top toolbar
 */

// Elgg logo
// Transitions² : use custom site menu
$menu = elgg_get_plugin_setting('menu_topbar', 'theme_transitions2');
if (empty($menu)) $menu = 'topbar';

// Ajout au menu
/*
if (elgg_is_active_plugin('language_selector')) {
	$language_selector = elgg_view('language_selector/default');
	if ($language_selector) {
		echo '<li class="language-selector">' . $language_selector . '</li>';
	}
}
elgg_register_menu_item('extras', array(
	'name' => 'bookmark',
	'text' => elgg_view_icon('push-pin-alt'),
	'href' => "bookmarks/add/$user_guid?address=$address",
	'title' => elgg_echo('bookmarks:this'),
	'rel' => 'nofollow',
));
*/
?>

<a class="elgg-button-nav" rel="toggle" data-toggle-selector=".elgg-topbar-nav-collapse" href="#">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>

<div class="elgg-topbar-nav-collapse">
<?php
echo elgg_view_menu($menu, array('sort_by' => 'priority', array('elgg-menu-hz'), 'class' => "elgg-menu-topbar elgg-menu-topbar-default clearfix"));
echo '</div>';

// Language switch menu
echo elgg_view_menu('topbar-lang', array('sort_by' => 'priority', array('elgg-menu-hz'), 'class' => "elgg-menu-topbar clearfix"));

// elgg tools menu
// need to echo this empty view for backward compatibility.
echo elgg_view_deprecated("navigation/topbar_tools", array(), "Extend the topbar menus or the page/elements/topbar view directly", 1.8);

// Dropdown login box
$login_url = elgg_get_site_url();
if (elgg_get_config('https_login')) {
	$login_url = str_replace("http:", "https:", elgg_get_site_url());
}
$login_dropdown = elgg_view_form('login', array('action' => "{$login_url}action/login"), array('returntoreferer' => TRUE));
echo elgg_view_module('dropdown', '', $login_dropdown, array('id' => 'login-dropdown-box')); 

