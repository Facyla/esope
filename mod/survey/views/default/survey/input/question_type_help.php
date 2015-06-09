<?php
// Add some help for each input type
$input_type = elgg_extract('input_type', $vars, 'text');
$question_types_opt = array('text', 'longtext', 'pulldown', 'checkboxes', 'multiselect', 'rating', 'date');

$content = '';
foreach($question_types_opt as $type) {
	if ($input_type == $type) {
		$content .= '<span class="question-help question-' . $type . '">' . elgg_echo("survey:type:$type:details") . '</span>';
	} else {
		$content .= '<span class="question-help question-' . $type . '" style="display:none;">' . elgg_echo("survey:type:$type:details") . '</span>';
	}
}

if (!empty($content)) echo '<br />' . $content;

