<?php
// Automatic mode
//echo esope_esearch(array('count' => true));


$name = get_input('name');
if (empty($name)) {
	echo "ERROR";
	exit;
}

// Get fields config
$title = get_input('title', false);
$type = get_input('type', 'text');
$category = get_input('category');
$read = get_input('read');
$edit = get_input('edit');
$required = get_input('required');
$multiple = get_input('multiple');
$autocomplete = get_input('autocomplete');
$default = get_input('default');
$options_values = get_input('options_values');
$addempty = get_input('addempty');

// Set defaults
if (empty($type)) { $type = 'text'; }
if (empty($category)) { $category = 'default'; }
if (empty($read)) { $read = 'yes'; }
if (empty($edit)) { $edit = 'yes'; }
if (empty($required)) { $required = 'no'; }
if (empty($multiple)) { $multiple = 'no'; }
if (empty($autocomplete)) { $autocomplete = 'no'; }
if (empty($default)) { $default = ''; }
if (empty($options_values)) { $options_values = ''; }
if (empty($addempty)) { $addempty = 'no'; }

// Transform some inputs before building config
// Syntax : role1,role2(step1,step2, step3),role3(step1,step2)

if ($read == 'yes') {
	$read_config = true;
} else if ($read == 'no') {
	$read_config = false;
} else {
	$read_config = esope_get_input_recursive_array($read, array(array("\r", "\t", "|"), '::', ','));
	//echo '<pre>' . print_r($read_config, true) . '</pre>';
}

if ($edit == 'yes') {
	$edit_config = true;
} else if ($edit == 'no') {
	$edit_config = false;
} else {
	$edit_config = esope_get_input_recursive_array($edit, array(array("\r", "\t", "|"), '::', ','));
}

if ($required == 'yes') { $required = true; } else { $required = false; }
if ($multiple == 'yes') { $multiple = true; } else { $multiple = false; }
if ($autocomplete == 'yes') { $autocomplete = true; } else { $autocomplete = false; }
if ($addempty == 'yes') { $addempty = true; } else { $addempty = false; }

// Syntax : key1::value1 | key2::value2
if ($options_values) {
	$options_values = esope_build_options($options_values, $addempty, 'knowledge_database:key');
}

$config = array(
	'title' => $title,
	// input/output field types (both views should exist, or at least input)
	'type' => $type,
	// fieldset
	'category' => $category,
	// roles who can read this field : see Roles config above
	/*
	Roles config :
	Roles can be passed as a parameter to the rendering function, and can be derived from any data on the platform 
	E.g. roles can be defined from profile type, context, custom list, etc.
	Allowed values for field are :
	 - true/false for all (not set means false)
	 - array('role1', 'role2') for limited roles (only these are allowed)
	 - array('role1' => array('step1', 'step2')) for limited roles, on specific workflow steps
	Note : workflow steps are based on the current state of $entity->workflow value
	*/
	'read' => $read_config,
	// roles which can edit this field : same as read options
	'edit' => $edit_config,
	
	// Other options for input
	'params' => array(
		// is the field required
		'required' => $required,
		// is the field multiple
		'multiple' => $multiple,
		// is autocompletion enabled (applies to single text inputs)
		'autocomplete' => $autocomplete,
		// add empty option to input select
		'addempty' => $addempty,
		// Default value if none set
		'default' => $default,
		/* Options for dropdowns :
		 * Allowed separators are new lines, or |
		 *    E.g.: metadata1 | metadata2 | ...
		 * Values can be keys only, or key::value (but remain consistent !)
		 * Use an empty string to add an empty field
		 *    E.g.: ::No value | metadata1::Clear name | metadata2::Other name | ...
		 * Translation can be defined with regular translation strings :
		 *    E.g.: "knowledge_database:field:$name" => "Translation name"
		 */
		'options_values' => $options_values,
	),
);

/* Debug tests
echo "TEST = " . knowledge_database_field_access($config, 'read', 'admin', false) . '<br />';
echo "TEST = " . knowledge_database_field_access($config, 'read', 'public', false) . '<br />';
echo "TEST = " . knowledge_database_field_access($config, 'read', 'user', false) . '<br />';
*/

//echo '<pre>' . print_r($config, true) . '</pre>';


$config = serialize($config);

// Note : any return other than "OK" will be considered as an error.
if (elgg_set_plugin_setting('field_' . $name, $config, 'knowledge_database')) {
	echo "OK";
	exit;
}

echo "ERROR";
exit;

