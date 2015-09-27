<?php
// All infos and actions related to an existing offer

$offer = elgg_extract('entity', $vars);

if (elgg_instanceof($offer, 'object', 'uhb_offer')) {
	$title = elgg_echo('uhb_annonces:sidebar:offer:title');
	$content = '';
	// Get parameter-free full URL
	$full_url = full_url();
	$full_url = explode("?", $full_url);
	$full_url = $full_url[0];
	
	// Droits d'accès
	$types = uhb_annonces_get_profile_type();
	$admin = false;
	if ($types == 'admin') { $admin = true; }
	
	$is_owner = uhb_annonces_is_owner($offer);
	
	$ownguid = elgg_get_logged_in_user_guid();
	
	// Stats
	$publish_date = $offer->followvalidation;
	//if (is_numeric($publish_date)) $publish_date = elgg_get_friendly_time($publish_date);
	// Note : assume that dates before Y2k are not valid
	//if (!empty($publish_date)) {
	if (!empty($publish_date) && ($publish_date > 946684800)) {
		if (is_numeric($publish_date)) $publish_date = date('d/m/Y', $publish_date);
		if (in_array($offer->followstate, array('new', 'confirmed'))) {
			$content .= '<p>' . elgg_echo('uhb_annonces:sidebar:offer:alreadypublished', array($publish_date)) . '</p>';
		} else {
			$content .= '<p>' . elgg_echo('uhb_annonces:sidebar:offer:published', array($publish_date)) . '</p>';
		}
	} else {
		// Indiqué seulement si offre publiée
		if (in_array($offer->followstate, array('new', 'confirmed'))) {
			$content .= '<p>' . elgg_echo('uhb_annonces:sidebar:offer:notyetpublished') . '</p>';
		} else  {
			$content .= '<p>' . elgg_echo('uhb_annonces:sidebar:offer:published:unknown') . '</p>';
		}
	}
	
	// Actions
	if (uhb_annonces_can_edit_offer($offer)) {
		$edit_url = $CONFIG->url . 'annonces/edit/' . $offer->guid;
		$pass_keys = '?' . uhb_annonces_add_keys();
		$add_keys = '&' . uhb_annonces_add_keys();
		if ($full_url != $edit_url) {
			if ($admin) {
				$content .= '<p><a href="' . $edit_url . $pass_keys . '">' . elgg_echo('uhb_annonces:sidebar:edit') . '</a></p>';
			} else {
				$content .= '<p><a href="' . $edit_url . $pass_keys . '">' . elgg_echo('uhb_annonces:sidebar:edit:your') . '</a></p>';
			}
		}
		// Admin et owner peuvent déclarer l'annonce pourvue et l'archiver (cf. feedbacks)
		if (!in_array($offer->followstate, array('archive', 'filled'))) {
			$content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:archive'), 'href' => $CONFIG->url . 'action/uhb_annonces/archive?guid='.$offer->guid.$add_keys, 'title' => '', "is_action" => true)) . '</p>';
			$content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:markfilled'), 'href' => $CONFIG->url . 'action/uhb_annonces/filled?guid='.$offer->guid.$add_keys, 'title' => '', "is_action" => true)) . '</p>';
		}
	}
	
	// Owner can duplicate an existing offer to create a new one
	if (uhb_annonces_can_edit_offer($offer) || ($offer->owner_guid == $ownguid)) {
		$pass_keys = '&' . uhb_annonces_add_keys();
		$content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:duplicate'), 'href' => $CONFIG->url . 'annonces/add?loadfrom='.$offer->guid . $pass_keys, 'title' => '')) . '</p>';
	}
	
	// Candidature et mémorisation
	if (uhb_annonces_can_candidate() && ($offer->followstate == 'published')) {
		// Memorised
		if (check_entity_relationship($ownguid, 'memorised', $offer->guid)) {
			$content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:offer:dontremember'), 'href' => $CONFIG->url . 'action/uhb_annonces/memorise?request=remove&guid='.$offer->guid, 'title' => '', "is_action" => true)) . '</p>';
		} else {
			$content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:offer:remember'), 'href' => $CONFIG->url . 'action/uhb_annonces/memorise?guid='.$offer->guid, 'title' => '', "is_action" => true)) . '</p>';
		}
		// Candidated
		if (check_entity_relationship($ownguid, 'has_candidated', $offer->guid)) {
			$content .= '<p>' . elgg_echo('uhb_annonces:sidebar:offer:hasapplied') . '</p>';
		} else {
			// Display only if we are not already doing it !
			if (get_input('apply') != 'yes') {
				$content .= '<p><a href="' . $offer->getURL() . '?apply=yes">' . elgg_echo('uhb_annonces:sidebar:offer:apply') . '</a></p>';
			}
		}
	}
	
	// Reported
	// Report only open offers (non-sense if already filled or archived)
	if (elgg_is_logged_in()) {
		// Do not add this button for offer owners (they can change the offer state instead)
		if (!$is_owner && !in_array($offer->followstate, array('filled', 'archive'))) {
			if (check_entity_relationship($ownguid, 'reported', $offer->guid)) {
				$content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:offer:unreport'), 'href' => $CONFIG->url . 'action/uhb_annonces/report?request=remove&guid='.$offer->guid, "is_action" => true)) . '</p>';
			} else {
				$content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:offer:report'), 'href' => $CONFIG->url . 'action/uhb_annonces/report?guid='.$offer->guid, "is_action" => true)) . '</p>';
			}
		}
	} else {
		$content .= '<p>' . elgg_echo('uhb_annonces:report:error:account') . '</p>';
	}
	
	echo elgg_view_module('aside', $title, $content);
	
	
	// Admin part
	if ($admin) {
		$admin_title = elgg_echo('uhb_annonces:sidebar:admin:title');
		$admin_content = '';
		// Stats
		$candidated = uhb_annonces_get_from_relationship('has_candidated', $offer->guid, true, true);
		$memorised = uhb_annonces_get_from_relationship('memorised', $offer->guid, true, true);
		$admin_content .= '<p>' . elgg_echo('uhb_annonces:sidebar:offer:memorised', array($memorised)) . '</p>';
		$admin_content .= '<p>' . elgg_echo('uhb_annonces:sidebar:offer:candidated', array($candidated)) . '</p>';
		
		// Actions
		if ($offer->managervalidated != 'yes') {
			$admin_content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:resendconfirm'), 'href' => $CONFIG->url . 'action/uhb_annonces/resendconfirm?guid='.$offer->guid, 'title' => '', "is_action" => true)) . '</p>';
		}
		if ($offer->managervalidated != 'yes') {
			$admin_content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:validate'), 'href' => $CONFIG->url . 'action/uhb_annonces/validate?guid='.$offer->guid, 'title' => '', "is_action" => true)) . '</p>';
		}
		if (in_array($offer->followstate, array('new', 'confirmed'))) {
			$admin_content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:publish'), 'href' => $CONFIG->url . 'action/uhb_annonces/publish?guid='.$offer->guid, 'title' => '', "is_action" => true)) . '</p>';
		}
		if ($offer->followreport > 0) {
			$admin_content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:removereport'), 'href' => $CONFIG->url . 'action/uhb_annonces/removereport?guid='.$offer->guid, 'title' => '', "is_action" => true)) . '</p>';
		}
		/*
		if ($offer->followstate != 'archive') {
			$admin_content .= '<p>' . elgg_view("output/url", array("text" => elgg_echo('uhb_annonces:sidebar:archive'), 'href' => $CONFIG->url . 'action/uhb_annonces/archive?guid='.$offer->guid, 'title' => '', "is_action" => true)) . '</p>';
		}
		*/
		
		echo elgg_view_module('aside', $admin_title, $admin_content);
	}
}

