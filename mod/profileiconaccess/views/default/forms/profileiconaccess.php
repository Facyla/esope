<?php

namespace AU\ProfileIconAccess;

elgg_require_js('profileiconaccess');

//$user = elgg_get_logged_in_user_entity();
$user = elgg_get_page_owner_entity();

$access = ($user->iconaccess === NULL) ? ACCESS_PUBLIC : $user->iconaccess;


echo '<div class="profileiconaccess">';
	echo '<label for="profileiconaccess-select">' . elgg_echo('profileiconaccess:label') . ' </label>';
	echo elgg_view('input/access', array(
				'name' => 'profileaccessicon',
				'value' => $access,
				'id' => 'profileiconaccess-select',
			));
	echo '<div class="profileiconaccess-throbber">';
		echo elgg_view('graphics/ajax_loader');
	echo '</div>';
echo '</div>';
