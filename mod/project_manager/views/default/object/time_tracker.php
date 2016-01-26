<?php
/**
 * View for time_tracker object
 *
 * @package ElggPages
 *
 * @uses $vars['entity']    The time_tracker object
 * @uses $vars['full_view'] Whether to display the full view
 * @uses $vars['revision']  This parameter not supported by elgg_view_entity()
 */

$full = elgg_extract('full_view', $vars, FALSE);
$time_tracker = elgg_extract('entity', $vars, FALSE);
if (!$time_tracker) { return true; }

// time_trackers used to use Public for write access => change to LOGGEDIN
if ($time_tracker->write_access_id == ACCESS_PUBLIC) {
	// this works because this metadata is public
	$time_tracker->write_access_id = ACCESS_LOGGED_IN;
}

// Get useful vars
$months = time_tracker_get_date_table('months');
$members_names = project_manager_get_members_names();
$projects_names = project_manager_get_projects_names();
$time_tracker_icon = elgg_view('time_trackers/icon', array('entity' => $time_tracker, 'size' => 'small'));

$metadata = elgg_view_menu('entity', array(
	  'entity' => $vars['entity'], 'handler' => 'time_trackers',
	  'sort_by' => 'priority', 'class' => 'elgg-menu-hz',
  ));

// do not show the metadata and controls in widget view
if (elgg_in_context('widgets') || $revision) { $metadata = ''; }

/* Accélération via un mini-cache
$project_name = time_tracker_get_projectname($time_tracker->project_guid);
$member = get_entity($time_tracker->owner_guid);
$member_name = $member->name;
*/
$project_name = $projects_names[$time_tracker->project_guid];
$member_name = $members_names[$time_tracker->owner_guid];

$content .= '<div style="border:1px solid #CCC; padding:6px 12px; margin:4px 12px;">';
$content .= $member_name . ' / ' . $months[(int)$time_tracker->month] . ' ' . $time_tracker->year . ' : "' . $project_name . '" = ' . time_tracker_get_total_time_tracker($time_tracker) . ' jour(s)<br />';
if (!empty($time_tracker->cost)) $content .= 'Frais : ' . $time_tracker->cost . '&nbsp;€<br />';
if (!empty($time_tracker->comment)) $content .= 'Commentaire : ' . $time_tracker->comment;
$content .= '</div>';

echo $content;

/*
// Render view
if ($full) {
	$body = elgg_view('output/longtext', array('value' => $time_tracker->value));
	//$params = array('entity' => $time_tracker, 'metadata' => $metadata, 'subtitle' => $subtitle, 'tags' => $tags);
	//$params = $params + $vars;
	//$summary = elgg_view('object/elements/summary', $params);
	echo elgg_view('object/elements/full', array(
		  'entity' => $time_tracker, 'icon' => $time_tracker_icon,
		  'title' => false, 'summary' => $summary, 'body' => $body,
	  ));

} else {
  // brief view
  $excerpt = elgg_get_excerpt($time_tracker->description);
  $params = array(
	    'entity' => $time_tracker, 'metadata' => $metadata, 'tags' => $tags,
	    'subtitle' => $subtitle, 'content' => $excerpt,
    );
  $params = $params + $vars;
  $list_body = elgg_view('object/elements/summary', $params);
  echo elgg_view_image_block($time_tracker_icon, $list_body);
}
*/

