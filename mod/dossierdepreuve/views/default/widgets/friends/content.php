<?php
/**
 * Friend widget display view
 *
 */

// owner of the widget
$owner = $vars['entity']->getOwnerEntity();

$scope = $vars['entity']->scope;

// Selon le profil : seules certaines options sont possibles et affichées (en cohérence avec les options d'édition)
$profiletype = dossierdepreuve_get_user_profile_type($vars['entity']->getOwnerEntity());
switch ($profiletype) {
	case 'learner':
		$scope = 'all';
		break;
	case 'tutor':
	case 'evaluator':
		if (!in_array($scope, array('all', 'organisations'))) $scope = 'all';
		break;
	case 'organisation':
		if (!in_array($scope, array('all', 'tutors'))) $scope = 'all';
		break;
	case 'other_administrative':
		if (!in_array($scope, array('all', 'tutors', 'organisations', 'learners'))) $scope = 'all';
		break;
	default:
		// Tous les contacts seulement (fonctionnement par défaut)
		$scope = 'all';
}

/*
// the number of friends to display
$num = (int) $vars['entity']->num_display;
*/

// get the correct size
$size = $vars['entity']->icon_size;

if (elgg_instanceof($owner, 'user')) {
	$all_friends = $owner->getFriends('', 99999);
	echo "<strong>" . elgg_echo('dossierdepreuve:widget:scope:' . $scope) . "</strong>";
	// Filtrage si le scope est différent de 'all'
	if ($scope != 'all') {
		foreach ($all_friends as $ent) {
			$ent_profile = dossierdepreuve_get_user_profile_type($ent);
			switch ($scope) {
				case 'organisations':
					if ($ent_profile == 'organisation') $friends[] = $ent;
					break;
				case 'tutors':
					if (in_array($ent_profile, array('tutor', 'evaluator'))) $friends[] = $ent;
					break;
				case 'learners':
					if ($ent_profile == 'learner') $friends[] = $ent;
					break;
			}
		}
	} else { $friends = $all_friends; }
	
	$count = count($friends);
	
	// $html = $owner->listFriends('', $num, array('size' => $size, 'list_type' => 'gallery', 'pagination' => false));
	// On affiche tous les contacts, pas de choix de nombre
	$html = elgg_view_entity_list($friends, array('size' => $size, 'list_type' => 'gallery', 'pagination' => false, 'count' => $count, 'limit' => $count));
	
	/* Du coup ce lien n'a plus de sens
	if ($count > $num) $html .= '<span class="elgg-widget-more"><a href="' . $vars['url'] . 'friends/' . $owner->username . '">' . elgg_echo('more:friends') . '</a></span>';
	*/
	if ($html) { echo $html; }
}

