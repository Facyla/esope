<?php 
/*
 * Important : les métadonnées sont globales (pas distinguées par groupe), donc on peut les choisir dans chaque groupe, mais on doit les définir globalement !
 */

elgg_load_js('lightbox');
elgg_load_css('lightbox');

$all_metadatas = array();

// $meta = array('kdb_theme', 'kdb_topic', 'kdb_country', 'kdb_region', 'kdb_type', 'kdb_lang', 'kdb_author', 'kdb_date');

$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
$no_yes_opt = array_reverse($yes_no_opt, true);



$all_groups = elgg_get_entities(array('types' => 'group', 'limit' => 0));
$groups_opt = array();
$groups_list = '';
if ($all_groups) {
	foreach ($all_groups as $ent) {
		$groups_opt[$ent->guid] = $ent->name;
		$groups_list .= $ent->name . ' (' . $ent->guid . ') &nbsp; ';
	}
}


// Set defaults
// Note we don't want to apply this to anything : only some main data types that are made for structure (and not discussion)
$kdb_tools_opt = "blog, bookmarks, pages, file, event_calendar, announcements";
if (!isset($vars['entity']->kdb_subtypes)) { $vars['entity']->kdb_subtypes = $kdb_tools_opt; }

$kdb_inputs_opt = "text, longtext, plaintext, select, multiselect, date, tags, email, file, color";
if (!empty($vars['entity']->kdb_inputs)) { $vars['entity']->kdb_inputs = $kdb_inputs_opt; }

if ($vars['entity']->site_fields == 'reset') {
	$vars['entity']->site_fields = 'kdb_theme | kdb_topic | kdb_country | kdb_region | kdb_type | kdb_lang | kdb_author | kdb_date';
	// ('kdb_theme' => 'select', 'kdb_topic' => 'select', 'kdb_country' => 'select', 'kdb_region' => 'select', 'kdb_type' => 'select', 'kdb_lang' => 'text', 'kdb_author' => 'text', 'kdb_date' => 'text');
}



?>
<script type="text/javascript">
$(function() {
	$('#knowledge-database-settings-accordion').accordion({ header: 'h3', autoHeight: false, heightStyle: 'content' });
});
</script>

<?php


echo '<div id="knowledge-database-settings-accordion">';


// GLOBAL SETTINGS
echo '<h3>' . elgg_echo('knowledge_database:settings:global') . '</h3>';
echo '<div>';
	
	// Enable site KDB
	echo '<p><label>' . elgg_echo('knowledge_database:settings:mode:site') . ' ' . elgg_view('input/select', array( 'name' => 'params[enable_site]', 'value' => $vars['entity']->enable_site, 'options_values' => $no_yes_opt)) . '</label></p>';

	// Enable per-group KDB
	//echo '<p><label>' . elgg_echo('knowledge_database:settings:mode:pergroup') . '&nbsp;: ' . elgg_view('input/select', array( 'name' => 'params[enable_groups]', 'value' => $vars['entity']->enable_groups, 'options_values' => $no_yes_opt)) . '</label></p>';
	//echo '<p><label>' . elgg_echo('knowledge_database:settings:mode:pergroup') . '&nbsp;: ' . elgg_view('input/multiselect', array( 'name' => 'params[enable_groups]', 'value' => $vars['entity']->enable_groups, 'options_values' => $groups_opt)) . '</label></p>';
	echo '<p><label>' . elgg_echo('knowledge_database:settings:mode:pergroup') . ' ' . elgg_view('input/text', array( 'name' => 'params[enable_groups]', 'value' => $vars['entity']->enable_groups)) . '</label><br /><em>' . $groups_list . '</em></p>';


	// Enable merge (when both site + group activated)
	echo '<p><label>' . elgg_echo('knowledge_database:settings:mode:merge') . ' ' . elgg_view('input/select', array( 'name' => 'params[enable_merge]', 'value' => $vars['entity']->enable_merge, 'options_values' => $yes_no_opt)) . '</label><br /><em>' . elgg_echo('knowledge_database:settings:mode:merge:details') . '</em></p>';

	// Enable global search (when both site + group activated)
	echo '<p><label>' . elgg_echo('knowledge_database:settings:globalsearch') . ' ' . elgg_view('input/select', array( 'name' => 'params[globalsearch]', 'value' => $vars['entity']->globalsearch, 'options_values' => $yes_no_opt)) . '</label><br /><em>' . elgg_echo('knowledge_database:settings:globalsearch:details') . '</em></p>';

	// Valid subtypes for KDB objects edit forms + search
	echo '<p><label>' . elgg_echo('knowledge_database:settings:subtypes') . '&nbsp;: ' . elgg_view('input/text', array( 'name' => 'params[kdb_subtypes]', 'value' => $vars['entity']->kdb_subtypes)) . '</label><br /><em>' . elgg_echo('knowledge_database:settings:subtypes:details') . '</em><br /><strong>' . elgg_echo('knowledge_database:settings:default') . '&nbsp;:</strong> <em>' . $kdb_tools_opt . '</em></p>';

	// Valid subtypes for KDB objects edit forms + search
	echo '<p><label>' . elgg_echo('knowledge_database:settings:inputs') . '&nbsp;: ' . elgg_view('input/text', array( 'name' => 'params[kdb_inputs]', 'value' => $vars['entity']->kdb_inputs)) . '</label><br /><em>' . elgg_echo('knowledge_database:settings:inputs:details') . '</em><br /><strong>' . elgg_echo('knowledge_database:settings:default') . '&nbsp;:</strong> <em>' . $kdb_inputs_opt . '</em></p>';

echo '</div>';



// SITE SETTINGS
if ($vars['entity']->enable_site == 'yes') {
	echo '<h3>' . elgg_echo('knowledge_database:settings:fields:site') . '</h3>';
	echo '<div>';

	// KDB Group
	echo '<p><label>' . elgg_echo('knowledge_database:settings:kdb_group') . '&nbsp;: ' . elgg_view('input/groups_select', array( 'name' => 'params[kdb_group]', 'value' => $vars['entity']->kdb_group, 'scope' => 'all')) . '</label></p>';
	
	
	// Define site fields
	echo '<p><label>' . elgg_echo("knowledge_database:settings:fields") . ' ' . elgg_view('input/plaintext', array( 'name' => "params[site_fields]", 'value' => $vars['entity']->site_fields)) . '</label><br /><em>' . elgg_echo('knowledge_database:settings:fields:details') . '</em></p>';
	
	// Add fields to fields config
	$metadatas = esope_get_input_array($vars['entity']->site_fields);
	// Add field to global fields setup
	foreach ($metadatas as $meta_key) {
		// Note : metadata names should respect some standards
		$meta_key = sanitise_string($meta_key);
		$all_metadatas[$meta_key] = $meta_key;
	}
	
	echo '</div>';
}


// PER-GROUP SETTINGS
if ($vars['entity']->enable_groups) {
	$enabled_groups = esope_get_input_array($vars['entity']->enable_groups);
	foreach ($enabled_groups as $guid) {
		if ($ent = get_entity($guid)) {
			echo '<h3>' . elgg_echo('knowledge_database:settings:fields:group', array($ent->name)) . '</h3>';
			echo '<div>';
				$group_setting_name = 'group_fields_' . $guid;
				echo '<p><label>' . elgg_echo("knowledge_database:settings:fields") . ' ' . elgg_view('input/plaintext', array( 'name' => "params[$group_setting_name]", 'value' => $vars['entity']->$group_setting_name)) . '</label><br /><em>' . elgg_echo('knowledge_database:settings:fields:details') . '</em></p>';
				
				// Define groupe fields
				$group_metadatas = esope_get_input_array($vars['entity']->$group_setting_name);
				// Add field to global fields setup
				foreach ($group_metadatas as $meta_key) {
					// Note : metadata names should respect some standards
					$meta_key = sanitise_string($meta_key);
					$all_metadatas[$meta_key] = $meta_key;
				}
				
			echo '</div>';
		}
	}
}


// FIELDS CONFIG
echo '<h3>' . elgg_echo('knowledge_database:settings:fields', array($ent->name)) . '</h3>';
echo '<div>';
	// Important notice before editing fields
	echo '<p><blockquote>' . elgg_echo('knowledge_database:settings:fields:config') . '</blockquote></p>';
	
	// Set up all metadata fields config (globally)
	foreach ($all_metadatas as $meta_key) {
		echo knowledge_database_define_field_config($meta_key);
	}
	
	// Save full fields list - very useful for actions particularly
	$vars['entity']->all_fields = implode(', ', $all_metadatas);
	
echo '</div>';


echo '</div>';


