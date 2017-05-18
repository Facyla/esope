<?php
/**
 * Profile info box
 */

$db_prefix = elgg_get_config('dbprefix');
$user = elgg_get_page_owner_entity();
$own = elgg_get_logged_in_user_entity();

?>

<?php /* We add mrn here because we're doing stupid things with the grid system. Remove this hack */ ?>
<div class="iris-profile-header" style="">
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
				<?php
				$options = array(
						'type' => 'group', 'relationship' => 'member', 'relationship_guid' => $user->guid,
						'limit' => false, 'full_view' => FALSE, 'pagination' => FALSE,
					);
				$user_groups = elgg_get_entities_from_relationship($options);
				$user_groups_count = sizeof($user_groups);
				echo '<h4>' . elgg_echo('theme_inria:user:groups:title', array($user_groups_count)) . '</h4>';
				foreach ($user_groups as $ent) {
					//echo '<div class=""><a href="' . $ent->getUrl() . '">' . elgg_view_entity_icon($ent, 'small') . '</a></div>';
					echo '<div class="iris-user-groups float"><a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconURL(array('size' => 'medium')) . '" /></a></div>';
				}
				if ($own->guid == $user->guid) {
					echo '<div class="iris-user-groups-add float"><a href="' . elgg_get_site_url() . 'groups/all">+</a></div>';
				}
				?>
				<div class="clearfloat"></div>
			</div>
			
			<div class="iris-profile-field">
				<?php
				$options = array(
						'type' => 'user', 'relationship' => 'friend', 'relationship_guid' => $user->guid,
						'limit' => false, 'size' => "small", 'list_type' => 'gallery', 'pagination' => false,
					);
				$user_friends = elgg_get_entities_from_relationship($options);
				$user_friends_count = sizeof($user_friends);
				echo '<h4>' . elgg_echo('theme_inria:user:friends:title', array($user_friends_count)) . '</h4>';
				foreach ($user_friends as $ent) {
					echo '<div class="iris-user-friend float"><a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconURL(array('size' => 'medium')) . '"/></a></div>';
				}
				if ($own->guid == $user->guid) {
					echo '<div class="iris-user-friends-add float"><a href="' . elgg_get_site_url() . 'members">+</a></div>';
				}
				?>
				<div class="clearfloat"></div>
			</div>
		</div>
	</div>
	
	<div class="iris-col">
		<h2><?php echo elgg_echo('theme_inria:activity'); ?></h2>
		<div class="iris-box">
			<?php
			$activity = elgg_list_river(array('subject_guids' => $user->guid, 'limit' => 6, 'pagination' => true));
			echo '<div class="profile-activity-river">' . $activity . '</div>';
			?>
		</div>
	</div>
	
</div>


