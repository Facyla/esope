<?php
$members = $vars['members'];
if (is_array($members)) {
	echo '<div class="membersWrapper"><div class="recentMember">';
	foreach($members as $member) {
		echo elgg_view_entity_icon($member, 'tiny');
	}
	echo '</div><div class="clearfloat"></div>';
echo '</div>';
}
