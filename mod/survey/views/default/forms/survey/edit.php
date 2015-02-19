<?php
/* Structure générale : 
 * Sondage : title, description, questions, close_date, open_survey, front_page, tags, access_id, container_guid, owner_guid
 * questions : list of related (relationship) 'question' objects ? => permet de +facilement traiater les réponses sous forme d'annotations de ces objets
 */

$survey = elgg_extract('entity', $vars);
if ($survey) {
	$guid = $survey->guid;
} else  {
	$guid = 0;
}

$question = $vars['fd']['question'];
$description = $vars['fd']['description'];
$tags = $vars['fd']['tags'];
$access_id = $vars['fd']['access_id'];


// @TODO : Add question : cd survey/input/questions
// @TODO For each question : question type, optional choice list, optional required (see profile_manager)

?>

<p><a href="#">Ajouter une question : Text court (text), Texte long (longtext ou plaintext), Choix dans une liste (dropdown), Cases à cocher (checkboxes), Choix multiple (multiselect), Echelle d'évaluation (0 à N) (@TODO), Date, Heure</a></p>

<p>Possibilité de réordonner les questions</p>


<div>
	<label><?php echo elgg_echo('survey:title'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $question)); ?>
</div>

<div>
	<label><?php echo elgg_echo('survey:description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $description)); ?>
</div>

<div>
	<label><?php echo elgg_echo('survey:questions'); ?></label>
	<?php echo elgg_view('survey/input/questions', array('survey' => $survey)); ?>
</div>

<!--
<div>
	<label><?php echo elgg_echo('survey:responses'); ?></label>
	<?php //echo elgg_view('survey/input/choices', array('survey' => $survey)); ?>
</div>
//-->

<?php
$allow_close_date = elgg_get_plugin_setting('allow_close_date','survey');
if ($allow_close_date == 'yes') {
	$close_date = $vars['fd']['close_date'];
?>
<div>
	<label><?php echo elgg_echo('survey:close_date'); ?></label>
	<?php echo  elgg_view('input/date', array('name' => 'close_date', 'timestamp' => true, 'value' => $close_date)); ?>
</div>
<?php
}
?>

<?php
$allow_open_survey = elgg_get_plugin_setting('allow_open_survey','survey');
if($allow_open_survey == 'yes') {
	$open_survey_input = '<p>';
	if ($vars['fd']['open_survey']) {
		$open_survey_input .= elgg_view('input/checkbox', array('name' => 'open_survey','value' => 1, 'checked' => 'checked'));
	} else {
		$open_survey_input .= elgg_view('input/checkbox', array('name' => 'open_survey','value' => 1));
	}
	$open_survey_input .= elgg_echo('survey:open_survey_label');
	$open_survey_input .= '</p>';
} else {
	$open_survey_input = '';
}
echo $open_survey_input;
?>

<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo  elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>

<div>
	<label><?php echo elgg_echo('access'); ?></label>
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>


<?php
$survey_front_page = elgg_get_plugin_setting('front_page','survey');

if(elgg_is_admin_logged_in() && ($survey_front_page == 'yes')) {
	$front_page_input = '<p>';
	if ($vars['fd']['front_page']) {
		$front_page_input .= elgg_view('input/checkbox', array('name' => 'front_page','value' => 1, 'checked' => 'checked'));
	} else {
		$front_page_input .= elgg_view('input/checkbox', array('name' => 'front_page','value' => 1));
	}
	$front_page_input .= elgg_echo('survey:front_page_label');
	$front_page_input .= '</p>';
} else {
	$front_page_input = '';
}

echo $front_page_input . "<br>";

if (isset($vars['entity'])) {
	$entity_hidden = elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
} else {
	$entity_hidden = '';
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
$('#survey_edit_cancel').click(
	function() {
		window.location.href="<?php echo elgg_get_site_url().'survey/owner/'.(elgg_get_page_owner_entity()->username); ?>";
	}
);
</script>
