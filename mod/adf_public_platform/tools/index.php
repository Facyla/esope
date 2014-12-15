<?php
/**
 * List a user's or group's pages
 *
 * @package ElggPages
 */


require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php");
admin_gatekeeper();

$title = "Outils d'administration spécifiques";
$content = '';
$sidebar = '';


$content .= "<p>Ces outils ne sont à utiliser que dans des cas particuliers, et nécessitent souvent un double accès administrateur et au code source pour être utilisés, du fait de leurs effets potentiels.</p>";

$content .= "<p>Veuillez consulter leur code source avant de les utiliser.</p>";

$content .= "<p><strong>Pour les outils critiques, veuilez effectuer un backup avant utilisation (spam, widgets, mises à jour, etc.)</p>";

$content .= "<p>group_admins : listes les administrateurs des groupes, et surtout les co-admins.</p>";
$content .= "<p>group_newsletters_default : définit le réglage des newsletters des groupes sur 'no', lorsque aucun réglage n'est encore défini.</p>";
$content .= "<p>group_updates : modifie les champs ->groupmenu1 et ->groupmenu2 utilisés dans certaines versions d'Elgg 1.6 pour définir de nouveaux champs ->customtab1 et ->customtab2. Passage nécessaire par le code source pour activation.</p>";
$content .= "<p>spam_users_list : outil très puissant, et très dangereux, pour supprimer massivement des comptes de spam, sur la base de divers critères. Passage obligé par le code source avant activation, et pour une utilisation optimale.</p>";
$content .= "<p>test_mail_notifications : envoie un mail de notification à chaque consultation de la page. Pratique pour tester le design des notifications en direct.</p>";
$content .= "<p>threads_disable : à utiliser avant désactivation du plugin threads, si l'on souhaite ne plus utiliser celui-ci (qui pose divers problèmes).</p>";
$content .= "<p>user_updates : Suppression des widgets du dashboard pour tous les utilisateurs. Passage par le code nécessaire pour activer.</p>";




$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);


$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);


