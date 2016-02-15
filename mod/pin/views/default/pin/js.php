<?php

$acturl = elgg_get_site_url() . 'mod/pin/actions/';
$ts = time();
$token = generate_action_token(time());
$tokens = '&__elgg_ts='.$ts.'&__elgg_token='.$token;


//<script type="text/javascript">
?>

function pin_entity(tool, guid){
	if ($("#" + tool + "_" + guid).hasClass('icon-un' + tool)) { action = "un" + tool; } else { action = tool; }
	
	jQuery.ajax({
		url: "<?php echo $acturl; ?>" + tool + ".php",
		data: "action=" + action + "&guid=" + guid + "<?php echo $tokens; ?>&userguid=<?php echo elgg_get_logged_in_user_guid(); ?>&callback=true",
		error: function() {
			alert("Une erreur s'est produite lors du changement de l'option");
		},
		success: function(data, action){
			$("#" + tool + "_" + guid).toggleClass("icon-" + tool);
			$("#" + tool + "_" + guid).toggleClass("icon-un" + tool);
			if (tool == "highlight") {
				$("#" + "highlight_" + guid).toggleClass("icon-highlighted");
			}
			//alert(data);
		}
	});
	
	// Change appropriate attribute (for tooltip)
	if (tool == "highlight") {
		if (action == 'unhighlight') {
			$("#highlight_" + guid).attr('title', "<?php echo elgg_echo('pin:highlight:true'); ?>" );
		} else {
			$("#highlight_" + guid).attr('title', "<?php echo elgg_echo('pin:highlight:false'); ?>" );
		}
	}
}
<?php
//</script>

