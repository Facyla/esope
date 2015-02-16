<?php

//get our defaults
$container_guid = get_input('container_guid');
$import_into = get_input('import_into');

// get our feed object
$rssimport_id = get_input('rssimport_guid');
$rssimport = get_entity($rssimport_id);


// Check that we are allowed to import into this container
$container = get_entity($container_guid);
if (!rssimport_can_use($container)) {
	// We still may be the owner of that particular feed (rights changes ?)...
	if (!(elgg_instanceof($rssimport, 'object', 'rssimport') && (elgg_get_logged_in_user_guid() != $rssimport->owner_guid))) {
		register_error(elgg_echo('rssimport:not:owner'));
		forward(REFERRER);
	}
}

// set the title
$title = elgg_echo('rssimport:title');

// get the sidebar
$sidebar = elgg_view('rssimport/sidebar', array('container_guid' => $container_guid, 'import_into' => $import_into));


$maincontent = "<div id=\"{$rssimport->guid}\" class=\"rssimport_feedwrapper\">";

$container = get_entity($container_guid);
$maincontent .= "<h2>" . elgg_echo("rssimport:import:title", array($container->name, elgg_echo($import_into))) . "</h2>";

$maincontent .= elgg_view_form('rssimport/add',
		array(),
		array(
			'entity' => $rssimport,
			'import_into' => $import_into,
			'container_guid' => $container_guid
		)
	);


$maincontent .= "<hr><br>";

if ($rssimport) {
	// Begin showing our feed
	$feed = rssimport_simplepie_feed($rssimport->description);
	
	$maincontent .= elgg_view('rssimport/feedcontrol', array('entity' => $rssimport, 'feed' => $feed));
	
	//Display each item
	$importablecount = 0;
	foreach ($feed->get_items() as $item) {
		if (!rssimport_already_imported($item, $rssimport)) {
			$importablecount++;
			
			if ($blacklisted = rssimport_is_blacklisted($item, $rssimport)) {
				$importablecount--;
			}
			
			$maincontent .= elgg_view('rssimport/feeditem', array(
					'entity' => $rssimport,
					'blacklisted' => $blacklisted,
					'item' => $item
				));
		}
	}
	
	$maincontent .= "</div><!-- rssimport_feedwrapper -->";
	
}

$maincontent .= "</div>";


// some items can be imported, so make that div visible
if($importablecount > 0){
	$maincontent .= "<script>
$(document).ready(function() {
	$('#rssimport_control_box').toggle(0);
  $('#rssimport_nothing_to_import').toggle(0);
});
</script>";
}


// place the form into the elgg layout
$body = elgg_view_layout('one_sidebar', array('content' => $maincontent, 'sidebar' => $sidebar));

// display the page
echo elgg_view_page($title, $body);

