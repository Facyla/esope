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
	$q = elgg_extract('q', $vars);
	$q = trim(strip_tags($q));
	$search_words = explode(' ', $q);
}

//$icon = elgg_view_entity_icon($entity, $size, $vars);
$profile_type = esope_get_user_profile_type($entity);
if (empty($profile_type)) { $profile_type = 'external'; }
// Archive : replace profile type by member status archived
if ($entity->memberstatus == 'closed') { $profile_type = 'archive'; }
$icon = '<a href="' . $entity->getURL() . '" class="elgg-avatar elgg-avatar-' . $size . ' profile-type-' . $profile_type . '"><img src="' . $entity->getIconUrl(array('size' => $size)) . '" alt="' . $entity->name . '"></a>';
// Add profile type badge, if defined
if (in_array($profile_type, array('external', 'archive'))) { $icon .= '<span class="iris-badge"><span class="iris-badge-' . $profile_type . '" title="' . elgg_echo('profile:types:'.$profile_type.':description') . '">' . elgg_echo('profile:types:'.$profile_type) . '</span></span>'; }

$title = elgg_extract('title', $vars);
if (!$title) {
	$title = $entity->name . ' &nbsp; <span class="username">@' . $entity->username . '</span>';
	// Highlight found terms
	if (elgg_is_active_plugin('search') || function_exists('search_highlight_words')) {
		$title = search_highlight_words($search_words, $entity->name) . ' &nbsp; <span class="username">@' . search_highlight_words($search_words, $entity->username) . '</span>';
	}
	$link_params = array(
		'href' => $entity->getUrl(),
		'text' => $entity->name . ' &nbsp; <span class="username">@' . $entity->username . '</span>',
	);

	// Simple XFN, see http://gmpg.org/xfn/
	if (elgg_get_logged_in_user_guid() == $entity->guid) {
		$link_params['rel'] = 'me';
	} elseif (check_entity_relationship(elgg_get_logged_in_user_guid(), 'friend', $entity->guid)) {
		$link_params['rel'] = 'friend';
	}

	$title = elgg_view('output/url', $link_params);
}

// Add profile type badge, if defined
if (in_array($profile_type, ['external', 'archive'])) {
	$title .= '<span class="iris-badge"><span class="iris-badge-' . $profile_type . '" title="' . elgg_echo('profile:types:'.$profile_type.':description') . '">' . elgg_echo('profile:types:'.$profile_type) . '</span></span>';
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
	
} else if (elgg_get_context() == 'livesearch') {
	
	echo elgg_view_image_block($icon, $entity->name, $vars);
	
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
		// User tags : combine all tags
		$user_tags = array_merge((array)$entity->skills, (array)$entity->interests);
		// Remove non-matching tags
		if (elgg_in_context('search')) {
			foreach ($user_tags as $k => $tag) {
				if (!in_array($tag, $search_words)) { unset($user_tags[$k]); }
			}
		}
		$tags = elgg_view("output/tags", array("value" => $user_tags));
		if (!empty($tags)) {
			//$tags .= '<h4>' . elgg_echo('profile:tags') . '</h4>' . $tags;
			$tags = '<h4>' . elgg_echo('theme_inria:user:tags') . '</h4>' . $tags;
		}
		
		$briefdescription = $briefdescription . $tags;
		// Highlight found terms
		if (!empty($q) && (elgg_is_active_plugin('search') || function_exists('search_highlight_words'))) {
			$briefdescription = search_highlight_words($search_words, $briefdescription);
		}
		$params = array(
			'entity' => $entity,
			'title' => $title,
			'metadata' => $metadata,
			'subtitle' => $briefdescription,
			'content' => elgg_view('user/status', array('entity' => $entity)),
		);
	}

	$list_body = elgg_view('user/elements/summary', $params);
	//$list_body = $title . $briefdescription . elgg_view('user/status', array('entity' => $entity));
	
	echo elgg_view_image_block($icon, $list_body, $vars);
}

