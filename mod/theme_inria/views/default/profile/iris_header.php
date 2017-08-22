<?php
/**
 * Iris v2 profile header
 */

$user = elgg_get_page_owner_entity();
$own = elgg_get_logged_in_user_entity();

$profile_type = esope_get_user_profile_type($user);
if (empty($profile_type)) { $profile_type = 'external'; }
// Archive : replace profile type by member status archived
if ($user->memberstatus == 'closed') { $profile_type = 'archive'; }

?>
<div class="iris-profile-icon <?php if (in_array($profile_type, ['external', 'archive'])) { echo 'profile-type-' . $profile_type; } ?>" style="background-image:url('<?php echo $user->getIconUrl(array('size' => 'large')); ?>');" />
	<?php
	if ($user->canEdit()) {
		echo '<a href="' . elgg_get_site_url() . 'avatar/edit/' . $user->username . '" class="iris-profile-editavatar"><i class="fa fa-camera"></i><br />' . elgg_echo('edit') . '</a>';
	}
	if ($user->guid != $own->guid) {
		// Friendship and friend request
		if (!$user->isFriendOf($own->guid)) {
			// no, check if pending request
			if (check_entity_relationship($own->guid, 'friendrequest', $user->guid)) {
				// pending request
				echo elgg_view('output/url', array(
						'href' => "friend_request/{$own->username}#friend_request_sent_listing",
						'text' => '<i class=" fa fa-user-plus"></i>',
						'title' => elgg_echo('friend_request:friend:add:pending'),
						'class' => 'iris-profile-pendingfriend', 'is_action' => true
					));
			} else {
				// add as friend
				echo elgg_view('output/url', array(
						'href' => "action/friends/add?friend={$user->guid}",
						'text' => '<i class=" fa fa-user-plus"></i>',
						'title' => elgg_echo('friend:add'),
						'class' => 'iris-profile-addfriend', 'is_action' => true
					));
			}
		} else {
			// is friend, so remove friend link
			echo elgg_view('output/url', array(
					'href' => "action/friends/remove?friend={$user->guid}",
					'text' => '<i class=" fa fa-user-times"></i>',
					'title' => elgg_echo('friend:remove'),
					'class' => 'iris-profile-removefriend', 'is_action' => true
				));
		}
		// Send message
		echo '<a href="' . elgg_get_site_url() . 'messages/compose?send_to=' . $user->guid . '" class="iris-profile-sendmessage"><i class=" fa fa-envelope"></i></a>';
	}

	?>
</div>

<div class="iris-profile-title">
	<h2>
		<?php
		echo $user->name;
		// Add profile type badge, if defined
		if (!empty($profile_type)) { echo '<span class="iris-badge"><span class="iris-badge-' . $profile_type . '" title="' . elgg_echo('profile:types:'.$profile_type.':description') . '">' . elgg_echo('profile:types:'.$profile_type) . '</span></span>'; }
		?>
	</h2>
	<?php echo strip_tags($user->briefdescription); ?>
</div>


