<?php
/**
 * Elgg survey individual post view
 *
 * @uses $vars['entity'] Optionally, the survey post to view
 */

if (isset($vars['entity'])) {
	$full = $vars['full_view'];
	$survey = $vars['entity'];
	
	$owner = $survey->getOwnerEntity();
	$container = $survey->getContainerEntity();
	$categories = elgg_view('output/categories', $vars);
	
	$owner_icon = elgg_view_entity_icon($owner, 'tiny');
	$owner_link = elgg_view('output/url', array('text' => $owner->name, 'href' => "survey/owner/$owner->username", 'is_trusted' => true));
	$author_text = elgg_echo('byline', array($owner_link));
	$tags = elgg_view('output/tags', array('tags' => $survey->tags));
	$date = elgg_view_friendly_time($survey->time_created);
	
	$allow_close_date = elgg_get_plugin_setting('allow_close_date','survey');
	if (($allow_close_date == 'yes') && (isset($survey->close_date))) {
		$date_day = gmdate('j', $survey->close_date);
		$date_month = gmdate('m', $survey->close_date);
		$date_year = gmdate('Y', $survey->close_date);
		$friendly_time = $date_day . '. ' . elgg_echo("survey:month:$date_month") . ' ' . $date_year;
		$survey_state = $survey->isOpen() ? 'open' : 'closed';
		$closing_date .= "<div class='survey_closing-date-{$survey_state}'><b>" . elgg_echo('survey:survey_closing_date', array($friendly_time)) . '</b></div>';
	}

	// TODO: support comments off
	// The "on" status changes for comments, so best to check for !Off
	$comments_link = '';
	if ($survey->comments_on == 'yes') {
		$comments_count = $survey->countComments();
		//only display if there are commments
		if ($comments_count != 0) {
			$text = elgg_echo("comments") . " ($comments_count)";
			$comments_link = elgg_view('output/url', array(
				'href' => $survey->getURL() . '#survey-comments',
				'text' => $text,
				'is_trusted' => true
			));
		}
	}

	// do not show the metadata and controls in widget view
	$metadata = '';
	if (!elgg_in_context('widgets')) {
		$metadata = elgg_view_menu('entity', array(
				'entity' => $survey,
				'handler' => 'survey',
				'sort_by' => 'priority',
				'class' => 'elgg-menu-hz'
			));
	}
	
	
	// Full view
	if ($full) {
		$subtitle = "$closing_date $author_text $date $comments_link $categories";
		$params = array(
			'entity' => $survey,
			'title' => false,
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'tags' => $tags
		);
		$params = $params + $vars;
		$summary = elgg_view('object/elements/summary', $params);
		echo elgg_view('object/elements/full', array('summary' => $summary, 'icon' => $owner_icon));
		
		// Add detailed description
		if (!empty($survey->description)) { echo elgg_view('output/longtext', array('value' => $survey->description)) . '<br />'; }
		
		// Add survey content : response form, or response message and optionally responses
		echo elgg_view('survey/survey_content', $vars);
		if ($survey->canEdit()) {
			echo '<a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '" class="elgg-button elgg-button-action" style="float:right;">' . elgg_echo('survey:results') . '</a>';
		}

	} else {
		// Brief view
		$responses_count = $survey->getResponseCount();
		if ($responses_count == 1) {
			$noun = elgg_echo('survey:noun_response');
		} else {
			$noun = elgg_echo('survey:noun_responses');
		}
		$responses_count = "<div>" . $responses_count . " " . $noun . "</div>";
		$subtitle = "$closing_date $responses_count $author_text $date $comments_link $categories";
		if ($survey->canEdit()) {
			$subtitle .= '<a href="' . elgg_get_site_url() . 'survey/results/' . $survey->guid . '" class="elgg-button elgg-button-action" style="float:right;">' . elgg_echo('survey:results') . '</a>';
		}
		$params = array(
			'entity' => $survey,
			'title' => '<a href="' . $survey->getURL() . '">' . $survey->title . '</a>',
			'metadata' => $metadata,
			'subtitle' => $subtitle,
			'tags' => $tags
		);
		$params = $params + $vars;
		$list_body .= elgg_view('object/elements/summary', $params);
		echo elgg_view_image_block($owner_icon, $list_body);
	}
	
}

