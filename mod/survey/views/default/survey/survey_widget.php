<?php
/**
 * Elgg survey individual widget view
 *
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 *
 * @uses $vars['entity'] Optionally, the survey post to view
*/

elgg_load_js('elgg.survey.survey');
//elgg_require_js('elgg/survey/survey'); // Elgg 1.10

$allow_close_date = elgg_get_plugin_setting('allow_close_date','survey');
$survey = $vars['entity'];
$owner = $survey->getOwnerEntity();
$friendlytime = elgg_get_friendly_time($survey->time_created);
$owner_link = elgg_view('output/url', array('text' => $owner->name, 'href' => "survey/owner/$owner->username", 'is_trusted' => true));
$author_text = elgg_echo('byline', array($owner_link));

$tags = elgg_view('output/tags', array('tags' => $survey->tags));

if (($allow_close_date == 'yes') && (isset($survey->close_date))) {
	$show_close_date = true;
	$date_day = gmdate('j', $survey->close_date);
	$date_month = gmdate('m', $survey->close_date);
	$date_year = gmdate('Y', $survey->close_date);
	$friendly_time = $date_day . '. ' . elgg_echo("survey:month:$date_month") . ' ' . $date_year;

	$survey_state = $survey->isOpen() ? 'open' : 'closed';

	$closing_date = "<div class='survey_closing-date-{$survey_state}'><b>" . elgg_echo('survey:survey_closing_date', array($friendly_time)) . '</b></div>';
}

// TODO: support comments off
$comments_link = '';
// The "on" status changes for comments, so best to check for !Off
if ($survey->comments_on != 'Off') {
	$comments_count = $survey->countComments();
	//only display if there are commments
	if ($comments_count != 0) {
		$text = elgg_echo("comments") . " ($comments_count)";
		$comments_link = elgg_view('output/url', array('text' => $text, 'href' => $survey->getURL() . '#survey-comments', 'is_trusted' => true));
	}
}

?>

<h3><?php echo "<a href=\"{$survey->getURL()}\">{$survey->title}</a>"; ?></h3>
<?php
if ($show_close_date) { echo $closing_date; }
echo "<div class=\"elgg-subtext\">{$author_text} {$friendlytime} {$comments_link}</div>";
echo $tags;

echo elgg_view('survey/survey_content', $vars); ?>


