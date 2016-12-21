<?php
/**
 * User's activity
 *
 * @uses $vars['entity']    ElggUser
 */

$user = elgg_extract('entity', $vars, elgg_get_page_owner_entity());
$limit = elgg_extract('limit', $vars, 20);

echo elgg_list_river(array('subject_guids' => $user->guid, 'limit' => $limit, 'pagination' => true));

