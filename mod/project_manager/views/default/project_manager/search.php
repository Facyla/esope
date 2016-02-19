<?php
/** Simple project_manager search */

$title = "Rechercher un projet";

$content = '';
$content .= '<form id="memberssearchform" action="' . elgg_get_site_url() . 'project_manager/references" method="get">';
$content .= '<label for="project_manager-search" class="hidden">Chercher un projet</label>';
$content .= '<input type="text" id="project_manager-search" name="search" placeholder="Rechercher un projet" class="search_input" value="' . $vars['search'] . '" />';
$content .= elgg_view('input/submit', array('value' => elgg_echo('Chercher un projet')));
$content .= '</form>';

echo elgg_view_module('aside', $title, $content);

