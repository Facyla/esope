<?php
/**
 * Elgg uhb_offer view
 *
 */

$full = elgg_extract('full_view', $vars, FALSE);
$offer = elgg_extract('entity', $vars, FALSE);

if (!$offer) { return; }

/* Note : search should used more direct functions to limit server load
$search = elgg_extract('search_view', $vars, FALSE);
// Search view : use another view...
if ($search) return elgg_view('object/uhb_offer_search', $vars);
*/


$types = uhb_annonces_get_profile_type();
$admin = false;
if ($types == 'admin') { $admin = true; }


/* Cycle de vie : selon l'état, seuls certains profils peuvent accéder aux annonces : 
 * new : owner + admin
 * confirmed : owner + admin
 * published : all
 * filled : admin + membres "intéressés par"
 * archive : admin + membres "intéressés par"
 */

$content = '';
$apply = false;
if (uhb_annonces_can_candidate() && (get_input('apply', false))) { $apply = true; }

$already_applied = false;
$ownguid = elgg_get_logged_in_user_guid();
if (!$admin && uhb_annonces_can_candidate()) {
	if (check_entity_relationship($ownguid, 'has_candidated', $offer->guid)) { $already_applied = true; }
}


if ($full) {
	// FULL VIEW
	// Title already displayed in view page handler
	
	// STEP 1 - Structure
	if ($apply) {
		$content .= '<div class="uhb_annonces-view-step uhb_annonces-view-step1" style="display:none">';
	} else {
		$content .= '<div class="uhb_annonces-view-step uhb_annonces-view-step1">';
	}
	$content .= '<h3>' . elgg_echo('uhb_annonces:form:group:structure') . '</h3>';
	$content .= '<p>' . elgg_echo('uhb_annonces:view:structure') . $offer->structurename . ' (' . elgg_echo('uhb_annonces:structurelegalstatus:'.$offer->structurelegalstatus) . ')</p>';
	$content .= '<p>' . elgg_echo('uhb_annonces:view:structureaddress') . '<br />' . $offer->structureaddress . '<br />' . $offer->structurepostalcode . ' ' . $offer->structurecity . '<br />' . '</p>';
	$content .= '<p>' . elgg_echo('uhb_annonces:view:structurewebsite') . '<a href="' . $offer->structurewebsite . '" target="_blank">' . $offer->structurewebsite . '</a></p>';
	
	if ($admin) {
		$content .= '<p>' . elgg_echo('uhb_annonces:view:structuresiret') . $offer->structuresiret;
		$content .= ' &nbsp; ';
		$content .= elgg_echo('uhb_annonces:view:structurenaf2008') . $offer->structurenaf2008 . '</a></p>';
	}

	if ($offer->structureworkforce) $content .= '<p>' . elgg_echo('uhb_annonces:view:structureworkforce', array(elgg_echo('uhb_annonces:structureworkforce:'.$offer->structureworkforce))) . '</p>';
	if ($offer->structuredetails) $content .= elgg_echo('uhb_annonces:view:structuredetails') . elgg_view('output/longtext', array('value' => $offer->structuredetails));
	$content .= '</div>';
	
	// STEP 2 - Offer + profile
	$content .= '<div class="uhb_annonces-view-step uhb_annonces-view-step2" style="display:none;">';
	$content .= '<h3>' . elgg_echo('uhb_annonces:object:group:offer') . '</h3>';
	if (!empty($offer->offerreference)) $content .= '<p>' . elgg_echo('uhb_annonces:view:offerreference') . $offer->offerreference . '</a></p>';
	if (!empty($offer->offerpay)) if ($offer->offerpay) $content .= '<p>' . elgg_echo('uhb_annonces:view:offerpay') . $offer->offerpay . '</p>';
	$content .= elgg_echo('uhb_annonces:view:offertask') . elgg_view('output/longtext', array('value' => $offer->offertask));
	$content .= '<br />';
	$content .= '<h3>' . elgg_echo('uhb_annonces:object:group:work') . '</h3>';
	$content .= '<p>';
	$content .= elgg_echo('uhb_annonces:view:workstart') . elgg_view('output/date', array('value' => $offer->workstart));
	$content .= ', ';
	$content .= elgg_echo('uhb_annonces:view:worklength', array($offer->worklength));
	$content .= '</p>';
	$content .= '<p>' . elgg_echo('uhb_annonces:view:worktime') . elgg_echo('uhb_annonces:view:worktime:'.$offer->worktime) . '</p>';
	$content .= '<p>' . elgg_echo('uhb_annonces:view:worktrip') . elgg_echo('uhb_annonces:worktrip:'.$offer->worktrip) . '</p>';
	if (!empty($offer->workcomment)) $content .= elgg_echo('uhb_annonces:view:workcomment') . elgg_view('output/longtext', array('value' => $offer->workcomment));
	$content .= '<br />';
	
	$content .= '<h3>' . elgg_echo('uhb_annonces:object:group:profile') . '</h3>';
	if ($offer->profileformation) {
		$profileformation = '<ul>';
		foreach ($offer->profileformation as $formation) {
			$profileformation .= '<li>' . elgg_echo('uhb_annonces:profileformation:'.$formation) . '</li>';
		}
		$profileformation .= '</ul>';
		$content .= elgg_echo('uhb_annonces:view:profileformation') . elgg_view('output/longtext', array('value' => $profileformation));
	}
	if (!empty($offer->profilelevel)) $content .= '<p>' . elgg_echo('uhb_annonces:view:profilelevel') . elgg_echo('uhb_annonces:profilelevel:' . $offer->profilelevel) . '</p>';
	if ($offer->profilecomment) $content .= elgg_echo('uhb_annonces:view:profilecomment') . elgg_view('output/longtext', array('value' => $offer->profilecomment));
	$content .= '</div>';
	
	// STEP 3 - Candidate
	if (!$admin && uhb_annonces_can_candidate()) {
		if ($apply) {
			$content .= '<div class="uhb_annonces-view-step uhb_annonces-view-step3">';
		} else {
			$content .= '<div class="uhb_annonces-view-step uhb_annonces-view-step3" style="display:none;">';
		}
		//$content .= elgg_view_form('uhb_annonces/candidate', array(), array('entity' => $offer));
		if ($already_applied) {
			$content .= '<p>' . elgg_echo('uhb_annonces:candidate:done:details') . '</p>';
		} else {
			$content .= elgg_view('forms/uhb_annonces/candidate', array('entity' => $offer));
		}
		$content .= '</div>';
		
	}
	
	// STEP 3 (admin) - Contact
	if ($admin) {
		$content .= '<div class="uhb_annonces-view-step uhb_annonces-view-step3" style="display:none;">';
		$content .= '<h3>' . elgg_echo('uhb_annonces:form:group:manager') . '</h3>';
		$content .= '<p>' . elgg_echo('uhb_annonces:object:managername') . '&nbsp;: ' . elgg_echo('uhb_annonces:managergender:'.$offer->managergender) . ' ' . $offer->managername . '</p>';
		$manageremail = '<a href="mailto:' . $offer->manageremail . '">' . $offer->manageremail . '</a>';
		$content .= '<p>' . elgg_echo('uhb_annonces:view:manageremail', array($manageremail)) . '<br />';
		if ($offer->managervalidated == 'yes') $content .= elgg_echo('uhb_annonces:view:managervalidated:yes');
		else $content .= '<strong>' . elgg_echo('uhb_annonces:view:managervalidated:no') . '</strong>';
		$content .= '</p>';
		if (!empty($offer->managerphone)) $content .= '<p>' . elgg_echo('uhb_annonces:view:managerphone', array($offer->managerphone)) . '</p>';
		$content .= '</div>';
	}
		
	// STEP 4 (admin) - Admin
	if ($admin) {
		$content .= '<div class="uhb_annonces-view-step uhb_annonces-view-step4" style="display:none;">';
		$content .= '<p><strong>' . elgg_echo('uhb_annonces:view:followstate', array(elgg_echo('uhb_annonces:followstate:'.$offer->followstate))) . '</strong></p>';
		/*
		$public_read_url = $CONFIG->url . 'annonces/edit/' . $offer->guid . '?editkey=' . $offer->readkey;
		$content .= '<p><strong>' . elgg_echo('uhb_annonces:object:readkey') . '&nbsp;:</strong> ' . $offer->readkey . '<br /><a href="' . $public_read_url . '">' . $public_read_url . '</a></p>';
		*/
		$public_edit_url = $CONFIG->url . 'annonces/edit/' . $offer->guid . '?editkey=' . $offer->editkey;
		$content .= '<p><strong>' . elgg_echo('uhb_annonces:object:editkey') . '&nbsp;:</strong> ' . $offer->editkey . '<br /><a href="' . $public_edit_url . '">' . $public_edit_url . '</a></p>';
		$content .= '<p>';
		$followcreation = $offer->time_created;
		if (!empty($followcreation)) {
			// If for some reason we have a date instead of a timestamp, handle it
			if (is_numeric($followcreation)) $followcreation = date('d/m/Y', $followcreation);
			$content .= elgg_echo('uhb_annonces:view:followcreation', array($followcreation));
		} else { $content .= elgg_echo('uhb_annonces:view:followcreation:no'); }
		// Auteur : important de distinguer les anonymes
		if ($offer->owner_guid == $CONFIG->site->guid) {
			$createdby = elgg_echo('uhb_annonces:view:createdby:nomember');
		} else {
			$owner = $offer->getOwnerEntity();
			$createdby = '<a href="' . $owner->getURL() . '" target="_blank">' . $owner->name . '</a>';
		}
		$content .= ' ' . elgg_echo('uhb_annonces:view:createdby', array($createdby));
		$content .= '<br />';
		$followvalidation = $offer->followvalidation;
		if (!empty($followvalidation)) {
			if (is_numeric($followvalidation)) $followvalidation = date('d/m/Y', $followvalidation);
			$content .= elgg_echo('uhb_annonces:view:followvalidation', array($followvalidation));
		} else { $content .= elgg_echo('uhb_annonces:view:followvalidation:no'); }
		$content .= '<br />';
		$followend = $offer->followend;
		if (!empty($followend)) {
			if (is_numeric($followend)) $followend = date('d/m/Y', $followend);
			$content .= elgg_echo('uhb_annonces:view:followend', array($followend));
		} else { $content .= elgg_echo('uhb_annonces:view:followend:no'); }
		$content .= '</p>';
		$content .= '<p>';
		$content .= elgg_echo('uhb_annonces:view:interested', array((int) $offer->followinterested));
		$content .= '<br />';
		$content .= elgg_echo('uhb_annonces:view:candidated', array((int) $offer->followcandidates));
		$content .= '<br />';
		$content .= elgg_echo('uhb_annonces:view:reported', array((int) $offer->followreport));
		$content .= '</p>';
		if ($offer->followcomments) $content .= elgg_echo('uhb_annonces:view:followcomments') . elgg_view('output/longtext', array('value' => $offer->followcomments));
		
		if ($admin) {
			$content .= '<p><a href="' . $vars['url'] . 'annonces/edit/' . $offer->guid . '" class="elgg-button elgg-button-action">' . elgg_echo('uhb_annonces:addcomment') . '</a><p>';
		}
		
		$content .= '</div>';
		
	}
	
	
} else {
	/* BRIEF VIEW (LISTING)
	 * Offre de stage/emploi (préciser si emploi)
	 * Intitulé du poste
	 * Structure : Raison sociale, ville
	 * Offre : Date de début, durée
	 * Profil : Niveau d'étude
	 * Admin : Email validé, Date validation, Etat, Nb intéressés, Nb candidatures, Nb signalements
	 */
	
	$content .= '<div class="uhb_annonces-offer">';
	// Admin side information fields
	$side_content = '';
	if ($admin) {
		$side_content .= '<span class="uhb_annonces-side-infos-validated">';
		if (!empty($offer->followvalidation)) {
			//$followvalidation = elgg_get_friendly_time($offer->followvalidation);
			$followvalidation = date('d/m/Y', $offer->followvalidation);
			$side_content .= elgg_echo('uhb_annonces:view:followvalidation', array($followvalidation));
		} else $side_content .= elgg_echo('uhb_annonces:view:followvalidation:no');
		$side_content .= '</span>';
		$side_content .= '<strong>' . elgg_echo('uhb_annonces:view:followstate', array(elgg_echo('uhb_annonces:followstate:'.$offer->followstate))) . '</strong>';
		$side_content .= '<br />';
		if ($offer->managervalidated == 'yes') $side_content .= elgg_echo('uhb_annonces:view:managervalidated:yes');
		else $side_content .= elgg_echo('uhb_annonces:view:managervalidated:no');
		$side_content .= '<br />';
		$side_content .= elgg_echo('uhb_annonces:view:interested', array((int) $offer->followinterested));
		$side_content .= '<br />';
		$side_content .= elgg_echo('uhb_annonces:view:candidated', array((int) $offer->followcandidates));
		$side_content .= '<br />';
		$side_content .= elgg_echo('uhb_annonces:view:reported', array((int) $offer->followreport));
	} else if (uhb_annonces_can_edit_offer($offer) || ($offer->owner_guid == $ownguid)) {
		// Only owner can view this - useful info to check status
		$side_content .= '<span class="uhb_annonces-side-infos-validated">';
		if (!empty($offer->followvalidation)) {
			//$followvalidation = elgg_get_friendly_time($offer->followvalidation);
			$followvalidation = date('d/m/Y', $offer->followvalidation);
			$side_content .= elgg_echo('uhb_annonces:view:followvalidation', array($followvalidation));
		} else $side_content .= elgg_echo('uhb_annonces:view:followvalidation:no');
		$side_content .= '</span>';
		$side_content .= '<strong>' . elgg_echo('uhb_annonces:view:followstate', array(elgg_echo('uhb_annonces:followstate:'.$offer->followstate))) . '</strong>';
		$side_content .= '<br />';
		if ($offer->managervalidated == 'yes') $side_content .= elgg_echo('uhb_annonces:view:managervalidated:yes');
		else $side_content .= elgg_echo('uhb_annonces:view:managervalidated:no');
	}
	if (!empty($side_content)) {
		$content .= '<span class="uhb_annonces-side-infos">' . $side_content . '</span>';
	}
	
	
	// Title
	$title = ' <em>' . $offer->offerposition . '</em>';
	switch($offer->typeoffer) {
		case 'stage':
			$title = elgg_echo('uhb_annonces:view:stage', array($title));
			break;
		case 'emploi':
			$title = elgg_echo('uhb_annonces:view:emploi', array(elgg_echo('uhb_annonces:typework:'.$offer->typework), $title));
			break;
		default:
			$title = elgg_echo('uhb_annonces:view', array(elgg_echo('uhb_annonces:typeoffer:'.$offer->typeoffer), $title));
	}
	$state = '';
	if (in_array($offer->followstate, array('filled', 'archive'))) { $state = '[' . elgg_echo('uhb_annonces:followstate:'.$offer->followstate) . '] '; }
	$content .= '<h3><a href="' . $offer->getURL() . '">' . $state . $title . '</a></h3>';
	
	// Offer content
	$content .= elgg_echo('uhb_annonces:view:structure') . $offer->structurename . ' (' . $offer->structurecity . ')';
	$content .= '<br />';
	// Offre : Date de début, durée
	$content .= elgg_echo('uhb_annonces:view:workstart') . elgg_view('output/date', array('value' => $offer->workstart));
	// Durée n'a pas de sens si CDI
	if ($offer->typework != 'cdi') {
		$content .= ', ';
		$content .= elgg_echo('uhb_annonces:view:worklength', array($offer->worklength));
	}
	// Profil : Niveau d'étude
	if (!empty($offer->profilelevel)) {
		$content .= '<br />';
		$content .= elgg_echo('uhb_annonces:view:profilelevel') . elgg_echo('uhb_annonces:profilelevel:' . $offer->profilelevel);
	}
	$content .= '<br />';
	
	// Admin / owner actions
	// Note : owner can not change content after some states (handled in can_edit function)
	if (uhb_annonces_can_edit_offer($offer)) {
		$content .= '<p><a href="' . $vars['url'] . 'annonces/edit/' . $offer->guid . '" class="elgg-button elgg-button-action">' . elgg_echo('edit') . '</a><p>';
	}
	$content .= '<div class="clearfloat"></div>';
	$content .= '</div>';
	
}

echo $content;

