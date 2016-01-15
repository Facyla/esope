<?php
/**
 * Elgg Market Plugin
 * @package market
 */

if (elgg_get_plugin_setting('market_adminonly', 'market') == 'yes') {
	admin_gatekeeper();
}
		
// How many classifieds can a user have
$marketmax = elgg_get_plugin_setting('market_max', 'market');
if(!$marketmax) {
	$marketmax = 0;
}

// How many classifieds can a freeloader have
if(elgg_is_active_plugin('vipmember')) {
	$user = elgg_get_logged_in_user_entity();
	if (!vipmember_isPayingMember($user)) {
		$marketmax = 1;
	}
}


// How many classifieds can a commercial user have
if (elgg_is_active_plugin('adserve')) {
	$user = elgg_get_logged_in_user_entity();
	if ($user->adserve_type == 'com') {
		$marketmax = elgg_get_plugin_setting('market_max', 'adserve');
		if(!$marketmax) {
			$marketmax = 0;
		}
	}
}

$marketactive = elgg_get_entities(array(
			'type' => 'object',
			'subtype' => 'market',
			'owner_guid' => elgg_get_logged_in_user_guid(),
			'count' => true
			));

$title = elgg_echo('market:add:title');

// Show form, or error if users has used his quota
if ($marketmax == 0 || elgg_is_admin_logged_in()) { 
	$form_vars = array(
			'name' => 'marketForm',
			'enctype' => 'multipart/form-data'
			);
	$body_vars = market_prepare_form_vars(NULL);
	$content = elgg_view_form("market/save", $form_vars, $body_vars);
} elseif ($marketmax > $marketactive) { 
	$form_vars = array(
			'name' => 'marketForm',
			'enctype' => 'multipart/form-data'
			);
	$body_vars = market_prepare_form_vars(NULL);
	$content = elgg_view_form("market/save", $form_vars, $body_vars);
} else {
	$content = elgg_view("market/error");
}

elgg_push_breadcrumb(elgg_echo('market:title'), "market/category");
elgg_push_breadcrumb(elgg_echo('market:add'));

// Show market sidebar
//$sidebar = elgg_view("market/sidebar");

$params = array(
		'content' => $content,
		'title' => $title,
		'sidebar' => $sidebar,
		);

$body = elgg_view_layout('one_sidebar', $params);

echo elgg_view_page($title, $body);
