<?php
$selected = elgg_extract('selected', $vars);

$sidebar .= '<div class="elgg-module elgg-page-menu elgg-module-info"><div class="elgg-body"><nav class="elgg-menu-container elgg-menu-page-container" data-menu-name="page">';
	$sidebar .= '<ul class="elgg-menu elgg-menu-page elgg-menu-page-default" data-menu-section="default">';
		
		if (empty($selected) || $selected == 'check') {
			$sidebar .= '<li class="elgg-state-selected">';
		} else {
			$sidebar .= '<li>';
		}
		$sidebar .= '<a href="' . elgg_get_site_url() . 'account_lifecycle">Re-vérifier les comptes utilisateurs</a></li>';
		
		if ($selected == 'anonymize') {
			$sidebar .= '<li class="elgg-state-selected">';
		} else {
			$sidebar .= '<li>';
		}
			$sidebar .= '<a href="' . elgg_get_site_url() . 'account_lifecycle/anonymize">Anonymiser un compte utilisateur</a></li>';
			
	$sidebar .= '</ul>';
$sidebar .= '</nav></div></div>';

echo $sidebar;

