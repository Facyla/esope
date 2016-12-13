<?php
$content = '';

$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }

// Get previous form values, so we can easily update requests without losing presets
//  - and also link to pre-configured searches...
$search_criteria = uhb_annonces_get_fields('search');
foreach ($search_criteria as $criteria) {
	// Use ranges for some fields
	if (in_array($criteria, array('workstart', 'followcreation', 'followvalidation', 'followend', 'followinterested', 'followcandidates', 'followreport'))) {
		${$criteria.'_min'} = get_input($criteria.'_min', '');
		${$criteria.'_max'} = get_input($criteria.'_max', '');
		// Optionally set min an max values based on existing offers
		/*
		if (empty(${$criteria.'_min'})) ${$criteria.'_min'} = esope_get_meta_min($criteria, 'uhb_offer');
		if (empty(${$criteria.'_max'})) ${$criteria.'_max'} = esope_get_meta_max($criteria, 'uhb_offer');
		*/
	} else {
		$$criteria = get_input($criteria, '');
	}
}


//$max = esope_get_meta_max('followreport', 'uhb_offer');
//$min = esope_get_meta_min('followreport', 'uhb_offer');
//$distinct = esope_get_meta_values('followreport');
// Set dropdown options_values
$yes_no_opt = array('' => elgg_echo('uhb_annonces:option:'), 'yes' => elgg_echo('uhb_annonces:option:yes'), 'no' => elgg_echo('uhb_annonces:option:no'));
// Author
$empty_value_title = elgg_echo('uhb_annonces:search:emptytitle');
$typeoffer_opt = uhb_annonces_build_options('typeoffer', $empty_value_title, true, 'uhb_annonces', $distinct);
$typework_opt = uhb_annonces_build_options('typework', $empty_value_title, true);
$structurelegalstatus_opt = uhb_annonces_build_options('structurelegalstatus', $empty_value_title, true);
$profileformation_opt = uhb_annonces_build_options('profileformation', $empty_value_title, true);
//$profilelevel_opt = uhb_annonces_build_options('profilelevel', $empty_value_title, true);
$profilelevel_opt = array(
	'' => elgg_echo('uhb_annonces:search:profilelevel:all'), 
	'1' => elgg_echo('uhb_annonces:search:profilelevel:1'), 
	'4' => elgg_echo('uhb_annonces:search:profilelevel:4'), 
	'6' => elgg_echo('uhb_annonces:search:profilelevel:6'), 
);
$worklength_opt = array(
	'' => elgg_echo('uhb_annonces:search:worklength:all'), 
	'0to3' => elgg_echo('uhb_annonces:search:worklength:0to3'), 
	'3to6' => elgg_echo('uhb_annonces:search:worklength:3to6'), 
	'6more' => elgg_echo('uhb_annonces:search:worklength:6more'), 
);
// Admin only
$managervalidated_opt = $yes_no_opt;
$followstate_opt = uhb_annonces_build_options('followstate', $empty_value_title, true);
$is_anonymous_opt = array(elgg_echo('uhb_annonces:owner:anonymous') => 'yes');


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
		// Enable selector if not "emploi" (so not "cdi" as well)
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

// Interception des modifications manuelles
// Note : In jQuery event.target always refers to the element that triggered the event, 
// where event is the parameter passed to the function. http://api.jquery.com/category/events/event-object/
$(document).ready(function() {
	$(\'.elgg-input-date\').change(function(event){
		$(\'input[name="\' + event.target.id + \'"]\').val($(this).val());
	});
});
</script>';

// Use POST for cleaner queries, but we allow GET vars to be passed
// Update : GET prefered because we might want to easily link to queries + update URL when using GET parameters
$content .= '<form id="uhb_annonces-search-form" method="GET">';
$content .= elgg_view('input/securitytoken');
$content .= elgg_view('input/hidden', array('name' => 'action', 'value' => 'search'));

// PLEINE LARGEUR : critères fondamentaux
// DATES DE L'ANNONCE
//$content .= '<fieldset>';
//	$content .= '<legend>' . elgg_echo('Annonce') . '</legend>';

	// Both : typeoffer, typework
	$content .= '<p>';
	$content .= '<label>' . elgg_echo("uhb_annonces:object:typeoffer") . elgg_view('input/dropdown', array('name' => 'typeoffer', 'value' => $typeoffer, 'options_values' => $typeoffer_opt, 'onchange' => 'uhb_annonces_toggle_typework();')) . '</label>';
	$content .= ' &nbsp; ';
	if ($typeoffer == 'emploi') {
		$content .= '<label class="uhb_annonces-typework">' . elgg_echo("uhb_annonces:object:typework") . elgg_view('input/dropdown', array('name' => 'typework', 'value' => $typework, 'options_values' => $typework_opt, 'onChange' => 'uhb_annonces_toggle_worklength();')) . '</label>';
	} else {
		$content .= '<label class="uhb_annonces-typework uhb_annonces-disabled">' . elgg_echo("uhb_annonces:object:typework") . elgg_view('input/dropdown', array('name' => 'typework', 'value' => $typework, 'options_values' => $typework_opt, 'disabled' => 'disabled', 'onChange' => 'uhb_annonces_toggle_worklength();')) . '</label>';
	}
	if ($admin) {
		$content .= '<label style="float:right;">' . elgg_echo("uhb_annonces:object:followstate") . elgg_view('input/dropdown', array('name' => 'followstate', 'value' => $followstate, 'options_values' => $followstate_opt)) . '</label>';
	}
//$content .= '</fieldset>';

$content .= '</p>';

// Filter on anonymous offer authors
if ($admin) {
	// Admin only : anonymous owner (site)
	// Not a metadata, so not retrieved likle other values
	$is_anonymous = get_input('is_anonymous');
	if ($is_anonymous[0] == 'yes') {
		$content .= elgg_view('input/checkboxes', array('name' => 'is_anonymous', 'value' => $is_anonymous, 'options' => $is_anonymous_opt, 'align' => 'horizontal', 'checked' => 'checked'));
	} else {
		$content .= elgg_view('input/checkboxes', array('name' => 'is_anonymous', 'value' => $is_anonymous, 'options' => $is_anonymous_opt, 'align' => 'horizontal'));
	}

}


// COLONNE 1
$content .= '<div class="" style="width:48%; float:left;">';
	
	// Both : structurepostalcode, structurelegalstatus
	$content .= '<fieldset>';
		$content .= '<legend>' . elgg_echo('uhb_annonces:search:structureprofile') . '</legend>';
		$content .= '<p><label>' . elgg_echo("uhb_annonces:object:structurelegalstatus") . elgg_view('input/dropdown', array('name' => 'structurelegalstatus', 'value' => $structurelegalstatus, 'options_values' => $structurelegalstatus_opt)) . '</label></p>';
		$content .= '<p>';
		$content .= '<label>' . elgg_echo("uhb_annonces:object:structurepostalcode") . elgg_view('input/text', array('name' => 'structurepostalcode', 'value' => $structurepostalcode)) . '</label>';
		// Admin only : managervalidated
		if ($admin) {
			$content .= ' &nbsp; <label>' . elgg_echo("uhb_annonces:object:search:managervalidated") . elgg_view('input/dropdown', array('name' => 'managervalidated', 'value' => $managervalidated, 'options_values' => $managervalidated_opt)) . '</label>';
		}
		$content .= '</p>';
		// Admin only : structurename, structuresiret, structurenaf2008
		if ($admin) {
			$content .= '<p><label>' . elgg_echo("uhb_annonces:object:structurename") . elgg_view('input/text', array('name' => 'structurename', 'value' => $structurename)) . '</label></p>';
			$content .= '<p><label>' . elgg_echo("uhb_annonces:object:structuresiret") . elgg_view('input/text', array('name' => 'structuresiret', 'value' => $structuresiret)) . '</label>';
			$content .= ' &nbsp; <label>' . elgg_echo("uhb_annonces:object:structurenaf2008") . elgg_view('input/text', array('name' => 'structurenaf2008', 'value' => $structurenaf2008)) . '</label>';
			$content .= '</p>';
		}
		// Both : profileformation, profilelevel
		$content .= '<p><label>' . elgg_echo("uhb_annonces:object:profileformation") . elgg_view('input/dropdown', array('name' => 'profileformation', 'value' => $profileformation, 'options_values' => $profileformation_opt)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo("uhb_annonces:object:profilelevel") . elgg_view('input/dropdown', array('name' => 'profilelevel', 'value' => $profilelevel, 'options_values' => $profilelevel_opt)) . '</label></p>';
	$content .= '</fieldset>';
	
$content .= '</div>';

// COLONNE 2
$content .= '<div class="" style="width:48%; float:right;">';
$content .= '<fieldset>';
	$content .= '<legend>' . elgg_echo('uhb_annonces:search:timefilters') . '</legend>';
	// Both : workstart, worklength
	if ($typework == 'cdi') {
		$content .= '<p><label class="uhb_annonces-worklength uhb_annonces-disabled">' . elgg_echo("uhb_annonces:search:worklength") . elgg_view('input/dropdown', array('name' => 'worklength', 'value' => $worklength, 'options_values' => $worklength_opt)) . '</label></p>';
	} else {
		$content .= '<p><label class="uhb_annonces-worklength">' . elgg_echo("uhb_annonces:search:worklength") . elgg_view('input/dropdown', array('name' => 'worklength', 'value' => $worklength, 'options_values' => $worklength_opt)) . '</label></p>';
	}
	$content .= '<p><label>' . elgg_echo('uhb_annonces:search:workstart') . ' :</label><br /> à partir du' . elgg_view('input/date', array('name' => 'workstart_min', 'value' => $workstart_min, 'timestamp' => true));
	$content .= ' &nbsp; ';
	$content .= 'jusqu\'au' . elgg_view('input/date', array('name' => 'workstart_max', 'value' => $workstart_max, 'timestamp' => true)) . '</p>';
	// Both : followvalidation
	$content .= '<p><label>' . elgg_echo('uhb_annonces:search:followvalidation') . ' :</label><br />à partir du' . elgg_view('input/date', array('name' => 'followvalidation_min', 'value' => $followvalidation_min, 'timestamp' => true));
	$content .= ' &nbsp; ';
	$content .= 'jusqu\'au' . elgg_view('input/date', array('name' => 'followvalidation_max', 'value' => $followvalidation_max, 'timestamp' => true)) . '</p>';
	// Admin only : followcreation, followend
	if ($admin) {
		$content .= '<p><label>' . elgg_echo('uhb_annonces:search:followcreation') . ' : min' . elgg_view('input/date', array('name' => 'followcreation_min', 'value' => $followcreation_min, 'timestamp' => true)) . '</label>';
		$content .= ' &nbsp; ';
		$content .= '<label>max' . elgg_view('input/date', array('name' => 'followcreation_max', 'value' => $followcreation_max, 'timestamp' => true)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('uhb_annonces:search:followend') . ' : min' . elgg_view('input/date', array('name' => 'followend_min', 'value' => $followend_min, 'timestamp' => true)) . '</label>';
		$content .= ' &nbsp; ';
		$content .= '<label>max' . elgg_view('input/date', array('name' => 'followend_max', 'value' => $followend_max, 'timestamp' => true)) . '</label></p>';
	}
$content .= '</fieldset>';
$content .= '</div>';

$content .= '<div class="clearfloat"></div>';

// Admin only : followinterested, followcandidates, followreport
if ($admin) {
	$content .= '<fieldset>';
		$content .= '<legend>' . elgg_echo('uhb_annonces:search:stats') . '</legend>';
		// Followinterested
		$max = esope_get_meta_max('followinterested', 'uhb_offer');
		if (empty($max)) $max = 0;
		$content .= elgg_view('input/range', array(
				'min' => array('name' => 'followinterested_min', 'value' => 0, 'text' => "min"),
				'max' => array('name' => 'followinterested_max', 'value' => $max, 'text' => "max"),
				'values' => array('min' => $followinterested_min, 'max' => $followinterested_max),
				'text' => elgg_echo('uhb_annonces:object:followinterested') . ' : ',
				'class' => 'uhb_annonces-range',
			));
		// Followcandidates
		$max = esope_get_meta_max('followcandidates', 'uhb_offer');
		if (empty($max)) $max = 0;
		$content .= elgg_view('input/range', array(
				'min' => array('name' => 'followcandidates_min', 'value' => 0, 'text' => "min"),
				'max' => array('name' => 'followcandidates_max', 'value' => $max, 'text' => "max"),
				'values' => array('min' => $followcandidates_min, 'max' => $followcandidates_max),
				'text' => elgg_echo('uhb_annonces:object:followcandidates') . ' : ',
				'class' => 'uhb_annonces-range',
			));
		// Followreport
		$max = esope_get_meta_max('followreport', 'uhb_offer');
		if (empty($max)) $max = 0;
		$content .= elgg_view('input/range', array(
				'min' => array('name' => 'followreport_min', 'value' => 0, 'text' => "min"),
				'max' => array('name' => 'followreport_max', 'value' => $max, 'text' => "max"),
				'values' => array('min' => $followreport_min, 'max' => $followreport_max),
				'text' => elgg_echo('uhb_annonces:object:followreport') . ' : ',
				'class' => 'uhb_annonces-range',
			));
	$content .= '</fieldset>';
}

$content .= '<div class="clearfloat"></div><br />';

$content .= elgg_view('input/submit', array('value' => elgg_echo('uhb_annonces:form:action:search')));
$content .= '<a href="' . $CONFIG->url . 'annonces/search?action=nofilter" class="elgg-button elgg-button-cancel">' . elgg_echo('uhb_annonces:form:action:removefilters') . '</a>';
$content .= '</form>';


echo $content;

