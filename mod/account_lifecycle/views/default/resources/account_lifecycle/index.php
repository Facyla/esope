<?php
/**
 * Main delivery modes page
 */

elgg_admin_gatekeeper();

$url = elgg_get_site_url();

elgg_push_breadcrumb(elgg_echo('account_lifecycle:index'), 'account_lifecycle');

// @TODO bouton visible ssi les fonctionnalités avancées sont développées
//elgg_register_title_button('account_lifecycle', 'add', 'object', 'account_lifecycle');

$content = '';


$include_admin = elgg_get_plugin_setting('direct_include_admin', 'account_lifecycle');
$interval = elgg_get_plugin_setting('direct_interval', 'account_lifecycle');
$action = elgg_get_plugin_setting('direct_rule', 'account_lifecycle');
//$notifications = elgg_get_plugin_setting('direct_rule', 'account_lifecycle');

$direct_rule_opt = account_lifecycle_direct_rule_options();
$yes_no_opt = ['yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no')];
$no_yes_opt = ['no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')];


// Plugin parameters
$content .= "<h3>" . elgg_echo('account_lifecycle:parameters') . "</h3>";
$content .= '<ul style="list-style: initial; margin-left: 1rem;">' . "
	<li>" . elgg_echo('account_lifecycle:settings:direct_include_admin') . " : <strong>" . elgg_echo("option:$include_admin") . "</strong></li>
	<li>" . elgg_echo('account_lifecycle:settings:direct_interval') . " : <strong>tous les $interval jours</strong></li>
	<li>" . elgg_echo('account_lifecycle:settings:direct_rule') . " : <strong>{$direct_rule_opt[$action]}</strong></li>
</ul>
<br />";


// Direct mode run
$direct_mode = get_input('direct_mode');
$direct_force_run = get_input('direct_force_run');
$direct_simulate = get_input('direct_simulate');
$direct_verbose = get_input('direct_verbose');

$content .= "<h3>" . elgg_echo('account_lifecycle:mode_direct') . "</h3>";
$content .= '<em>' . elgg_echo('account_lifecycle:mode_direct:details') . '</em>';
//$content .= '<p>' . elgg_view('output/url', ['text' => "Vérifier maintenant", 'href' => "?direct_mode=yes", 'class' => "elgg-button elgg-button-action"]) . '</p>';
$content .= '<form id="account_lifecycle-direct-form" action="" method="GET">';
	$content .= "<label>" . elgg_echo('account_lifecycle:simulation') . ' ' . elgg_view('input/select', ['name' => 'direct_simulate', 'options_values' => $yes_no_opt, 'value' => $direct_simulate]) . "</label><br /><em>" . elgg_echo('account_lifecycle:simulation:details') . '</em><br />';
	$content .= "<label>" . elgg_echo('account_lifecycle:verbose') . ' ' . elgg_view('input/select', ['name' => 'direct_verbose', 'options_values' => $yes_no_opt, 'value' => $direct_verbose]) . "</label><br /><em>" . elgg_echo('account_lifecycle:verbose:details') . '</em><br />';
	$content .= "<label>" . elgg_echo('account_lifecycle:force_run') . ' ' . elgg_view('input/select', ['name' => 'direct_force_run', 'options_values' => $no_yes_opt, 'value' => $direct_force_run]) . "</label><br /><em>" . elgg_echo('account_lifecycle:force_run:details') . '</em><br />';
	$content .= elgg_view('input/hidden', ['name' => "direct_mode", 'value' => "yes"]);
	$content .= '<p>' . elgg_view('input/submit', ['value' => elgg_echo('account_lifecycle:run_now'), 'class' => "elgg-button elgg-button-action"]);
$content .= '</form>';

// Exécution
if ($direct_mode == 'yes') {
	$direct_force_run = ($direct_force_run == 'yes') ? true : false;
	$direct_simulate = ($direct_simulate == 'yes') ? true : false;
	$direct_verbose = ($direct_verbose == 'no') ? false : true;
	$content .= account_lifecycle_execute_rules($direct_force_run, $direct_simulate, $direct_verbose);
}



// Per-user mode
$cherrypicking_mode = get_input('cherrypicking_mode');
$cherry_force_run = get_input('cherry_force_run');
$cherry_simulate = get_input('cherry_simulate');
$cherry_verbose = get_input('cherry_verbose');
$cherry_users = get_input('cherry_users');

$content .= '<br /><br />';
$content .= "<h3>" . elgg_echo('account_lifecycle:cherrypicking') . "</h3>";
$content .= "<em>" . elgg_echo('account_lifecycle:cherrypicking:description') . "</em>";
$content .= '<ul style="list-style: initial; margin-left: 1rem;">' . "
	<li>" . elgg_echo('account_lifecycle:settings:direct_include_admin') . " : <strong>" . elgg_echo("option:$include_admin") . "</strong></li>
	<li>" . elgg_echo('account_lifecycle:settings:direct_interval') . " : <strong>tous les $interval jours</strong></li>
	<li>" . elgg_echo('account_lifecycle:settings:direct_rule') . " : <strong>{$direct_rule_opt[$action]}</strong></li>
</ul>";
$content .= '<form id="account_lifecycle-cherrypicking-form" action="" method="GET">';
	$content .= "<label>" . elgg_echo('account_lifecycle:select_users') . ' ' . elgg_view('input/userpicker', ['name' => 'cherry_users', 'value' => $cherry_users]) . "</label><br />";
	$content .= "<label>" . elgg_echo('account_lifecycle:simulation') . ' ' . elgg_view('input/select', ['name' => 'cherry_simulate', 'options_values' => $yes_no_opt, 'value' => $cherry_simulate]) . "</label><br />";
	$content .= "<label>" . elgg_echo('account_lifecycle:verbose') . ' ' . elgg_view('input/select', ['name' => 'cherry_verbose', 'options_values' => $yes_no_opt, 'value' => $cherry_verbose]) . "</label><br />";
	$content .= "<label>" . elgg_echo('account_lifecycle:force_run') . ' ' . elgg_view('input/select', ['name' => 'cherry_force_run', 'options_values' => $no_yes_opt, 'value' => $cherry_force_run]) . "</label><br />";
	$content .= elgg_view('input/hidden', ['name' => "cherrypicking_mode", 'value' => "yes"]);
	$content .= '<p>' . elgg_view('input/submit', ['value' => elgg_echo('account_lifecycle:run_now'), 'class' => "elgg-button elgg-button-action"]) . '</p>';
$content .= '</form>';

// Exécution
if ($cherrypicking_mode == 'yes') {
	$cherry_force_run = ($cherry_force_run == 'yes') ? true : false;
	$cherry_simulate = ($cherry_simulate == 'yes') ? true : false;
	$cherry_verbose = ($cherry_verbose == 'no') ? false : true;
	$content .= account_lifecycle_execute_rules($cherry_force_run, $cherry_simulate, $cherry_verbose, $cherry_users);
}



// Full featured mode - NOT FUNCTIONAL - NOT FULLY IMPLEMENTED
$content .= '<br /><br />';
$content .= "<h3>" . elgg_echo('account_lifecycle:mode_full') . "</h3>";
$content .= elgg_list_entities(['type' => 'object', 'subtype' => 'account_lifecycle', 'no_results' => elgg_echo('account_lifecycle:noresult'), 'order_by_metadata' => ['name' => 'position', 'direction' => 'ASC', 'as' => 'integer']]);




// SIDEBAR
$sidebar .= elgg_view('account_lifecycle/sidebar', ['selected' => 'check']);


// Sidebar droite
$sidebar_alt .= '';



echo elgg_view_page($title, [
	'title' => elgg_echo('account_lifecycle:index'),
	'content' =>  $content,
	'sidebar' => $sidebar,
	//'sidebar_alt' => $sidebar_alt,
	'class' => 'elgg-chat-layout',
]);

