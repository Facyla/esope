<?php
/**
 * Profile info box
 */

$db_prefix = elgg_get_config('dbprefix');
$user = elgg_get_page_owner_entity();
$own = elgg_get_logged_in_user_entity();
$url = elgg_get_site_url();

$max_groups = 4;
$max_friends = 6;

$profile_type = esope_get_user_profile_type($user);
if (empty($profile_type)) { $profile_type = 'external'; }

$banner_css = '#424B5F';
if ($profile_type == 'external') { $banner_css = '#F7A621'; }

//if (!empty($user->banner)) { $banner_css = " url('{$url}groups/file/{$user->guid}/banner) no-repeat center/cover"; }
//$banner_css = "linear-gradient(rgba(66, 75, 95, 0.45), rgba(66, 75, 95, 0.45)), #424B5F url('{$url}mod/theme_inria/graphics/aleatoire/" . rand(0,7) . ".png') no-repeat center/cover";
//$banner_css = "linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), #424B5F url('{$url}mod/theme_inria/graphics/backgrounds/profile/" . rand(1,3) . ".jpg') no-repeat center/cover";
$banner_css .= " url('{$url}mod/theme_inria/graphics/backgrounds/profile/" . rand(1,3) . ".jpg') no-repeat center/cover";

?>

<div class="iris-profile-header" style="background: <?php echo $banner_css; ?>;">
	<?php echo elgg_view('profile/iris_header', $vars); ?>
</div>
<div class="iris-profile-info">
	<?php echo elgg_view('profile/iris_profile_info', $vars); ?>
</div>


<div class="iris-cols">
	
	<div class="iris-col">
		<?php
		if ($user->guid == $own->guid || $user->canEdit()) {
			echo '<a href="'. elgg_get_site_url() . 'profile/' . $user->username . '/edit' . '" class="view-all float-alt">' . elgg_echo('profile:edit') . '</a>';
		}
		?>
		<h2><?php echo elgg_echo('theme_inria:aboutme'); ?></h2>
		<div class="iris-box">
			<?php echo elgg_view('profile/iris_details'); ?>
		
			<div class="iris-profile-field">
				<?php // Groupes du membre
				$options = array(
						'type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid,
						'limit' => false, 'full_view' => FALSE, 'pagination' => FALSE,
					);
				$user_groups = elgg_get_entities_from_relationship($options);
				$user_groups_count = sizeof($user_groups);
				echo '<h4>' . elgg_echo('theme_inria:user:groups:title', array($user_groups_count)) . '</h4>';
				foreach ($user_groups as $k => $ent) {
					//echo '<div class=""><a href="' . $ent->getUrl() . '">' . elgg_view_entity_icon($ent, 'small') . '</a></div>';
					if ($k >= $max_groups) { $hidden = "hidden"; } else { $hidden = ''; }
					echo '<div class="iris-user-groups float ' . $hidden . '"><a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconURL(array('size' => 'medium')) . '" /></a></div>';
				}
				// New group or show all groups ?
				//if ($own->guid == $user->guid) {
				//	echo '<div class="iris-user-groups-add float"><a href="' . elgg_get_site_url() . 'groups/all">+</a></div>';
				// Add toggle for next groups
				if ($user_groups_count > $max_groups) {
					$count = $user_groups_count - $max_groups;
					$style = '';
					if (strlen((string)$count) > 2) { $style = 'font-size: 1rem; line-height: 1rem; padding-top: 0.7rem;'; }
					echo '<div class="iris-user-groups-add float" style="' . $style . '"><a href="javascript:void(0);" onClick="javascript:$(\'.iris-profile-field .iris-user-groups.hidden\').removeClass(\'hidden\'); $(this).parent().hide();" title="' . elgg_echo('theme_inria:viewall') . '">+'. ($user_groups_count - $max_groups) . '</a></div>';
				}
				?>
				<div class="clearfloat"></div>
			</div>
			
			<div class="iris-profile-field">
				<?php // Contacts du membre
				$options = array(
						'type' => 'user', 'relationship' => 'friend', 'relationship_guid' => $user->guid,
						'limit' => false, 'size' => "small", 'list_type' => 'gallery', 'pagination' => false,
					);
				$user_friends = elgg_get_entities_from_relationship($options);
				$user_friends_count = sizeof($user_friends);
				echo '<h4>' . elgg_echo('theme_inria:user:friends:title', array($user_friends_count)) . '</h4>';
				foreach ($user_friends as $k => $ent) {
					if ($k >= $max_friends) { $hidden = "hidden"; } else { $hidden = ''; }
					echo '<div class="iris-user-friend float ' . $hidden . '"><a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconURL(array('size' => 'medium')) . '"/></a></div>';
				}
				//if ($own->guid == $user->guid) {
				//	echo '<div class="iris-user-friends-add float"><a href="' . elgg_get_site_url() . 'members">+</a></div>';
				// Add toggle for next groups
				if ($user_friends_count > $max_friends) {
					$count = $user_friends_count - $max_friends;
					$style = '';
					if (strlen((string)$count) > 2) { $style = 'font-size: 1rem; line-height: 1rem; padding-top: 0.7rem;'; }
					echo '<div class="iris-user-friends-add float" style="' . $style . '"><a href="javascript:void(0);" onClick="javascript:$(\'.iris-profile-field .iris-user-friend.hidden\').removeClass(\'hidden\'); $(this).parent().hide();" title="' . elgg_echo('theme_inria:viewall') . '">+'. $count . '</a></div>';
				}
				?>
				<div class="clearfloat"></div>
			</div>
		</div>
	</div>
	
	<div class="iris-col">
		<?php echo '<a href="'. elgg_get_site_url() . 'activity/owner/' . $user->username . '" class="view-all float-alt">' . elgg_echo('theme_inria:user:activity:all') . '</a>'; ?>
		<h2><?php echo elgg_echo('theme_inria:user:activity'); ?></h2>
		<div class="iris-box">
			<?php
			$activity = elgg_list_river(array('subject_guids' => $user->guid, 'limit' => 6, 'pagination' => true));
			echo '<div class="profile-activity-river">' . $activity . '</div>';
			?>
		</div>
	</div>
	
</div>


