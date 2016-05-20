<?php
// Main KDB view, for inner group + public interface

$fields = elgg_extract('fields', $vars);
$container_guid = elgg_extract('container_guid', $vars, false);
$publish_guid = elgg_extract('publish_guid', $vars);


// Search vars
$search_q = get_input('q');
// The other vars are in a single loop


// Types d'entités et subtypes
/*
$types_opt = array('user' => elgg_echo('user'), 'group' => elgg_echo('group'), 'object' => elgg_echo('object')); // We dont't want empty type
$registered_subtypes = get_registered_entity_types(); // Returns all subtypes, even non-objects
$subtypes_opt[] = '';
foreach ($registered_subtypes as $type => $subtypes) {
	foreach ($subtypes as $type => $subtype) {
		$subtypes_opt[] = $subtype;
	}
}
*/
//$container = get_entity($container_guid);
$tools = knowledge_database_get_allowed_tools($container_guid);
$subtypes = knowledge_database_get_allowed_subtypes();
$subtypes_opt = knowledge_database_get_allowed_subtypes(true, $tools);



// FORMULAIRE
// Prepare JS script for forms
$action_base = elgg_get_site_url() . 'action/knowledge_database/';
$kdb_search_url = elgg_add_action_tokens_to_url($action_base . 'search');


$content .= '<h3>' . elgg_echo("knowledge_database:search:title") . '</h3>';
$content .= '<script>
var formdata;
function kdb_search(){
	//$("body").addClass("esope-search-wait");
	formdata = $("#kdb-search-form").serialize();
	$.post("' . $kdb_search_url . '", formdata, function(data){
		$("#esope-search-results").html(data);
		//$("body").removeClass("esope-search-wait");
	});
}
</script>';

// Préparation du formulaire
$search_action = "javascript:kdb_search();";
// Should be an array, so clear blanks then make it an array
$metadata_search = '';

// Construction du formulaire
$search_form = '<form id="kdb-search-form" method="post" action="' . $search_action . '">';
$search_form .= elgg_view('input/securitytoken');
//$search_form .= elgg_view('input/hidden', array('name' => 'debug', 'value' => 'true'));
// @TODO Limit in a container (group) only if we are in a KDB group
if ($container_guid) { $search_form .= elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid)); }
$search_form .= elgg_view('input/hidden', array('name' => 'entity_type', 'value' => 'object'));

$search_form .= '<p><em><i class="fa fa-info-circle"></i> ' . elgg_echo('knowledge_database:search:details') . '</em></p>';
// Main search
$search_form .= '<fieldset style="border: 1px solid #2195B1; padding: 1ex 2ex; background: #f5f5f5; margin-top:1ex;">';
//$search_form .= '<legend>' . elgg_echo("knowledge_database:search:form:title") . '</legend>';
$search_form .= '<div class="kdb-search-main">';
$search_form .= '<p><label><i class="fa fa-eye"></i> ' . elgg_echo('knowledge_database:fulltextsearch') . ' <input type="text" name="q" value="' . $search_q . '" /></label><br />' . elgg_echo('knowledge_database:fulltextsearch:details') . '<em></em></p>';
$search_form .= '</div>';
$search_form .= '<div class="clearfloat"></div>';

// Custom fields
if ($fields) {
	foreach ($fields as $name) {
		$field_content = '';
		$inputs[$name] = get_input($name);
	
		// Selectors options
		$config = knowledge_database_get_field_config($name);
		$selectors[$name] = $config['params']['options_values'];
		if ($selectors[$name]) {
			// Ajoute une option vide au début du tableau
			//array_unshift($selectors[$name], ''); // Attention : inserts a "0" value !!
			$selectors[$name] = array_merge(array('' => ''), $selectors[$name]);
		}
	
		$title = esope_get_best_translation_for_metadata($name, 'knowledge_database:metadata', $config['title']);
	
		// Adjust input types
		$view = 'text';
		//$view = $config['type'];
		if (in_array($config['type'], array('dropdown', 'multiselect', 'select'))) {
			$view = 'select';
		} else if (in_array($config['type'], array('date'))) {
			$view = 'date';
		} else if (in_array($config['type'], array('longtext', 'plaintext', 'tags', 'email'))) {
			$view = 'text';
		} else if (in_array($config['type'], array('file'))) {
			continue;
		}
	
		// Build search field
		$field_content .= '<div class="kdb-search-filter">';
			$field_content .= '<p><label><span>' . $title . '</span> ';
			$field_content .= elgg_view("input/$view", array('name' => "metadata[$name]", 'value' => $inputs[$name], 'options_values' => $selectors[$name]));
			$field_content .= '</label></p>';
		$field_content .= '</div>';
	
		$fieldset = $config['category'];
		if (empty($fieldset)) { $fieldset = 'default'; }
		// Add field to appropriate fieldset
		$fieldset_fields[$fieldset] .= $field_content;
	}
}


// Render fields into fieldsets
foreach ($fieldset_fields as $fieldset => $fields_content) {
	$search_form .= '<div class="clearfloat"></div>';
	if ($fieldset == 'default') {
		$search_form .= $fields_content;
	} else {
		$fieldset_title = esope_get_best_translation_for_metadata($fieldset, 'knowledge_database:fieldset');
		$search_form .= '<fieldset class="knowledge_database-fieldset">';
		$search_form .= '<legend>' . $fieldset_title . '</legend>';
		$search_form .= $fields_content;
		$search_form .= '</fieldset>';
	}
	$search_form .= '<div class="clearfloat"></div><br />';
}

$search_form .= '<div class="clearfloat" style="margin:0;"></div>';
$search_form .= '<input type="submit" class="elgg-button elgg-button-submit fa fa-search" value="' . elgg_echo('search') . '" />';
$search_form .= '</fieldset>';
$search_form .= '</form><br />';




// Random resources block
$params = array('type' => 'object', 'subtypes' => $subtypes, 'limit' => 0, 'max' => 3);
if ($container_guid) { $params['container_guid'] = $container_guid; }
$content_latest = elgg_view('knowledge_database/random_resources', $params);

// Add resources block
$content_add = elgg_view('knowledge_database/add_resources', array('publish_guid' => $publish_guid, 'tools' => $tools));



// Compose final page
$content .= $search_form;
$content .= '<div id="esope-search-results">' . $content_latest . '</div>';
$content .= '<div class="clearfloat"></div><br /><br />';
$content .= $content_add;
$content .= '<div class="clearfloat"></div><br /><br />';

elgg_set_context('knowledge_database');

echo $content;

