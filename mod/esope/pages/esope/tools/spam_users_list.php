<?php
/**
 * Page admin pour supprimer massivement des comptes de spam
 * 
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010-2014
 * @link http://id.facyla.net/
 */


admin_gatekeeper();

// This is quite dangerous, so block by default.
// Sys admin, comment when you need it, and uncomment again once done !
exit; // @TODO : uncomment to proceed

global $CONFIG;

$title = '';
$content = '';

$limit = 50;
$offset = get_input('offset', 0);

$action = get_input('action', false);

$delete_guids = get_input('delete_guids', false);
if ($delete_guids) { $guids = esope_get_input_array($delete_guids); }

$email_match = get_input('email_match', false);
if ($email_match) { $matches = esope_get_input_array($email_match); }

echo implode(', ', $matches);


// Perform action
switch($action) {
	case 'delete_by_guid':
		foreach ($guids as $guid) {
			if ($ent = get_entity($guid)) {
				$content .= "$ent->guid $ent->username ($ent->name) : $ent->email => ";
				$content .= "DELETE";
				$content .= "<br />";
				//$ent->delete();
			}
		}
		break;
	
	case 'delete_by_email_match':
		$content .= "DELETE BY EMAIL DOMAIN MATCH<br />";
		$members = elgg_get_entities(array('types' => 'user', 'limit' => 0));
		if (!empty($email_match)) {
			foreach ($members as $ent) {
				$content .= "$ent->guid $ent->username ($ent->name) : $ent->email => ";
				if (!empty($ent->email)) {
					$domain = explode('@', $ent->email);
					// Mode exact
					if (in_array($domain[1], $matches)) {
						$content .= "DELETE";
						//$ent->delete(); // @TODO : uncomment to proceed
					}
					// Mode par recherche de la présence d'une chaîne
					foreach ($matches as $match) {
						if (strpos($domain[1], $match) !== false) {
							$content .= "DELETE";
							//$ent->delete(); // @TODO : uncomment to proceed
						}
					}
				}
				$content .= "<br />";
			}
		}
		break;
}


// Form
$content .= '<form action="' . current_page_url() . '" method="POST">';
$content .= '<p><label>ACTION : ' . elgg_view('input/text', array('name' => 'action', 'value' => $action)) . '</label></p>';
$content .= '<p><em>delete_by_guid, delete_by_email_match</em></p>';

$content .= '<p><label>GUIDs à supprimer : ' . elgg_view('input/plaintext', array('name' => 'delete_guids', 'value' => $delete_guids)) . '</label></p>';
$content .= '<p><label>Noms de domaines à supprimer : ' . elgg_view('input/plaintext', array('name' => 'email_match', 'value' => $email_match)) . '</label></p>';

$content .= elgg_view('input/submit');
$content .= '</form>';


/*
if ($countusers > $limitusers) $countusers = $limitusers;
$users = get_entities('user', '', 0, "time_created asc", $countusers, $offset, false, $site_guid);
$i = 0;
foreach($users as $user) {
  set_time_limit(0);
  // Suppression auto des users de la blacklist
  //$emaildomain = explode('@', $user->email);
  //if (in_array($emaildomain[1], $blacklist)) { $autodeleted .= $user->guid . ' supprimé<br />'; $user->delete(); continue; }
  
  if ($action == 'select') {
    if ($todelete_users && !in_array($user->guid, $todelete_users)) continue;
  } else {
    // On zappe certains comptes dont les caractéristiques ne sont pas celles de spammeurs
    //if (($user->admin == true) || ($user->admin == 'yes') || ($user->admin == '1')) continue;
    //if (!empty($user->fonction) || !empty($user->organisation)) continue;
    //if (strpos('_'.$user->username, 'openid_')) continue;
    //if (strpos($user->name, ' ')) continue;
  }
  $userstyle = ''; $groups = ''; $i++;
  if ($user->isbanned()) $userstyle .= 'text-decoration:line-through; ';
  if (!$user->enabled) $userstyle .= 'font-weight:bold; ';
  
  // Liste des groupes
  $groupcount = get_entities_from_relationship('member',$user->guid,false,'group','',0, '', 999, 0, true, $site_guid);
  $usergroups = get_entities_from_relationship('member',$user->guid,false,'group','',0, '', 999, 0, false, $site_guid);
  if ($usergroups) foreach ($usergroups as $group) $groups[] = $group->name;
  // NB publications : on ne compte que ce qui apparaît dans la recherche
  $nb_publications = get_entities('object', $alltypes, $user->guid, "time_created asc", 9999, 0, true, $site_guid);
  //$nb_publications .= ' / ' . get_entities('object', '', $user->guid, "time_created asc", 9999, 0, true, $site_guid);
  $wikisedits = get_annotations(0, "object", "", "page", "", $user->guid, 9999, 0, "desc");
  $nb_publications .= ' (+'.sizeof($wikisedits).')';
  // Nb participations forums
  $nb_forums = sizeof(get_annotations(0, "object", "", "group_topic_post", "", $user->guid, $limit, 0, "desc"));
  if ($nb_forums >$limit) $nb_forums = "> ".$limit;
  // Nb commentaires
  $nb_comments = sizeof(get_annotations(0, "object", "", "generic_comment", "", $user->guid, $limit, 0, "desc"));
  if ($nb_comments >$limit) $nb_comments = "> ".$limit;

  $organisation = $user->organisation;
  $organisation = (is_array($organisation)) ? implode(' / ', $user->organisation) : $organisation;
  
  $friendscount = count($user->getFriends('', $limit+1, 0));
  if ($friendscount >$limit) $friendscount = "> ".$limit;
  
//    <td><a href="'.$user->getURL().'">'.$user->name.'</a></td>
//    <td>'.$user->name.'</td>
  $area1 .= '<tr>';
  if ($todelete_users && in_array($user->guid, $todelete_users)) $area1 .= '<td>' . $i . ' <label for="check_' . $user->guid . '"><input type="checkbox" value="' . $user->guid . '" id="' . $user->guid . '" checked="checked" name="id[]"></label></td>';
  else $area1 .= '<td>' . $i . ' <label for="check_' . $user->guid . '"><input type="checkbox" value="' . $user->guid . '" id="' . $user->guid . '" name="id[]"></label></td>';
  $area1 .= '<td style="'.$userstyle.'">'.$user->username.' ('.$user->guid.')</td>';
  if (strpos($user->name, ' ')) $area1 .= '<td><strong>'.$user->name.'</strong></td>';
  else $area1 .= '<td>'.$user->name.'</td>';
  $area1 .= '<td>'.$user->email.'</td>';
  $area1 .= '<td>'.$organisation.'</td>';
  $area1 .= '<td>'.substr($user->fonction, 0, 100).'</td>';
  $area1 .= '<td>'.date('d/m/Y à H:m', $user->time_created).'</td>';
  $area1 .= '<td>'.date('d/m/Y à H:m', $user->last_action).'</td>';
  $area1 .= '<td>'.$friendscount.'</td>';
  $area1 .= '<td>'.$groupcount.'</td>';
  $area1 .= '<td>'.$nb_publications.'</td>';
  $area1 .= '<td>'.$nb_forums.'</td>';
  $area1 .= '<td>'.$nb_comments.'</td>';
  //$area1 .= '<td><a href="http://www.reseaufing.org/action/admin/user/delete?guid='.$user->guid.'&__elgg_ts='.$ts.'&__elgg_token='.$token.'">Supprimer le compte</a></td>';
  $area1 .= '</tr>';
}

$area1 .= '</tbody></table><br />';
$area1 .= $pagination;

$area1 .= '<input type="hidden" name="site_guid" value="' . $site_guid . '" />';
$area1 .= '<input type="hidden" name="offset" value="' . $offset . '" />';
$area1 .= '<input type="hidden" name="limitusers" value="' . $limitusers . '" />';
if ($action == "select") {
  $area1 .= '<input type="hidden" name="action" value="delete" />';
  $area1 .= '<input type="submit" value="Confirmer la suppression définitive des comptes sélectionnés" />';
} else if ($action == "delete") {
  $area1 .= '<input type="hidden" name="action" value="" />';
  $area1 .= '<input type="submit" value="Revenir à la liste initiale" />';
} else {
  $area1 .= '<input type="hidden" name="action" value="select" />';
  $area1 .= '<input type="submit" value="Sélectionner les comptes à supprimer" />';
}
$area1 .= '</form>';

if ($autodeleted) $autodeleted = '<h3>Comptes supprimés automatiquement (liste noire)</h3>' . $autodeleted . '<hr />';
$body = elgg_view_layout('one_column', elgg_view_title($title) . '<div class="contentWrapper">' . $autodeleted . $area1 . '</div>');

*/




$params = array(
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
);

$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);

