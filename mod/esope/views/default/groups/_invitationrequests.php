<?php
/**
 * A user's group invitations
 *
 * @uses $vars['invitations'] Array of ElggGroups
 */

if (!empty($vars['invitations']) && is_array($vars['invitations'])) {
	$user = elgg_get_logged_in_user_entity();
	echo '<ul class="elgg-list">';
	foreach ($vars['invitations'] as $group) {
		if ($group instanceof ElggGroup) {
			// Facyla : removes invite if user is already a member
			if ($group->isMember($user)) {
				remove_entity_relationship($group->guid, 'invited', $user->guid);
				continue;
			}
			
			$icon = elgg_view_entity_icon($group, 'tiny', array('use_hover' => 'true'));

			$group_title = elgg_view('output/url', array(
				'href' => $group->getURL(),
				'text' => $group->name,
				'is_trusted' => true,
			));

			$url = elgg_add_action_tokens_to_url(elgg_get_site_url()."action/groups/join?user_guid={$user->guid}&group_guid={$group->guid}");
			$accept_button = elgg_view('output/url', array(
				'href' => $url,
				'text' => elgg_echo('accept'),
				'title' => elgg_echo('accept') . ' ' . $group->name,
				'class' => 'elgg-button elgg-button-submit',
				'confirm' => true,
				'is_trusted' => true,
			));

			$url = "action/groups/killinvitation?user_guid={$user->getGUID()}&group_guid={$group->getGUID()}";
			$delete_button = elgg_view('output/url', array(
					'href' => $url,
					'confirm' => elgg_echo('groups:invite:remove:check'),
					'text' => elgg_echo('decline'),
  				'title' => elgg_echo('decline') . ' ' . $group->name,
					'class' => 'elgg-button elgg-button-delete mlm',
			));

			$body = <<<HTML
<h4>$group_title</h4>
<p class="elgg-subtext">$group->briefdescription</p>
HTML;
			$alt = $accept_button . $delete_button;

			echo '<li class="pvs">';
			echo elgg_view_image_block($icon, $body, array('image_alt' => $alt));
			echo '</li>';
		}
	}
	echo '</ul>';
} else {
		echo '<p class="mtm">' . elgg_echo('groups:invitations:none') . "</p>";
}
