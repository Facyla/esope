<?php
/**
 * Elgg bookmarks plugin everyone page
 *
 * @package ElggBookmarks
 */

elgg_push_context('members');
elgg_push_context('search');

elgg_pop_breadcrumb();
elgg_push_breadcrumb($owner->name);


$title = '';
$content = '';
$sidebar = '';

$sidebar .= "Filtres avancés<br />
Statut<br />
Localisation<br />
EPI ou service<br />
Rattachement<br />
Afficher seulement mes contacts<br />
Rechercher<br />
";

$content .= 'X membres
Trier par <select></select><br />
<div class="iris-members-search-results">Liste de resultats<br />
</div>
';


$body = elgg_view_layout('iris_search', array(
	//'filter_context' => 'all',
	'filter' => false,
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);

