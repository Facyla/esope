<?php
/**
 * Members index
 *
 */

$num_members = get_number_users();

$title = elgg_echo('members');

$options = array('type' => 'user', 'full_view' => false);

switch ($vars['page']) {
	case 'organisation':
		$content = dossierdepreuve_list_members_by_profiletype('organisation');
		break;
	case 'formateur':
		$content = dossierdepreuve_list_members_by_profiletype('evaluator');
		$content .= dossierdepreuve_list_members_by_profiletype('tutor');
		break;
	case 'candidat':
		$content = dossierdepreuve_list_members_by_profiletype('learner');
		break;
	case 'popular':
		$options['relationship'] = 'friend';
		$options['inverse_relationship'] = false;
		$content = elgg_list_entities_from_relationship_count($options);
		break;
	case 'online':
		$content = get_online_users();
		break;
	case 'newest':
	default:
		$content = elgg_list_entities($options);
		break;
}

$params = array(
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'title' => $title . " ($num_members)",
	//'title' => $num_filtered $title . " (total $num_members)",
	'filter_override' => elgg_view('members/nav', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
