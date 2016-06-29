<?php
/**
 * Knowledge Database fields definition
 *
 */
$url = elgg_get_site_url();

admin_gatekeeper();

$name = get_input('name', false);
if (!$name) { return; }

$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
$no_yes_opt = array_reverse($yes_no_opt, true);

// Get field config
$config = elgg_get_plugin_setting('field_' . $name, 'knowledge_database');
$config = unserialize($config);

$field_types = knowledge_database_get_field_types();
$field_type_opt = array();
foreach ($field_types as $type) {
	$field_type_opt[$type] = $type;
}

// Set defaults
if (!isset($config['title'])) { $config['title'] = $name; }
if (!isset($config['type'])) { $config['type'] = ''; }
if (!isset($config['read'])) { $config['read'] = true; }
if (!isset($config['edit'])) { $config['edit'] = true; }
if (!isset($config['category'])) { $config['category'] = 'default'; }
if (!isset($config['params']['required'])) { $config['params']['required'] = false; }
if (!isset($config['params']['multiple'])) { $config['params']['multiple'] = false; }
if (!isset($config['params']['default'])) { $config['params']['default'] = ''; }
if (!isset($config['params']['autocomplete'])) { $config['params']['autocomplete'] = false; }
// Options : separators are "\n" or "|", optional name-value separator i "::")
if (!isset($config['params']['options_values'])) { $config['params']['options_values'] = ''; }

/*
if ($config['params']['required'] === true) $config['params']['required'] = 'yes'; else $config['params']['required'] = 'no';
if ($config['params']['multiple'] === true) $config['params']['multiple'] = 'yes'; else $config['params']['multiple'] = 'no';
if ($config['params']['autocomplete'] === true) $config['params']['autocomplete'] = 'yes'; else $config['params']['autocomplete'] = 'no';

if ($config['params']['options_values']) $config['params']['options_values'] = esope_build_options_string($config['params']['options_values'], 'knowledge_database:key');
*/

// Convert fields values to form-compliant values
if ($config['read'] === true) {
	$config['read'] = 'yes';
} else if ($config['read'] === false) {
	$config['read'] = 'no';
} else {
	$config['read'] = esope_set_input_recursive_array($config['read'], array("|", '::', ','));
}

if ($config['edit'] === true) {
	$config['edit'] = 'yes';
} else if ($config['edit'] === false) {
	$config['edit'] = 'no';
} else {
	$config['edit'] = esope_set_input_recursive_array($config['read'], array("|", '::', ','));
}

if ($config['params']['required'] === true) { $config['params']['required'] = 'yes'; } else { $config['params']['required'] = 'no'; }
if ($config['params']['multiple'] === true) { $config['params']['multiple'] = 'yes'; } else { $config['params']['multiple'] = 'no'; }
if ($config['params']['autocomplete'] === true) { $config['params']['autocomplete'] = 'yes'; } else { $config['params']['autocomplete'] = 'no'; }
if ($config['params']['addempty'] === true) { $config['params']['addempty'] = 'yes'; } else { $config['params']['addempty'] = 'no'; }

// Format readable options list
if ($config['params']['options_values']) {
	$config['params']['options_values'] = esope_build_options_string($config['params']['options_values'], 'knowledge_database:key', "\n");
} else if (!isset($config['params']['options_values'])) {
// Init default options (defined in translation files)
	$default_opts = elgg_echo("knowledge_database:default:$name");
	if ($default_opts == "knowledge_database:default:$name") { $default_opts = ''; }
	if (!empty($default_opts)) { $config['params']['options_values'] = $default_opts; }
}


$kdb_define_field_url = elgg_add_action_tokens_to_url($url . 'action/knowledge_database/define_field');
// RENDER THE FIELD EDIT FORM
echo '<div class="knowledge_database-edit-field">';

	echo '<script>
	var formdata;
	function kdb_define_field(){
		$("body").addClass("esope-search-wait");
		formdata = $("#kdb-define-field-form").serialize();
		$.post("' . $kdb_define_field_url . '", formdata, function(data){
			$("#kdb-define-field-result").html(data);
			if (data ==  "OK") {
					elgg.system_message("' . elgg_echo('knowledge_database:define_field:success') . '");
				parent.$.fancybox.close();
			} else {
					elgg.register_error("' . elgg_echo('knowledge_database:define_field:error') . '");
			}
			$("body").removeClass("esope-search-wait");
		});
	}
	</script>';

		// Render field edit form
	echo '<form id="kdb-define-field-form" action="javascript:kdb_define_field();" method="POST">';
		echo '<h3>' . elgg_echo('knowledge_database:settings:field:edit', array($name)) . '</h3>';
		echo elgg_view('input/hidden', array('name' => 'name', 'value' => $name));

		echo '<p><blockquote>' . elgg_echo('knowledge_database:settings:field:edit:details') . '</blockquote></p>';

		echo '<p><label>' . elgg_echo('knowledge_database:settings:field:title') . ' ' . elgg_view('input/text', array('name' => 'title', 'value' => $config['title'])) . '</label></p>';

		echo '<p><label>' . elgg_echo('knowledge_database:settings:field:tooltip') . ' ' . elgg_echo('knowledge_database:settings:field:tooltip:details') . '</label></p>';
		echo '<p>';
			//echo '<label>' . elgg_echo('knowledge_database:settings:field:type') . ' ' . elgg_view('input/text', array('name' => 'type', 'value' => $config['type'])) . '</label> &nbsp; ';
			echo '<label>' . elgg_echo('knowledge_database:settings:field:type') . ' ' . elgg_view	('input/dropdown', array('name' => 'type', 'value' => $config['type'], 'options_values' => $field_type_opt)) . '</label> &nbsp; ';
			echo '<label>' . elgg_echo('knowledge_database:settings:field:category') . ' ' . elgg_view('input/text', array('name' => 'category', 'value' => $config['category'])) . '</label>';
		echo '</p>';

	echo '<p>';
		echo '<label>' . elgg_echo('knowledge_database:settings:field:read') . ' ' . elgg_view('input/text', array('name' => 'read', 'value' => $config['read'])) . '</label> &nbsp; ';
		echo '<label>' . elgg_echo('knowledge_database:settings:field:write') . ' ' . elgg_view('input/text', array('name' => 'edit', 'value' => $config['edit'])) . '</label>';
	echo '</p>';

echo '<p>' . elgg_echo('knowledge_database:settings:actions:details') . '</p>';

		echo '<p>';
			echo '<label>' . elgg_echo('knowledge_database:settings:field:required') . ' ' . elgg_view('input/dropdown', array('name' => 'required', 'value' => $config['params']['required'], 'options_values' => $no_yes_opt)) . '</label> &nbsp; ';
			echo '<label>' . elgg_echo('knowledge_database:settings:field:multiple') . ' ' . elgg_view('input/dropdown', array('name' => 'multiple', 'value' => $config['params']['multiple'], 'options_values' => $no_yes_opt)) . '</label> &nbsp; ';
			echo '<label>' . elgg_echo('knowledge_database:settings:field:autocomplete') . ' ' . elgg_view('input/dropdown', array('name' => 'autocomplete', 'value' => $config['params']['autocomplete'], 'options_values' => $no_yes_opt)) . '</label> &nbsp; ';
			echo '<label>' . elgg_echo('knowledge_database:settings:field:addempty') . ' ' . elgg_view('input/select', array('name' => 'addempty', 'value' => $config['params']['addempty'], 'options_values' => $no_yes_opt)) . '</label> &nbsp; ';
			echo '<label>' . elgg_echo('knowledge_database:settings:field:defaultvalue') . ' ' . elgg_view('input/text', array('name' => 'default', 'value' => $config['params']['default'])) . '</label>';
		echo '</p>';

		// Important notice before editing fields
		echo '<p><blockquote>' . elgg_echo('knowledge_database:settings:fields:notice') . '</blockquote></p>';
		echo '<p><label>' . elgg_echo('knowledge_database:settings:field:options_values') . ' ' . elgg_view('input/plaintext', array('name' => 'options_values', 'value' => $config['params']['options_values'])) . '</label></p>';

		echo elgg_view('input/submit', array('value' => elgg_echo('knowledge_database:settings:field:save') . ""));

	echo '</form>';

	echo '<div id="kdb-define-field-result"></div>';

echo '</div>';

