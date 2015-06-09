<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */


require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
admin_gatekeeper();

$title = "Suppression des widgets du dashboard";
$content = '';
$sidebar = '';

exit;

$options = array('types' => 'user', 'limit' => false);
$all_users = elgg_get_entities($options);
$content .= "Le site comporte actuellement  " . count($all_users) . " membres.<br /><br />";

$content .= '<table>';

set_time_limit(0); // Ce sera long
foreach ($all_users as $ent) {
        $widgets = elgg_get_widgets($ent->guid, 'dashboard');
        $content .= '<tr>';
        $content .= '<td><a href="' . $ent->getURL() . '">' . $ent->name . '</a> (' . $ent->guid . ')</td>';
        $content .= '<td>';
        if ($widgets) foreach ($widgets as $widget) { foreach ($widget as $w) { $w->delete(); } }
        $content .= '</td>';
        $content .= '<tr>';
}
$content .= '</table>';
$content .= '<br />';



$params = array(
        'content' => $content,
        'title' => $title,
        'sidebar' => $sidebar,
);


$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);

