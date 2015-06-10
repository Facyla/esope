<?php

$url = $vars['url'];
$urlicon = $url . 'mod/esope/img/theme/';

$site = elgg_get_site_entity();
$title = $site->name;

if (elgg_is_logged_in()) {
  $own = $_SESSION['user'];
  $ownguid = $own->guid;
  $ownusername = $own->username;
  
  /*
  // Liste de ses groupes
  $groups = ''; $mygroups = array();
  $allowed_groups = explode(',', elgg_get_logged_in_user_entity()->external_groups);
  foreach ($allowed_groups as $group_guid) {
    $group = get_entity($group_guid);
    $mygroups[] = $group;
  }
  foreach ($mygroups as $group) {
    $groups .= '<li><a href="' . $group->getURL() . '">' 
      . '<img src="' . $group->getIconURL('tiny') . '" alt="' . str_replace('"', "''", $group->name) . ' (' . elgg_echo('esope:groupicon') . '" />'
      . $group->name . '</a></li>';
  }
  */
  
  /*
  // Liste des catégories (thématiques du site)
  if (elgg_is_active_plugin('categories')) {
    $categories = '';
    $themes = $site->categories;
    foreach ($themes as $theme) {
      $categories .= '<li><a href="' . $url . 'categories/list?category='.urlencode($theme) . '">' . $theme . '</a></li>';
    }
  }
  */
  
  // Messages non lus
  $num_messages = (int)messages_count_unread();
  if ($num_messages != 0) {
    $text = "$num_messages";
    $tooltip = elgg_echo("messages:unreadcount", array($num_messages));
    $messages = '<li class="invites"><a href="' . $url . 'messages/inbox/' . $ownusername . '" title="' .  $tooltip . '">' . $text . '</a></li>';
  }
  
  // "Invitations" dans les groupes : affiché seulement s'il y a des invitations en attente
  $group_invites = groups_get_invited_groups(elgg_get_logged_in_user_guid());
  $invites_count = sizeof($group_invites);
  if ($invites_count == 1) {
    $invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvite') . '">' . $invites_count . '</a></li>';
  } else if ($invites_count > 1) {
    $invites = '<li class="group-invites"><a href="' . $url . 'groups/invitations/' . $ownusername . '" title="' . $invites_count . ' ' . elgg_echo('esope:groupinvites') . '">' . $invites_count . '</a></li>';
  }
  // Demandes de contact en attente : affiché seulement s'il y a des demandes en attente
	$friendrequests_options = array("type" => "user", "count" => true, "relationship" => "friendrequest", "relationship_guid" => $own->guid, "inverse_relationship" => true);
  $friendrequests_count = elgg_get_entities_from_relationship($friendrequests_options);
  if ($friendrequests_count == 1) {
    $friendrequests = '<li class="invites"><a href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('esope:friendinvite') . '">' . $friendrequests_count . '</a></li>';
  } else if ($friendrequests_count > 1) {
    $friendrequests = '<li class="invites"><a href="' . $url . 'friend_request/' . $ownusername . '" title="' . $friendrequests_count . ' ' . elgg_echo('esope:friendinvites') . '">' . $friendrequests_count . '</a></li>';
  }
  
}
?>

      <header>
        <div class="interne">
          <h1><a href="<?php echo $url; ?>" title="<?php echo elgg_echo('esope:gotohomepage'); ?>"><?php
          echo elgg_get_plugin_setting('headertitle', 'esope');
          //'<span>D</span>epartements-en-<span>R</span>eseaux.<span class="minuscule">fr</span>';
          ?></a></h1>
          <?php if (elgg_is_logged_in()) { ?>
            <a href="<?php echo $url . 'profile/' . $ownusername; ?>"><span id="esope-profil"><img src="<?php echo $own->getIconURL('topbar'); ?>" alt="<?php echo $own->name; ?>" /> <?php echo $own->name; ?> (profil)</span></a>
            <nav>
              <ul>
                <li id="home"><a href="<?php echo $url; ?>">Tableau de bord & Projets</a></li>
                <li id="msg"><a href="<?php echo $url . 'messages/inbox/' . $ownusername; ?>"><?php echo elgg_echo('messages'); ?></a></li>
                <?php if ($messages) { echo $messages; } ?>
                <li id="man"><a href="<?php echo $url . 'friends/' . $ownusername; ?>"><?php echo elgg_echo('friends'); ?></a></li>
                <?php echo $friendrequests; ?>
                <li><a href="<?php echo $url . 'settings/user/' . $ownusername; ?>"><?php echo elgg_echo('esope:usersettings'); ?></a></li>
                    <!--
                <li><?php echo elgg_echo('esope:myprofile'); ?></a>
                    <li><a href="<?php echo $url . 'profile/' . $ownusername . '/edit'; ?>">Compléter mon profil</a></li>
                    <li><a href="<?php echo $url . 'avatar/edit/' . $ownusername . '/edit'; ?>">Changer la photo du profil</a></li>
                </li>
                    //-->
                <?php if (elgg_is_admin_logged_in()) { ?>
                  <li><a href="<?php echo $url . 'admin/dashboard/'; ?>"><?php echo elgg_echo('admin'); ?></a></li>
                <?php } ?>
                <li><?php echo elgg_view('output/url', array('href' => $url . "action/logout", 'text' => elgg_echo('logout'), 'is_action' => true)); ?></li>
              </ul>
            </nav>
          <?php } else {
            echo '<nav><ul><li><a href="' . $url . '">' . elgg_echo('esope:loginregister') . '</a></li></ul></nav>';
          } ?>
        </div>
      </header>


