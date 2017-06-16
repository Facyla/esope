<?php
// PH spécifique pour ces pages d'interfaces similaires entre tous les contenus 
// => ça facilitera la mise en place des filtres, et plus encore celle des listings
// par ex. groups/resources/$subtype/all|ine|draft ... (ou content, publications)

// Determine current workspace (page_owner, potentially a subgroup)
$guid = elgg_extract('group_guid', $vars);
elgg_entity_gatekeeper($guid, 'group');

$group = get_entity($guid);
if (!elgg_instanceof($group, 'group')) {
	register_error('groups:error:invalid');
	forward();
}
elgg_group_gatekeeper();

elgg_set_page_owner_guid($guid);

// Determine main group
$main_group = theme_inria_get_main_group($group);

$own = elgg_get_logged_in_user_entity();

// ESOPE: Add members invite button
//groups_register_profile_buttons($group); // add all group actions buttons
if ($group->canEdit()) {
	elgg_register_menu_item('title', array(
			'name' => 'groups:invite',
			'href' => elgg_get_site_url() . 'groups/invite/' . $group->guid,
			'text' => elgg_echo('groups:invite'),
			'link_class' => 'elgg-button elgg-button-action',
		));
}


$title = elgg_echo('groups:members:title', array($group->name));

elgg_push_breadcrumb($group->name, $group->getURL());
elgg_push_breadcrumb(elgg_echo('groups:members'));


$content = '';

// Workspaces switch
$content .= elgg_view('theme_inria/groups/workspaces_tabs', array('main_group' => $main_group, 'group' => $group, 'link_type' => 'members'));

$content .= '<div class="group-profile-main">';
	
	// @TODO Ajouter les actions : rendre resp du groupe, enlever resp, rendre proprio
	// Owner and operators
	$owner = $group->getOwnerEntity();
	$max_operators = 0;
	$operators_opt = array('types'=>'user', 'limit'=> $max_operators, 'relationship_guid'=> $group->guid, 'relationship'=>'operator', 'inverse_relationship'=>true, 'wheres' => "e.guid != {$owner->guid}");
	$operators_count = elgg_get_entities_from_relationship($operators_opt + array('count' => true));
	$operators = elgg_get_entities_from_relationship($operators_opt);

	// Lien admin et responsables de groupe
	/*
	if ($group->canEdit()) {
		$manage_group_admins = '<a href="' . elgg_get_site_url() . 'group_operators/manage/' . $group->guid . '" class="iris-manage float-alt">' . elgg_echo('theme_inria:manage') . '</a>';
	}
	*/
	$content .= '<div class="group-workspace-module group-workspace-admins">';
		$content .= '<div class="group-admins">
				<div class="group-admin">
					<h3>' . elgg_echo('groups:owner') . '</h3>
					<img src="' . $owner->getIconURL(array('size' => 'medium')) . '" /><br />
					' . $owner->name . '
				</div>
			</div>';
		$content .= '<div class="group-operators">' . $manage_group_admins;
			if ($operators_count > 0) {
				$content .= '<h3>' . elgg_echo('theme_inria:groups:operators', array($operators_count)) . '</h3>';
				if ($operators) {
					foreach($operators as $ent) {
						if ($ent->guid == $owner->guid) { continue; }
						$actions = '';
						if ($group->canEdit()) {
							$make_owner_url = elgg_add_action_tokens_to_url(elgg_get_site_url() . 'action/group_operators/mkowner?mygroup=' . $group->guid . '&who=' . $ent->guid);
							$actions .= '<a href="' . $make_owner_url . '" class="iris-round-button make-group-owner" title="Rendre propriétaire" style="background: #1488CA;"><i class="fa fa-user-plus fa-user-circle-o"></i></a>';
							$remove_operator_url = elgg_add_action_tokens_to_url(elgg_get_site_url() . 'action/group_operators/remove?mygroup=' . $group->guid . '&who=' . $ent->guid);
							$actions .= '<a href="' . $remove_operator_url . '" class="iris-round-button remove-group-operator" title="Supprimer responsable" style="background: #FF0000;"><i class="fa fa-user-times"></i></a>';
						}
						$content .= '<div class="group-operator">
								<img src="' . $ent->getIconURL(array('size' => 'medium')) . '" /><br />
								' . $ent->name . '
								' . $actions . '
							</div>';
					}
				}
				/*
				if (($max_operators > 0) && ($operators_count > $max_operators)) {
					$operators_more_count = $operators_count - $max_operators;
					$content .= '<div class="group-operator more">' . elgg_view('output/url', array(
						'href' => 'group_operators/manage/' . $group->guid,
						'text' => "+".$operators_more_count,
						'is_trusted' => true, 'class' => 'operators-more',
					)) . '</div>';
				}
				*/
			}
		$content .= '</div>';
		$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';


	// Membres du groupe
	$dbprefix = elgg_get_config('dbprefix');
	$members_opt = array(
			'relationship' => 'member',
			'relationship_guid' => $group->guid,
			'inverse_relationship' => true,
			'type' => 'user',
			'limit' => (int)get_input('limit', max(20, elgg_get_config('default_limit')), false),
			'joins' => array("JOIN {$dbprefix}users_entity u ON e.guid=u.guid"),
			'order_by' => 'u.name ASC',
		);
	$members = elgg_get_entities_from_relationship($members_opt);
	$members_count = elgg_get_entities_from_relationship($members_opt + array('count' => true));
	
	$content .= "<h3>Tous les membres ($members_count)</h3>";
	
	// @TODO recherche live parmi les membres du groupe
	$content .= '<div class="group-members-search"><i class="fa fa-search"></i><input type="text" placeholder="3 premières lettres" class="" /></div>';
	
	
	// Members listing
	if ($members) {
		$content .= '<div class="group-members">';
		foreach($members as $ent) {
			$actions = '';
			if ($group->canEdit()) {
				$remove_member_url = elgg_add_action_tokens_to_url(elgg_get_site_url() . 'action/groups/remove?group_guid=' . $group->guid . '&user_guid=' . $ent->guid);
				$actions .= '<a href="' . $remove_member_url . '" class="iris-round-button" title="Retirer du groupe" style="background: #FF0000;"><i class="fa fa-user-times"></i></a>';
				if (!check_entity_relationship($ent->guid, 'operator', $group->guid)) {
					$make_operator_url = elgg_add_action_tokens_to_url(elgg_get_site_url() . 'action/group_operators/add?mygroup=' . $group->guid . '&who=' . $ent->guid);
					$actions .= '<a href="' . $make_operator_url . '" class="iris-round-button" title="Rendre responsable" style="background: #1488CA;"><i class="fa fa-user-plus fa-user-circle"></i></a>';
				}
			}
		
			$content .= '<div class="group-member" style="min-height: 3rem;">';
			$content .= '<img src="' . $ent->getIconURL(array('size' => 'small')) . '" /><br />' . $ent->name;
			$content .= $actions;
			$content .= '</div>';
		}
		$content .= '<div>';
	}
	

$content .= '</div>';


$params = array(
	'content' => $content,
	'title' => $title,
	'filter' => '',
	'sidebar_alt' => "Demandes en attente",
);
$body = elgg_view_layout('iris_group', $params);

echo elgg_view_page($title, $body);

