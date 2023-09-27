<?php
/**
 * Default view for an entity returned in a search
 *
 * Display largely controlled by a set of overrideable volatile data:
 *   - search_icon
 *   - search_matched_title
 *   - search_matched_description
 *   - search_matched_extra
 *   - search_url
 *   - search_time (defaults to entity->time_created)
 *
 * @uses $vars['entity'] Entity returned in a search
 */
$entity = elgg_extract('entity', $vars);
if (!$entity instanceof ElggEntity) {
	return;
}

$defaults = [
	'tags' => false,
	'time' => $entity->getVolatileData('search_time') ?: $entity->time_created,
	'access' => false,
	'show_social_menu' => false,
	'show_entity_menu' => false,
];
$vars = array_merge($defaults, $vars);

// overrules
$params = [
	'title' => elgg_view('search/elements/title', $vars),
	'content' => elgg_view('search/elements/content', $vars),
	'icon' => elgg_view('search/elements/icon', $vars),
];
$params = $params + $vars;

echo elgg_view("{$entity->getType()}/elements/summary", $params);
