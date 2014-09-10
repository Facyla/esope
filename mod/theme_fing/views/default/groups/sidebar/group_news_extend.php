<?php
// Note : if extending owner_block, there is no $vars ['entity']

$group = elgg_get_page_owner_entity();
if ($group->groupnews) {
	echo '<div class="clearfloat"></div>';
	echo $group->groupnews;
}

