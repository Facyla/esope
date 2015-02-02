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
	if ($users) {
		foreach ($users as $ent) {
			$content .= '<p><a href="' . $ent->getURL() . '">' . $ent->email . ' => GUID&nbsp;: ' . $ent->guid . ', Username&nbsp;: ' . $ent->username . ', Nom&nbsp;: ' . $ent->name . '</a></p>';
		}
	} else {
		$content .= "<p>Aucun résultat</p>";
	}
}


$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);


$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);


