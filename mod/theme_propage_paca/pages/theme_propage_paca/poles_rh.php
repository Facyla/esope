<?php
global $CONFIG;

// Ensure that only logged-in users can see this page
gatekeeper();

$user_guid = elgg_get_logged_in_user_guid();
$user = elgg_get_logged_in_user_entity();

// Set context and title
elgg_set_context('poles-rh');
//elgg_set_page_owner_guid($user_guid);

$pole = get_input('pole', false);
if (!$pole || !in_array($pole, array('social', 'devpro', 'gestion'))) {
	register_error(elgg_echo('theme_afparh:pole:inexistent'));
	forward();
}
$title = elgg_echo("theme_afparh:pole:$pole");
$content = '';

elgg_push_breadcrumb(elgg_echo('theme_afparh:pole-rh'));
elgg_push_breadcrumb($title);


// Menu du Pôle
$filter = '';
$filter .= '<ul class="elgg-tabs elgg-htabs">';
$filter .= '<li><a href="">Consulter</a></li>';
$filter .= '<li><a href="">Diffuser</a></li>';
$filter .= '<li><a href="">Echanger/forum</a></li>';
$filter .= '<li><a href="">Produire ensemble</a></li>';
$filter .= '</ul>';


// Groupes du Pôle
$groups = '';
$groups .= "<h3>Groupes du Pôle</h3>";
// Get and list groups
$params = array(
	'type' => 'group', 'limit' => 0,
	'metadata_name_value_pairs' => array('name' => 'poles_rh', 'value' => $pole, 'case_sensitive' => false, 'full_view' => false),
);
$pole_groups = elgg_get_entities_from_metadata($params);
$group_guids = array();
foreach ($pole_groups as $ent) {
	$group_guids[] = $ent->guid;
	$img = '<a href="' . $ent->getURL() . '" title="' . $ent->name . '"><img src="' . $ent->getIconURL('small') . '" /></a>';
	$text = '<a href="' . $ent->getURL() . '" title="' . $ent->name . '">' . $ent->name . '</a><br /><q>' . $ent->briefdescription . '</q>';
	$groups .= elgg_view_image_block($img, $text);
}


// Actualités du Pôle
$latest_news = '';
$latest_news .= "<h3>Actualités du Pôle</h3>";
$db_prefix = elgg_get_config('dbprefix');
$pole_group_in = implode(',', $group_guids);
$latest_news .= elgg_list_river(array(
	'pagination' => true,
	'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
	'wheres' => array("(e1.container_guid IN ($pole_group_in))"),
));

// Dernières informations déposées dans le Pôle
$latest_content = '';
$latest_content .= "<h3>Dernières publications dans le Pôle</h3>";
elgg_push_context('widgets');
$latest_content .= elgg_list_entities(array('type' => 'object', 'container_guids' => $group_guids, 'limit' => 10, 'pagination' => true, 'full_view' => false));
elgg_pop_context();


// Contacter l'animateur du Pôle
$contact = '';
$contact .= "Contacter l'animateur du Pôle";
$contact .= "@TODO : est-ce une personne précise, ou les responsables du groupe correspondant au pôle ?";



// Composition de la page
$content .= '<div class="clearfloat"></div>';
$content .= '<div>' . $latest_news . '</div>';
$content .= '<div>' . $latest_content . '</div>';
$content .= '<div>' . $contact . '</div>';



// Filtre
$filter_context = '';

$body = elgg_view_layout('content', array('title' => $title, 'content' => $content, 'filter' => $filter, 'filter_context' => $filter_context, 'sidebar' => $groups));


// Affichage
echo elgg_view_page($title, $body);

