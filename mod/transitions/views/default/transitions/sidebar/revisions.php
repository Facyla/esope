<?php
/**
 * Transitions sidebar menu showing revisions
 *
 * @package Transitions
 */

//If editing a post, show the previous revisions and drafts.
$transitions = elgg_extract('entity', $vars, FALSE);

if (elgg_instanceof($transitions, 'object', 'transitions') && $transitions->canEdit()) {
	$owner = $transitions->getOwnerEntity();
	$revisions = array();

	$auto_save_annotations = $transitions->getAnnotations(array(
		'annotation_name' => 'transitions_auto_save',
		'limit' => 1,
	));
	if ($auto_save_annotations) {
		$revisions[] = $auto_save_annotations[0];
	}

	// count(FALSE) == 1!  AHHH!!!
	$saved_revisions = $transitions->getAnnotations(array(
		'annotation_name' => 'transitions_revision',
		'reverse_order_by' => true,
	));
	if ($saved_revisions) {
		$revision_count = count($saved_revisions);
	} else {
		$revision_count = 0;
	}

	$revisions = array_merge($revisions, $saved_revisions);

	if ($revisions) {
		$title = elgg_echo('transitions:revisions');

		$n = count($revisions);
		$body = '<ul class="transitions-revisions">';

		$load_base_url = "transitions/edit/{$transitions->getGUID()}";

		// show the "published revision"
		if ($transitions->status == 'published') {
			$load = elgg_view('output/url', array(
				'href' => $load_base_url,
				'text' => elgg_echo('status:published'),
				'is_trusted' => true,
			));

			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($transitions->time_created) . "</span>";

			$body .= "<li>$load : $time</li>";
		}

		foreach ($revisions as $revision) {
			$time = "<span class='elgg-subtext'>"
				. elgg_view_friendly_time($revision->time_created) . "</span>";

			if ($revision->name == 'transitions_auto_save') {
				$revision_lang = elgg_echo('transitions:auto_saved_revision');
			} else {
				$revision_lang = elgg_echo('transitions:revision') . " $n";
			}
			$load = elgg_view('output/url', array(
				'href' => "$load_base_url/$revision->id",
				'text' => $revision_lang,
				'is_trusted' => true,
			));

			$text = "$load: $time";
			$class = 'class="auto-saved"';

			$n--;

			$body .= "<li $class>$text</li>";
		}

		$body .= '</ul>';

		echo elgg_view_module('aside', $title, $body);
	}
}
