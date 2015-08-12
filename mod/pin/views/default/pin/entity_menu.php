<?php
$ent = $vars['entity'];

//if ($ent instanceof ElggObject) {
if (elgg_instanceof($ent, 'object')) {
	$url = elgg_get_site_url();

	// Filter on chosen subtypes only
	// Note : this is done in start hook
	/*
	$subtype = $entity->getSubtype();
	// Types d'entités autorisées
	$validhighlight = elgg_get_plugin_setting('validhighlight', 'pin');
	if (!empty($validhighlight)) {
		if (function_exists('esope_get_input_array')) $validhighlight = esope_get_input_array($validhighlight);
		else $validhighlight = explode(',', $validhighlight);
		if (!in_array($subtype, $validhighlight)) { return; }
	}
	*/


	$body = '';
	$guid = $ent->guid;
	$acturl = $url . 'mod/pin/actions/';
	$imgurl = $url . 'mod/pin/graphics/';
	$ownguid = elgg_get_logged_in_user_guid();
	
	// Use to get back to same page
	$_SESSION['last_forward_from'] = current_page_url();
	
	// Check plugin settings
	// Highlight - admin or moderator selected content
	/* Mise en valeur d'un contenu :
	 * (int) or (array) highlight : (true or value or array of values) / (false or null)
	 * usage plutôt admin, collectif, 
	 * valeur attachée au contenu
	 * valeur peut être signifiante :
			- déterminer qui a mis en valeur (user, groupadmin, localadmin, admin) 
			- et dans quel contexte (groupe, site, multisite)
			- forme : array( usertype or GUID => highlightcontext) ?
	 */
	// Qui a le droit de mettre des contenus en avant ?
	if (elgg_is_admin_logged_in() 
		//	|| // @TODO ou si le container du contenu est un groupe et que l'user en est l'owner
		) { $highlightaccess = true; } else { $highlightaccess = false; }
	
	if ($highlightaccess) {
		
		// Action currently works as a toggle
		$url = elgg_add_action_tokens_to_url($acturl.'highlight.php?guid='.$ent->guid);
		
		// Prepare link and popup content
		if (empty($ent->highlight)) {
			// Not pinned yet
			$details .= elgg_echo('pin:unhighlighted');
			$icon = '<img src="'.$imgurl.'pin_add.png" />';
			$href = $url . '&action=highlight';
			$title = elgg_echo('pin:highlight:true');
			$text = elgg_echo('pin:pin');
			$alt = 'highlight';
		} else {
			// Pinned somewhere
			$details .= elgg_echo('pin:highlighted');
			switch ($ent->highlight) {
				case 'admin':
				default:
					$icon = '<img src="'.$imgurl.'pin_remove.png" />';
					$href = $url . '&action=unhighlight';
					$title = elgg_echo('pin:highlight:false');
					$text = 'Un-Pin';
					$alt = 'un-highlight';
			}
		}
		
		
		// Prepare action links
		$toggle_link = elgg_view('output/url', array(
				'href' => $href,
				'text' => $icon . ' ' . $text, 
				'title' => $title,
				'alt' => $alt,
			));
		
		
		// Old working version : 1 single toggle link
		$body .= $toggle_link;
		
		// New pin lightbox version (use when we have multiple actions available)
		/*
		$params = array(
				'text' => '<i class="fa fa-thumb-tack"></i> ' . $text, 
				'title' => elgg_echo('pin:pinmenu') . ' - ' . $title,
				'rel' => 'popup', 
				'href' => "#pins-$guid"
			);
		$body .= elgg_view('output/url', $params);
		$body .= '<div class="elgg-module elgg-module-popup elgg-pin hidden clearfix" id="pins-' . $guid . '">';
			// Current status details
			$body .= '<p>' . $details . '</p>';
			// POPUP CONTENT : actions
			$body .= $toggle_link;
			// @TODO : add new actions, that rely on relationship
			// @TODO : enable using multiple lists
			// @TODO : enable ordering lists contents
		$body .= '</div>';
		*/
		
	}
	
	// Render the view only if not empty
	//if ($body) echo '<div class="pin_container">' . $body . '</div>';
	if ($body) echo $body;
	
}

