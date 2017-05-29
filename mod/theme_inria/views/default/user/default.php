<?php
/**
 * Elgg user display
 *
 * @uses $vars['entity'] ElggUser entity
 * @uses $vars['size']   Size of the icon
 * @uses $vars['title']  Optional override for the title
 */

$entity = $vars['entity'];
$size = elgg_extract('size', $vars, 'tiny');


// Iris : bigger images + search highlight or filter
if (elgg_in_context('search')) {
	$size = 'medium';
	$q = get_input('q');
	$search_words = explode(array(' ', ','), $q);
}

//$icon = elgg_view_entity_icon($entity, $size, $vars);
$icon = '<a href="' . $entity->getURL() . '"><img src="' . $entity->getIconUrl(array('size' => $size)) . '" alt="' . $entity->name . '"></a>';

$title = elgg_extract('title', $vars);
if (!$title) {
	$link_params = array(
		'href' => $entity->getUrl(),
		'text' => $entity->name,
	);

	// Simple XFN, see http://gmpg.org/xfn/
	if (elgg_get_logged_in_user_guid() == $entity->guid) {
		$link_params['rel'] = 'me';
	} elseif (check_entity_relationship(elgg_get_logged_in_user_guid(), 'friend', $entity->guid)) {
		$link_params['rel'] = 'friend';
	}

	$title = elgg_view('output/url', $link_params);
}


$metadata = elgg_view_menu('entity', array(
	'entity' => $entity,
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));

if (elgg_in_context('owner_block') || elgg_in_context('widgets')) {
	$metadata = '';
}

if (elgg_get_context() == 'gallery') {
	echo $icon;
} else {
	if ($entity->isBanned()) {
		$banned = elgg_echo('banned');
		$params = array(
			'entity' => $entity,
			'title' => $title,
			'metadata' => $metadata,
		);
	} else {
		$briefdescription = '';
		if (!empty($entity->briefdescription)) {
			$briefdescription .= '<h4>' . elgg_echo('profile:briefdescription') . '</h4>';
			$briefdescription .= '<p>' . $entity->briefdescription . '</p>';
		} else if (!empty($entity->description)) {
			$briefdescription .= '<h4>' . elgg_echo('profile:briefdescription') . '</h4>';
			$briefdescription .= '<p>' . elgg_get_excerpt($entity->description) . '</p>';
		}
		$user_tags = array_merge((array)$entity->skills, (array)$entity->interests);
		// Remove non-matching tags
		foreach ($user_tags as $k => $tag) {
			if (!in_array($tag, $search_words)) { unset($user_tags[$k]); }
		}
		$tags = elgg_view("output/tags", array("value" => $user_tags));
		if (!empty($tags)) {
			//$tags .= '<h4>' . elgg_echo('profile:tags') . '</h4>' . $tags;
			$tags = '<h4>' . elgg_echo('theme_inria:user:tags') . '</h4>' . $tags;
		}
		$params = array(
			'entity' => $entity,
			'title' => $title,
			'metadata' => $metadata,
			'subtitle' => $briefdescription . $tags,
			'content' => elgg_view('user/status', array('entity' => $entity)),
		);
	}

	$list_body = elgg_view('user/elements/summary', $params);
	
	// Highlight found terms
	if (elgg_is_active_plugin('search') || function_exists('search_highlight_words')) {
		$list_body = search_highlight_words($search_words, $list_body);
	}
	
	echo elgg_view_image_block($icon, $list_body, $vars);
}
