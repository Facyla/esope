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
$open_survey_input = '';
$front_page_input = '';
$access_id = $vars['fd']['access_id'];
?>

<p>@TODO Possibilité de réordonner les questions</p>


<div>
	<label><?php echo elgg_echo('survey:title'); ?></label>
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>

<div>
	<label><?php echo elgg_echo('survey:description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $description)); ?>
</div>

<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo  elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>

<?php if ($allow_close_date == 'yes') { ?>
	<div>
		<label><?php echo elgg_echo('survey:close_date'); ?></label>
		<?php echo  elgg_view('input/date', array('name' => 'close_date', 'timestamp' => true, 'value' => $close_date)); ?>
	</div>
<?php } ?>

<?php
if($allow_open_survey == 'yes') {
	$open_survey_input = '<p>';
	if ($vars['fd']['open_survey']) {
		$open_survey_input .= elgg_view('input/checkbox', array('name' => 'open_survey','value' => 1, 'checked' => 'checked'));
	} else {
		$open_survey_input .= elgg_view('input/checkbox', array('name' => 'open_survey','value' => 1));
	}
	$open_survey_input .= elgg_echo('survey:open_survey_label');
	$open_survey_input .= '</p>';
}
echo $open_survey_input;
?>

<?php
if (elgg_is_admin_logged_in() && ($survey_front_page == 'yes')) {
	if ($vars['fd']['front_page']) {
		$front_page_input .= elgg_view('input/checkbox', array('name' => 'front_page','value' => 1, 'checked' => 'checked'));
	} else {
		$front_page_input .= elgg_view('input/checkbox', array('name' => 'front_page','value' => 1));
	}
	$front_page_input .= elgg_echo('survey:front_page_label');
}
echo '<div><p>' . $front_page_input . '</p></div>';
?>

<div>
	<label><?php echo elgg_echo('access'); ?></label>
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>

<br />

<div>
	<h3><?php echo elgg_echo('survey:questions'); ?></h3>
	<?php echo elgg_view('survey/input/questions', array('survey' => $survey)); ?>
</div>

<br />

<?php
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
$('#survey_edit_cancel').click(
	function() {
		window.location.href="<?php echo elgg_get_site_url().'survey/owner/'.(elgg_get_page_owner_entity()->username); ?>";
	}
);
</script>
