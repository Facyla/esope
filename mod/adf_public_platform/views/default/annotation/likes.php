<?php
/**
 * Elgg show the users who liked the object
 *
 * @uses $vars['annotation']
 */

if (!isset($vars['annotation'])) {
	return true;
}

$like = $vars['annotation'];

$user = $like->getOwnerEntity();
if (!$user) {
	return true;
}

$user_icon = elgg_view_entity_icon($user, 'tiny');
$user_link = elgg_view('output/url', array(
	'href' => $user->getURL(),
	'text' => $user->name,
	'is_trusted' => true,
));

$likes_string = elgg_echo('likes:this');

$friendlytime = elgg_view_friendly_time($like->time_created);

//if ($like->canEdit()) {
// Esope : peut poser pb dans le cas des pages wiki, car si on peut éditer la page on peut éditer le like (= le supprimer)
// Donc seuls l'auteur du like ou un admin peuvet le supprimer (pas grave si l'auteur de l'article ou le responsable du groupe ne peuvent pas)
if (elgg_is_admin_logged_in() || (elgg_is_logged_in() && ($like->owner_guid == elgg_get_logged_in_user_guid()))) {
	$delete_button = elgg_view("output/confirmlink",array(
		'href' => "action/likes/delete?id={$like->id}",
		'text' => "<span class=\"elgg-icon elgg-icon-delete float-alt\"></span>",
		'confirm' => elgg_echo('likes:delete:confirm'),
		'encode_text' => false,
	));
}

$body = <<<HTML
<p class="mbn">
	$delete_button
	$user_link $likes_string
	<span class="elgg-subtext">
		$friendlytime
	</span>
</p>
HTML;

echo elgg_view_image_block($user_icon, $body);
