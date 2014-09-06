<?php
global $CONFIG;

// Doc : see https://togetherjs.com/docs/#extending-togetherjs
if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	$username = $own->name;
	$usericon = $own->getIconURL('small');
}

?>
<script>
var TogetherJSConfig_siteName = "<?php echo $CONFIG->site->name ?>";
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
<script src="https://togetherjs.com/togetherjs.js"></script>
<script>
// Update name and profile picture
TogetherJS.refreshUserData();

TogetherJS.addTracker(tinyMCE, true);

$(function () {
  tinymce.init({ 
    selector: '.elgg-input-longtext',
  });
});

/*
  // check for a tinymce instance
  if (tinymce !== undefined) {
    tinymce.on("AddEditor", function (event) {
      var editor = event.editor;
      editor.on("init", function (event) {
        //add EventListener here
      });
    });
  }
});
*/
</script>

