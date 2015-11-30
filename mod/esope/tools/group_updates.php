<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */


require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
admin_gatekeeper();

$title = "Modification de propriétés des groupes";
$content = '';
$sidebar = '';

exit;

$options = array('types' => 'group', 'limit' => false);
$all_groups = elgg_get_entities($options);
$content .= "Le site comporte actuellement  " . count($all_groups) . " groupes.<br /><br />";

$content .= '<table>';

set_time_limit(0);
foreach ($all_groups as $ent) {
	if (!empty($ent->groupmenu1)) {
		$menu1 = explode('::', $ent->groupmenu1);
		$menu1 = trim($menu1[1]) . '::' . trim($menu1[0]) . '::' . trim($menu1[3]);
		$ent->customtab1 = $menu1;
	}
	if (!empty($ent->groupmenu2)) {
		$menu2 = explode('::', $ent->groupmenu2);
		$menu2 = trim($menu2[1]) . '::' . trim($menu2[0]) . '::' . trim($menu2[3]);
		$ent->customtab2 = $menu2;
	}
	$ent->groupmenu1 = null;
	$ent->groupmenu2 = null;

        $content .= '<tr>';
        $content .= '<td><a href="' . $ent->getURL() . '">' . $ent->name . '</a> (' . $ent->guid . ')</td>';
        $content .= '<td>' . $ent->groupmenu1 . '</td>';
        $content .= '<td>' . $ent->groupmenu2 . '</td>';
        $content .= '<td>' . $menu1 . '</td>';
        $content .= '<td>' . $menu2 . '</td>';
        $content .= '<td>' . $ent->customtab2 . '</td>';
        $content .= '<td>' . $ent->customtab1 . '</td>';
        $content .= '<td>';
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


