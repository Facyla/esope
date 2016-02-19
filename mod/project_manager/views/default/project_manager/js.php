<?php global $CONFIG; ?>
void(0);

// MAJ Consultants
// A chaque event de changement de valeur du champ JS (par ex. pas slide mais change pour le slider)
function project_manager_update_consultants(user_guid, field, value) {
  $('#loading_overlay').show();
  $.post(
    elgg.security.addToken('<?php echo $CONFIG->url; ?>action/project_manager/edit_consultants'), 
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
        alert(elgg.echo("<?php echo elgg_echo('project_manager:ajax:error:reload'); ?>"));
      }
      $('#loading_overlay').hide();
    }, 
    "json"
  );
}



// A chaque event de changement de valeur du champ JS (par ex. pas slide mais change pour le slider)
function project_manager_save_project_production(form_id) {
  $('#loading_overlay').show();
  // Remplace les , par des . et enlève les espaces (pour avoir des données valides pour les calculs)
  $('input').each(function(){
    $(this).val( $(this).val().replace(/\,/g, '.') );
    $(this).val( $(this).val().replace(/\ /g, '') );
  });
  
  $.post(
    elgg.security.addToken('<?php echo $CONFIG->url; ?>action/project_manager/edit_project_production'), 
    $("#" + form_id).serialize(),
    function(data) {
      if (data.result == 'true') {
        //alert('OK');
        //project_manager_update_project_production(project_guid, data);
      } else {
        alert(elgg.echo("<?php echo elgg_echo('project_manager:ajax:error:retry'); ?>"));
      }
      $('#loading_overlay').hide();
    }
    , "json"
  );
}



// A chaque event de changement de valeur du champ JS (par ex. pas slide mais change pour le slider)
function project_manager_save_expenses(form_id) {
  $('#loading_overlay').show();
  // Remplace les , par des . et enlève les espaces (pour avoir des données valides pour les calculs)
  $('input').each(function(){
    $(this).val( $(this).val().replace(/\,/g, '.') );
    $(this).val( $(this).val().replace(/\ /g, '') );
  });
  
  $.post(
    elgg.security.addToken('<?php echo $CONFIG->url; ?>action/project_manager/edit_project_expenses'), 
    $("#" + form_id).serialize(),
    function(data) {
      if (data.result == 'true') {
        //alert('OK');
      } else {
        alert(elgg.echo("<?php echo elgg_echo('project_manager:ajax:error:retry'); ?>"));
      }
      $('#loading_overlay').hide();
    }
    , "json"
  );
}



/* Time tracker JS */

function time_tracker_disable_line(line, id) {
  $('input.time_tracker_day' + line).each(function(){
    // Pas de modif du champ congé lui-même
    if (!$(this).hasClass('time_tracker_C')) {
      $(this).val("");
      $(this).attr('disabled', 'disabled');
      //$(this).css('background-color', '#CCCCCC');
      $(this).addClass('time_tracker_conge');
    }
  });
}

function time_tracker_enable_line(line) {
  $('input.time_tracker_day' + line).each(function(){
    // Pas de modif du champ congé lui-même
    if (!$(this).hasClass('time_tracker_C')) {
      $(this).removeAttr('disabled');
      //$(this).css('background-color', '#FFFF99');
      $(this).removeClass('time_tracker_conge');
    }
  });
}

function time_tracker_update_line_total(line, alert) {
  var sum = 0;
  var alert = alert || true;
  $('input.time_tracker_day' + line).each(function(){
    // Remplace les , par des . (pour les calculs)
    //$(this).val( $(this).val().replace(/\./g, ',') );
    $(this).val( $(this).val().replace(/\,/g, '.') );
    if ($(this).val() != 'null') {
      if (parseFloat($(this).val()) > 0) { sum = parseFloat( parseFloat(sum) + parseFloat(eval($(this).val())) ).toFixed(2); }
    }
  });
  $("#time_tracker_line_total_" + line).val(sum);
  if (sum > 1) {
    if (alert == 'true') alert("Ligne " + line + " le total des temps est de " + sum + " jours. La somme des saisies d'un jour doit être égale à 1. En cas de charge supplémentaire, merci de la reporter sur un autre jour.");
    $("#time_tracker_line_total_" + line).css('background-color', '#FFCCCC');
  } else if (sum == 1) {
    $("#time_tracker_line_total_" + line).css('background-color', '#CCFFCC');
  } else {
    $("#time_tracker_line_total_" + line).css('background-color', '#CCCCFF');
  }
  time_tracker_update_global_total(false);
}

function time_tracker_update_global_total(alert) {
  var sum = 0;
  var alert = alert || false;
  /* Utile pour compter les jours hors-production
  $('input.time_tracker_noday').each(function(){
    if (($(this).val() != 'null') && (parseFloat($(this).val()) > 0)) { sum += parseFloat($(this).val()); }
  });
  */
  // Comptage des totaux journaliers
  $('input.time_tracker_line_total').each(function(){
    if (($(this).val() != 'null') && (parseFloat($(this).val()) > 0)) {sum += parseFloat($(this).val()); }
  });
  $("#time_tracker_global_total").val(sum);
}

function time_tracker_update_all_lines_total(alert) {
  var max = 31;
  var alert = alert || true;
  for (var line = 1 ; line <= 31; line++) {
    time_tracker_update_line_total(line, alert);
  }
}

function time_tracker_toggle_conge(id, form_id, line) {
  var state = $("#"+id).val();
  if ((state == '') || (state == 'undefined')) {
    //if (confirm('Attention, si ce jour est noté comme congé, les saisies de cette ligne seront effacées. Confirmer ?')) {
    //}
    $("#"+id).val('1');
    time_tracker_disable_line(line, id);
    time_tracker_update_line_total(line, true);
  } else if (state == '1') {
    $("#"+id).val('');
    time_tracker_enable_line(line);
    time_tracker_update_line_total(line, true);
  }
  save_time_tracker(form_id);
}

function time_tracker_validation(state, year, month, user_guid) {
  if (state == 'validate') {
    if (confirm('<?php echo elgg_echo('time_tracker:validate:warning'); ?>')) {
      var new_state = "1";
      // Modifie les données
      $('input.time_tracker_validation').each(function(){ $(this).val(new_state); });
      // Valide les saisies du mois
      validate_time_trackers(year, month, user_guid, new_state);
      // Modifie l'affichage
      $('.time_tracker_validation_status span.validated').each(function(){ $(this).show(); });
      $('.time_tracker_validation_status span.notvalidated').each(function(){ $(this).hide(); });
      $('#time_tracker_validation_global').hide();
      $('#time_tracker_validation_global_cancel').show();
    }
  } else if (state == 'cancel') {
    // Déjà validé : Admin seulement pour annuler la validation
    if (confirm('<?php echo elgg_echo('time_tracker:unvalidate:warning'); ?>')) {
      var new_state = "";
      // Modifie les données
      $('input.time_tracker_validation').each(function(){ $(this).val(new_state); });
      // Valide les saisies du mois
      validate_time_trackers(year, month, user_guid, new_state);
      $('.time_tracker_validation_status span.validated').each(function(){ $(this).hide(); });
      $('.time_tracker_validation_status span.notvalidated').each(function(){ $(this).show(); });
      $('#time_tracker_validation_global').show();
      $('#time_tracker_validation_global_cancel').hide();
    }
  }
  
}

// Valide toutes les saisies d'un mois donné pour un user donné
function validate_time_trackers(year, month, user, state) {
  $('#loading_overlay').show();
  $.post(
    elgg.security.addToken('<?php echo $CONFIG->url; ?>action/time_tracker/validate'), 
    {
      user: user,
      year: year,
      month: month,
      validation: state,
    }, 
    function(data) {
      if (data == 'true') {
        // on recharge la page pour actualiser les données et terminer/rouvrir les saisies
        location.assign(location.href);
      } else {
        alert(elgg.echo("Erreur : le rapport d'activité pour ce mois n'a pas pu être validé, veuillez réessayer dans un instant."));
      }
      $('#loading_overlay').hide();
    }
    //, "json"
  );
}


// A chaque event de changement de valeur du champ JS (par ex. pas slide mais change pour le slider)
function save_time_tracker(form_id, line) {
  $('#loading_overlay').show();
  $.post(
    elgg.security.addToken('<?php echo $CONFIG->url; ?>action/time_tracker/edit'), 
    $("#" + form_id).serialize(),
    function(data) {
      if (data == 'true') {
        //alert('OK');
        time_tracker_update_line_total(line, true);
      } else {
        alert(elgg.echo("<?php echo elgg_echo('project_manager:ajax:error:retry'); ?>"));
      }
      $('#loading_overlay').hide();
    }
    //, "json"
  );
}


// A chaque event de changement de valeur du champ JS (par ex. pas slide mais change pour le slider)
function update_time_tracker(user, year, month, unique_id) {
  $('#loading_overlay').show();
  $.post(
    elgg.security.addToken('<?php echo $CONFIG->url; ?>action/time_tracker/edit'), 
    {
      user: user,
      year: year,
      month: month,
      unique_id: unique_id,
      project: $("#project_" + unique_id).val(),
      days: $("#project_days_" + unique_id + "_val").val(),
      hours: $("#project_hours_" + unique_id + "_val").val(),
      cost: $("#project_cost_" + unique_id).val(),
      comment: $("#project_comment_" + unique_id).val(),
      validation: $("#project_validation_" + unique_id).val(),
    }, 
    function(data) {
      if (data.result == 'true') {
        $("#project_days_" + unique_id).slider('value', data.days);
        $("#project_hours_" + unique_id).slider('value', data.hours);
        $("#project_cost_" + unique_id).val(data.cost);
        $("#project_cost_" + unique_id).val(data.cost);
        $("#project_comment_" + unique_id).val(data.comment);
        $("#project_validation_" + unique_id).val(data.validation);
      } else {
        alert(elgg.echo("<?php echo elgg_echo('project_manager:ajax:error:retry'); ?>"));
      }
      $('#loading_overlay').hide();
    }, 
    "json"
  );
}

// Récupération des infos d'un formulaire
// Suite à chaque event de changement de valeur du champ JS (par ex. pas slide mais change pour le slider)
function get_time_tracker(user, year, month, project, unique_id) {
  $('#loading_overlay').show();
  $.post(
    elgg.security.addToken('<?php echo $CONFIG->url; ?>action/time_tracker/edit'), 
    {
      user: user,
      year: year,
      month: month,
      unique_id: unique_id,
      project: project,
    }, 
    function(data) {
      if (data.result == 'true') {
        $("#project_days_" + unique_id).slider('value', data.days);
        $("#project_hours_" + unique_id).slider('value', data.hours);
        $("#project_cost_" + unique_id).val(data.cost);
        $("#project_comment_" + unique_id).val(data.comment);
        $("#project_validation_" + unique_id).val(data.validation);
      } else {
        alert(elgg.echo("<?php echo elgg_echo('project_manager:ajax:error:reload'); ?>"));
      }
      $('#loading_overlay').hide();
    }, 
    "json"
  );
}

// At startup : calculate time sums per line
$(document).ready(function(){
  time_tracker_update_all_lines_total(false);
});


