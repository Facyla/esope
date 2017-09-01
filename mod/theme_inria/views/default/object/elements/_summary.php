<?php
/**
 * Object summary
 *
 * Sample output
 * <ul class="elgg-menu elgg-menu-entity"><li>Public</li><li>Like this</li></ul>
 * <h3><a href="">Title</a></h3>
 * <p class="elgg-subtext">Posted 3 hours ago by George</p>
 * <p class="elgg-tags"><a href="">one</a>, <a href="">two</a></p>
 * <div class="elgg-content">Excerpt text</div>
 *
 * @uses $vars['entity']    ElggEntity
 * @uses $vars['title']     Title link (optional) false = no title, '' = default
 * @uses $vars['metadata']  HTML for entity menu and metadata (optional)
 * @uses $vars['metadata_alt']  HTML for bottom entity menu and metadata (optional)
 * @uses $vars['subtitle']  HTML for the subtitle (optional)
 * @uses $vars['tags']      HTML for the tags (default is tags on entity, pass false for no tags)
 * @uses $vars['content']   HTML for the entity content (optional)
 */

$entity = $vars['entity'];
if (!elgg_instanceof($entity)) { error_log("Entity not valid : " . print_r($entity, true)); return;  }

$title_link = elgg_extract('title', $vars, '');
if ($title_link === '') {
	if (isset($entity->title)) {
		$text = $entity->title;
	} else {
		$text = $entity->name;
	}
	$params = array(
		'text' => elgg_get_excerpt($text, 100),
		'href' => $entity->getURL(),
		'is_trusted' => true,
	);
	$title_link = elgg_view('output/url', $params);
}

$metadata = elgg_extract('metadata', $vars, '');
$metadata_alt = elgg_extract('metadata_alt', $vars, '');
$subtitle = elgg_extract('subtitle', $vars, '');
$content = elgg_extract('content', $vars, '');

$tags = elgg_extract('tags', $vars, '');
if ($tags === '') {
	$tags = elgg_view('output/tags', array('tags' => $entity->tags));
}


// Bottom menu
$metadata_alt_after = '';
$metadata_alt = '<ul class="elgg-menu-entity-alt float">' . $metadata_alt . '</ul>';

// Add likes counter and actions
$metadata_alt .= '<ul class="elgg-menu-entity-alt float-alt">';
	
	$comments = $entity->countComments();
	if ($comments > 0) {
		$metadata_alt .= '<li>' . $entity->countComments() . '&nbsp;<i class="fa fa-comments"></i>' . '</li>';
	}
	
	if (elgg_instanceof($entity, 'object', 'thewire')) {
		$metadata_alt .= '<li>' . elgg_view('output/url', array(
				'href' => "javascript:void(0);", 'onClick' => "$('#thewire-reply-{$entity->guid}').slideToggle('slow');",
				'text' => '<i class="fa fa-comment"></i>',
		)) . '</li>';
			// Form should separated from menu
		$form_vars = array('class' => 'thewire-form');
		$metadata_alt_after .= '<div id="thewire-reply-' . $entity->guid . '" class="thewire-reply-inline hidden">';
		$metadata_alt_after .= elgg_view_form('thewire/add', $form_vars, array('post' => $entity));
		$metadata_alt_after .= '</div>';
	}
	
	if ($entity->canAnnotate(0, 'likes')) {
		$hasLiked = \Elgg\Likes\DataService::instance()->currentUserLikesEntity($entity->guid);
		$metadata_alt .= '<li>' . elgg_view('output/url', array(
				'name' => 'likes',
				'href' => elgg_add_action_tokens_to_url("/action/likes/add?guid={$entity->guid}"),
				'text' => elgg_view_icon('thumbs-up'),
				'title' => elgg_echo('likes:likethis'),
				'class' => $hasLiked ? 'hidden' : '',
			)) . '</li>';
		$metadata_alt .= '<li>' . elgg_view('output/url', array(
				'name' => 'unlike',
				'href' => elgg_add_action_tokens_to_url("/action/likes/delete?guid={$entity->guid}"),
				'text' => elgg_view_icon('thumbs-up-alt'),
				'title' => elgg_echo('likes:remove'),
				'class' => $hasLiked ? '' : 'hidden',
			)) . '</li>';
	}
	
	$likes = \Elgg\Likes\DataService::instance()->getNumLikes($entity);
	if ($likes > 0) {
		$metadata_alt .= '<li>' . elgg_view('likes/count', array('entity' => $entity, 'class' => '')) . '</li>';
	}
	
$metadata_alt .= '</ul>';

$metadata_alt .= '<div class="clearfloat"></div>' . $metadata_alt_after;

if (!elgg_in_context('main') && elgg_instanceof($entity, 'object', 'thewire')) { $metadata_alt = '';}


if (elgg_in_context('workspace') && elgg_instanceof($entity, 'object')) {
	
	$owner = $entity->getOwnerEntity();
	if ($owner) echo "<h3>$owner->name</h3>";
	echo ' &nbsp; <span class="elgg-river-timestamp">' . elgg_view_friendly_time($entity->time_created) . '</span>';
	echo '<div class="entity-submenu">
			<a href="javascript:void(0);" onClick="$(this).parent().find(\'.entity-submenu-content\').toggleClass(\'hidden\')"><i class="fa fa-ellipsis-h"></i></a>
			<div class="entity-submenu-content hidden">' . $metadata . '</div>
		</div>';

	echo "<div class=\"elgg-subtext\">$subtitle</div>";
	echo $tags;

	echo elgg_view('object/summary/extend', $vars);

	if ($content) { echo "<div class=\"elgg-content\">$content</div>"; }
	
	if ($metadata_alt) { echo $metadata_alt; }
	
} else {
	
	if (elgg_instanceof($entity, 'object') && !elgg_instanceof($entity, 'object', 'thewire')) {
		if (!elgg_in_context('main')) {
			$owner = $entity->getOwnerEntity();
			echo '<div class="entity-headline">';
				echo '<span class="elgg-avatar float"><img src="' . $owner->getIconURL(array('size' => 'small')) . '" /></span>&nbsp;<strong>' . $owner->name . '</strong>';
				echo ' &nbsp; <span class="elgg-river-timestamp">' . elgg_view_friendly_time($entity->time_created) . '</span>';
				if ($metadata && (elgg_instanceof($entity, 'user') || elgg_in_context('workspace-content'))) {
					echo '<div class="entity-submenu">
				<a href="javascript:void(0);" onClick="$(this).parent().find(\'.entity-submenu-content\').toggleClass(\'hidden\')"><i class="fa fa-ellipsis-h"></i></a>
				<div class="entity-submenu-content hidden">' . $metadata . '</div>
			</div>';
				}
			echo '</div>';
			echo '<div class="clearfloat"></div>';
		}
	}
	
	if ($title_link) { echo "<h3>$title_link</h3>"; }
	if (!elgg_instanceof($entity, 'object')) {
		if ($metadata && (elgg_instanceof($entity, 'user') || elgg_in_context('workspace-content'))) { echo $metadata; }
	}

	echo "<div class=\"elgg-subtext\">$subtitle</div>";
	echo $tags;

	echo elgg_view('object/summary/extend', $vars);

	if ($content) { echo "<div class=\"elgg-content\">$content</div>"; }

	//if ($metadata && !elgg_instanceof($entity, 'user') && !elgg_in_context('workspace-content')) { echo $metadata; }
	if ($metadata && !elgg_instanceof($entity, 'user') && !elgg_in_context('workspace-content') && !elgg_in_context('main')) { echo $metadata; }
	
	if (elgg_instanceof($entity, 'object') && $metadata_alt) { echo $metadata_alt; }
	
}

