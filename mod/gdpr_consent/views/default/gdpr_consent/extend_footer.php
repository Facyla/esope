<?php
if (!elgg_is_logged_in()) { return; }

$url = elgg_get_site_url();
$user_guid = elgg_get_logged_in_user_guid();
$config = gdpr_consent_get_current_config();

// Option that enables displaying validated consent proofs
$show_validated = elgg_extract('show_validated', false);

if (count($config) > 0) {
	$unvalidated = 0;
	$content = '';
	
	foreach($config as $consent) {
		$proof_name = "{$consent['key']}_{$consent['version']}"; // eg. privacy_0.1
		// Show only if not validated yet - get plugin usersetting, which returns validation timestamp
		$validated = elgg_get_plugin_user_setting($proof_name, $user_guid, 'gdpr_consent');
		if (!$validated) {
		$unvalidated++;
		}
		
		$content .= '<p>';
			// Document link
			$content .= elgg_view('output/url', ['href' => $consent['href'], 'text' => $consent['text'], 'target' => '_blank', 'class' => ""]) . "&nbsp;: ";
			
			if ($validated) {
				$validation_date = elgg_get_friendly_time($validated);
				$content .= elgg_echo('gdpr_consent:validatedon', [$validation_date]);
			} else {
				// Accept button
				$content .= elgg_view('output/url', [
					'href' => elgg_get_site_url() . "action/gdpr_consent/consent?key={$consent['key']}&version={$consent['version']}&consent=yes", 
					'text' => elgg_echo('gdpr_consent:banner:button', [$consent['text']]), 
					'class' => "elgg-button elgg-button-action",
					'is_action' => true,
				]);
			}
		$content .= '</p>';
	}
	
	// Display unvalidated documents (or all if using display option)
	if ($unvalidated > 0 || $show_validated) {
		echo '<div class="gdpr-consent-overlay">';
			echo '<div class="gdpr-consent-banner">';
				echo '<p>' . elgg_echo('gdpr_consent:banner:details') . '</p>';
				echo $content;
			echo '</div>';
		echo '</div>';
	}
}

