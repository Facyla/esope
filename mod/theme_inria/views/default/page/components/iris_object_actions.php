<?php
// Iris object footer actions

$entity = elgg_extract('entity', $vars, FALSE);
$metadata = elgg_extract('metadata', $vars, FALSE);
$metadata_alt = elgg_extract('metadata_alt', $vars, FALSE);
$mode = elgg_extract('mode', $vars, FALSE);

$page_owner = elgg_get_page_owner_entity();
$owner = $entity->getOwnerEntity();

$title = $entity->title;
if (empty($title)) { $title = $entity->name; }


// ACTIONS - Bottom menu
$actions_after = '';

// Add container if we are in a global context
$container_info = '';
$group_icon = '<svg class="iris-groupes" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path d="M25.54,3.17H9.66a1,1,0,0,0-1,1v5h-5a1,1,0,0,0-1,1V26a1,1,0,0,0,1.51.86L8.95,24H19.58a1,1,0,0,0,1-1V18.23L25,20.9A1,1,0,0,0,26.54,20V4.17A1,1,0,0,0,25.54,3.17ZM18.58,22H8.67a1,1,0,0,0-.51.14L4.71,24.23V11.12h4v5.94a1,1,0,0,0,1,1h8.92Zm6-3.74-3.45-2.07a1,1,0,0,0-.51-.14H10.66V5.17H24.54Z"></path><circle cx="21.07" cy="10.61" r="0.99"></circle><circle cx="17.6" cy="10.61" r="0.99"></circle><circle cx="14.13" cy="10.61" r="0.99"></circle></svg>';

// Determine which entity can be commented
$commentable_object = $entity;
$subtype = $entity->getSubtype();
if (in_array($subtype, array('comment', 'discussion_reply', 'groupforumtopic'))) {
	// Get real container for forum & comment
	$container = $entity->getContainerEntity();
	while(elgg_instanceof($container, 'object')) {
		$commentable_object = $container;
		$parent_container = $container->getContainerEntity();
		if ($parent_container) { $container = $parent_container; }
	}
}

//if (elgg_instanceof($entity, 'object') && !elgg_instanceof($page_owner, 'group') && !elgg_instanceof($page_owner, 'user')) {
if ($container && !elgg_instanceof($page_owner, 'group')) {
	//error_log($object->guid .' // container='.$subtype . ' // object='.$object->getSubtype().' == '.print_r($vars['item'], true));
	if (elgg_instanceof($container, 'group')) {
		$container_info .= '<li>' . elgg_view('output/url', array(
				'text' => $group_icon . '&nbsp;' . $container->name,
				'href' => $container->getURL(),
				'class' => 'iris-container',
			)) . '</li>';
	}
}

$access_info = '<li>' . elgg_view('output/access', array('entity' => $entity)) . '</li>';


$actions = '<div class="clearfloat"></div>';
$actions .= '<div class="iris-object-actions">';
	// left
	$actions .= '<ul class="elgg-menu-entity float">' . $access_info . $container_info . $metadata_alt . '</ul>';
	
	// right
	// Add likes counter and actions
	$actions .= '<ul class="elgg-menu-entity-alt float-alt">';
	
		$actions .= $metadata;
		
		if (($mode != 'full') && !in_array($entity->comments_on, array('no', 'Off'))) {
			// Nb comments
			$comments = $entity->countComments();
			if (elgg_instanceof($entity, 'object', 'groupforumtopic')) {
				$comments = elgg_get_entities(array(
					'type' => 'object',
					'subtype' => 'discussion_reply',
					'container_guid' => $entity->getGUID(),
					'count' => true,
					'distinct' => false,
				));
			}
			if ($comments > 0) { $actions .= '<li><a href="' . $entity->getURL() . '">' . $comments . '&nbsp;<i class="fa fa-comments"></i></a></li>'; }
		
			// Wire : reply form
			if (elgg_instanceof($entity, 'object', 'thewire')) {
				$actions .= '<li>' . elgg_view('output/url', array(
							'href' => "javascript:void(0);", 'onClick' => "$('#thewire-reply-{$entity->guid}').slideToggle('slow');",
							'text' => '<i class="fa fa-comment"></i>',
					)) . '</li>';
					// Form should separated from menu
				$form_vars = array('class' => 'thewire-form');
				$actions_after .= '<div id="thewire-reply-' . $entity->guid . '" class="thewire-reply-inline hidden">';
				$actions_after .= elgg_view_form('thewire/add', $form_vars, array('post' => $entity));
				$actions_after .= '</div>';
				
			} else if (elgg_instanceof($entity, 'object', 'groupforumtopic')) {
				if ($entity->status != 'closed') {
					$actions .= '<li>' . elgg_view('output/url', array(
								'href' => "javascript:void(0);", 'onClick' => "$('#discussion-reply-{$entity->guid}').slideToggle('slow');",
								'text' => '<i class="fa fa-comment"></i>',
						)) . '</li>';
						// Form should separated from menu
					$form_vars = array();
					$actions_after .= '<div id="discussion-reply-' . $entity->guid . '" class="discussion-reply-inline hidden">';
					$actions_after .= elgg_view_form('discussion/reply/save', $form_vars, array('topic' => $entity, 'inline' => true));
					$actions_after .= '</div>';
				}
				
			} else if (elgg_instanceof($entity, 'object', 'comment')) {
				if (in_array($entity->comments_on, array('Off', 'no'))) { break; }
				// Generic inline comment form
				$actions .= '<li>' . elgg_view('output/url', array(
							'href' => "javascript:void(0);", 'onClick' => "$('#comments-add-{$entity->guid}').slideToggle('slow');",
							'text' => '<i class="fa fa-comment"></i>',
					)) . '</li>';
				$actions_after .= elgg_view_form('comment/save', 
						array('id' => "comments-add-{$entity->guid}", 'class' => 'hidden'), 
						array('entity' => $commentable_object, 'inline' => true)
					);
					
			} else {
				if (in_array($entity->comments_on, array('Off', 'no'))) { break; }
				// Generic inline comment form
				$actions .= '<li>' . elgg_view('output/url', array(
							'href' => "javascript:void(0);", 'onClick' => "$('#comments-add-{$entity->guid}').slideToggle('slow');",
							'text' => '<i class="fa fa-comment"></i>',
					)) . '</li>';
				$actions_after .= elgg_view_form('comment/save', 
						array('id' => "comments-add-{$entity->guid}", 'class' => 'hidden'), 
						array('entity' => $entity, 'inline' => true)
					);
			}
		}
		
		// Nb likes
		$likes = \Elgg\Likes\DataService::instance()->getNumLikes($entity);
		if ($likes > 0) { $actions .= '<li>' . elgg_view('likes/count', array('entity' => $entity, 'class' => '')) . '</li>'; }
	
		// Like / unlike
		if ($entity->canAnnotate(0, 'likes')) {
			$hasLiked = \Elgg\Likes\DataService::instance()->currentUserLikesEntity($entity->guid);
			$actions .= '<li>' . elgg_view('output/url', array(
					'name' => 'likes',
					'href' => elgg_add_action_tokens_to_url("/action/likes/add?guid={$entity->guid}"),
					'text' => elgg_view_icon('thumbs-up'),
					'title' => elgg_echo('likes:likethis'),
					'class' => $hasLiked ? 'hidden' : '',
				)) . '</li>';
			$actions .= '<li>' . elgg_view('output/url', array(
					'name' => 'unlike',
					'href' => elgg_add_action_tokens_to_url("/action/likes/delete?guid={$entity->guid}"),
					'text' => elgg_view_icon('thumbs-up-alt'),
					'title' => elgg_echo('likes:remove'),
					'class' => $hasLiked ? '' : 'hidden',
				)) . '</li>';
		}
	
	$actions .= '</ul>';
$actions .= '</div>';
$actions .= '<div class="clearfloat"></div>' . $actions_after;

$actions .= $after;

echo $actions;

