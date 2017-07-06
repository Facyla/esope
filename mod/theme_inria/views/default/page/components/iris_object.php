<?php


/**
 * Elgg image block pattern
 *
 * Common pattern where there is an image, icon, media object to the left
 * and a descriptive block of text to the right.
 * 
 * ---------------------------------------------------------------
 * |          |                                      |    alt    |
 * |  image   |               body                   |   image   |
 * |  block   |               block                  |   block   |
 * |          |                                      | (optional)|
 * ---------------------------------------------------------------
 *
 * @uses $vars['body']        HTML content of the body block
 * @uses $vars['image']       HTML content of the image block
 * @uses $vars['image_alt']   HTML content of the alternate image block
 * @uses $vars['class']       Optional additional class for media element
 * @uses $vars['id']          Optional id for the media element
 */


/* listing iris : contenu
 * 3 modes :
 * - listing simple
 *   photo auteur
 *   auteur + date + menu
 *   titre
 *   extrait
 *   actions likes comments
 * 
 * - listing enrichi (groupes)
 *   image contenu
 *   photo auteur + auteur + date + menu
 *   titre
 *   extrait
 *   actions likes comments
 * 
 * - full view
 *   auteur + date + menu
 *   titre + contenu
 *   actions likes comments
 
*/


$entity = elgg_extract('entity', $vars, FALSE);
$body = elgg_extract('body', $vars, FALSE);
$metadata_alt = elgg_extract('metadata_alt', $vars, FALSE);
$after = elgg_extract('after', $vars, FALSE);

$mode = elgg_extract('mode', $vars, FALSE);
$full = elgg_extract('full_view', $vars, FALSE);
$class = 'elgg-image-block';
$additional_class = elgg_extract('class', $vars, '');
if ($additional_class) { $class = "$class $additional_class"; }

$id = '';
if (isset($vars['id'])) { $id = "id=\"{$vars['id']}\""; }

$page_owner = elgg_get_page_owner_entity();
$owner = $entity->getOwnerEntity();

$title = $entity->title;
if (empty($title)) { $title = $entity->name; }

if (!in_array($mode, array('full', 'listing', 'content'))) {
	$mode = 'listing';
	if ($full) {
		$mode = 'full';
	//} else if (elgg_instanceof($page_owner, 'group') || elgg_instanceof($page_owner, 'user')) {
	} else if (elgg_instanceof($page_owner, 'group')) {
		$mode = 'content';
	}
}


// ICONS AND IMAGES
$owner_icon = '<a href="' . $owner->getURL() . '" title="' . $owner->name . '" class="elgg-avatar medium"><img src="' . $owner->getIconURL(array('size' => 'medium')) . '" /></a>';

$entity_icon = $entity->getIconURL(array('size' => 'medium'));
if (elgg_instanceof($entity, 'object', 'file')) {
	$entity_icon = '<a href="' . $entity->getURL() . '" class="medium"><img src="' . $entity->getIconUrl(array('size' => 'medium')) . '" alt="object ' . $entity->getSubtype() . '" /></a>';
} else {
	$entity_icon = '<a href="' . $entity->getURL() . '" title="' . $title . '"><span class="small">' . elgg_echo('esope:icon:'.$entity->getSubtype()) . '</span></a>';
}

$group_icon = '<svg class="iris-groupes" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path d="M25.54,3.17H9.66a1,1,0,0,0-1,1v5h-5a1,1,0,0,0-1,1V26a1,1,0,0,0,1.51.86L8.95,24H19.58a1,1,0,0,0,1-1V18.23L25,20.9A1,1,0,0,0,26.54,20V4.17A1,1,0,0,0,25.54,3.17ZM18.58,22H8.67a1,1,0,0,0-.51.14L4.71,24.23V11.12h4v5.94a1,1,0,0,0,1,1h8.92Zm6-3.74-3.45-2.07a1,1,0,0,0-.51-.14H10.66V5.17H24.54Z"></path><circle cx="21.07" cy="10.61" r="0.99"></circle><circle cx="17.6" cy="10.61" r="0.99"></circle><circle cx="14.13" cy="10.61" r="0.99"></circle></svg>';


// TOP MENU
$menu = elgg_view_menu('entity', array(
		'entity' => $entity,
		'handler' => $entity->getSubtype(),
		'sort_by' => 'priority',
		'class' => 'elgg-menu-vert',
	));
$header = '<div class="entity-headline">';
	if ($mode != 'listing') {
		$header .= '<div class="owner-icon"><a href="' . $owner->getURL() . '" title="' . $owner->name . '" class="elgg-avatar medium"><img src="' . $owner->getIconURL(array('size' => 'small')) . '" /></a></div>';
	}
	
	$header .= '<div class="entity-title">';
		$header .= '<strong>' . $owner->name . '</strong>';
		$header .= '<span class="elgg-river-timestamp">' . elgg_view_friendly_time($entity->time_created) . '</span>';
		//$header .= elgg_view('output/access', array('entity' => $entity));
	$header .= '</div>';
	
	$header .= '<div class="entity-submenu">
		<a href="javascript:void(0);" onClick="$(this).parent().find(\'.entity-submenu-content\').toggleClass(\'hidden\')"><i class="fa fa-ellipsis-h"></i></a>
		<div class="entity-submenu-content hidden">' . $menu . '</div>
	</div>';
$header .= '</div>';


// MAIN CONTENT
$main_content = '';
if (!empty($title)) {
	if ($mode == 'full') {
		$main_content .= '<h2>' . $title . '</h2>';
	} else {
		$main_content .= '<h3><a href="' . $entity->getURL() . '">' . $title . '</a></h3>';
	}
}
if (!empty($body)) {
	$main_content .= '<div class="elgg-content">' . $body . '</div>';
}


// ACTIONS - Bottom menu
$actions_after = '';

if (!elgg_instanceof($page_owner, 'group') && !elgg_instanceof($page_owner, 'user')) {
}

// Add container
$container_info = '';
//if (elgg_instanceof($entity, 'object') && !elgg_instanceof($page_owner, 'group') && !elgg_instanceof($page_owner, 'user')) {
if (elgg_instanceof($entity, 'object') && !elgg_instanceof($page_owner, 'group')) {
	$container = $entity->getContainerEntity();
	// Get real container for forum & comment
	$subtype = $container->getSubtype();
	//error_log($entity->guid .' // container='.$subtype . ' // object='.$entity->getSubtype().' == '.print_r($vars['item'], true));
	if ($subtype == 'discussion_reply') {
		while(in_array($subtype, array('discussion_reply', 'groupforumtopic')) || !$parent_container) {
			$parent_container = $container->getContainerEntity();
			if ($parent_container) { $container = $parent_container; }
			$subtype = $container->getSubtype();
		}
	} else if ($subtype == 'comment') {
		while($subtype == 'comment' || !$parent_container) {
			$parent_container = $container->getContainerEntity();
			if ($parent_container) { $container = $parent_container; }
			$subtype = $container->getSubtype();
		}
	}
	if (elgg_instanceof($container, 'group')) {
		$container_info = '<li>' . elgg_view('output/url', array(
				'text' => $group_icon . '&nbsp;' . $container->name,
				'href' => $container->getURL(),
				'class' => 'iris-container',
			)) . '</li>';
	}
}

$access_info = '<li>' . elgg_view('output/access', array('entity' => $entity)) . '</li>';
$metadata_alt = $access_info . $container_info . $metadata_alt;
$actions = '<div class="clearfloat"></div>';
$actions .= '<div class="iris-object-actions">';
	if (!empty($metadata_alt)) {
		$actions .= '<ul class="elgg-menu-entity float">' . $metadata_alt . '</ul>';
	}
	// Add likes counter and actions
	$actions .= '<ul class="elgg-menu-entity-alt float-alt">';
	
		// @TODO ajout form de commentaire ? pas sûr...
	
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
		}
	
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
		if ($comments > 0) { $actions .= '<li>' . $entity->countComments() . '&nbsp;<i class="fa fa-comments"></i>' . '</li>'; }
	
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

//echo $mode;
echo '<div class="iris-object iris-object-' . $mode . '">';
switch($mode) {
	case 'full':
		echo $header;
		echo $main_content;
		echo $actions;
		break;
		
	case 'content':
		echo elgg_view_image_block($entity_icon, $header . $main_content . $actions);
		break;
		
	case 'listing':
	default:
		echo elgg_view_image_block($owner_icon, $header . $main_content . $actions);
}
echo '</div>';

