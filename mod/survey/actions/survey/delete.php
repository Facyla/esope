<?php
/**
 * Elgg Survey plugin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 */

// Get input data
$guid = (int) get_input('guid');

// Make sure we actually have permission to edit
$survey = get_entity($guid);

if ($survey instanceof Survey && $survey->canEdit()) {

	// Get container
	$container = $survey->getContainerEntity();
	// Delete the survey!
	$survey->deleteChoices();
	if ($survey->delete()) {
		// Success message
		system_message(elgg_echo("survey:deleted"));
	} else {
		register_error(elgg_echo("survey:notdeleted"));
	}
	// Forward to the main survey page
	if (elgg_instanceof($container, 'group')) {
		forward("survey/group/" . $container->guid);
	} else {
		forward("survey/owner/" . $container->username);
	}
}

