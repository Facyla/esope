<?php
global $CONFIG;

// @TODO : don't load it always : use register and load in calling pages instead...

// Doc : see https://togetherjs.com/docs/#extending-togetherjs
if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	$username = $own->name;
	$usericon = $own->getIconURL('small');

	?>
	<script>
	// Use own server
	//var TogetherJSConfig_hubBase = "http://127.0.0.1:10005";
	
	var TogetherJSConfig_siteName = "<?php echo $CONFIG->site->name; ?>";
	var TogetherJSConfig_toolName = "TogetherJS";
	var TogetherJSConfig_findRoom = "Global"
	var TogetherJSConfig_inviteFromRoom = true;
	var TogetherJSConfig_dontShowClicks = true;
	var TogetherJSConfig_suppressInvite = true;
	var TogetherJSConfig_suppressJoinConfirmation = true;
	var TogetherJSConfig_disableWebRTC = true;
	var TogetherJSConfig_getUserName = function () { return '<?php echo $username; ?>'; };
	var TogetherJSConfig_getUserAvatar = function () { return '<?php echo $usericon; ?>'; };
	//var TogetherJSConfig_tinymce = true;
	</script>
	<?php
}


