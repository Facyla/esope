<?php

function survey_get_question_array($survey) {
	$responses = array();
	foreach($survey->getQuestions() as $question) {
		$responses[$question->guid] = $question;
		/*
		array(
				'title' => $question->title,
				'description' => $question->description,
				'input_type' => $question->input_type,
				'options' => $question->options,
				'empty_value' => $question->empty_value,
				'required' => $question->required,
			);
		*/
	}
	return $responses;
}

/* Get options and formats them in a suitable array for input views
 * @param $question : the question object
 * @param $reverse : reverse return array key <=> values order
 * Notes : we do not need to reverse order, as we use no keys here (will be numerical)
           use regular options_values (option=>value) for : dropdown, pulldown, multiselect
           use reverse options for : checkboxes, radio, rating
 */
function survey_get_question_choices_array($question) {
	$choices = explode("\n", $question->options);
	if (is_array($choices)) {
		$choices = array_map('trim', $choices);
		// Remove empty values
		$choices = array_filter($choices);
		$choices = array_unique($choices);
	}
	// Build clean array with choices both as key and value
	$options = array();
	foreach($choices as $option) { $options["$option"] = $option; }
	// Add optional empty option
	if ($question->empty_value == 'yes') { array_unshift($options, ''); }
	return $options;
}

// Format date for display
function survey_format_date($ts) {
	$format = "d/m/Y";
	return date($format, $ts);
}

function survey_activated_for_group($group) {
	$group_survey = elgg_get_plugin_setting('group_survey', 'survey');
	if ($group && ($group_survey != 'no')) {
		if (($group->survey_enable == 'yes') || (!$group->survey_enable && ($group_survey == 'yes_default'))) {
			return true;
		}
	}
	return false;
}

function survey_can_add_to_group($group, $user = null) {
	$survey_group_access = elgg_get_plugin_setting('group_access', 'survey');
	if (!$survey_group_access || $survey_group_access == 'admins') {
		return $group->canEdit();
	} else {
		if (!$user) {
			$user = elgg_get_logged_in_user_guid();
		}
		return $group->canEdit() || $group->isMember($user);
	}
}

function survey_get_page_edit($page_type, $guid = 0) {
	gatekeeper();
	$form_vars = array('id' => 'survey-edit-form');

	// Get the post, if it exists
	if ($page_type == 'edit') {
		$survey = get_entity($guid);

		if (!$survey instanceof Survey) {
			register_error(elgg_echo('survey:not_found'));
			forward(REFERER);
		}

		if (!$survey->canEdit()) {
			register_error(elgg_echo('survey:permission_error'));
			forward(REFERER);
		}

		$container = $survey->getContainerEntity();
		elgg_set_page_owner_guid($container->guid);

		$title = elgg_echo('survey:editpost', array($survey->title));

		$body_vars = array(
			'fd' => survey_prepare_edit_body_vars($survey),
			'entity' => $survey
		);

		if ($container instanceof ElggGroup) {
			elgg_push_breadcrumb($container->name, 'survey/group/' . $container->guid);
		} else {
			// Do not show owner for site surveys ?
			elgg_push_breadcrumb($container->name, 'survey/owner/' . $container->username);
		}
		elgg_push_breadcrumb(elgg_echo("survey:edit"));
	} else {
		if ($guid) {
			$container = get_entity($guid);
			elgg_push_breadcrumb($container->name, 'survey/group/' . $container->guid);
		} else {
			$container = elgg_get_logged_in_user_entity();
			elgg_push_breadcrumb($container->name, 'survey/owner/' . $container->username);
		}

		elgg_set_page_owner_guid($container->guid);

		elgg_push_breadcrumb(elgg_echo('survey:add'));

		$title = elgg_echo('survey:addpost');

		$body_vars = array(
			'fd' => survey_prepare_edit_body_vars(),
			'container_guid' => $guid
		);
	}

	$content = elgg_view_form("survey/edit", $form_vars, $body_vars);

	$params = array(
		'title' => $title,
		'content' => $content,
		'filter' => ''
	);

	//$body = elgg_view_layout('content', $params);
	$body = elgg_view_layout('one_column', $params);

	// Display page
	return elgg_view_page($title, $body);
}

/**
 * Pull together variables for the edit form
 * @param ElggObject $survey
 * @return array
 *
 * TODO - put questions in sticky form as well
 */
function survey_prepare_edit_body_vars($survey = null) {

	// input names => defaults
	$values = array(
		'title' => null,
		'description' => null,
		'close_date' => null,
		'open_survey' => null,
		'tags' => null,
		'front_page' => null,
		'comments_on' => null,
		'access_id' => ACCESS_DEFAULT,
		'guid' => null
	);

	if ($survey) {
		foreach (array_keys($values) as $field) {
			if (isset($survey->$field)) {
				$values[$field] = $survey->$field;
			}
		}
	}

	if (elgg_is_sticky_form('survey')) {
		$sticky_values = elgg_get_sticky_values('survey');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('survey');

	return $values;
}

// Display results page
function survey_get_page_results($guid = false, $filter = false, $filter_guid = false) {
	gatekeeper();
	$user = elgg_get_logged_in_user_entity();
	
	$survey = get_entity($guid);
	if (!elgg_instanceof($survey, 'object', 'survey')) {
		elgg_echo('survey:invalid');
		forward(REFERER);
	}
	
	// Access control
	if (!$survey->canEdit($user) && !elgg_is_admin_logged_in()) {
		elgg_echo('survey:no_access');
		forward(REFERER);
	}
	
	elgg_push_breadcrumb($survey->title, $survey->getURL());
	elgg_push_breadcrumb(elgg_echo('survey:results'), 'survey/results/' . $survey->guid);
	
	$title = elgg_echo('survey:results');
	// Check filter validity - forward to results page if error
	if ($filter) {
		$filter_entity = get_entity($filter_guid);
		if (($filter == 'user') && !elgg_instanceof($filter_entity, 'user')) {
			register_error(elgg_echo('survey:filter:invalid'));
			forward('survey/results/' . $survey->guid);
		}
		if (($filter == 'question') && !elgg_instanceof($filter_entity, 'object', 'survey_question')) {
			register_error(elgg_echo('survey:filter:invalid'));
			forward('survey/results/' . $survey->guid);
		}
		if (in_array($filter, array('user', 'question'))) {
			//elgg_push_breadcrumb(elgg_echo('survey:results:' . $filter), 'survey/results/' . $survey->guid . '/' . $filter . '/' . $filter_guid);
			if ($filter == 'question') {
				$title = elgg_echo('survey:results:questiondetails', array($filter_entity->title));
			} else if ($filter == 'user') {
				$title = elgg_echo('survey:results:userdetails', array($filter_entity->name));
			}
			elgg_push_breadcrumb(elgg_echo('survey:results:' . $filter));
		}
	}
	
	$body = '';
	/*
	$body .= '<h3>' . elgg_echo('survey:results:summary') . '</h3>';
	$body .= elgg_view('survey/survey_results', array('entity' => $survey));
	$body .= '<br />';
	$body .= '<h3>' . elgg_echo('survey:results:full') . '</h3>';
	*/
	$body .= elgg_view('survey/survey_full_results', array('entity' => $survey, 'filter' => $filter, 'filter_guid' => $filter_guid, 'filter_entity' => $filter_entity));
	
	$params = array(
			'title' => $title,
			'content' => $body,
		);
	
	$body = elgg_view_layout("one_column", $params);
	return elgg_view_page($params['title'], $body);
	
}


/* Export survey data as CSV
 * Header : - | Q1  | Q2  | Q3  | etc.
 * Rows : Responder | R1  | R2  | R3  | etc.
 */
function survey_get_page_export($guid = false) {
	gatekeeper();
	$user = elgg_get_logged_in_user_entity();
	
	$survey = get_entity($guid);
	if (!elgg_instanceof($survey, 'object', 'survey')) {
		elgg_echo('survey:invalid');
		forward(REFERER);
	}
	
	// Access control
	if (!$survey->canEdit($user) && !elgg_is_admin_logged_in()) {
		elgg_echo('survey:no_access');
		forward(REFERER);
	}
	
	// CSV EXPORT
	set_time_limit(0);
	$ia = elgg_set_ignore_access(true);
	$filename = 'survey_' . $survey->guid . '_' . date('Y-m-d-H-i-s') . '.csv';
	$delimiter = ";";

	// Send file using headers for download
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=' . $filename);

	// create a file pointer connected to the output stream
	$output = fopen('php://output', 'w');
	// output up to 5MB is kept in memory, if it becomes bigger it will automatically be written to a temporary file
	//$output = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');

	// Add Headings : Question titles
	$questions = survey_get_question_array($survey);
	$headings[] = elgg_echo('survey:results:name');
	$i = 0;
	foreach ($questions as $question) {
		$i++;
		$headings[] = $i . " " . $question->title;
	}
	fputcsv($output, $headings, $delimiter);
	
	// Output the CSV responses row for each responder
	$responders_guid = $survey->getResponders();
	foreach ($responders_guid as $guid) {
		if ($user = get_entity($guid)) {
			$row_array = array("{$user->name} ({$user->guid})");
			foreach ($questions as $i => $question) {
				$values = array();
				$responses = elgg_get_annotations(array('guid' => $question->guid, 'annotation_owner_guids' => $user->guid, 'annotation_name' => 'response', 'limit' => 0));
				foreach($responses as $response) { $values[] = $response->value; }
				$row_array[] = implode("\n", $values);
			}
			fputcsv($output, $row_array, $delimiter);
		} else {
			fputcsv($output, array('Error'), $delimiter);
		}
	}
	
	elgg_set_ignore_access($ia);
	// Note : page handlers should return true.. but it would add an extra "1" in exported CSV, 
	// so end earlier, as we will anyway not display any page
	exit;
	return true;
}


function survey_get_page_list($page_type, $container_guid = null) {
	global $autofeed;
	$autofeed = true;
	$user = elgg_get_logged_in_user_entity();
	$params = array();
	$options = array(
		'type'=>'object',
		'subtype'=>'survey',
		'full_view' => false,
		'limit' => 15
	);

	if ($page_type == 'group') {
		$group = get_entity($container_guid);
		if (!elgg_instanceof($group, 'group') || !survey_activated_for_group($group)) {
			forward();
		}
		$crumbs_title = $group->name;
		$params['title'] = elgg_echo('survey:group_survey:listing:title', array(htmlspecialchars($crumbs_title)));
		$params['filter'] = "";

		// set breadcrumb
		elgg_push_breadcrumb($crumbs_title);

		elgg_push_context('groups');

		elgg_set_page_owner_guid($container_guid);
		group_gatekeeper();

		$options['container_guid'] = $container_guid;
		$user_guid = elgg_get_logged_in_user_guid();
		if (elgg_get_page_owner_entity()->canWriteToContainer($user_guid)){
			elgg_register_menu_item('title', array(
				'name' => 'add',
				'href' => "survey/add/".$container_guid,
				'text' => elgg_echo('survey:add'),
				'link_class' => 'elgg-button elgg-button-action'
			));
		}

	} else {
		switch ($page_type) {
			case 'owner':
				$options['owner_guid'] = $container_guid;

				$container_entity = get_user($container_guid);
				elgg_push_breadcrumb($container_entity->name);

				if ($user->guid == $container_guid) {
					$params['title'] = elgg_echo('survey:your');
					$params['filter_context'] = 'mine';
				} else {
					$params['title'] = elgg_echo('survey:not_me', array(htmlspecialchars($container_entity->name)));
					$params['filter_context'] = "";
				}
				$params['sidebar'] = elgg_view('survey/sidebar');
				break;
			case 'friends':
				$container_entity = get_user($container_guid);
				$friends = $container_entity->getFriends(array('limit' => false));

				$options['container_guids'] = array();
				foreach ($friends as $friend) {
					$options['container_guids'][] = $friend->getGUID();
				}

				$params['filter_context'] = 'friends';
				$params['title'] = elgg_echo('survey:friends');

				elgg_push_breadcrumb($container_entity->name, "survey/owner/{$container_entity->username}");
				elgg_push_breadcrumb(elgg_echo('friends'));
				break;
			case 'all':
				$params['filter_context'] = 'all';
				$params['title'] = elgg_echo('item:object:survey');
				$params['sidebar'] = elgg_view('survey/sidebar');
				break;
		}

		$survey_site_access = elgg_get_plugin_setting('site_access', 'survey');

		if ((elgg_is_logged_in() && ($survey_site_access != 'admins')) || elgg_is_admin_logged_in()) {
			elgg_register_menu_item('title', array(
				'name' => 'add',
				'href' => "survey/add",
				'text' => elgg_echo('survey:add'),
				'link_class' => 'elgg-button elgg-button-action'
			));
		}
	}

	if (($page_type == 'friends') && (count($options['container_guids']) == 0)) {
		// this person has no friends
		$params['content'] = '';
	} else {
		$params['content'] = elgg_list_entities($options);
	}
	if (!$params['content']) {
		$params['content'] = elgg_echo('survey:none');
	}

	$body = elgg_view_layout("content", $params);

	return elgg_view_page($params['title'],$body);
}

function survey_get_page_view($guid) {
	elgg_load_js('elgg.survey.survey');
	//elgg_require_js('elgg/survey/survey'); // Elgg 1.10

	$survey = get_entity($guid);
	if ($survey instanceof Survey) {
		// Set the page owner
		$page_owner = $survey->getContainerEntity();
		if (elgg_instanceof($page_owner, 'group')) {
			elgg_set_page_owner_guid($page_owner->guid);
		} else {
			elgg_set_page_owner_guid(elgg_get_site_entity()->guid);
		}
		$title =  $survey->title;
		$content = elgg_view_entity($survey, array('full_view' => true));
		//check to see if comments are on
		if ($survey->comments_on == 'yes') {
			$content .= elgg_view_comments($survey);
		}

		if (elgg_instanceof($page_owner,'group')) {
			elgg_push_breadcrumb($page_owner->name, "survey/group/{$page_owner->guid}");
		} else {
			//elgg_push_breadcrumb($page_owner->name, "survey/owner/{$page_owner->username}");
		}
		elgg_push_breadcrumb($survey->title);
	} else {
		// Display the 'post not found' page instead
		$title = elgg_echo("survey:notfound");
		$content = elgg_view("survey/notfound");
		elgg_push_breadcrumb($title);
	}

	if (elgg_instanceof($page_owner, 'group')) {
		$body = elgg_view_layout('content', array('title' =>$title, 'content' => $content, 'filter' => ''));
	} else {
		$body = elgg_view_layout('one_column', array('title' =>$title, 'content' => $content, 'filter' => ''));
	}
	// Display page
	return elgg_view_page($title, $body);
}

function survey_manage_front_page($survey, $front_page) {
	$survey_front_page = elgg_get_plugin_setting('front_page','survey');
	if(elgg_is_admin_logged_in() && ($survey_front_page == 'yes')) {
		$options = array(
			'type' => 'object',
			'subtype' => 'survey',
			'metadata_name_value_pairs' => array(array('name' => 'front_page','value' => 1)),
			'limit' => 1
		);
		$survey_front = elgg_get_entities_from_metadata($options);
		if ($survey_front) {
			$front_page_survey = $survey_front[0];
			if ($front_page_survey->guid == $survey->guid) {
				if (!$front_page) {
					$front_page_survey->front_page = 0;
				}
			} else {
				if ($front_page) {
					$front_page_survey->front_page = 0;
					$survey->front_page = 1;
				}
			}
		} else {
			if ($front_page) {
				$survey->front_page = 1;
			}
		}
	}
}


