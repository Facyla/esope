<?php
/**
* Plugin main output page
* 
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Florian DANIEL aka Facyla
* @copyright Florian DANIEL aka Facyla 2016
* @link http://facyla.fr/
*/

$title = elgg_echo('citadel_converter:title');

$sidebar = '';

$content = '';

$base_url = elgg_get_site_url() . 'citadel_converter/';
$datapath = elgg_get_data_path() . 'citadel_converter/';

$content .= elgg_echo('citadel_converter:description');

elgg_push_breadcrumb(elgg_echo('citadel_converter:title'));


// Select options
$format_opt = array('citadel' => "Citadel JSON", 'geojson' => "geoJSON");
$import_format_opt = array(
		'csv' => "CSV",
		'geojson' => "geoJSON",
		'osmjson' => "OSM JSON",
	);


$source = get_input('source', $base_url . 'samples/dataset.csv');
$filename = get_input('filename', '');
$format = get_input('format', 'citadel');
$import_format = get_input('import', 'csv');
$remote_template = get_input('remote_template');
$serialized_template = get_input('serialized_template');
// Set default only if no value specified for *both* fields
if (empty($remote_template) && empty($serialized_template)) {
	$remote_template = $base_url . 'samples/template.txt';
}


// Links to converted file
if (!empty($source)) {
	$download_url = $base_url . 'convert/?source=' . urlencode($source) . '&filename=' . urlencode($filename) . '&remote_template=' . urlencode($remote_template) . '&serialized_template=' . urlencode($serialized_template) . '&format=' . urlencode($format) . '&import=' . urlencode($import_format);
	$download_shorturl_name = $datapath . 'urldata/' . md5($download_url);
	$download_shorturl = $base_url . 'convert/?u=' . md5($download_url);
	if (!file_exists($download_shorturl_name)) {
		citadel_converter_write_file($download_shorturl_name, $download_url);
	}
	//citadel_converter_get_file($url)
	$content .= '<blockquote>
		<p><a href="' . $download_url . '">' . elgg_echo('citadel_converter:download:file') . '</a></p>
		<p>' . elgg_echo('citadel_converter:download:link') . '<br /><pre>' . $download_url . '</pre></p>
		<p>' . elgg_echo('citadel_converter:download:shortlink') . '<br /><pre><a href="' . $download_shorturl . '">' . $download_shorturl . '</a></pre></p>
	</blockquote><br />';
}


// Converter form
$content .= '<form method="POST" id="citadel-converter-convert">';
$content .= '<fieldset><legend>' . elgg_echo('citadel_converter:form') . '</legend>';

// Conversion data
$content .= '<div style="width:45%; float:left;" class="static-container">';
	$content .= '<p><label>' . elgg_echo('citadel_converter:form:source') . elgg_view('input/text', array('name' => 'source', 'value' => $source)) . '</label></p>';

	$content .= '<p><label>' . elgg_echo('citadel_converter:form:filename') . elgg_view('input/text', array('name' => 'filename', 'value' => $filename)) . '</label></p>';
	
	$content .= '<p><label>' . elgg_echo('citadel_converter:form:import') . elgg_view('input/dropdown', array('name' => 'import', 'options_values' => $import_format_opt, 'value' => $import_format)) . '</p>';

	$content .= '<p><label>' . elgg_echo('citadel_converter:form:format') . elgg_view('input/dropdown', array('name' => 'format', 'options_values' => $format_opt, 'value' => $format)) . '</p>';
$content .= '</div>';

// Conversion template
$content .= '<div style="width:45%; float:right;" class="static-container">';
	$content .= '<p><label>' . elgg_echo('citadel_converter:form:template') . elgg_view('input/text', array('name' => 'remote_template', 'value' => $remote_template)) . '</label></p>';
	$content .= '<p><label>' . elgg_echo('citadel_converter:form:serialized_template') . elgg_view('input/plaintext', array('name' => 'serialized_template', 'style' => "width:90%; height:5ex;", 'value' => $serialized_template)) . '</label></p>';
$content .= '</div>';

// Submit button
$content .= '<p style="clear:both;">' . elgg_view('input/submit', array('value' => elgg_echo('citadel_converter:form:givelink'), 'class' => 'elgg-button elgg-button-submit')) . '</p>';

$content .= '</fieldset>';
$content .= '</form>';



// Use inner layout (one_sidebar, one_column, content, etc.)
$body = elgg_view_layout('one_sidebar', array('title' => $title, 'content' => $content, 'sidebar' => $sidebar));

// Render the page
echo elgg_view_page($title, $body);

