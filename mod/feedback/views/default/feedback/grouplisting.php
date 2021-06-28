<?php
// Give access to feedbacks in groups
$feedbackgroup = elgg_get_plugin_setting('feedbackgroup', "feedback");
if (!empty($feedbackgroup) && ($feedbackgroup != 'no') && elgg_is_logged_in()) {
	$page_owner = elgg_get_page_owner_entity();
	if ($page_owner instanceof ElggGroup) {
		// Only add feedback to a group if it is allowed
		if (!empty($feedbackgroup) && ($feedbackgroup != 'no')) {
			if (($page_owner->guid == $feedbackgroup) || (($feedbackgroup == 'grouptool') && ($page_owner->feedback_enable == 'yes')) ) {
				echo '<div class="elgg-module elgg-module-group elgg-module-group-feedback elgg-module-info">';
					echo '<div class="elgg-head">';
						echo '<span class="groups-widget-viewall"><a rel="nofollow" title="' . elgg_echo('feedback:admin:title') . ', ' . elgg_echo('viewall') . '" href="' . $vars['url'] . 'feedback/group/' . $page_owner->guid . '">' . elgg_echo('link:view:all') . '</a></span>';
						echo '<h3><i class="fa fa-bullhorn"></i> ' . elgg_echo('feedback:admin:title') . '</h3>';
					echo '</div>';
					echo '<div class="elgg-body">';
						echo elgg_view('feedback/list_feedbacks', []);
					echo '</div>';
				echo '</div>';
			}
		}
	}
}

