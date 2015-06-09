<?php
?>
//<script>

elgg.provide("elgg.dossierdepreuve");

// MAJ Membres
// A chaque event de changement de valeur du champ JS
function dossierdepreuve_update_members(user_guid, field, value) {
  $('#loading_overlay').show();
  $.post(
    elgg.security.addToken('<?php echo $CONFIG->url; ?>action/dossierdepreuve/edit_members'), 
    {
      user_guid: user_guid,
      field: field,
      field_value: value,
    }, 
    function(data) {
      if (data.result == 'true') {
        $("#loading_fader").show();
        $("#loading_fader").fadeOut(3000, function() {});
      } else {
        alert(elgg.echo("<?php echo elgg_echo('dossierdepreuve:ajax:error:reload'); ?>"));
      }
      $('#loading_overlay').hide();
    }, 
    "json"
  );
}


// Fonctions à initialiser
elgg.profile_manager.init = function(){
	
	// Domaine switcher
	$("#autopositionnement_quest_tabs a").click(function(){
		var id = $(this).attr("href").replace("#", "");
		$("#autopositionnement_quest_tabs div").removeClass("elgg-state-selected");
		$(this).parent().addClass("elgg-state-selected");
		$('#autopositionnement_quest_tab_content_wrapper>div').hide();
		$('#autopositionnement_quest_tab_content_' + id).show();
	});
	
	// Domaine switcher : inner switcher
	$("#autopositionnement_quest_tab_content_wrapper a").click(function(){
		var id = $(this).attr("href").replace("#", "");
		$("#autopositionnement_quest_tabs div").removeClass("elgg-state-selected");
		$("#autopositionnement_quest_tabs div#" + id).addClass("elgg-state-selected");
		$('#autopositionnement_quest_tab_content_wrapper>div').hide();
		$('#autopositionnement_quest_tab_content_' + id).show();
	});
	
}


// Register JS init hook
elgg.register_hook_handler("init", "system", elgg.profile_manager.init);

