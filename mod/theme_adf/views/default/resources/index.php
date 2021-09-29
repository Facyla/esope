<?php
// Page d'accueil
use Elgg\Database\QueryBuilder;
use Elgg\Database\Clauses\OrderByClause;
//use Elgg\Activity\GroupRiverFilter;


$user = elgg_get_logged_in_user_entity();
elgg_push_context('index'); // basic context for widgets
elgg_push_context('dashboard'); // much more widgets

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
$default_limit = elgg_get_config('default_limit');

$content = '';
$content .= "<h1 style=\"color:#e57b5f;\">Départements en Réseaux</h1>";



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


// Bloc éditorial
$editorial = elgg_get_plugin_setting('home_text', 'theme_adf');
if (!empty($editorial)) {
	$editorial = elgg_view('output/longtext', ['value' => $editorial]);
} else {
	$editorial = '<p>Bienvenue sur Départements-en-Réseaux ! <br />
	Vous êtes actuellement sur votre tableau de bord personnel. <br />
	Il vous permet de suivre ce qui se passe sur le site.<br />
	</p>';
}

// Mes informations
$infos = elgg_view('theme_adf/home-user-infos', ['user' => $user]);
//$infos_title = elgg_echo("Mes informations") . elgg_view('output/url', ['href' => "friends/{$user->username}/invite", 'text' => "Inviter des collègues", 'class' => "elgg-button elgg-button-action float-alt", 'is_action' => true]);
$infos_title = elgg_echo("Mes informations");


$content .= '<div style="display: grid; grid-template-columns: repeat(auto-fit,minmax(16rem,1fr)); grid-gap: 1rem 2rem;">';
$content .= elgg_view_module('home-editorial', elgg_echo("Bienvenue !"), $editorial);
$content .= elgg_view_module('home-infos', $infos_title, $infos);
$content .= '</div>';




// Discussions : Fil global et Activité des groupes

// Fil global
// Formulaire
$thewire_global = elgg_view('thewire_tools/activity_post', $vars);
// Liste des messages
$options = [
	'type' => 'object', 'subtype' => 'thewire', 
	//'container_guids' => $user_groups_guids_list,
	'limit' => max(2, $default_limit),
	//'order_by' => ['e.time_created', 'desc'],
	'pagination' => false, 
];
// Exclude group containers
$options['wheres'][] = function(QueryBuilder $qb, $main_alias) use ($container_type) {
	$c_join = $qb->joinEntitiesTable($main_alias, 'container_guid');
	return $qb->compare("{$c_join}.type", '!=', 'group', ELGG_VALUE_STRING);
};
$thewire_global .= elgg_list_entities($options);
$thewire_global .= '<p>' . elgg_view('output/url', [
	'href' => elgg_get_site_url() . 'thewire/all',
	'text' => elgg_echo('thewire:moreposts'),
	'is_trusted' => true,
	'class' => "elgg-button elgg-pagination",
]) . '</p>';

// Activité dans mes groupes
//$activity_my_groups = elgg_view('discussion/listing/my_groups', ['entity' => $user]);
// check of the user is a member of any groups
$user_groups = theme_adf_get_user_groups_guids();
$user_groups_sql_in = theme_adf_get_user_groups_guids('sql_in');
$user_groups_clauses = theme_adf_get_user_groups_guids('where_clause');
if ($user_groups) {
	/*
	$activity_my_groups = elgg_list_entities([
		'type' => 'object',
		'subtype' => 'discussion',
		'container_guids' => $user_groups,
		'limit' => max(20, $default_limit),
		'order_by' => new OrderByClause('e.last_action', 'desc'),
		'no_results' => elgg_echo('discussion:none'),
	]);
	*/
	// Activité dans mes groupes : devrait permettre renvoi sur page de suivi/filtrage de l'activité
	$river_params = [
		//'limit' => 4,
		'limit' => max(2, $default_limit),
		'pagination' => false,
		//'wheres' => [new GroupRiverFilter($group)],
		'wheres' => [
			/*
		function(QueryBuilder $qb, $main_alias) {
				$user_groups_clauses = theme_adf_get_user_groups_guids('where_clause');
				return $qb->merge($user_groups_clauses, 'AND'); 
			},
			// marche si 1 seul groupe, pas avec plusieurs (à cause du AND : comment le  changer en OR ?)
			$user_groups_clauses,   // utiliser : 'wheres' => $user_groups_clauses  (et PAS dans un array)
			
			function(QueryBuilder $qb, $main_alias) {
				$user_groups_clauses = theme_adf_get_user_groups_guids('where_clause');
				return $qb->merge([$user_groups_clauses], 'AND'); 
			},
			*/
			// Filtre uniquement les éléments de la rivière dont le container est un groupe dont l'user est membre
			// note : ne liste donc pas les commentaires
			function(QueryBuilder $qb, $main_alias) use ($container_type) {
				$c_join = $qb->joinEntitiesTable($main_alias, 'object_guid');
				$user_groups_sql_in = theme_adf_get_user_groups_guids('array');
				return $qb->compare("{$c_join}.container_guid", 'IN', $user_groups_sql_in, ELGG_VALUE_STRING);
			},
		],
//		'container_guids' => $user_groups,
		'no_results' => elgg_echo('theme_adf:my_groups:noactivity'),
	];
	// @TODO Exclude comments on feedbacks
	//$river_params['wheres'][] = "subtype != 'feedback'";
	/*
	$river_params['wheres'][] = function(QueryBuilder $qb, $main_alias) use ($container_type) {
		$c_join = $qb->joinEntitiesTable($main_alias, 'container_guid');
		return $qb->compare("{$c_join}.type", '!=', 'group', ELGG_VALUE_STRING);
	};
	*/
	
	$activity_my_groups_count = elgg_get_river($river_params + ['count' => true]);
	$activity_my_groups = elgg_list_river($river_params);
	// Add button if more content
	if ($activity_my_groups_count > $default_limit) {
		$activity_my_groups .= '<br />' . elgg_view('output/url', [
			'href' => elgg_get_site_url() . 'activity/groups',
			'text' => elgg_echo('theme_adf:my_groups:viewall'),
			'is_trusted' => true,
			'class' => "elgg-button elgg-pagination",
		]);
	}
} else {
	// Aucun groupe : inviter à rejoindre
	$activity_my_groups = '<p>' . elgg_echo('theme_adf:my_groups:nogroup') . '</p>';
	$activity_my_groups .= elgg_view('output/url', [
		'href' => elgg_get_site_url() . "groups/all",
		'text' => elgg_echo('theme_adf:menu:groups:join'),
		'class' => "elgg-button elgg-button-action",
	]);
	// Liens vers plus toute l'activité du site
	$activity_my_groups .= elgg_view('output/url', [
		'href' => elgg_get_site_url() . 'activity/all',
		'text' => elgg_echo('theme_adf:activity:viewall'),
		'is_trusted' => true,
		'class' => "elgg-button elgg-pagination",
	]);
}

$content .= '<div style="border: 1px solid #e57b5f;">';
	$content .= '<h3 style="background: #e57b5f; padding: .5rem 1rem; color: white; font-size: 1.5rem; margin-bottom: 1rem;">Discussions en cours</h3>';
	$content .= '<div style="display:flex; flex-wrap: wrap;">';
	$content .= elgg_view_module('home-thewire-global', elgg_echo("Au fil du réseau"), $thewire_global);
	$content .= elgg_view_module('home-my-groups', elgg_echo("Activités dans mes espaces de travail"), $activity_my_groups);
	$content .= '</div>';
$content .= '</div>';


// Widgets
elgg_set_page_owner_guid($user->guid);
$widgets_intro = '<h3 style="padding: .5rem 1rem; border: 1px solid; font-size: 1.5rem; font-weight: normal; margin-bottom: 1rem;">Personnalisez votre tableau de bord</h3>';
$content .= elgg_view_layout('widgets', [
	'content' => 'test', //$widgets_intro, // Texte en intro des widgets (avant les 3 colonnes)
	'num_columns' => 3, 
	'show_access' => false, 
	'owner_guid'=> $user->guid,
	'no_widgets' => function () use ($widgets_intro) {
		//echo elgg_view('dashboard/blurb') . $widgets_intro;
	},
]);
//elgg_set_page_owner_guid(1); // on évite de se retrouver avec une sidebar...


echo elgg_view_page(null, [
	'title' => $title,
	'header' => false,
	'content' => $content,
	'sidebar' => false,
	//'filter_value' => $page_filter,
	//'sidebar' => $mygroups . $recommandations,
]);

