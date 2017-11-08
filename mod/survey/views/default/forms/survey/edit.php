<?php
/* Structure générale : 
 * Sondage : title, description, questions, close_date, open_survey, front_page, tags, access_id, container_guid, owner_guid
 * questions : list of related (relationship) 'question' objects ? => permet de +facilement traiater les réponses sous forme d'annotations de ces objets
 */

$survey = elgg_extract('entity', $vars);
$guid = 0;
if ($survey) { $guid = $survey->guid; }

// Global settings
$allow_close_date = elgg_get_plugin_setting('allow_close_date','survey');
$allow_open_survey = elgg_get_plugin_setting('allow_open_survey','survey');
$survey_front_page = elgg_get_plugin_setting('front_page','survey');

// Current/default value
$title = $vars['fd']['title'];
$description = $vars['fd']['description'];
$tags = $vars['fd']['tags'];
if ($allow_close_date == 'yes') { $close_date = $vars['fd']['close_date']; }
$comments_on = $vars['fd']['comments_on'];
$open_survey_input = '';
$front_page_input = '';
$access_id = $vars['fd']['access_id'];

// @TODO Possibilité de réordonner les questions "display_order"



echo '<div><label>' . elgg_echo('survey:title') . ' ' . elgg_view('input/text', array('name' => 'title', 'value' => $title)) . '</label></div>';

echo '<div><label for="survey_description">' . elgg_echo('survey:description') . '</label> ' . elgg_view('input/longtext', array('name' => 'description', 'id' => 'survey_description', 'value' => $description)) . '</div>';

echo '<div><label>' . elgg_echo('tags') . ' ' . elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)) . '</label></div>';

if ($allow_close_date == 'yes') {
	echo '<div><label>' . elgg_echo('survey:close_date') . ' ' . elgg_view('input/date', array('name' => 'close_date', 'timestamp' => true, 'value' => $close_date)) . '</label></div>';
}

if($allow_open_survey == 'yes') {
	$open_survey_input = '<p><label>';
	if ($vars['fd']['open_survey']) {
		$open_survey_input .= elgg_view('input/checkbox', array('name' => 'open_survey','value' => 1, 'checked' => 'checked'));
	} else {
		$open_survey_input .= elgg_view('input/checkbox', array('name' => 'open_survey','value' => 1));
	}
	$open_survey_input .= elgg_echo('survey:open_survey_label');
	$open_survey_input .= '</label></p>';
}
echo $open_survey_input;



if (elgg_is_admin_logged_in() && ($survey_front_page == 'yes')) {
	if ($vars['fd']['front_page']) {
		$front_page_input .= elgg_view('input/checkbox', array('name' => 'front_page','value' => 1, 'checked' => 'checked'));
	} else {
		$front_page_input .= elgg_view('input/checkbox', array('name' => 'front_page','value' => 1));
	}
	$front_page_input .= elgg_echo('survey:front_page_label');
}
echo '<div><p><label>' . $front_page_input . '</label></p></div>';

$yn_options = array(elgg_echo('survey:settings:yes') => 'yes', elgg_echo('survey:settings:no') => 'no');
echo '<div><label>' . elgg_echo('survey:comments_on') . '</label>' . elgg_view('input/radio', array('name' => 'params[comments_on]', 'value' => $comments_on, 'options' => $yn_options)) . '</div>';

echo '<div><label>' . elgg_echo('access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)) . '</label></div>';

echo '<br />';

echo '<div>
	<span style=float:right;"><a href="javascript:void(0);" onclick="$(\'.survey-input-question-details\').toggle();">' . elgg_echo('survey:question:toggle:details') . '</a></span>
	<h3>' . elgg_echo('survey:questions') . '</h3>
	<p><em>' . elgg_echo('survey:questions:reorder') . '</em></p>'
	. elgg_view('survey/input/questions', array('survey' => $survey)) 
	. '</div><br />';


$entity_hidden = '';
if (isset($vars['entity'])) {
	$entity_hidden = elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}
$entity_hidden .= elgg_view('input/hidden', array('name' => 'container_guid', 'value' => elgg_get_page_owner_guid()));

$submit_input = elgg_view('input/submit', array('name' => 'submit', 'class' => 'elgg-button elgg-button-submit', 'value' => elgg_echo('save')));
$submit_input .= ' '.elgg_view('input/button', array('name' => 'cancel', 'id' => 'survey_edit_cancel', 'type'=> 'button', 'class' => 'elgg-button elgg-button-cancel', 'value' => elgg_echo('cancel')));

?>

<div class="elgg-foot">
	<?php
	echo $entity_hidden;
	echo $submit_input;
	?>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("#survey-questions").sortable({ // initialisation de Sortable sur le container parent
		placeholder: 'survey-sort-highlight', // classe du placeholder ajouté lors du déplacement
	});
});
</script>

<script type="text/javascript">
$('#survey_edit_cancel').click(
	function() {
		window.location.href="<?php echo elgg_get_site_url().'survey/owner/'.(elgg_get_page_owner_entity()->username); ?>";
	}
);
</script>

