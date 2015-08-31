<?php
/**
 * Save transitions entity
 *
 * Can be called by clicking save button or preview button. If preview button,
 * we automatically save as draft. The preview button is only available for
 * non-published drafts.
 *
 * Drafts are saved with the access set to private.
 *
 * @package Transitions
 */

// start a new sticky form session in case of failure
elgg_make_sticky_form('transitions-addlink');


// edit or create a new entity
$guid = get_input('guid');
$address = get_input('address');
$comment = get_input('comment');

// Check entity
if ($guid) {
	$entity = get_entity($guid);
	if (!elgg_instanceof($entity, 'object', 'transitions')) {
		register_error(elgg_echo('transitions:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}
}

// Clean and validate URL
// don't use elgg_normalize_url() because we don't want
// relative links resolved to this site.
if ($address && !preg_match("#^((ht|f)tps?:)?//#i", $address)) {
	$address = "http://$address";
}
// see https://bugs.php.net/bug.php?id=51192
$php_5_2_13_and_below = version_compare(PHP_VERSION, '5.2.14', '<');
$php_5_3_0_to_5_3_2 = version_compare(PHP_VERSION, '5.3.0', '>=') && version_compare(PHP_VERSION, '5.3.3', '<');
$validated = false;
if ($php_5_2_13_and_below || $php_5_3_0_to_5_3_2) {
	$tmp_address = str_replace("-", "", $address);
	$validated = filter_var($tmp_address, FILTER_VALIDATE_URL);
} else {
	$validated = filter_var($address, FILTER_VALIDATE_URL);
}
if (!$validated) {
	register_error(elgg_echo('transitions:addlink:invalidlink'));
	forward(get_input('forward', REFERER));
}

// Add new link
if (!empty($address)) {
	$links = (array)$entity->links;
	$links_comment = (array)$entity->links_comment;
	// Dédoublonnage : ssi URL et commentaire tous deux identiques
	if ($links) foreach ($links as $k => $link) {
		if (($link == $address) && ($links_comment[$k] == $comment)) {
			register_error(elgg_echo('transitions:addlink:alreadyexists'));
			forward(get_input('forward', REFERER));
		}
	}
	/*
	// Dédoublonnage : ssi le lien et le commentaire existent déjà ?
	if (in_array($address, $links) && in_array($comment, $links_comment)) {
		register_error(elgg_echo('transitions:addlink:alreadyexists'));
	} else {
	*/
		// Add link
		$links[] = $address;
		//$links = array_unique($links);
		//$links = array_filter($links);
		$entity->links = $links;
		// Add comment
		$links_comment[] = $comment;
		//$links_comment = array_unique($links_comment);
		//$links_comment = array_filter($links_comment);
		$entity->links_comment = $links_comment;
		
		system_messages(elgg_echo('transitions:addlink:success'));
		elgg_clear_sticky_form('transitions-addlink');
	//}
} else {
	register_error(elgg_echo('transitions:addlink:emptylink'));
}


forward($entity->getURL());

