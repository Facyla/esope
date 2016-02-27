<?php
/**
* Plugin main template generator page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2016
* @link http://facyla.fr/
*/

$title = elgg_echo('citadel_converter:tplgen:title');

$sidebar = '';

$content = '';

$base_url = elgg_get_site_url() . 'citadel_converter/';


$content .= elgg_echo('citadel_converter:tplgen:description');

//elgg_push_breadcrumb(elgg_echo('citadel_converter:tplgen:title'), 'citadel_converter/template');
elgg_push_breadcrumb(elgg_echo('citadel_converter:tplgen:title'));

$action = get_input('action', '');
$load_template = get_input('load_template', false);

// Select options
$skip_first_row_opt = array('yes' => elgg_echo('citadel_converter:tplgen:firstline:yes'), 'no' => elgg_echo('citadel_converter:tplgen:firstline:no'));
$action_opt = array('generate' => elgg_echo('citadel_converter:tplgen:action:generate'), 'export' => elgg_echo('citadel_converter:tplgen:action:export'));


// Paramètres configurables
// Liste des paramètres
//$params_options = array('skip-first-row', 'delimiter', 'enclosure', 'escape');

if (!empty($load_template)) {
	//$content .= "Loading existing template...<br />";
	// Load_existing template;
	$template = unserialize(base64_decode(trim($load_template)));
	
	//$content .= '<pre>' . print_r($template, true) . '</pre>';
	$skip_first_row = $template['skip-first-row'];
	$delimiter = $template['delimiter'];
	$enclosure = $template['enclosure'];
	$escape = $template['escape'];
	$dataset_id = $template['metadata']['dataset-id'];
	$dataset_lang = $template['metadata']['dataset-lang'];
	$dataset_author_id = $template['metadata']['dataset-author-id'];
	$dataset_author_name = $template['metadata']['dataset-author-name'];
	$dataset_license_url = $template['metadata']['dataset-license-url'];
	$dataset_license_term = $template['metadata']['dataset-license-term'];
	$dataset_source_url = $template['metadata']['dataset-source-url'];
	$dataset_source_term = $template['metadata']['dataset-source-term'];
	$dataset_update_frequency = $template['metadata']['dataset-update-frequency'];
	// Mapping
	$dataset_poi_category_default = $template['mapping']['dataset-poi-category-default'];
	$dataset_poi_id = $template['mapping']['dataset-poi-id'];
	$dataset_poi_title = $template['mapping']['dataset-poi-title'];
	$dataset_poi_description = $template['mapping']['dataset-poi-description'];
	$dataset_poi_category = $template['mapping']['dataset-poi-category'];
	$dataset_poi_lat = $template['mapping']['dataset-poi-lat'];
	$dataset_poi_long = $template['mapping']['dataset-poi-long'];
	$dataset_coordinate_system = $template['mapping']['dataset-coordinate-system'];
	$dataset_poi_address = $template['mapping']['dataset-poi-address'];
	$dataset_poi_postal = $template['mapping']['dataset-poi-postal'];
	$dataset_poi_city = $template['mapping']['dataset-poi-city'];
	//$content .= "License : $dataset_license_url";
	
} else {
	$skip_first_row = get_input('skip-first-row', 'yes');
	//if ($skip_first_row == 'yes') { $skip_first_row = true; } else { $skip_first_row = false; }
	$delimiter = get_input('delimiter', ';');
	$enclosure = get_input('enclosure', '"');
	$escape = get_input('escape', '\\');
	$dataset_id = get_input('dataset_id', '');
	$dataset_lang = get_input('dataset_lang', 'fr_FR');
	$dataset_author_id = get_input('dataset_author_id', '');
	$dataset_author_name = get_input('dataset_author_name', '');
	$dataset_license_url = get_input('dataset_license_url', '');
	$dataset_license_term = get_input('dataset_license_term', 'CC-BY');
	$dataset_source_url = get_input('dataset_source_url', '');
	$dataset_source_term = get_input('dataset_source_term', 'source');
	$dataset_update_frequency = get_input('dataset_update_frequency', 'semester');
	// Mapping
	$dataset_poi_category_default = get_input('dataset_poi_category_default', '');
	$dataset_poi_id = get_input('dataset_poi_id', '');
	$dataset_poi_title = get_input('dataset_poi_title', 'Titre');
	$dataset_poi_description = get_input('dataset_poi_description', 'Description');
	$dataset_poi_category = get_input('dataset_poi_category', 'Catégorie1');
	$dataset_poi_lat = get_input('dataset_poi_lat', 'Latitude');
	$dataset_poi_long = get_input('dataset_poi_long', 'Longitude');
	$dataset_coordinate_system = get_input('dataset_coordinate_system', 'WGS84');
	$dataset_poi_address = get_input('dataset_poi_address', 'Adresse');
	$dataset_poi_postal = get_input('dataset_poi_postal', 'Codepostal');
	$dataset_poi_city = get_input('dataset_poi_city', 'Ville');
}



// Generate a template
if (in_array($action, array('generate', 'export'))) {
	$template = array(
		// Set to true if the first line of data contains the lables (titles of columns)
		// Set to false if the data starts immediately
		// See also mapping, as this setting has an impact on how the mapping is made
		'skip-first-row' => $skip_first_row,
		// Common delimiters are : ",", ";", "\t", "|" and " " (comma, period, tabulation, pipe and space)
		'delimiter' => $delimiter,
		// Enclosure is the character used to enclose values
		// Common enclosure are : "'", "\"" (single or double quote)
		'enclosure' => $enclosure,
		// Escape is the character used to escape special characters 
		// (such as the ones used for enclosure or as delimiter)
		// Common escape character should not be changed : "\\"
		'escape' => $escape, 
		// Metadata are the values that will describe the entire dataset
		'metadata' => array(
			'dataset-id' => $dataset_id, // A unique id for the dataset
			'dataset-lang' => $dataset_lang, // ISO code of the dataset language
			'dataset-author-id' => $dataset_author_id, // A unique ID for the author (optional)
			'dataset-author-name' => $dataset_author_name, // The author name (optional)
			'dataset-license-url' => $dataset_license_url, // Dataset license URL (optional)
			'dataset-license-term' => $dataset_license_term, // Dataset license term (optional)
			'dataset-source-url' => $dataset_source_url, // Dataset source URL (where is located the input file - optional)
			'dataset-source-term' => $dataset_source_term, // Dataset source term (should not be changed)
			'dataset-update-frequency' => $dataset_update_frequency, // Dataset update frequency (change only if you know why !)
		),
		// The following describes each row of the dataset = POI = Point Of Interest = marker on the map
		// Mapping is the semantic process that will tie a specific column to a Citadel-JSON field
		// Mapping keys should not be changed (except if the Citadel-JSON format evolves)
		// Mapping values can take 2 forms, depending on 'skip-first-row' setting :
		// If set to true : values should be the "title colums", ie the labels of the CSV table
		// If set to false : values should be the index numbers of the columns, ie 1 less than the column number.
		//     Example : if you have 10 columns (from 1 to 10), the corresponding index will range from 0 to 9
		//     If you data start with a title, you should indicate '0' as the value for the 'dataset-poi-title' key
		'mapping' => array(
			'dataset-poi-category-default' => $dataset_poi_category_default, // Default category for the POI = ataset license URL (optional)
			'dataset-poi-id' => $dataset_poi_id, // A Unique ID for the POI (optional)
			'dataset-poi-title' => $dataset_poi_title,
			'dataset-poi-description' => $dataset_poi_description,
			'dataset-poi-category' => $dataset_poi_category,
			'dataset-poi-lat' => $dataset_poi_lat,
			'dataset-poi-long' => $dataset_poi_long,
			'dataset-coordinate-system' => $dataset_coordinate_system,
			'dataset-poi-address' => $dataset_poi_address,
			'dataset-poi-postal' => $dataset_poi_postal,
			'dataset-poi-city' => $dataset_poi_city,
		),
	);

	$serialized_template = base64_encode(serialize($template));
	// Output the template in a form which can be fetched from a remote server
	if ($action == 'export') {
		echo $serialized_template;
		exit;
	}
}



// Template serialized data
if (isset($serialized_template)) {
$content .= '<h2>' . elgg_echo('citadel_converter:tplgen:output') . '</h2>
	<blockquote>
		<textarea readonly="readonly" style="width:90%; height:120px;">' . $serialized_template . '</textarea>
	</blockquote>
	<br />';
}


// Template generation form
$content .= '<h2>' . elgg_echo('citadel_converter:tplgen:form') . '</h2>';
$content .= '<form method="POST" id="citadel-converter-template">';

// CSV settings
$content .= '<fieldset><legend>' . elgg_echo('citadel_converter:tplgen:legend:technical') . '</legend>';
	$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:firstline') . ' ' . elgg_view('input/dropdown', array('name' => 'skip_first_row', 'options_values' => $skip_first_row_opt, 'value' => $skip_first_row)) . '</label></p>';

	$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:delimiter') . ' ' . elgg_view('input/text', array('name' => 'delimiter', 'value' => htmlentities($delimiter, ENT_QUOTES))) . '</label></p>';

	$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:enclosure') . ' ' . elgg_view('input/text', array('name' => 'enclosure', 'value' => htmlentities($enclosure, ENT_QUOTES))) . '</label></p>';

	$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:escape') . '' . elgg_view('input/text', array('name' => 'escape', 'value' => htmlentities($escape, ENT_QUOTES))) . '</label></p>';
$content .= '</fieldset><br /><br />';


// Export file metadata
$content .= '<fieldset><legend>' . elgg_echo('citadel_converter:tplgen:legend:metadata') . '</legend>';
	$content .= '<div style="width:45%; float:left;" class="static-container">';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:dataset_id') . ' ' . elgg_view('input/text', array('name' => 'dataset_id', 'value' => $dataset_id)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:dataset_lang') . ' ' . elgg_view('input/text', array('name' => 'dataset_lang', 'value' => $dataset_lang)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:authorid') . ' ' . elgg_view('input/text', array('name' => 'dataset_author_id', 'value' => $dataset_author_id)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:authorname') . ' ' . elgg_view('input/text', array('name' => 'dataset_author_name', 'value' => $dataset_author_name)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:updatefreq') . ' ' . elgg_view('input/text', array('name' => 'dataset_update_frequency', 'value' => $dataset_update_frequency)) . '</label></p>';
	$content .= '</div>';
	$content .= '<div style="width:45%; float:right;" class="static-container">';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:licenceurl') . ' ' . elgg_view('input/text', array('name' => 'dataset_license_url', 'value' => $dataset_license_url)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:licenceterm') . ' ' . elgg_view('input/text', array('name' => 'dataset_license_term', 'value' => $dataset_license_term)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:sourceurl') . ' ' . elgg_view('input/text', array('name' => 'dataset_source_url', 'value' => $dataset_source_url)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:sourceterm') . ' ' . elgg_view('input/text', array('name' => 'dataset_source_term', 'value' => $dataset_source_term)) . '</label></p>';
	$content .= '</div>';
$content .= '</fieldset><br /><br />';


// Fields mappings
$content .= '<fieldset><legend>' . elgg_echo('citadel_converter:tplgen:legend:semantic') . '</legend>';
	$content .= '<div style="width:45%; float:left;" class="static-container">';
		$content .= '<p><strong>' . elgg_echo('citadel_converter:tplgen:legend:display') . '</strong></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:poi_default_cat') . ' ' . elgg_view('input/text', array('name' => 'dataset_poi_category_default', 'value' => $dataset_poi_category_default)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:poi_id') . ' ' . elgg_view('input/text', array('name' => 'dataset_poi_id', 'value' => $dataset_poi_id)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:poi_title') . ' ' . elgg_view('input/text', array('name' => 'dataset_poi_title', 'value' => $dataset_poi_title)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:poi_descr') . ' ' . elgg_view('input/text', array('name' => 'dataset_poi_description', 'value' => $dataset_poi_description)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:poi_cat') . ' ' . elgg_view('input/text', array('name' => 'dataset_poi_category', 'value' => $dataset_poi_category)) . '</label></p>';
	$content .= '</div>';
	$content .= '<div style="width:45%; float:right;" class="static-container">';
		$content .= '<p><strong>' . elgg_echo('citadel_converter:tplgen:legend:geo') . '</strong></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:lat') . ' ' . elgg_view('input/text', array('name' => 'dataset_poi_lat', 'value' => $dataset_poi_lat)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:long') . ' ' . elgg_view('input/text', array('name' => 'dataset_poi_long', 'value' => $dataset_poi_long)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:geosystem') . ' ' . elgg_view('input/text', array('name' => 'dataset_coordinate_system', 'value' => $dataset_coordinate_system)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:address') . ' ' . elgg_view('input/text', array('name' => 'dataset_poi_address', 'value' => $dataset_poi_address)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:postalcode') . ' ' . elgg_view('input/text', array('name' => 'dataset_poi_postal', 'value' => $dataset_poi_postal)) . '</label></p>';
		$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:city') . ' ' . elgg_view('input/text', array('name' => 'dataset_poi_city', 'value' => $dataset_poi_city)) . '</label></p>';
	$content .= '</div>';
$content .= '</fieldset>';


// Action to perform
$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:action') . ' ' . elgg_view('input/dropdown', array('name' => 'action', 'options_values' => $action_opt, 'value' => $action)) . '</label></p>';

// Submit button
$content .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('citadel_converter:tplgen:submit'), 'class' => 'elgg-button elgg-button-submit')) . '</p>';

$content .= '</form>';



// IMPORT TEMPLATE
$content .= '<div class="clearfloat"></div><br />';
$content .= '<h2>' . elgg_echo('citadel_converter:tplgen:legend:import') . '</h2>';
$content .= '<form method="POST">';
$content .= '<p><label>' . elgg_echo('citadel_converter:tplgen:import') . ' ' . elgg_view('input/plaintext', array('name' => 'load_template', 'style' => "width:100%; height:20ex;")) . '</label></p>';
$content .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('citadel_converter:tplgen:submit'), 'class' => 'elgg-button elgg-button-submit')) . '</p>';
$content .= '</form>';




// Use inner layout (one_sidebar, one_column, content, etc.)
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

