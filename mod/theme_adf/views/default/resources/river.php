<?php
/**
 * Main activity stream list page
 */
use Elgg\Database\QueryBuilder;
use Elgg\Database\Clauses\OrderByClause;
use Elgg\Activity\GroupRiverFilter;

$options = [
	'distinct' => false,
	'no_results' => elgg_echo('river:none'),
];

$type = preg_replace('[\W]', '', get_input('type', 'all'));
$subtype = preg_replace('[\W]', '', get_input('subtype', ''));
if ($subtype) {
	$selector = "type=$type&subtype=$subtype";
} else {
	$selector = "type=$type";
}

if ($type != 'all') {
	$options['type'] = $type;
	if ($subtype) {
		$options['subtype'] = $subtype;
	}
}

$request = elgg_extract('request', $vars);
/* @var $request \Elgg\Request */
switch ($request->getRoute()) {
	case 'collection:river:owner':
		elgg_gatekeeper();
		if ($vars['username'] === elgg_get_logged_in_user_entity()->username) {
			elgg_set_page_owner_guid(elgg_get_logged_in_user_guid());

			$title = elgg_echo('river:mine');
			$page_filter = 'mine';
			$options['subject_guid'] = elgg_get_logged_in_user_guid();
			break;
		} else {
			$subject_username = elgg_extract('username', $vars, '');
			$subject = get_user_by_username($subject_username);
			if (!$subject) {
				register_error(elgg_echo('river:subject:invalid_subject'));
				forward();
			}
			elgg_set_page_owner_guid($subject->guid);
			$title = elgg_echo('river:owner', [htmlspecialchars($subject->getDisplayName(), ENT_QUOTES, 'UTF-8', false)]);
			$page_filter = 'subject';
			$options['subject_guid'] = $subject->guid;
			break;
		}
	case 'collection:river:friends':
		if (elgg_is_active_plugin('friends')) {
			$title = elgg_echo('river:friends');
			$page_filter = 'friends';
			$options['relationship_guid'] = elgg_get_logged_in_user_guid();
			$options['relationship'] = 'friend';
			break;
		}
	case 'collection:river:groups':
		if (elgg_is_active_plugin('groups')) {
			$title = elgg_echo('theme_adf:activity:groups');
			$user_groups = theme_adf_get_user_groups_guids();
			$page_filter = 'groups';
			//$options['container_guids'] = $user_groups;
			$options['wheres'] = function(QueryBuilder $qb, $main_alias) use ($container_type) {
				$c_join = $qb->joinEntitiesTable($main_alias, 'object_guid');
				$user_groups_sql_in = theme_adf_get_user_groups_guids('array');
				return $qb->compare("{$c_join}.container_guid", 'IN', $user_groups_sql_in, ELGG_VALUE_STRING);
			};
			break;
		}
	default:
		$title = elgg_echo('river:all');
		$page_filter = 'all';
		break;
}

$activity = elgg_list_river($options);

$content = elgg_view('river/filter', ['selector' => $selector]);

echo elgg_view_page($title, [
	'content' =>  $content . $activity,
	'sidebar' => elgg_view('river/sidebar'),
	'filter_value' => $page_filter,
	'filter' => ['all' => elgg_echo('river:all'), 'mine' => elgg_echo('river:mine'), 'friends' => elgg_echo('river:friends'), 'groups' => elgg_echo('river:groups')],
	'class' => 'elgg-river-layout',
]);
