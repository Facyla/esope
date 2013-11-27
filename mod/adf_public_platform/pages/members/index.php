<?php
/**
 * Members index
 *
 */
global $CONFIG;

$num_members = get_number_users();
$title = elgg_echo('members');

$options = array('type' => 'user', 'full_view' => false);

switch ($vars['page']) {
	
	case 'popular':
		$options['relationship'] = 'friend';
		$options['inverse_relationship'] = false;
		$content = elgg_list_entities_from_relationship_count($options);
		break;
	
	case 'online':
		$content = get_online_users();
		break;
	
	case 'alpha':
		// Alphabetic sort
		$db_prefix = elgg_get_config('dbprefix');
		$firstletter = get_input('letter', false);
		$options['joins'] = array("JOIN {$db_prefix}users_entity ue USING(guid)");
		$options['order_by'] = 'ue.name ASC';
		$options['wheres'] = "UPPER(ue.name) LIKE UPPER('$firstletter%')";
		$content = '<div class="esope-alpha-char">';
		$chararray = elgg_echo('friendspicker:chararray');
		while (!empty($chararray)) {
			$char = substr($chararray, 0, 1);
			$content .= '<a href="' . $CONFIG->url . 'members/alpha/?letter=' . $char . '">' . $char . '</a> ';
			$chararray = substr($chararray, 1);
		}
		$content .= '</div>';
		$content .= elgg_list_entities($options);
		break;
	
	case 'newest':
	default:
		$content = elgg_list_entities($options);
		break;
}

$params = array(
	'content' => $content,
	'sidebar' => elgg_view('members/sidebar'),
	'title' => $title . " ($num_members)",
	'filter_override' => elgg_view('members/nav', array('selected' => $vars['page'])),
);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

