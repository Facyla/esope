<?php

$options = [
	'type' => 'group',
	'no_results' => elgg_echo('groups:none'),
];

$getter = 'elgg_get_entities';
// sorting options
$sorting = get_input('sort');
switch ($sorting) {
	case 'popular':
		$getter = 'elgg_get_entities_from_relationship_count';
		
		$options['relationship'] = 'member';
		$options['inverse_relationship'] = false;
		break;
	case 'alpha':
		$order = strtoupper(get_input('order'));
		if (!in_array($order, ['ASC', 'DESC'])) {
			$order = 'ASC';
		}
		
		$options['order_by_metadata'] = [
			'name' => 'name',
			'direction' => $order,
		];
		
		break;
	case 'newest':
	default:
		// nothing, as Elgg default sorting is by time_created desc (eg newest)
		break;
}

echo elgg_list_entities($options, $getter);
