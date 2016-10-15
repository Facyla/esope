<?php
/**
 * Form body for refining the log browser search.
 * Look for a particular person or in a time window.
 * ESOPE : add GUID filtering
 *
 * @uses $vars['username']
 * @uses $vars['ip_address']
 * @uses $vars['timelower']
 * @uses $vars['timeupper']
 * 
 * ESOPE additions :
 * @uses $vars['entity_type']
 * @uses $vars['entity_subtype']
 * @uses $vars['object_guid']
 * @uses $vars['event']
 */

if (isset($vars['timelower']) && $vars['timelower']) {
	$lowerval = date('r', $vars['timelower']);
} else {
	$lowerval = "";
}
if (isset($vars['timeupper']) && $vars['timeupper']) {
	$upperval = date('r', $vars['timeupper']);
} else {
	$upperval = "";
}
$ip_address = elgg_extract('ip_address', $vars);
$username = elgg_extract('username', $vars);

$user_guid = elgg_extract('user_guid', $vars);
$entity_type = elgg_extract('entity_type', $vars);
$entity_subtype = elgg_extract('entity_subtype', $vars);
$object_guid = elgg_extract('object_guid', $vars);
$event = elgg_extract('event', $vars);

// Populate search boxes
$entity_type_opt = esope_get_log_distinct_values('object_type');
$entity_subtype_opt = esope_get_log_distinct_values('object_subtype');
$event_opt = esope_get_log_distinct_values('event');


// Form fields
$form = '';
$form .= '<p>';
	$form .= '<label>' . elgg_echo('logbrowser:user') . ' ' . elgg_view('input/text', array('name' => 'search_username', 'value' => $username, 'style' => 'max-width:25ex')) . '</label>';
	$form .= ' &nbsp; ';
	$form .= '<label>' . elgg_echo('logbrowser:user_guid') . ' ' . elgg_view('input/text', array('name' => 'user_guid', 'value' => $user_guid, 'style' => 'max-width:10ex')) . '</label>';
$form .= '</p>';

$form .= '<div class="elgg-grid">';
	
	$form .= '<div class="elgg-col elgg-col-1of2">';
		$form .= '<p><label>' . elgg_echo('logbrowser:ip_address') . ' ' . elgg_view('input/text', array('name' => 'ip_address', 'value' => $ip_address, 'style' => 'max-width:17ex')) . '</label></p>';
		$form .= '<p><label>' . elgg_echo('logbrowser:starttime') . ' ' . elgg_view('input/text', array('name' => 'timelower', 'value' => $lowerval)) . '</label></p>';
		$form .= '<p><label>' . elgg_echo('logbrowser:endtime') . ' ' . elgg_view('input/text', array('name' => 'timeupper', 'value' => $upperval))  . '</label></p>';
	$form .= '</div>';
	
	$form .= '<div class="elgg-col elgg-col-1of2">';
		$form .= '<p><label>' . elgg_echo('logbrowser:entity_type') . ' ' . elgg_view('input/select', array('name' => 'entity_type', 'value' => $entity_type, 'options_values' => $entity_type_opt)) . '</label></p>';
		$form .= '<p><label>' . elgg_echo('logbrowser:entity_subtype') . ' ' . elgg_view('input/select', array('name' => 'entity_subtype', 'value' => $entity_subtype, 'options_values' => $entity_subtype_opt)) . '</label></p>';
		$form .= '<p><label>' . elgg_echo('logbrowser:object_guid') . ' ' . elgg_view('input/text', array('name' => 'object_guid', 'value' => $object_guid, 'style' => 'max-width:10ex')) . '</label></p>';
		$form .= '<p><label>' . elgg_echo('logbrowser:event') . ' ' . elgg_view('input/select', array('name' => 'event', 'value' => $event, 'options_values' => $event_opt)) . '</label></p>';
	$form .= '</div>';
	
$form .= '</div>';

$form .= '<div class="clearfloat"></div>';



$form .= '<div class="elgg-foot">';
$form .= elgg_view('input/submit', array(
	'value' => elgg_echo('search'),
));
$form .= '</div>';

echo $form;
