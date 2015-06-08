<?php
/**
 * Elgg groups invite form extend
 * IMPORTANT : we're extending a view that will be embedded into a form, so take care to close and reopen "wrapper' HTML tags (<form><div>)
 *
 * @package ElggGroups
 */

$group = $vars['entity'];
$owner = $group->getOwnerEntity();
$forward_url = $group->getURL();

$own = elgg_get_logged_in_user_entity();
$ownguid = elgg_get_logged_in_user_guid();

// Get input fields
$metadata_search_fields = array('inria_location', 'inria_location_main', 'epi_ou_service', 'location');
$meta_fields = get_input("metadata");
foreach ($metadata_search_fields as $field) {
	$$field = $meta_fields["$field"];
	$query .= $$field; // Used to determine if we have any filter
	//if (!empty($$field)) $content .= "FIELD $field = " . $$field . "<br />";
}

$content = '';

// End normal invite form
$content .= "</div>";
$content .= "</form>";



$content .= '<form id="esope-search-form-invite-groups" method="POST" class="elgg-form elgg-form-groups-invite-search">';
$content .= '<div class="blockform">';
$content .= "<h3>Méthode 2&nbsp;: Recherche de membres à inviter</h3>";


// Step 1. Search form using LDAP fields
$content .= "<h4>Etape 1 : faites une recherche avec les critères disponibles</h4>";
// Préparation du formulaire : on utilise la config du thème + adaptations spécifiques pour notre cas
// Note : on peut récupérer les résultats sur cette page plutôt qu'en AJAX, si on veut...
$metadata_search = '';

// Build metadata search fields
if (elgg_is_active_plugin('profile_manager')) {
	// Metadata options fetching will only work if those are stored somewhere
	foreach ($metadata_search_fields as $metadata) {
		$name = "metadata[$metadata]";
		$meta_title = elgg_echo($metadata);
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-select"><label>' . ucfirst($meta_title) . esope_make_search_field_from_profile_field(array('metadata' => $metadata, 'name' => $name, 'auto-options' => true, 'value' => $$metadata)) . '</label></div>';
	}
} else {
	// We'll rely on text inputs then
	foreach ($metadata_search_fields as $metadata) {
		$name = "metadata[$metadata]";
		$meta_title = elgg_echo($metadata);
		$metadata_search .= '<div class="esope-search-metadata esope-search-metadata-text"><label>' . ucfirst($meta_title) . '<input type="text" name="' . $name . '" /></label></div>';
	}
}
$content .= elgg_view('input/securitytoken');
$content .= elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'user'));
$content .= $metadata_search . '<div class="clearfloat"></div>';
$content .= '<input type="submit" class="elgg-button elgg-button-submit" value="' . elgg_echo('search:go') . '" />';



// Step 2. Handle search form and display results in the invite form
// Formulaire d'invitation
$content .= '<div class="clearfloat"></div><br />';
$content .= "<h4>Etape 2 : sélectionnez les personnes à inviter ou inscrire</h4>";
// @TODO add selected results to .elgg-user-picker-list ? as : <input type="hidden" name="members[]" value="XXX">
if (!empty($query)) {
	$max_results = 500;
	$users = esope_esearch(array('returntype' => 'entities'), $max_results);
		$return_count = count($users);
	if ($users) {
		$content .= "</div>";
		$content .= '</form>';
		$content .= '<form id="esope-search-form-invite-results" method="POST" class="elgg-form elgg-form-alt mtm elgg-form-groups-invite-results" action="' . elgg_get_site_url() . 'action/groups/invite">';
		$content .= '<div class="blockform">';
		$content .= elgg_view('input/securitytoken');
		$content .= "<script>
		$(document).ready(function() {
			$('#group-invite-user-selectall').click(function(event) {
			if(this.checked) {
				$('.group-invite-user').each(function() { this.checked = true; });
			}else{
				$('.group-invite-user').each(function() { this.checked = false; });
			}
			});
		});
		</script>";
		if ($return_count > $max_results) { $content .= '<span class="esope-morethanmax">' . elgg_echo('esope:search:morethanmax') . '</span>'; }
		$content .= elgg_echo('esope:search:nbresults', array($return_count));
		foreach ($users as $ent) {
			$content .= '<p><label><input type="checkbox" name="user_guid[]" value="' . $ent->guid . '" class="group-invite-user" /> <img src="' . $ent->getIcon('topbar') . '" /> ' . $ent->name . '</label></p>';
		}
		$content .= "<p><label><input type=\"checkbox\" id=\"group-invite-user-selectall\"> " . elgg_echo('select:all') . "</label></p>";

		// Invitation ou inscription ?
		$allowregister = elgg_get_plugin_setting('allowregister', 'adf_public_platform');
		if ($allowregister == 'yes') {
			$content .= ' <p><label>' . elgg_echo('adf_platform:groups:allowregister') . '</label> ' . elgg_view('input/dropdown', array('name' => 'group_register', 'options_values' => array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes')))) . '</p>';
		}
		$content .= '<div class="elgg-foot">';
		$content .= elgg_view('input/hidden', array('name' => 'forward_url', 'value' => $forward_url));
		$content .= elgg_view('input/hidden', array('name' => 'group_guid', 'value' => $group->guid));
		$content .= elgg_view('input/submit', array('value' => elgg_echo('invite')));
		$content .= '</div>';
	} else {
		$content .= '<span class="esope-noresult">' . elgg_echo('esope:search:noresult') . '</span>';
	}
}


$content .= '<div class="clearfloat"></div>';

echo $content;

