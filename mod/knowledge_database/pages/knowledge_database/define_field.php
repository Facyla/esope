<?php
/**
 * Knowledge Database public fields definition
 *
 */
global $CONFIG;

admin_gatekeeper();

$name = get_input('name', false);
if ($name) {
	
	$yes_no_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no') );
	$no_yes_opt = array_reverse($yes_no_opt, true);
	
	$config = elgg_get_plugin_setting('field_' . $name, 'knowledge_database');
	$config = unserialize($config);
	
	// Convert fields values to form-compliant values
	if ($config['read'] === true) $config['read'] = 'yes';
	else if ($config['read'] === false) $config['read'] = 'no';
	else $config['read'] = esope_set_input_recursive_array($config['read'], array("|", '::', ','));
	
	if ($config['edit'] === true) $config['edit'] = 'yes';
	else if ($config['edit'] === false) $config['edit'] = 'no';
	else $config['edit'] = esope_set_input_recursive_array($config['read'], array("|", '::', ','));
	
	if ($config['params']['required'] === true) $config['params']['required'] = 'yes'; else $config['params']['required'] = 'no';
	if ($config['params']['multiple'] === true) $config['params']['multiple'] = 'yes'; else $config['params']['multiple'] = 'no';
	if ($config['params']['autocomplete'] === true) $config['params']['autocomplete'] = 'yes'; else $config['params']['autocomplete'] = 'no';
	
	if ($config['params']['options_values']) $config['params']['options_values'] = esope_build_options_string($config['params']['options_values'], 'knowledge_database:key');
	
	
	// Set default options if needed and available (separators are "\n" or "|", optional name-value separator i "::")
	if (empty($config['params']['options_values'])) {
		$default_opts = elgg_echo("knowledge_database:default:$name");
		if ($default_opts == "knowledge_database:default:$name") $default_opts = '';
		if (!empty($default_opts)) $config['params']['options_values'] = $default_opts;
	}
	
	
	// BUILD THE FORM
	echo '<div class="knowledge_database-edit-field">';
	
	$action_base = $CONFIG->url . 'action/knowledge_database/';
	$kdb_define_field_url = $action_base . 'define_field' . $action_token;
	$kdb_define_field_url = elgg_add_action_tokens_to_url($kdb_define_field_url);
	
	echo '<script>
	var formdata;
	function kdb_define_field(){
		$("body").addClass("esope-search-wait");
		formdata = $("#kdb-define-field-form").serialize();
		$.post("' . $kdb_define_field_url . '", formdata, function(data){
			$("#kdb-define-field-result").html(data);
			if (data ==  "OK") {
				elgg.system_message("OK ! Configuration enregistrée");
				parent.$.fancybox.close();
			} else {
				elgg.register_error("Error, could not save data. Please reload page and try again.");
			}
			$("body").removeClass("esope-search-wait");
		});
	}
	</script>';
	
	echo '<form id="kdb-define-field-form" action="javascript:kdb_define_field();" method="POST">';
	echo '<h3>' . elgg_echo('knowledge_database:settings:field:edit', array($name)) . '</h3>';
	echo elgg_view('input/hidden', array('name' => 'name', 'value' => $name));
	echo '<p><blockquote>' . elgg_echo('knowledge_database:settings:field:edit:details') . '</blockquote></p>';
	echo '<p><label>Field title ' . elgg_view('input/text', array('name' => 'title', 'value' => $config['title'])) . '</label></p>';
	echo '<p>
			<label>Field type ' . elgg_view('input/text', array('name' => 'type', 'value' => $config['type'])) . '</label> &nbsp; 
			<label>Category ' . elgg_view('input/text', array('name' => 'category', 'value' => $config['category'])) . '</label>
		</p>';
	echo '<p><label>Read ' . elgg_view('input/text', array('name' => 'read', 'value' => $config['read'])) . '</label> &nbsp; 
			<label>Edit ' . elgg_view('input/text', array('name' => 'edit', 'value' => $config['edit'])) . '</label>
		</p>';
	echo '<p>' . elgg_echo('knowledge_database:settings:actions:details') . '</p>';
	echo '<p>';
	echo '<label>Required ' . elgg_view('input/dropdown', array('name' => 'required', 'value' => $config['params']['required'], 'options_values' => $no_yes_opt)) . '</label> &nbsp; ';
	echo '<label>Multiple ' . elgg_view('input/dropdown', array('name' => 'multiple', 'value' => $config['params']['multiple'], 'options_values' => $no_yes_opt)) . '</label> &nbsp; ';
	echo '<label>Autocomplete ' . elgg_view('input/dropdown', array('name' => 'autocomplete', 'value' => $config['params']['autocomplete'], 'options_values' => $no_yes_opt)) . '</label> &nbsp; ';
	echo '<label>Default value ' . elgg_view('input/text', array('name' => 'default', 'value' => $config['params']['default'])) . '</label>';
	echo '</p>';
	// Important notice before editing fields
	echo '<p><blockquote>' . elgg_echo('knowledge_database:settings:fields:notice') . '</blockquote></p>';
	echo '<p><label>Options values ' . elgg_view('input/plaintext', array('name' => 'options_values', 'value' => $config['params']['options_values'])) . '</label></p>';
	
	echo elgg_view('input/submit', array('value' => "Enregistrer la configuration"));
	echo '</form>';
	echo '<div id="kdb-define-field-result"></div>';
	echo '</div>';
	
}


