<?php
/**
 * Iris sidebar object view
 *
 */

$group = elgg_get_page_owner_entity();

if (elgg_is_active_plugin('feedback')) {
	$feedbackgroup = elgg_get_plugin_setting("feedbackgroup", "feedback");
	if (!empty($feedbackgroup) && ($feedbackgroup != 'no')) {
		if (($feedbackgroup == 'grouptool' && ($group->feedback_enable == 'yes')) || ($feedbackgroup == $group->guid)) {
			$options = array('type' => 'object', 'subtype' => 'feedback', 'limit' => 2);
			$count = elgg_get_entities($options + array('count' => true));
			$objects = elgg_get_entities($options);

			$content = '';
			if ($objects) {
				foreach ($objects as $ent) {
					$content .= '<div class="feedback">';
						$content .= '<a href="' . $ent->getURL() . '" title="' . $ent->title . '">';
							//$image = '<img src="' . $ent->getIconURL(array('size' => 'small')) . '" />';
							$image = esope_get_fa_icon($ent, 'tiny');
							//$body = '<p>' . elgg_get_excerpt($ent->title, 64) . '</p>';
							$body = '<p>' . $ent->title . '</p>'; // Already an excerpt from input text
							$content .= elgg_view_image_block($image, $body);
						$content .= '</a>';
					$content .= '</div>';
				}
			}

			$all_link = elgg_view('output/url', array(
				'href' => "groups/content/$group->guid/feedback/all",
				'text' => elgg_echo('theme_inria:workspace:feedback'). ' &nbsp; <i class="fa fa-angle-right"></i>',
				'is_trusted' => true,
			));

			$new_link = elgg_view('output/url', array(
				'href' => "javascript:void(0)",
				'onclick' => "FeedBack_Toggle()",
				'text' => '+', 
				'title' => elgg_echo('feedback:add'),
				'class' => "add-plus float-alt",
				'is_trusted' => true,
			));


			echo '<div class="iris-sidebar-content">';
				echo '<div class="workspace-subtype-header">';
					echo $new_link;
					echo '<h3>' . $all_link . '</h3>';
				echo '</div>';
				echo '<div class="workspace-subtype-content">';
					echo $content;
				echo '</div>';
			echo '</div>';
		}
	}
}

