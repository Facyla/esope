<?php

// Page handler
// Loads pages located in emojis/pages/emojis/
function emojis_page_handler($page) {
	$base = elgg_get_plugins_path() . 'emojis/pages/emojis';
	switch ($page[0]) {
		/*
		case 'view':
			set_input('guid', $page[1]);
			include "$base/view.php";
			break;
		*/
		default:
			include "$base/index.php";
	}
	return true;
}


