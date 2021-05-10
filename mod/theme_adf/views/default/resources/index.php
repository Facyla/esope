<?php
// Page d'accueil
use Elgg\Database\QueryBuilder;

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
$editorial = '<p>Bienvenue sur Départements-en-Réseaux ! <br />
Vous êtes actuellement sur votre tableau de bord personnel. <br />
Il vous permet de suivre ce qui se passe sur le site.<br />
</p>';
// Mes informations : actions, alertes et statistiques
elgg_set_page_owner_guid($user->guid);
$infos = '';
$infos .= "<p>Nombre de personnes connectés : " . find_active_users(['seconds' => 600, 'count' => true]) . ' personnes<br />';
$infos .= "Nombre de membres actifs : " . get_number_users(false) . ' personnes (total ' . get_number_users(true) . ')</p>';

$group_invitations = elgg_call(ELGG_IGNORE_ACCESS, function() use ($user) {
	return elgg_get_relationships([
		'relationship' => 'invited',
		'relationship_guid' => $user->guid,
		'inverse_relationship' => true,
		'no_results' => elgg_echo('groups:invitations:none'),
		'count' => true,
	]);
});
$infos .= '<a href="' . elgg_get_site_url() . 'groups/invitations/' . $user->username . '">' . "$group_invitations invitations à rejoindre un espace de travail" . '</a>';
if ($group_invitations > 0) {
	$infos .= elgg_view('groups/invitationrequests') . '</p>';
}

$infos .= "Valider les demandes d'adhésion aux groupes : @TODO";
// @TODO faire une vue pour chaque groupe dont on est propriétaire ou co-administrateur
/* elgg_list_relationships([
	'relationship' => 'membership_request',
	'relationship_guid' => $group->guid,
	'inverse_relationship' => true,
	'order_by' => new OrderByClause('er.time_created', 'ASC'),
	'no_results' => elgg_echo('groups:requests:none'),
]);
*/
//$infos .= elgg_view('groups/membershiprequests') . '</p>';
$infos .= '</p>';

// set the correct context and page owner
elgg_set_page_owner_guid($user->guid);
elgg_push_context('friends');

$friend_requests_sent = elgg_get_entities_from_relationship([
	'type' => 'user',
	'relationship' => 'friendrequest',
	'relationship_guid' => $user->guid,
	'inverse_relationship' => false,
	'offset_key' => 'offset_sent',
	'no_results' => elgg_echo('friend_request:sent:none'),
	'item_view' => 'friend_request/item',
	'count' => true,
]);
$friend_requests_received = elgg_get_entities_from_relationship([
	'type' => 'user',
	'relationship' => 'friendrequest',
	'relationship_guid' => $user->guid,
	'inverse_relationship' => true,
	'offset_key' => 'offset_received',
	'no_results' => elgg_echo('friend_request:received:none'),
	'item_view' => 'friend_request/item',
	'count' => true,
]);
$infos .= '<p><a href="' . elgg_get_site_url() . 'friend_request">' . "$friend_requests_received demandes de contact reçues" . '</a></p>';
if ($friend_requests_received > 0) {
	$infos .= elgg_view('friend_request/received');
}
$infos .= '<p><a href="' . elgg_get_site_url() . 'friend_request">' . "$friend_requests_sent demandes de contact envoyées" . '</a></p>';
if ($friend_requests_sent > 0) {
	$infos .= elgg_view('friend_request/sent');
}
elgg_pop_context();





$content .= '<div style="display: grid; grid-template-columns: repeat(auto-fit,minmax(16rem,1fr)); grid-gap: 1rem 2rem;">';
$content .= elgg_view_module('home-editorial', elgg_echo("Bloc éditorial"), $editorial);
$content .= elgg_view_module('home-infos', elgg_echo("Mes informations"), $infos);
$content .= '</div>';




// Discussions : Fil global et Activité des groupes

// Fil global
// Formulaire
$thewire_global = elgg_view('thewire_tools/activity_post', $vars);
// Liste des messages
$options = [
	'type' => 'object', 'subtype' => 'thewire', 
	//'container_guids' => $user_groups_guids_list,
	'limit' => max(20, elgg_get_config('default_limit')),
	//'order_by' => ['e.time_created', 'desc'],
	];
// Exclude group containers
$options['wheres'][] = function(QueryBuilder $qb, $main_alias) use ($container_type) {
		$c_join = $qb->joinEntitiesTable($main_alias, 'container_guid');
		return $qb->compare("{$c_join}.type", '!=', 'group', ELGG_VALUE_STRING);
	};
$thewire_global .= elgg_list_entities($options);

// Activité des groupes
$discussions_my_groups = elgg_view('discussion/listing/my_groups', ['entity' => $user]);

$content .= '<div style="border: 1px solid #e57b5f;">';
	$content .= '<h3 style="background: #e57b5f; padding: .5rem 1rem; color: white; font-size: 1.5rem; margin-bottom: 1rem;">Discussions en cours</h3>';
	$content .= '<div style="display:flex; flex-wrap: wrap;">';
	$content .= elgg_view_module('home-thewire-global', elgg_echo("Au fil du réseau"), $thewire_global);
	$content .= elgg_view_module('home-my-groups', elgg_echo("Activités dans mes espaces de travail"), $discussions_my_groups);
	$content .= '</div>';
$content .= '</div>';


// Widgets
elgg_set_page_owner_guid($user->guid);
$widgets_intro = '<h3 style="padding: .5rem 1rem; border: 1px solid; font-size: 1.5rem; font-weight: normal; margin-bottom: 1rem;">Personnalisez votre tableau de bord</h3>';
$content .= elgg_view_layout('widgets', [
	'content' => $widgets_intro, // Texte en intro des widgets (avant les 3 colonnes)
	'num_columns' => 3, 
	'show_access' => false, 
	'owner_guid'=> $user->guid,
	'no_widgets' => function () use ($widgets_intro) {
		echo elgg_view('dashboard/blurb');
		echo $widgets_intro;
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

