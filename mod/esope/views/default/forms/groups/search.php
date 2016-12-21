<?php
/**
 * Group search form
 *
 * @uses $vars['entity'] ElggGroup
 */

if ($vars['entity']) {
	$container_guid = $vars['entity']->getGUID();
} else {
	$container_guid = elgg_get_page_owner_guid();
}

$tag_string = get_input('q', '');

$params = array(
	'name' => 'q',
	'class' => 'elgg-input-search mbm',
	'value' => $tag_string,
	'placeholder' => elgg_echo('groups:search_in_group'),
);
echo '<label for="q" class="hidden">' . elgg_echo('groups:search_in_group') . '</label>';
echo elgg_view('input/text', $params);

echo elgg_view('input/hidden', array(
	'name' => 'container_guid',
	'value' => $container_guid,
));

//echo elgg_view('input/submit', array('value' => elgg_echo('search:go'),'class' => "groups-search-submit-button"));
echo '<input type="image" class="groups-search-submit-button" src="' . elgg_get_site_url() . 'mod/esope/img/theme/recherche.png" value="' . elgg_echo('search:go') . '" />';

