<?php
/**
 * List comments with optional add form
 *
 * @uses $vars['entity']        ElggEntity
 * @uses $vars['show_add_form'] Display add form or not
 * @uses $vars['id']            Optional id for the div
 * @uses $vars['class']         Optional additional class for the div
 * @uses $vars['limit']         Optional limit value (default is 25)
 *
 * @todo look into restructuring this so we are not calling elgg_list_entities()
 * in this view
 */

$show_add_form = elgg_extract('show_add_form', $vars, true);
$full_view = elgg_extract('full_view', $vars, true);
$limit = elgg_extract('limit', $vars, get_input('limit', 25));

// Iris : pas de commentaire si l'édition est réservée aux responsables d'un groupe
$page_owner = elgg_get_page_owner_entity();
if (elgg_instanceof($page_owner, 'group') && ($page_owner->operators_edit_only == 'yes')) {
	if (!$page_owner->canWriteToContainer()) { $show_add_form = false; }
}

$id = '';
if (isset($vars['id'])) {
	$id = "id =\"{$vars['id']}\"";
}

$class = 'elgg-comments';
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}

// work around for deprecation code in elgg_view()
unset($vars['internalid']);

echo "<div $id class=\"$class\">";

	$html = elgg_list_entities(array(
		'type' => 'object',
		'subtype' => 'comment',
		'container_guid' => $vars['entity']->getGUID(),
		'reverse_order_by' => true,
		'full_view' => true,
		'limit' => $limit,
	));

	if ($html) {
		// Iris : on masque aussi le titre s'il n'y a pas de commentaire du tout
		if ($show_add_form || ($vars['entity']->countComments() > 0)) {
			echo '<h3 id="comments">' . elgg_echo('comments') . '</h3>';
		}
		echo $html;
	}

	if ($show_add_form) {
		$form_id = esope_unique_id('iris-comments-');
		echo elgg_view('output/url', array('href' => '#' . $form_id, 'rel' => 'toggle', 'text' => elgg_echo('comment:toggle'), 'class' => 'elgg-button elgg-button-action elgg-button-comment-toggle'));
		//echo elgg_view_form('comments/add', array('name' => 'elgg_add_comment'), $vars);
		echo elgg_view_form('comment/save', array('id' => $form_id, 'class' => 'hidden'), $vars);
	}

echo '</div>';

