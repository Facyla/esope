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
$metadata = elgg_extract('metadata', $vars, FALSE);
$metadata_alt = elgg_extract('metadata_alt', $vars, FALSE);
$after = elgg_extract('after', $vars, FALSE);

$mode = elgg_extract('mode', $vars, FALSE);
$full = elgg_extract('full_view', $vars, FALSE);
if (!in_array($mode, array('full', 'listing', 'content'))) {
	$mode = 'listing';
	if ($full) {
		$mode = 'full';
	//} else if (elgg_instanceof($page_owner, 'group') || elgg_instanceof($page_owner, 'user')) {
	} else if (elgg_instanceof($page_owner, 'group') && !elgg_in_context('workspace')) {
		$mode = 'content';
	}
}

$class = 'elgg-image-block';
$additional_class = elgg_extract('class', $vars, '');
if ($additional_class) { $class = "$class $additional_class"; }

$id = '';
if (isset($vars['id'])) { $id = "id=\"{$vars['id']}\""; }

$page_owner = elgg_get_page_owner_entity();
$owner = $entity->getOwnerEntity();

// Main title
$title = $entity->title;
if (empty($title)) { $title = $entity->name; }
if (!empty($title)) {
	if ($mode == 'full') {
		$main_title = '<h2>' . $title . '</h2>';
	} else {
		$main_title = '<h3 title="' . $title . '"><a href="' . $entity->getURL() . '">' . elgg_get_excerpt($title, 50) . '</a></h3>';
		//$main_content .= '<h3 title="' . $title . '">' . elgg_get_excerpt($title, 50) . '</h3>';
	}
}



// ICONS AND IMAGES
if (elgg_instanceof($owner)) {
	$profile_type = esope_get_user_profile_type($owner);
	if (empty($profile_type)) { $profile_type = 'external'; }
	// Archive : replace profile type by member status archived
	if ($owner->memberstatus == 'closed') { $profile_type = 'archive'; }
	$owner_icon = '<span class="elgg-avatar elgg-avatar-medium profile-type-' . $profile_type . '"><a href="' . $owner->getURL() . '" title="' . $owner->name . '" class="elgg-avatar medium"><img src="' . $owner->getIconURL(array('size' => 'medium')) . '" /></a></span>';
} else {
	$owner_icon = '';
	error_log('DEBUG page/components/iris_object : invalid $owner');
}

$entity_icon = $entity->getIconURL(array('size' => 'medium'));
if (elgg_instanceof($entity, 'object', 'file')) {
	$entity_icon = '<a href="' . $entity->getURL() . '" class="medium"><img src="' . $entity->getIconUrl(array('size' => 'medium')) . '" alt="object ' . $entity->getSubtype() . '" /></a>';
} else {
	$entity_icon = '<a href="' . $entity->getURL() . '" title="' . $title . '"><span class="small">' . elgg_echo('esope:icon:'.$entity->getSubtype()) . '</span></a>';
}

$group_icon = '<svg class="iris-groupes" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><path d="M25.54,3.17H9.66a1,1,0,0,0-1,1v5h-5a1,1,0,0,0-1,1V26a1,1,0,0,0,1.51.86L8.95,24H19.58a1,1,0,0,0,1-1V18.23L25,20.9A1,1,0,0,0,26.54,20V4.17A1,1,0,0,0,25.54,3.17ZM18.58,22H8.67a1,1,0,0,0-.51.14L4.71,24.23V11.12h4v5.94a1,1,0,0,0,1,1h8.92Zm6-3.74-3.45-2.07a1,1,0,0,0-.51-.14H10.66V5.17H24.54Z"></path><circle cx="21.07" cy="10.61" r="0.99"></circle><circle cx="17.6" cy="10.61" r="0.99"></circle><circle cx="14.13" cy="10.61" r="0.99"></circle></svg>';


// TOP MENU
$header = elgg_view('page/components/iris_object_header', array('entity' => $entity, 'mode' => $mode));


// MAIN CONTENT
$main_content = '';
if (!empty($body)) {
	if ($mode != 'full') {
		// Auto-detect link in text for more flexibility ?
		//if ((strpos($body, '<a ') === false) && (strpos($body, '</a>') === false)) {
		if ((strpos($body, '<a ') === false) && (strpos($body, '</a>') === false) && !in_array($entity->getSubtype(), array('thewire'))) {
		//if (in_array($entity->getSubtype(), ['blog', 'file', 'bookmarks', 'page', 'page_top', 'thewire', 'newsletter'])) {
			$main_content .= '<a href="' . $entity->getUrl() . '" class="iris-object-readmore"><div class="elgg-content">' . $body . '<span class="readmore">' . elgg_echo('theme_inria:readmore') . '</span></div></a>';
		} else {
			//$main_content .= '<div class="elgg-content">' . $body . '<a href="' . $entity->getUrl() . '" class="iris-object-readmore"><span class="readmore">' . elgg_echo('theme_inria:readmore') . '</span></a></div>';
			$main_content .= '<div class="elgg-content">' . $body . '</div>';
		}
	} else {
		$main_content .= '<div class="elgg-content">' . $body . '</div>';
	}
}


// ACTIONS - Bottom menu
$actions = elgg_view('page/components/iris_object_actions', array('entity' => $entity, 'mode' => $mode, 'metadata_alt' => $metadata_alt, 'metadata' => $metadata)) . $after;


//echo $mode;
echo '<div class="iris-object iris-object-' . $mode . '">';
switch($mode) {
	case 'full':
		echo $header;
		echo $main_title;
		echo $main_content;
		echo $actions;
		break;
		
	case 'content':
		echo elgg_view_image_block($entity_icon, $header . $main_title . $main_content . $actions);
		break;
		
	case 'listing':
	default:
		echo elgg_view_image_block($owner_icon, $header . $main_title . $main_content . $actions);
}
echo '</div>';

