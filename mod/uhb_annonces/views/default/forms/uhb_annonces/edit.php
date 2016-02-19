<?php
$full = elgg_extract('full_view', $vars, FALSE);
$offer = elgg_extract('entity', $vars, FALSE);

$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }


$content = '';

$required_mark = '<span class="required">*</span>';

// Set form values and defaults
if (elgg_instanceof($offer, 'object', 'uhb_offer')) {
	$guid = $offer->guid;
	$owner_guid = $offer->owner_guid; // // Can be edited by admins only (affect offer to other member)
	
	$typeoffer = $offer->typeoffer;
	$typework = $offer->typework;
	
	$structurename = $offer->structurename;
	$structureaddress = $offer->structureaddress;
	$structurepostalcode = $offer->structurepostalcode;
	$structurecity = $offer->structurecity;
	$structurewebsite = $offer->structurewebsite;
	$structuresiret = $offer->structuresiret;
	$structurenaf2008 = $offer->structurenaf2008;
	$structurelegalstatus = $offer->structurelegalstatus;
	$structureworkforce = $offer->structureworkforce;
	$structuredetails = $offer->structuredetails;
	
	$offerposition = $offer->offerposition;
	$offerreference = $offer->offerreference;
	$offertask = $offer->offertask;
	$offerpay = $offer->offerpay;
	
	$workstart = $offer->workstart;
	$worklength = $offer->worklength;
	$worktime = $offer->worktime;
	$worktrip = $offer->worktrip;
	$workcomment = $offer->workcomment;
	
	$profileformation = $offer->profileformation;
	$profilelevel = $offer->profilelevel;
	$profilecomment = $offer->profilecomment;
	
	$managergender = $offer->managergender;
	$managername = $offer->managername;
	$manageremail = $offer->manageremail;
	$managerphone = $offer->managerphone;
	$managervalidated = $offer->managervalidated; // admin only
	
	// admin only
	//$followcreation = $offer->followcreation;
	$followcreation = $offer->time_created;
	$followupdated = $offer->time_updated;
	$followvalidation = $offer->followvalidation;
	$followend = $offer->followend;
	if ($followend < 1) $followend = null; // Avoid weird values when set to 0
	$followstate = $offer->followstate;
	$followinterested = $offer->followinterested;
	$followcandidates = $offer->followcandidates;
	$followreport = $offer->followreport;
	$followcomments = $offer->followcomments;
	
} else {
	// Set defaults
	$workstart = time();
	$managervalidated = 'no';
	$worklength = 1;
	$followstate = 'new';
	$followend = time() + 30*24*3600;
	$followinterested = 0;
	$followcandidates = 0;
	$followreport = 0;
	
	$preload_data = false;
	$loadfromguid = get_input('loadfrom', false);
	if ($loadfromguid) {
		$loadfrom = get_entity($loadfromguid);
	} else {
		if (elgg_is_logged_in()) {
			// Auto-load from latest offer
			$params = array('types' => 'object', 'subtypes' => 'uhb_offer', 'limit' => 1, 'owner_guid' => elgg_get_logged_in_user_guid());
			$previous = elgg_get_entities($params);
			if ($previous) { $loadfrom = $previous[0]; }
		}
	}
	if (elgg_instanceof($loadfrom, 'object', 'uhb_offer') && (($loadfrom->owner_guid == elgg_get_logged_in_user_guid()) || ($loadfrom->editkey == get_input('editkey')))) {
			$preload_data = true;
	}
	
	// Get saved values in case saving has failed...
	if (elgg_is_sticky_form('uhb_offer')) {
		$fields = uhb_annonces_get_fields('edit');
		extract(elgg_get_sticky_values('uhb_offer'));
		elgg_clear_sticky_form('uhb_offer');
	} else if ($preload_data) {
		// OR preload data (but prefer sticky form if available)
		// Preload structure + manager data
		$preload_fields = uhb_annonces_get_fields('preload');
		foreach ($preload_fields as $field) {
			$$field = $loadfrom->$field;
		}
		system_message(elgg_echo('uhb_annonces:preload:message'));
	}
}
$manageremail_confirm = get_input('manageremail_confirm');
// Pre-remplissage si déjà validé
if (empty($manageremail_confirm) && ($managervalidated == 'yes')) {
	$manageremail_confirm = $manageremail;
}


// Form validation (provides details that tab may hide..)
elgg_load_js('validate-js');
$required_fields = array('typeoffer', 
		'structurename', 'structureaddress', 'structurepostalcode', 'structurecity', 'structurelegalstatus', 
		'offerposition', 'offertask', 
		/* 'workstart', */ // Causes problems, as date field use a hidden input...
		'worklength', 'worktime', 'worktrip', 
		'managergender', 'managername', 
		);
$validators = array();
foreach($required_fields as $field) {
	$validators[] = "\n{name: '$field', display: '" . addslashes(elgg_echo("uhb_annonces:object:$field")) . "', rules: 'required'}";
}
// Handle some special cases : ie. emails
$validators[] = "\n{name: 'manageremail', display: '" . addslashes(elgg_echo("uhb_annonces:object:manageremail:confirm")) . "', param: '" . addslashes(elgg_echo("uhb_annonces:object:manageremail")) . "', rules: 'required|valid_email'}";
$validators[] = "\n{name: 'manageremail_confirm', display: '" . addslashes(elgg_echo("uhb_annonces:object:manageremail:confirm")) . "', rules: 'required|matches[manageremail]'}";


$content .= "<script>
var validator = new FormValidator(
	'elgg-form-uhb-annonces-edit', 
	[" . implode(', ', $validators) . "], 
	function(errors, evt) {
		if (errors.length > 0) {
			var validator_err = '<p>" . addslashes(elgg_echo('uhb_annonces:error:missingrequired')) . "</p>';
			for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
				validator_err = validator_err + errors[i].message + '<br />';
			}
			elgg.register_error(validator_err);
			if (evt && evt.preventDefault) { evt.preventDefault(); } 
			else if (event) { evt.returnValue = false; }
		}
	}
);
</script>";



// Set dropdown options_values
$yes_no_opt = array('yes' => elgg_echo('uhb_annonces:option:yes'), 'no' => elgg_echo('uhb_annonces:option:no'));
// Author
$typeoffer_opt = uhb_annonces_build_options('typeoffer', false);
$typework_opt = uhb_annonces_build_options('typework', true);
$structurelegalstatus_opt = uhb_annonces_build_options('structurelegalstatus', true);
$structureworkforce_opt = uhb_annonces_build_options('structureworkforce', true);
$worktime_opt = uhb_annonces_build_options('worktime', false);
$profilelevel_opt = uhb_annonces_build_options('profilelevel', true);
// Checkboxes : label => value
$profileformation_opt = uhb_annonces_build_options('profileformation', false);
$profileformation_opt = array_flip($profileformation_opt);
// Radio : label => value
$worktrip_opt = array_flip($yes_no_opt);
$managergender_opt = uhb_annonces_build_options('managergender', false);
$managergender_opt = array_flip($managergender_opt);

// Admin only
$managervalidated_opt = $yes_no_opt;
$followstate_opt = uhb_annonces_build_options('followstate', false);


// Toggle disabled field control
$content .= '<script>
function uhb_annonces_toggle_typework() {
	var val = $("select[name=\'typeoffer\']").val();
	if (val == "emploi") {
		$("select[name=typework]").prop(\'disabled\', false);
		$(".uhb_annonces-typework").removeClass(\'uhb_annonces-disabled\');
	} else {
		$("select[name=typework] option[value=\'\']").prop(\'selected\', true);
		$("select[name=typework]").prop(\'disabled\', true);
		$(".uhb_annonces-typework").addClass(\'uhb_annonces-disabled\');
		uhb_annonces_toggle_worklength("yes");
	}
	return true;
}
function uhb_annonces_toggle_worklength(state) {
	if ((state != "no") && (state != "yes")) {
		var val = $("select[name=\'typework\']").val();
		if (val == "cdi") { state = "no"; } else { state = "yes"; }
	}
	if (state == "yes") {
		$("select[name=worklength]").prop(\'disabled\', false);
		$(".uhb_annonces-worklength").removeClass(\'uhb_annonces-disabled\');
	} else {
		$("select[name=worklength] option[value=\'\']").prop(\'selected\', true);
		$("select[name=worklength]").prop(\'disabled\', true);
		$(".uhb_annonces-worklength").addClass(\'uhb_annonces-disabled\');
	}
	return true;
}
</script>';



// Hidden fields (required but non-editable)
if (!empty($guid)) { $content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid)); }
$content .= uhb_annonces_add_keys(true);


// STEP 0 (admin)
if ($admin) {
	$content .= '<div class="uhb_annonces-form-step uhb_annonces-form-step0">';
	
	// @TODO : allow admins to affect offer to a specific user ?
	// Can be done but not required by the plugin behaviour...
	if (!empty($owner_guid)) { $content .= elgg_view('input/hidden', array('name' => 'owner_guid', 'value' => $owner_guid)); }
	
	// Some of these are not editable (automatically set values)
	$content .= '<div style="width:48%; float:left;">';
		$content .= '<p><label>' . elgg_echo('uhb_annonces:object:followstate') . elgg_view('input/dropdown', array('name' => 'followstate', 'value' => $followstate, 'options_values' => $followstate_opt)) . '</label></p>';
		// Not editable ? (automatically set values)
		$content .= '<p>' . elgg_echo('uhb_annonces:object:followinterested') . '&nbsp;: ' . (int) $followinterested . '<br />';
		$content .= elgg_echo('uhb_annonces:object:followcandidates') . '&nbsp;: ' . (int) $followcandidates . '<br />';
		$content .= elgg_echo('uhb_annonces:object:followreport') . '&nbsp;: ' . (int) $followreport . '</p>';
	$content .= '</div>';
	$content .= '<div style="width:48%; float:right;">';
		$content .= '<p><label>' . elgg_echo('uhb_annonces:object:followend') . elgg_view('input/date', array('name' => 'followend', 'value' => $followend, 'timestamp' => true)) . '</label></p>';
		$content .= '<p>' . elgg_echo('uhb_annonces:object:followcreation') . '&nbsp;: ';
		if (empty($followcreation)) { $content .= elgg_echo('uhb_annonces:undefined'); } else { $content .= date('d/m/Y', $followcreation); }
		$content .= '<br />';
		$content .= elgg_echo('uhb_annonces:object:followvalidation') . '&nbsp;: ';
		if (empty($followvalidation)) { $content .= elgg_echo('uhb_annonces:undefined'); } else { $content .= date('d/m/Y', $followvalidation); }
		$content .= '<br />';
		$content .= elgg_echo('uhb_annonces:object:followupdated') . '&nbsp;: ';
		if (empty($followupdated)) { $content .= elgg_echo('uhb_annonces:undefined'); } else { $content .= date('d/m/Y', $followupdated); }
		$content .= '</p>';
	$content .= '</div>';
	$content .= '<div class="clearfloat"></div><br />';
	$content .= '<label>' . elgg_echo('uhb_annonces:object:followcomments') . '' . elgg_view('input/plaintext', array('name' => 'followcomments', 'value' => $followcomments)) . '</label>';
	$content .= '</div>';
}



// STEP 1
if ($admin) $content .= '<div class="uhb_annonces-form-step uhb_annonces-form-step1" style="display:none;">';
else $content .= '<div class="uhb_annonces-form-step uhb_annonces-form-step1">';
$content .= '<h3>' . elgg_echo('uhb_annonces:form:group:structure') . '</h3>';

$content .= '<p><label><span>' . elgg_echo('uhb_annonces:object:structurename') . $required_mark . '</span>' . elgg_view('input/text', array('name' => 'structurename', 'value' => $structurename, 'required' => 'required')) . '</label>';
$content .= ' &nbsp; &nbsp; ';
$content .= '<label>' . elgg_echo('uhb_annonces:object:structurelegalstatus') . $required_mark . elgg_view('input/dropdown', array('name' => 'structurelegalstatus', 'value' => $structurelegalstatus, 'options_values' => $structurelegalstatus_opt, 'required' => 'required')) . '</label></p>';
$content .= '<p>';
$content .= '<label>' . elgg_echo('uhb_annonces:object:structureaddress') . $required_mark . elgg_view('input/plaintext', array('name' => 'structureaddress', 'value' => $structureaddress, 'required' => 'required', 'style' => 'height:6ex;')) . '</label>';
$content .= '</p>';
$content .= '<p>';
$content .= '<label>' . elgg_echo('uhb_annonces:object:structurepostalcode') . $required_mark . elgg_view('input/text', array('name' => 'structurepostalcode', 'value' => $structurepostalcode, 'required' => 'required')) . '</label>';
$content .= ' &nbsp; &nbsp; ';
$content .= '<label>' . elgg_echo('uhb_annonces:object:structurecity') . $required_mark . elgg_view('input/text', array('name' => 'structurecity', 'value' => $structurecity, 'required' => 'required')) . '</label>';
$content .= ' &nbsp; &nbsp; ';
$content .= '<label>' . elgg_echo('uhb_annonces:object:structurewebsite') . elgg_view('input/text', array('name' => 'structurewebsite', 'value' => $structurewebsite)) . '</label></p>';
$content .= '<p>';
$content .= '<label><span>' . elgg_echo('uhb_annonces:object:structuresiret') . '</span>' . elgg_view('input/text', array('name' => 'structuresiret', 'value' => $structuresiret)) . '</label>';
$content .= ' &nbsp; &nbsp; ';
$content .= '<label>' . elgg_echo('uhb_annonces:object:structurenaf2008') . elgg_view('input/text', array('name' => 'structurenaf2008', 'value' => $structurenaf2008)) . '</label>';
$content .= ' &nbsp; &nbsp; ';
$content .= '<label>' . elgg_echo('uhb_annonces:object:structureworkforce') . elgg_view('input/dropdown', array('name' => 'structureworkforce', 'value' => $structureworkforce, 'options_values' => $structureworkforce_opt)) . '</label>';
$content .= '</p>';
$content .= '<p><label><span>' . elgg_echo('uhb_annonces:object:structuredetails') . '</span>' . elgg_view('input/plaintext', array('name' => 'structuredetails', 'value' => $structuredetails)) . '</label></p>';
$content .= '<div class="clearfloat"></div><br />';
$content .= '</div>';



// STEP 2
$content .= '<div class="uhb_annonces-form-step uhb_annonces-form-step2" style="display:none;">';
$content .= '<h3>' . elgg_echo('uhb_annonces:object:group:offer') . '</h3>';
$content .= '<p>';
$content .= '<label><span>' . elgg_echo('uhb_annonces:object:typeoffer') . '</span>' . $required_mark . elgg_view('input/dropdown', array('name' => 'typeoffer', 'value' => $typeoffer, 'options_values' => $typeoffer_opt, 'required' => 'required', 'onchange' => 'uhb_annonces_toggle_typework();')) . '</label>';
$content .= ' &nbsp; &nbsp; ';
// @TODO afficher ssi valeur 'emploi' choisie dans le sélecteur précédent
if ($typeoffer == 'emploi') {
	$content .= '<label class="uhb_annonces-typework">' . elgg_echo('uhb_annonces:object:typework');
	$content .= elgg_view('input/dropdown', array('name' => 'typework', 'value' => $typework, 'options_values' => $typework_opt, 'onChange' => 'uhb_annonces_toggle_worklength();'));
} else {
	$content .= '<label class="uhb_annonces-typework uhb_annonces-disabled">' . elgg_echo('uhb_annonces:object:typework');
	$content .= elgg_view('input/dropdown', array('name' => 'typework', 'value' => $typework, 'options_values' => $typework_opt, 'disabled' => 'disabled', 'onChange' => 'uhb_annonces_toggle_worklength();'));
}
$content .= '</label>';
$content .= '</p>';
$content .= '<p>';
$content .= '<label><span>' . elgg_echo('uhb_annonces:object:offerposition') . '</span>' . $required_mark . elgg_view('input/text', array('name' => 'offerposition', 'value' => $offerposition, 'required' => 'required')) . '</label>';
$content .= ' &nbsp; &nbsp; ';
$content .= '<label>' . elgg_echo('uhb_annonces:object:offerreference') . elgg_view('input/text', array('name' => 'offerreference', 'value' => $offerreference)) . '</label></p>';
$content .= '<p><label>' . elgg_echo('uhb_annonces:object:offertask') . $required_mark . elgg_view('input/plaintext', array('name' => 'offertask', 'value' => $offertask, 'required' => 'required')) . '</label></p>';
$content .= '<p><label>' . elgg_echo('uhb_annonces:object:offerpay') . elgg_view('input/text', array('name' => 'offerpay', 'value' => $offerpay)) . '</label></p>';
$content .= '<h3>' . elgg_echo('uhb_annonces:object:group:work') . '</h3>';
$content .= '<p><label>' . elgg_echo('uhb_annonces:object:workstart') . $required_mark . elgg_view('input/date', array('name' => 'workstart', 'value' => $workstart, 'timestamp' => true, 'required' => 'required')) . '</label>';
$content .= ' &nbsp; &nbsp; ';
if ($typework == 'cdi') {
	$content .= '<label class="uhb_annonces-worklength uhb_annonces-disabled">' . elgg_echo('uhb_annonces:object:worklength') . '<input type="number" step="1" min="1" maxlength="3" name="worklength" value="' . $worklength . '" /></label>';
} else {
	$content .= '<label class="uhb_annonces-worklength">' . elgg_echo('uhb_annonces:object:worklength') . '<input type="number" step="1" min="1" maxlength="3" name="worklength" value="' . $worklength . '" /></label>';
}
$content .= ' &nbsp; &nbsp; ';
$content .= '<label>' . elgg_echo('uhb_annonces:object:worktime') . $required_mark . elgg_view('input/dropdown', array('name' => 'worktime', 'value' => $worktime, 'options_values' => $worktime_opt, 'required' => 'required')) . '</label></p>';
$content .= '<p><label>' . elgg_echo('uhb_annonces:object:worktrip') . $required_mark . '</label><span class="radio">' . elgg_view('uhb_annonces/input/radio', array('name' => 'worktrip', 'value' => $worktrip, 'options' => $worktrip_opt, 'required' => 'required')) . '</span></p>';
$content .= '<p><label>' . elgg_echo('uhb_annonces:object:workcomment') . elgg_view('input/plaintext', array('name' => 'workcomment', 'value' => $workcomment)) . '</label></p>';

$content .= '<h3>' . elgg_echo('uhb_annonces:object:group:profile') . '</h3>';
$content .= '<p><label>' . elgg_echo('uhb_annonces:object:profilelevel') . elgg_view('input/dropdown', array('name' => 'profilelevel', 'value' => $profilelevel, 'options_values' => $profilelevel_opt)) . '</label><br /><span class="uhb_profile-label-example">' . elgg_echo('uhb_annonces:object:profilelevel:details') . '</span></p>';
$content .= '<p><label>' . elgg_echo('uhb_annonces:object:profileformation') . '</label><br />' . elgg_view('input/checkboxes', array('name' => 'profileformation', 'value' => $profileformation, 'options' => $profileformation_opt, 'align' => 'horizontal')) . '</p>';
$content .= '<p><label>' . elgg_echo('uhb_annonces:object:profilecomment') . elgg_view('input/plaintext', array('name' => 'profilecomment', 'value' => $profilecomment)) . '</label>';
$content .= '</div>';



// STEP 3
$content .= '<div class="uhb_annonces-form-step uhb_annonces-form-step3" style="display:none;">';
$content .= '<h3>' . elgg_echo('uhb_annonces:form:group:manager') . '</h3>';
$content .= '<p>';
if ($admin) {
	$content .= '<label style="float:right">' . elgg_echo('uhb_annonces:object:managervalidated') . elgg_view('input/dropdown', array('name' => 'managervalidated', 'value' => $managervalidated, 'options_values' => $managervalidated_opt)) . '</label>';
}
$content .= '<p><label><span>' . elgg_echo('uhb_annonces:object:managergender') . $required_mark . '</span></label><span class="radio">' . elgg_view('uhb_annonces/input/radio', array('name' => 'managergender', 'value' => $managergender, 'options' => $managergender_opt, 'required' => 'required')) . '</span></p>';
//$content .= ' &nbsp; &nbsp; ';
$content .= '<p><label>' . elgg_echo('uhb_annonces:object:managername') . $required_mark . elgg_view('input/text', array('name' => 'managername', 'value' => $managername, 'required' => 'required')) . '</label>';
$content .= '</p>';
$content .= '<p>';
$content .= '<label>' . elgg_echo('uhb_annonces:object:manageremail') . $required_mark . elgg_view('input/text', array('name' => 'manageremail', 'value' => $manageremail, 'required' => 'required')) . '</label> &nbsp; &nbsp; ';
$content .= '<label>' . elgg_echo('uhb_annonces:object:manageremail:confirm') . $required_mark . elgg_view('input/text', array('name' => 'manageremail_confirm', 'value' => $manageremail_confirm, 'autocomplete' => 'off', 'required' => 'required')) . '</label></p>';
$content .= '<p><label><span>' . elgg_echo('uhb_annonces:object:managerphone') . '</span>' . elgg_view('input/text', array('name' => 'managerphone', 'value' => $managerphone)) . '</label></p>';
// Add captcha hook if new offer and no edit key
if (!elgg_is_logged_in() && (!elgg_instanceof($offer, 'object', 'uhb_offer') || ($offer->editkey != get_input('editkey'))) ) {
	$content .= elgg_view('input/captcha', $vars);
}
$content .= '<blockquote>' . elgg_echo('uhb_annonces:form:manager:details') . '</blockquote>';
$content .= '</div>';



// Action buttons
$content .= '<div class="clearfloat"></div><br />';
$content .= '<div class="uhb_annonces-form-buttons">';
	
	// Step 0 buttons
	if ($admin) $content .= '<span class="uhb_annonces-form-step uhb_annonces-form-step0">';
	else $content .= '<span class="uhb_annonces-form-step uhb_annonces-form-step0" style="display:none;">';
	$content .= '<a href="javascript:void(0);" class="elgg-button elgg-state-disabled">' . elgg_echo('uhb_annonces:form:action:previous') . '</a>';
	$content .= '<a href="javascript:void(0);" class="elgg-button" onclick="uhb_annonces_selecttab(1);">' . elgg_echo('uhb_annonces:form:action:next') . '</a>';
	$content .= '</span>';
	
	// Step 1 buttons
	if ($admin) $content .= '<span class="uhb_annonces-form-step uhb_annonces-form-step1" style="display:none;">';
	else $content .= '<span class="uhb_annonces-form-step uhb_annonces-form-step1">';
	if ($admin) $content .= '<a href="javascript:void(0);" class="elgg-button" onclick="uhb_annonces_selecttab(0);">' . elgg_echo('uhb_annonces:form:action:previous') . '</a>';
	else $content .= '<a href="javascript:void(0);" class="elgg-button elgg-state-disabled">' . elgg_echo('uhb_annonces:form:action:previous') . '</a>';
	$content .= '<a href="javascript:void(0);" class="elgg-button" onclick="uhb_annonces_selecttab(2);">' . elgg_echo('uhb_annonces:form:action:next') . '</a>';
	$content .= '</span>';
	
	// Step 2 buttons
	$content .= '<span class="uhb_annonces-form-step uhb_annonces-form-step2" style="display:none;">';
	$content .= '<a href="javascript:void(0);" class="elgg-button" onclick="uhb_annonces_selecttab(1);">' . elgg_echo('uhb_annonces:form:action:previous') . '</a>';
	$content .= '<a href="javascript:void(0);" class="elgg-button" onclick="uhb_annonces_selecttab(3);">' . elgg_echo('uhb_annonces:form:action:next') . '</a>';
	$content .= '</span>';
	
	// Step 3 buttons
	$content .= '<span class="uhb_annonces-form-step uhb_annonces-form-step3" style="display:none;">';
	$content .= '<a href="javascript:void(0);" class="elgg-button" onclick="uhb_annonces_selecttab(2);">' . elgg_echo('uhb_annonces:form:action:previous') . '</a>';
	$content .= '<a href="javascript:void(0);" class="elgg-button elgg-state-disabled">' . elgg_echo('uhb_annonces:form:action:next') . '</a> &nbsp; ';
	// Save button is at the end, except for admins when editing an existing offer
	if (!$admin || empty($guid)) {
		$content .= '<span class="uhb_annonces-form-actions">';
		if (empty($guid)) { $content .= elgg_view('input/submit', array('value' => elgg_echo('uhb_annonces:form:action:create'))); } 
		else { $content .= elgg_view('input/submit', array('value' => elgg_echo('uhb_annonces:form:action:save'))); }
		$content .= '</span>';
	}
	$content .= '</span>';
	
	
	// Admin only : cancel and save existing offer at any time
	if ($admin && !empty($guid)) {
		$content .= '<span class="uhb_annonces-form-actions">';
		$content .= elgg_view('output/confirmlink', array('href' => $offer->getURL(), 'class' => "elgg-button elgg-button-cancel", 'confirm' => elgg_echo('uhb_annonces:form:action:cancel:confirm'), 'text' => elgg_echo('uhb_annonces:form:action:cancel')));
		$content .= elgg_view('input/submit', array('value' => elgg_echo('uhb_annonces:form:action:save')));
		$content .= '</span>';
	}

$content .= '<div class="clearfloat"></div><br /><br />';
$content .= '</div>';



echo '<form method="post" action="' . $CONFIG->url . 'action/uhb_annonces/edit" name="elgg-form-uhb-annonces-edit" novalidate="novalidate" id="uhb_annonces-edit-form">';
echo elgg_view('input/securitytoken');
echo $content;
echo '</form>';
echo '<br />';

