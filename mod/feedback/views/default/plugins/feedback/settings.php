<?php
$yesno_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));

$feedbackgroup_opt[] = elgg_echo('option:no');
$feedbackgroup_opt['grouptool'] = elgg_echo('feedback:option:grouptool');
$groups_count = elgg_get_entities(array('type' => 'group', 'count' => true));
$groups = elgg_get_entities(array('type' => 'group', 'limit' => $groups_count));
foreach ($groups as $ent) { $feedbackgroup_opt[$ent->guid] = $ent->name; }

// Set defaults
if (!isset($vars['entity']->about_values)) { $vars['entity']->about_values = 'bug_report, content, suggestions, compliment, question, other'; }



// Link to feedbacks page
echo '<p><a href="' . elgg_get_site_url() . 'feedback" target="_new" class="elgg-button">&raquo;&nbsp;' . elgg_echo('feedback:admin:title') . '</a></p>';

// Publicly available?
echo '<p><label>' . elgg_echo("feedback:settings:public") . elgg_view('input/dropdown', array('name' => 'params[publicAvailable_feedback]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->publicAvailable_feedback)) . '</label></p>';
?>

<p>
	<?php echo elgg_echo("feedback:settings:usernames");?>
	<br>
	<?php
		echo "<label>".elgg_echo('feedback:user_1')."</label>";
		echo "<input type='text' size='60' name='params[user_1]' value='".$vars['entity']->user_1."' />";
		echo "<br />";

		echo "<label>".elgg_echo('feedback:user_2')."</label>";
		echo "<input type='text' size='60' name='params[user_2]' value='".$vars['entity']->user_2."' />";
		echo "<br />";

		echo "<label>".elgg_echo('feedback:user_3')."</label>";
		echo "<input type='text' size='60' name='params[user_3]' value='".$vars['entity']->user_3."' />";
		echo "<br />";

		echo "<label>".elgg_echo('feedback:user_4')."</label>";
		echo "<input type='text' size='60' name='params[user_4]' value='".$vars['entity']->user_4."' />";
		echo "<br />";

		echo "<label>".elgg_echo('feedback:user_5')."</label>";
		echo "<input type='text' size='60' name='params[user_5]' value='".$vars['entity']->user_5."' />";
		echo "<br />";
	?>
</p>

<?php
// Can members read feedbacks ?
echo '<p><label>' . elgg_echo("feedback:settings:memberview") . elgg_view('input/dropdown', array('name' => 'params[memberview]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->memberview)) . '</label></p>';

// Are comments allowed on feedbacks ?
echo '<p><label>' . elgg_echo("feedback:settings:comment") . elgg_view('input/dropdown', array('name' => 'params[comment]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->comment)) . '</label></p>';

// Associate a group to feedbacks ?
echo '<p><label>' . elgg_echo("feedback:settings:feedbackgroup") . elgg_view('input/dropdown', array('name' => 'params[feedbackgroup]', 'options_values' => $feedbackgroup_opt, 'value' => $vars['entity']->feedbackgroup)) . '</label></p>';


// Enable feedback types

// @TODO : Mood : global enable + available moods
echo '<p><label>' . elgg_echo("feedback:settings:enablemood") . elgg_view('input/dropdown', array('name' => 'params[enable_mood]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->enable_mood)) . '</label></p>';
/*
// Mood values
echo '<p><label>' . elgg_echo("feedback:settings:mood_values") . elgg_view('input/text', array('name' => 'params[mood_values]', 'value' => $vars['entity']->mood_values)) . '</label>';
echo '<br /><em>Default : happy, neutral, angry</em>';
*/

// @TODO : About : global enable
echo '<p><label>' . elgg_echo("feedback:settings:enableabout") . elgg_view('input/dropdown', array('name' => 'params[enable_about]', 'options_values' => $yesno_opt, 'value' => $vars['entity']->enable_about)) . '</label></p>';
// About values
echo '<p><label>' . elgg_echo("feedback:settings:about_values") . elgg_view('input/text', array('name' => 'params[about_values]', 'value' => $vars['entity']->about_values)) . '</label>';
echo '<br /><em>Default : bug_report, content, suggestions, compliment, question, other</em>';
echo '</p>';



