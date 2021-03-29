<?php
// Page d'accueil
use Elgg\Database\QueryBuilder;

$user = elgg_get_logged_in_user_entity();

// PAGE D'ACCUEIL PUBLIQUE
if (!$user) {
	$title = elgg_echo('welcome');
	$sidebar = elgg_view('core/account/login_box');
	echo elgg_view_page(null, [
		'title' => $title,
		'content' => elgg_echo('index:content'),
		'sidebar' => $sidebar,
	]);
	return;
}


// PAGE D'ACCUEIL CONNECTEE
// Structure générale : 1 zone principale (discussions globales et dans les groupes) + sidebar (liste de mes groupes et recommandations)

// @TODO ajouter filtre par type de contenus
$title = elgg_echo('welcome:user', [$user->getDisplayName()]);
$sidebar = null;

$content = '';
$content .= "<h1 style=\"color:#e57b5f;\">Départements en Réseaux</h1>";


// Micromessages
$thewire_form = elgg_view('thewire_tools/activity_post', $vars);


// Mes groupes
elgg_push_context('widgets');
$mygroups_ents = elgg_get_entities([
	'type' => 'group', 
	'relationship' => 'member',
	'relationship_guid' => $user->guid,
	'limit' => false,
	'pagination' => false,
	'no_results' => elgg_echo('groups:none'), 
	'full_view' => false,
	'list_type' => 'gallery',
	'list_class' => "elgg-gallery flex-grid", 
	]);
$mygroups .= '<ul class="elgg-gallery">';
$user_groups_guids = [];
foreach($mygroups_ents as $mygroup_ent) {
	$user_groups_guids[] = $mygroup_ent->guid;
	$mygroups .= elgg_format_element('li', 
		[
			'class' => 'elgg-item groups-profile-icon',
			'id' => "elgg-group-{$mygroup_ent->guid}",
		], 
		elgg_view_entity_icon($mygroup_ent, 'large', [
			//'href' => '',
			'width' => '100',
			'height' => '100',
		])
	);
}
$mygroups .= '</ul>';
elgg_pop_context();
if (count($user_groups_guids) > 0) { $user_groups_guids_list = implode(',', $user_groups_guids); }

/*
$mygroups_all = elgg_view('output/url', [
	'href' => elgg_generate_url('collection:group:group:member', [
		'username' => $user->username,
	]),
	'text' => elgg_echo('more'),
	'is_trusted' => true,
	'class' => "float-alt",
]);
*/
$mygroups = elgg_view_module('home-mygroups', elgg_echo('groups:yours'), $mygroups);



// Recommandations
$recommandations = '';
$recommandations .= 'Groupes<br />Contacts<br />Contenus ou Thématiques ?';
$recommandations = elgg_view_module('home-recommandations', elgg_echo("Recommandations"), $recommandations);



// Activité
// Sync with activity view : resources/activity/river
$activity = '';

/**
 * Main activity stream list page
 */

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
	default:
		$title = elgg_echo('river:all');
		$page_filter = 'all';
		break;
}

$activity .= elgg_view('river/filter', ['selector' => $selector]);
$activity .= elgg_list_river($options);



// Compose page content
/*
$content .= $thewire_form;

//$content .= elgg_view_module('', elgg_echo('activity'), $activity);
$content .= $activity;
*/





// Discussions : Discussions en cours
$content .= '<h3>Discussions en cours</h3>';


$options = [
	'type' => 'object', 'subtype' => 'discussion', 
	//'container_guids' => $user_groups_guids_list,
	'limit' => max(20, elgg_get_config('default_limit')),
	//'order_by' => ['e.time_created', 'desc'],
	];
// Exclude group containers
$options['wheres'][] = function(QueryBuilder $qb, $main_alias) use ($container_type) {
		$c_join = $qb->joinEntitiesTable($main_alias, 'container_guid');
		return $qb->compare("{$c_join}.type", '!=', 'group', ELGG_VALUE_STRING);
	};
$discussions_global .= elgg_list_entities($options);

$discussions_my_groups = elgg_view('discussion/listing/my_groups', ['entity' => $user]);

$content .= '<div style="display:flex; flex-wrap: wrap;">';
$content .= elgg_view_module('discussions-global', elgg_echo("Questions au réseau"), $discussions_global);
$content .= elgg_view_module('discussions-my-groups', elgg_echo("Dans mes groupes"), $discussions_my_groups);
$content .= '</div>';







echo elgg_view_page(null, [
	'title' => $title,
	'header' => false,
	'content' => $content,
	//'filter_value' => $page_filter,
	'sidebar' => $mygroups . $recommandations,
]);

