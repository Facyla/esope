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
			echo '<a href="'. elgg_get_site_url() . 'profile/' . $user->username . '/edit' . '" class="view-all float-alt">modifier le profil</a>';
		}
		?>
		<h2>A propos de moi</h2>
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
				echo '<h4>Groupes (' . sizeof($user_groups) . ')</h4>';
				foreach ($user_groups as $ent) {
					//echo '<div class=""><a href="' . $ent->getUrl() . '">' . elgg_view_entity_icon($ent, 'small') . '</a></div>';
					echo '<div class="float" style="margin:0 0.2rem 0.1rem 0;"><a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconURL(array('size' => 'medium')) . '" style="height:80px; width:80px;"/></a></div>';
				}
				if ($own->guid == $user->guid) {
					echo '<div class="float" style="height:5rem; width:5rem; border:1px dashed #384257; display:flex; text-align:center; line-height:5rem; font-size:2rem;"><a href="' . elgg_get_site_url() . 'groups/all" style="width: 100%; color: #384257;"><i class="fa fa-plus"></i></a></div>';
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
				echo '<h4>Mes contacts (' . sizeof($user_friends) . ')</h4>';
				foreach ($user_friends as $ent) {
					echo '<div class="float" style="margin:0 0.2rem 0.1rem 0; "><a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconURL(array('size' => 'medium')) . '" style="height:3.375rem; width:3.375rem; border-radius:3.375rem;"/></a></div>';
				}
				if ($own->guid == $user->guid) {
					echo '<div class="float" style="height:3.375rem; width:3.375rem; border:1px dashed #384257; display:flex; text-align:center; line-height:3.375rem; font-size:2rem;"><a href="' . elgg_get_site_url() . 'members" style="width: 100%; color: #384257;"><i class="fa fa-plus"></i></a></div>';
				}
				?>
				<div class="clearfloat"></div>
			</div>
		</div>
	</div>
	
	<div class="iris-col">
		<h2>Activité</h2>
		<div class="iris-box">
			<?php
			$activity = elgg_list_river(array('subject_guids' => $user->guid, 'limit' => 6, 'pagination' => true));
			echo '<div class="profile-activity-river">' . $activity . '</div>';
			?>
		</div>
	</div>
	
</div>


