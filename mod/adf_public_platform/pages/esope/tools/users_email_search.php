<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */


admin_gatekeeper();

$title = "Recherche de compte par email";
$content = '';
$sidebar = '';

$email = get_input('email');
$content .= '<form><p><label>Email à rechercher' . elgg_view('input/text', array('name' => 'email', 'value' => $email)) . '</label></p><p>' . elgg_view('input/submit', array('text' => elgg_echo('search'))) . '</p></form>';
$content .= '<div class="clearfloat"></div>';
if (!empty($email)) {
	$content .= '<h3>Comptes correspondant à "' . $email . '"</h3>';
	$users = get_user_by_email($email);
	$content .= "<h4>Recherche exacte</h4>";
	if ($users) {
		foreach ($users as $ent) {
			$icon = elgg_view_entity_icon($ent, 'tiny');
			$text = $ent->name . ' : <a href="' . $ent->getURL() . '">' . $ent->username . ' (GUID ' . $ent->guid . ') => ' . $ent->email . '</a>';
			$content .= elgg_view_image_block($icon, $text);
		}
	} else {
		$content .= "<p>Aucun résultat avec l'email : $email</p>";
	}
	// Match search search
	$content .= "<h4>Recherche par correspondance</h4>";
	$users = elgg_get_entities(array(
			'type' => 'user',
			'joins' => array("INNER JOIN " . elgg_get_config("dbprefix") . "users_entity ue USING(guid)"),
			'wheres' => array("ue.email LIKE '%$email%'"),
		));
	if ($users) {
		foreach ($users as $ent) {
			$icon = elgg_view_entity_icon($ent, 'tiny');
			$text = $ent->name . ' : <a href="' . $ent->getURL() . '">' . $ent->username . ' (GUID ' . $ent->guid . ') => ' . $ent->email . '</a>';
			$content .= elgg_view_image_block($icon, $text);
		}
	} else {
		$content .= "<p>Aucun email contenant : $email</p>";
	}
}


$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);


$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);


