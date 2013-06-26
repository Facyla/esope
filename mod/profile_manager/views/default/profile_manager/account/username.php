<?php

$enable_username_change = elgg_get_plugin_setting("enable_username_change", "profile_manager");
if($enable_username_change == "yes" || ($enable_username_change == "admin" && elgg_is_admin_logged_in())){
	
	$user = elgg_get_page_owner_entity();
	
	$body = elgg_view("input/button", array("href" => "#profile_manager_username", "rel" => "toggle", "value" => elgg_echo("profile_manager:account:username:button"), "class" => "elgg-button-action profile-manager-account-change-username"));
	$body .= "<div id='profile_manager_username' class='hidden'>";
	$body .= elgg_view_icon("profile-manager-loading") . elgg_view_icon("profile-manager-valid") . elgg_view_icon("profile-manager-invalid");
	$body .= elgg_view("input/text", array("name" => "username", "value" => $user->username, "rel" => $user->username));
	$body .= "<div class='elgg-subtext'>" . elgg_echo("profile_manager:account:username:info") . "</div>";
	$body .= "</div>";
	
	echo elgg_view_module("info" , elgg_echo("username"), $body);
	
	?>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#profile_manager_username .elgg-input-text").live("keyup", function(event){
			if(event.which != 13){
				var username = $(this).val();
				$container = $(this).parent();
				$container.find(".elgg-icon").hide();
				
				if(username !== $(this).attr("rel")){
					$container.find(".elgg-icon-profile-manager-loading").show();
					
					$.getJSON(elgg.get_site_url() + "profile_manager/validate_username", { "username": username }, function(data){
						if($("#profile_manager_username .elgg-input-text").val() == username){
							if(data.valid){
								$container.find(".elgg-icon-profile-manager-valid").show();
							} else {
								$container.find(".elgg-icon-profile-manager-invalid").show();
							}
							
							$("#profile_manager_username .elgg-icon-profile-manager-loading").hide();
						}
					});
				}
			}
		});
	});
	</script>
<?php 
}