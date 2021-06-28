<?php
/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 *
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Prashant Juvekar
 * @copyright Prashant Juvekar
 * @link http://www.linkedin.com/in/prashantjuvekar
 *
 * for Elgg 1.8 by iionly iionly@gmx.de
 * new features and rewrite by Facyla
 */

$imgurl = elgg_get_site_url() . 'mod/feedback/graphics/';
$feedback_url = elgg_get_site_url() . "action/feedback/submit_feedback";
$feedback_url = elgg_add_action_tokens_to_url($feedback_url);
$progress_img = '<img src="' . $imgurl . 'ajax-loader.gif" alt="'.elgg_echo('feedback:submit_msg').'" />';

$user_ip = $_SERVER['REMOTE_ADDR'];
//$user_id = elgg_echo('feedback:default:id');
$user_id = '';
if (elgg_is_logged_in()) {
	$user = elgg_get_logged_in_user_entity();
	$user_id = $user->name . " (" . $user->email .")";
}

$memberview = elgg_get_plugin_setting("memberview", "feedback");
if ($memberview == 'yes') { $memberview = true; } else { $memberview = false; }
?>

<div id="feedbackWrapper">

	<?php echo elgg_view('feedback/toggle_menu'); ?>

	<div id="feedBackContentWrapper">
		<div id="feedBackContent" class="elgg-module elgg-module-info">
			<div class="elgg-head">
				<h3><?php echo elgg_echo('feedback:title'); ?></h3>
			</div>

			<div id="feedBackIntro">
				<?php
				echo elgg_echo('feedback:message');
				// Additional message if tool is for admin only (= no discussion/animation tool)
				if (!$memberview) echo elgg_echo('feedback:message:adminonly');
				?>
			</div>

			<div id="feedBackFormInputs">
				<form id="feedBackForm" action="" method="POST">
				
					<?php if (feedback_is_mood_enabled()) {
						$mood_values = feedback_mood_values();
						if (sizeof($mood_values) > 1) {
							?>
							<div id="feedback_mood">
								<b><?php echo elgg_echo('feedback:list:mood'); ?>&nbsp;: &nbsp</b> 
								<?php
								foreach ($mood_values as $mood) {
									echo '<label class="' . $mood .'"><input type="radio" name="mood" value="' . $mood .'"> ' . elgg_echo("feedback:mood:$mood") . '</label>';
								}
								?>
							</div>
							<?php
						} else {
							// We only have one value (not indexed)
							$unique_value = implode('', $mood_values);
							echo elgg_view('input/hidden', ['name' => 'mood', 'value' => $unique_value]);
						}
					}
					
					// About / topic
					if (feedback_is_about_enabled()) {
						$about_values = feedback_about_values();
						if (sizeof($about_values) > 1) {
							?>
							<div id="feedback_about">
								<b><?php echo elgg_echo('feedback:list:about'); ?>&nbsp;: &nbsp</b> 
								<?php
								foreach ($about_values as $about) {
									echo '<label class="' . $about .'"><input type="radio" name="about" value="' . $about .'"> ' . elgg_echo("feedback:about:$about") . '</label>';
								}
								?>
							</div>
							<?php
						} else {
							// We only have one value (not indexed)
							$unique_value = implode('', $about_values);
							echo elgg_view('input/hidden', ['name' => 'about', 'value' => $unique_value]);
						}
					}
					
					
					// Access select only if member view is allowed and logged_in
					// (otherwise use private access_id)
					if ($memberview && elgg_is_logged_in()) {
						$default_access = 1;
						$access_opt["0"] = elgg_echo('feedback:access:admin');
						$access_opt["1"] = elgg_echo('feedback:access:sitemembers');
						$page_owner = elgg_get_page_owner_entity();
						if ($page_owner instanceof ElggGroup) {
							//$group_id = $page_owner->group_acl;
							$group_id = $page_owner->getOwnedAccessCollection('group_acl')->id;
							$access_opt["$group_id"] = elgg_echo('feedback:access:group');
							$default_access = $group_id;
						}
						?>
						<div id="feedbackAccess">
							<label><?php echo elgg_echo('access') . ' ' . elgg_view('input/access', ['name' => 'feedback_access_id', 'value' => $default_access, 'options_values' => $access_opt]); ?></label>
						</div>
					<?php } else { ?>
						<input type="hidden" name="feedback_access_id" value="0" />
					<?php } ?>
					<div id="feedbackId">
						<input type="text" name="feedback_id" value="<?php echo $user_id; ?>" id="feedback_id" size="30" placeholder="<?php echo elgg_echo('feedback:default:id'); ?>" class="feedbackText" />
					</div>
				
					<div id="feedBackText">
						<textarea name="feedback_description" cols="34" rows="10" id="feedback_description" placeholder="<?php echo elgg_echo('feedback:default:description'); ?>" class="feedbackTextbox mceNoEditor" required></textarea>
					</div>
				
					<?php
					// Captcha : only when logged out
					if (!elgg_is_logged_in()) {
						// if captcha functions are loaded, then use captcha
						if (function_exists("captcha_generate_token")) {
							echo elgg_view('input/captcha');
						}
					}
					?>
				
					<div id="feedBackSend">
						<input id="feedback_send_btn" value="<?php echo elgg_echo('send'); ?>" type="button" class="elgg-button elgg-button-submit" />
						&nbsp;
						<input id="feedback_cancel_btn" value="<?php echo elgg_echo('cancel'); ?>" type="button" class="elgg-button elgg-button-cancel" />
					</div>
				
					<?php if ($memberview || elgg_is_admin_logged_in()) {
						// Additional message if tool is for members (= link to feedback page)
						echo '<p id="feedbackDisplay"><a href="' . elgg_get_site_url() . 'feedback" target="_blank">' . elgg_echo('feedback:linktofeedbacks') . '</a></p>';
					} ?>
				
				</form>
			</div>
		
			<div id="feedBackFormStatus"></div>
		
			<div id="feedbackClose">
				<input id="feedback_close_btn" name="<?php echo elgg_echo('close'); ?>" value="Close" type="button" class="elgg-button elgg-button-cancel" />
			</div>
		</div>
	</div>

	<div class="clearfloat"></div>

</div>

<script type="text/javascript">
require(['jquery'], function($){
	// Handlers
	// Generic class, to be used for new buttons
	$('.feedback-toggle').click(function() { FeedBack_Toggle(); });
	// Handlers for older versions
	$('#feedBackTogglerLink').click(function() { FeedBack_Toggle(); this.blur(); });
	$('#feedback_cancel_btn').click(function() { FeedBack_Toggle(); });
	$('#feedback_close_btn').click(function() { FeedBack_Toggle(); });
	
	
	$('#feedBackForm').submit(function() { FeedBack_Send(); return false; });
	$('#feedback_send_btn').click(function() { FeedBack_Send(); return false; });
	
	
	
	<?php
	// if user is logged in then disable the feedback ID
	if (elgg_is_logged_in()) {
		echo "$('#feedback_id').attr ('disabled', 'disabled');";
	}
	?>
	$('#feedbackClose').hide();
	var toggle_state = 0;
	
	// Toggle function
	function FeedBack_Toggle() {
		if (toggle_state) {
			toggle_state = 0;
			$("#feedBackTogglerLink .feedback-toggle").toggle();
			$('#feedBackFormInputs').show();
			$("#feedBackFormStatus").html("");
			$('#feedbackClose').hide();
			document.forms["feedBackForm"].reset();
		} else {
			toggle_state = 1;
			$("#feedBackTogglerLink .feedback-toggle").toggle();
		}

		$("#feedBackContentWrapper").toggle();
	}
	
	// Check and send feedback
	function FeedBack_Send() {
		var page = encodeURIComponent(location.href);
		var mood = $('input[name=mood]:checked').val();
		var about = $('input[name=about]:checked').val();
		var access_id = $('*[name=feedback_access_id]').val();
		var id = $("#feedback_id").val().replace(/^\s+|\s+$/g,"");
		var description = encodeURIComponent( $("#feedback_description").val().replace(/^\s+|\s+$/g,"") );

		// only use captcha when logged out
		<?php if (!elgg_is_logged_in() && function_exists("captcha_generate_token")) { ?>
			var captcha_token = $('input[name=captcha_token]').val();
			var captcha_input = $('input[name=captcha_input]').val();
			if ( captcha_token != '' && captcha_input == '' ) {
				alert ( "<?php echo elgg_echo('feedback:captcha:blank'); ?>" );
				return;
			}
		<?php } ?>

		// if no address provided... we don't care about email 'cause we got the IP..
		if ( id == '' || id == "<?php echo elgg_echo('feedback:default:id'); ?>" ) {
			alert ( "<?php echo elgg_echo('feedback:id:blank'); ?>" );
			return;
		}
		<?php if (!elgg_is_logged_in()) { ?>
			id = id + " (<?php echo $user_ip ?>)";
		<?php } ?>

		// if no text provided...
		if ( description == '' || description == encodeURIComponent("<?php echo elgg_echo('feedback:default:description'); ?>") ) {
			alert ( "<?php echo elgg_echo('feedback:default:description:err'); ?>" );
			return;
		}

		// show progress indicator
		$('#feedBackFormStatus').html('<?php echo $progress_img; ?>');

		// disable the send button while we are submitting
		$('#feedBackFormInputs').hide();

		// fire the AJAX query
		jQuery.ajax( {
			url: "<?php echo $feedback_url?>",
			type: "POST",
			// only use captcha when logged out
			<?php if (!elgg_is_logged_in() && function_exists("captcha_generate_token")) { ?>
				data: "captcha_input="+captcha_input+"&captcha_token="+captcha_token+"&page="+page+"&mood="+mood+"&about="+about+"&id="+id+"&description="+description+"&access_id="+access_id,
			<?php } else { ?>
				data: "page="+page+"&mood="+mood+"&about="+about+"&id="+id+"&description="+description+"&access_id="+access_id,
			<?php } ?>
			cache: false,
			dataType: "html",
			error: function() {
				//$('#feedBackFormInputs').show();
				$("#feedBackFormStatus").html("<div id='feedbackError'><?php echo elgg_echo('feedback:submit_err'); ?></div>");
				$('#feedbackClose').show();
				//document.forms["feedBackForm"].reset();
			},
			success: function(data) {
				//$('#feedBackFormInputs').show(); // show form
				$("#feedBackFormStatus").html(data);
				$('#feedbackClose').show();
				document.forms["feedBackForm"].reset();
			}
		});
	}
	
});
</script>

