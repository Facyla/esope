<?php

namespace AU\RSSImport;

elgg_gatekeeper();

// get our feed object
$rssimport_id = get_input('rssimport_guid');
$rssimport = get_entity($rssimport_id);

// make sure we're the owner if selecting a feed
if (!($rssimport instanceof RSSImport) || !$rssimport->canEdit()) {
	register_error(elgg_echo('rssimport:not:owner'));
	forward(REFERRER);
}

// set up breadcrumbs
$urlsuffix = 'owner/' . $container->username;
$name = $container->username;
if ($container instanceof \ElggGroup) {
	RSSImport::groupGatekeeper($container, $import_into);
	$urlsuffix = 'group/' . $container->guid . '/all';
	$name = $container->name;
}

$url = elgg_get_site_url() . "{$import_into}/{$urlsuffix}";

// push original context
elgg_push_breadcrumb(elgg_echo($import_into), $url);
elgg_push_breadcrumb(elgg_echo('rssimport:import'), "rssimport/{$container->guid}/{$import_into}");
elgg_push_breadcrumb($rssimport->title, $rssimport->getURL());
elgg_push_breadcrumb(elgg_echo('rssimport:history'));

/**
 * 	***********************************
 * 			Begin History
 * 	***********************************
 */

// get all our history items
$history = elgg_list_annotations(array(
	'guid' => $rssimport->guid,
	'annotaion_names' => 'rssimport_history',
	'no_results' => elgg_echo('rssimport:no:history')
));

/*
$historycount = count($history);
$html = "";
if ($historycount > 0 && !empty($history)) {
	for ($i = 0; $i < $historycount; $i++) {
		$ids = explode(',', $history[$i]->value);
		$html .= "<div class=\"rssimport_history_item\">";
		$html .= "<h4>" . elgg_echo('rssimport:imported:on') . " " . date("F j, Y, g:i a", $history[$i]->time_created) . "<h4>";

		//create links to each entity imported on that occasion
		for ($j = 0; $j < count($ids); $j++) {
			$entity = get_entity($ids[$j]);
			if (is_object($entity)) {
				$html .= "<a href=\"" . $entity->getURL() . "\">" . $entity->title . "</a><br>";
			}
		}
		$html .= "<br>";
		$url = elgg_get_site_url() . "action/rssimport/undoimport?id=" . $history[$i]->id;
		//$url = elgg_add_action_tokens_to_url($url);
		//$html .= "<a href=\"$url\" onclick=\"return confirm('" . elgg_echo('rssimport:undo:import:confirm') . "');\">" . elgg_echo('rssimport:undo:import') . "</a>";

		$html .= elgg_view('output/confirmlink', array(
			'href' => $url,
			'text' => elgg_echo('rssimport:undo:import'),
			'confirm' => elgg_echo('rssimport:undo:import:confirm'),
			'class' => 'elgg-button elgg-button-action'
		));
		$html .= "</div><!-- /rssimport_history_item -->";
	}
} else {
	$html .= "<div class=\"rssimport_history_item\">";
	$html .= "<h4>" . elgg_echo('rssimport:no:history') . "</h4>";
	$html .= "</div><!-- /rssimport_history_item -->";
}
$content .= $html;
*/

// place the form into the elgg layout
$body = elgg_view_layout('one_sidebar', array(
	'content' => $history,
	'sidebar' => $sidebar
));

// display the page
echo elgg_view_page($title, $body);
