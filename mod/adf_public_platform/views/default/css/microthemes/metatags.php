<?php	
$page_owner = elgg_get_page_owner_entity();

if ($page_owner) {// && $page_owner->microtheme && get_entity($page_owner->microtheme)) {
	echo "<link rel=\"stylesheet\" href=\"{$vars['url']}microthemes/css/{$page_owner->username}\" type=\"text/css\" />";
}
