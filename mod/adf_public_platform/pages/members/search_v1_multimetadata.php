<?php
/**
 * Members index
 *
 */

$num_members = get_number_users();

$title = elgg_echo('members');

$content = '';

// Search params
$search_type = get_input('search_type', 'tags');
$q = get_input('q');
$searchable_metadata = get_input('field');
$tag_names = get_input('field');
$limit = get_input('limit');
$offset = get_input('offset');
//$entity_type = get_input('entity_type');
$entity_subtype = get_input('entity_subtype');
$owner_guid = get_input('owner_guid');
$container_guid = get_input('container_guid');
$friends = get_input('friends');
$sort = get_input('sort');
$order = get_input('order');


/* Notes de conception : la recherche actuelle est conçue pour chercher une seule valeur (requête) dans une série de métadonnées. 
 * Cela se fait par comparaison '=', le nom de la métdonnée étant dans un IN().
 * Ce n'est donc pas adapté, en l'état, à une recherche multicritères, qui nécessiterait des comparaisons plus fines et des requêtes à bien calibrer (entre charge et efficacité, et utilisation de l'API)
 * Voir mod/search/search_hooks
 * Ceci dit, on a un peu triché en utilisant des clauses "wheres" pour permettre une recherche plus élaborée sur plusieurs critères simultanés
 */

// Search form : define a set of configured properties to search : basic + advanced ?
$content .= '<form action="" method="get">';
$content .= elgg_view('input/text', array('name' => 'q', 'value' => $q));

$search_fields = array('industry', 'promotion');
$access = get_access_sql_suffix('md');
foreach ($search_fields as $name) {
	// On récupère les saisies
	${$name} = get_input($name, false);
	if (!empty(${$name})) {
		$searchable_metadata[] = $name;
		$tag_names[] = $name;
		$search_values[] = ${$name};
		if (!empty($q)) $wheres[] = "(msn.string = '$name' AND msv.string = '${$name}' AND $access)";
		$q = ${$name};
	}
	$field_a = elgg_get_entities_from_metadata(array('types' => 'object', 'subtype' => 'custom_profile_field', 'metadata_names' => 'metadata_name', 'metadata_values' => $name));
	if ($field_a) {
		$field = $field_a[0];
		$options = false;
		$options = $field->getOptions();
		$valtype = $field->metadata_type;
		//if ($valtype == 'multiselect') $valtype = 'radio';
		if ($options) {
			$valtype = 'radio';
			$options['empty option'] = '';
		}
		$content .= '<label>' . elgg_echo("profile:$name") . '</label> ' . elgg_view("input/$valtype", array('name' => $name, 'options' => $options, 'value' => ${$name})) . '<br />';
	}
}
$content .= elgg_view("input/hidden", array('name' => 'search_type', 'value' => 'tags'));
$content .= elgg_view("input/submit", array('value' => elgg_echo('search')));
$content .= '</form><br /><br />';

//$q = implode('\' OR msv.string = \'', $search_values);
//$content .= print_r($wheres, true);

// Get all fields
/*
$options = array("type" => "object", "subtype" => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE, "limit" => false, "owner_guid" => elgg_get_config("site_guid"), "site_guid" => elgg_get_config("site_guid")); 
$fields = elgg_get_entities($options);
foreach($fields as $field){
*/


// Search query and results
$search_params = array(
		'search_type' => $search_type,
		'q' => $q,
		'searchable_metadata' => $searchable_metadata, // Which metadata should be searched
		'tag_names' => $tag_names, // Use only these metadata (filter)
		'tag' => $tag,
		'limit' => $limit,
		'offset' => $offset,
		'entity_type' => 'user',
		'entity_subtype' => $entity_subtype,
		'owner_guid' => $owner_guid,
		'container_guid' => $container_guid,
		'friends' => $friends,
		'sort' => $sort,
		'order' => $order,
		'wheres' => $wheres,
	);
$content .= elgg_view('adf_platform/search_facility', $search_params);

/*
$options = array('type' => 'user', 'full_view' => false);

$filter_type = get_input('filter_type', false);
$filter_value = get_input('filter_value', false);
$search_q = get_input('search_q', false);

$content = '<form action="" method="post">';
$content = elgg_echo('input/text', array('name' => 'filter_type', 'value' => $filter_type));
$content = elgg_echo('input/text', array('name' => 'filter_value', 'value' => $filter_value));
$content = elgg_echo('input/text', array('name' => 'search_q', 'value' => $search_q));
$content .= '</form>';

// Alphabetic search results
$db_prefix = elgg_get_config('dbprefix');

// Type de profil => getprofile...  => promotion  | Ordre alphabétique


if ($filter_type) $options['metadata_names'] = $filter_type;
if ($filter_value) $options['metadata_values'] = $filter_value;

$options['joins'] = array("JOIN {$db_prefix}users_entity ue USING(guid)");
$options['order_by'] = 'ue.name ASC';
$content .= elgg_list_entities_from_metadata($options);
*/


$params = array(
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'title' => $title . " ($num_members)",
	'filter_override' => elgg_view('members/nav', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

