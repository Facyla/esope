<?php

if (elgg_get_context() !== 'profile' || elgg_extract('size', $vars) !== 'large') {
	return;
}

if (!elgg_get_plugin_setting('profile_display', 'elggx_userpoints')) {
	return;
}

/*
<div class="userpoints_profile mtm">
	<div><span><?php echo elgg_echo('elggx_userpoints:upperplural') . ': ' . $vars['entity']->userpoints_points;?></span></div>
</div>
*/
// Compare to max points, and adjust accordingly
$max_userpoints_users = elgg_get_entities([
	'type' => 'user', 'limit' => 1, 'offset' => 0,
	'order_by_metadata' => ['name' => 'userpoints_points', 'direction' => 'DESC', 'as' => 'integer'],
	'metadata_name_value_pairs' => ['name' => 'userpoints_points', 'value' => 0, 'operand' => '>'],
]);
$max_userpoints = (float) $max_userpoints_users[0]->userpoints_points;
$user_points = $vars['entity']->userpoints_points;
$rank = 'user-rank-0';
$rank_stars = '☆☆☆☆☆';
$rank_text = "Nouveau contributeur";
if ($max_userpoints > 0) {
	$ratio = (float) $user_points / $max_userpoints;
	//echo "RATIO = $user_points / $max_userpoints = $ratio";
	switch (true) {
		case (!$ratio || $ratio === 0):
			$rank = 'user-rank-none';
			$rank_stars = '☆☆☆☆☆';
			$rank_text = "Bébé contributeur";
			break;
		case ($ratio < 0.1):
			$rank = 'user-rank-0';
			$rank_stars = '★☆☆☆☆';
			$rank_text = "Jeune contributeur";
			break;
		case ($ratio >= 0.1 && $ratio < 0.2):
			$rank = 'user-rank-1';
			$rank_stars = '★☆☆☆☆';
			$rank_text = "Jeune contributeur";
			break;
		case ($ratio >= 0.2 && $ratio < 0.3):
			$rank = 'user-rank-2';
			$rank_stars = '★★☆☆☆';
			$rank_text = "Contributeur";
			break;
		case ($ratio >= 0.3 && $ratio < 0.4):
			$rank = 'user-rank-3';
			$rank_stars = '★★☆☆☆';
			$rank_text = "Contributeur expérimenté";
			break;
		case ($ratio >= 0.4 && $ratio < 0.5):
			$rank = 'user-rank-4';
			$rank_stars = '★★★☆☆';
			$rank_text = "Contributeur prolixe";
			break;
		case ($ratio >= 0.5 && $ratio < 0.6):
			$rank = 'user-rank-5';
			$rank_stars = '★★★☆☆';
			$rank_text = "Super-Contributeur";
			break;
		case ($ratio >= 0.6 && $ratio < 0.7):
			$rank = 'user-rank-6';
			$rank_stars = '★★★★☆';
			$rank_text = "Contributeur spécialiste";
			break;
		case ($ratio >= 0.7 && $ratio < 0.8):
			$rank = 'user-rank-7';
			$rank_stars = '★★★★☆';
			$rank_text = "Contributeur spécialiste";
			break;
		case ($ratio >= 0.8 && $ratio < 0.9):
			$rank = 'user-rank-8';
			$rank_stars = '★★★★★';
			$rank_text = "Contributeur expert";
			break;
		case ($ratio >= 0.9 && $ratio < 1):
			$rank = 'user-rank-9';
			$rank_stars = '★★★★★';
			$rank_text = "Contributeur Top niveau !";
			break;
		case ($ratio == 1):
			$rank = 'user-rank-top';
			$rank_stars = '★★★★★';
			$rank_text = "Contributeur Top niveau !";
			break;
	}
}

?>
<div class="userpoints_profile mtm">
	<div class="<?php echo $rank; ?>" title="<?php echo $vars['entity']->userpoints_points . ' ' . elgg_echo('elggx_userpoints:lowerplural'); ?> - <?php echo $rank_text; ?>">
		<span class="userpoints-count"><?php echo $vars['entity']->userpoints_points; ?></span>
		<span class="userpoints-stars"><?php echo $rank_stars; ?></span>
	</div>
</div>

