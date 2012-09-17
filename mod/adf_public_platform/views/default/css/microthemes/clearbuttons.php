<?php
	$assign_to = $vars['assign_to'];
	$action_base = "{$vars['url']}action/microthemes/clear?assign_to=";
	$assign_to_entity = get_entity($vars['assign_to']);
	if (isadminloggedin()) {
		$site = get_site_by_url($vars['url']);
		if ($site->microtheme) {
			$action_ref = $action_base . $site->getGUID();
			$pars =  array(
				'href' => $action_ref,
				'text' => elgg_echo('microthemes:clearsite')
			);

			echo elgg_view('output/confirmlink', $pars);
		}
	}
	echo " ";
	if ($assign_to_entity->microtheme && $assign_to_entity->canEdit()) {
		if ($assign_to_entity instanceof ElggGroup) {
			$text = 'microthemes:cleargroup';
		}
		else {
			$text = 'microthemes:clearuser';
		}
		$action_ref = $action_base . $assign_to;
		$pars =  array(
			'href' => $action_ref,
			'text' => elgg_echo($text)
		);

		echo elgg_view('output/confirmlink', $pars);
	}
?>
