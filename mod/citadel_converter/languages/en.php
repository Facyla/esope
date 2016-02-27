<?php

$url = elgg_get_site_url();

return array(
	'citadel_converter' => "CSV and JSON data converter",
	
	'citadel_converter:error:nofileselected' => "No file selected",
	'citadel_converter:error:nofileuploaded' => "No file uploaded",
	'citadel_converter:error:upload' => "Error uploading dataset. Please try again.",
	'citadel_converter:error:upload:system' => "System error uploading dataset.",
	'citadel_converter:error:toobig' => "Dataset cannot be uploaded because it's too big.",
	'citadel_converter:error:nodataset' => "No Dataset settings selected",
	'citadel_converter:error:missingconversionsettings' => "No Conversion settings selected",
	'citadel_converter:error:nofilefound' => "We've got a problem : no file found !",
	
	// Index file
	'citadel_converter:title' => "CSV to Citadel JSON converter",
	'citadel_converter:description' => "<p>This PHP converter library is meant to be used as a service that can convert CSV files to Citadel-JSON files on the fly.</p>
			<p>It includes the following services:</p>
			<ul>
				<li>convert : a converting API, used to convert CSV files to Citadel-JSON. The form below facilitates its use.</li>
				<li>template : a conversion template generator, that can be used to generate a new conversion template which can then be provided to the converting API.</li>
			</ul>
			<br />
			<h2>Step 1: Prepare and publish your CSV file</h2>
			<p>Preparing the CSV file is not part of that tool. The CSV file should contain at least the geographical coordinates (latitude and longitude) and a title. Publish the file anywhere it can be accessed by a web address (URL). Using a public datastore is recommended.</p>
			<br /><br />
			<h2>Step 2: Use the template generator</h2>
			<p><a href=\"" . $url . "template\" target=\"_blank\">Open the template generator in a new window</a></p>
			<p>The CSV fields needs to be mapped to Citadel JSON fields, which are designed to be easily displayed into a mobile application. The converter can be configured with a PHP array, but this tool make the process easier for non-developpers to prepare the fields mapping.</p>
			<p>Besides preparing the data themselves, this is the most important part as it will define how your data will be displayed into the final mobile application.</p>
			<p>Once done, you will get a rather un-readable text file (serialized PHP array), but don't worry and publish that file  anywhere it can be accessed by a web address (URL). This way you will be able to use it in the converter, and reuse it for any other CSV file that is formatted the same way.</p>
			<br /><br />
			<h2>Step 3: Generate the converter URL</h2>
			<p>The following form will generate an URL that can be used to get the converted file, or directly into your application to provide it with a live data source.</p>",
	'citadel_converter:download:file' => "Download generated Citadel-JSON file",
	'citadel_converter:download:link' => "OR use this direct URL into your app: ",
	'citadel_converter:download:shortlink' => "OR use this shorter URL: ",
	'citadel_converter:form' => "Configure to get the converted file",
	'citadel_converter:form:source' => "Source file (local file or URL): ",
	'citadel_converter:form:template' => "Template file: ",
	'citadel_converter:form:serialized_template' => "OR Template file content: ",
	'citadel_converter:form:filename' => "Exported file name (optional, no file extension): ",
	'citadel_converter:form:import' => "Import format: ",
	'citadel_converter:form:format' => "Export format: ",
	'citadel_converter:form:givelink' => "Give me the link to the converted file !",
	
	// Template generator
	'citadel_converter:tplgen:title' => "Conversion template generator",
	'citadel_converter:tplgen:description' => "<p>This form is meant to facilitate the generation of mapping templates that can be used directly by the converter.</p>
			<p>A mapping template is basically a serialized PHP array, so it a text string that can be hosted on any web server, or sent in a form.</p>
			<p>This tool makes it generation and edition easier</p>",
	'citadel_converter:tplgen:output' => "Generated conversion template",
	'citadel_converter:tplgen:form' => "Edit / Generate a conversion template",
	'citadel_converter:tplgen:legend:technical' => "Input technical settings",
	'citadel_converter:tplgen:firstline' => "Fields title on first line:",
	'citadel_converter:tplgen:firstline:yes' => "YES",
	'citadel_converter:tplgen:firstline:no' => "NO (direct data)",
	'citadel_converter:tplgen:delimiter' => "Delimiter:",
	'citadel_converter:tplgen:enclosure' => "Enclosure:",
	'citadel_converter:tplgen:escape' => "Escape:",
	'citadel_converter:tplgen:legend:metadata' => "Dataset description",
	'citadel_converter:tplgen:dataset_id' => "Dataset ID:",
	'citadel_converter:tplgen:dataset_lang' => "Dataset language:",
	'citadel_converter:tplgen:authorid' => "Author ID:",
	'citadel_converter:tplgen:authorname' => "Author name:",
	'citadel_converter:tplgen:updatefreq' => "Update frequency:",
	'citadel_converter:tplgen:licenceurl' => "Licence URL:",
	'citadel_converter:tplgen:licenceterm' => "Licence term:",
	'citadel_converter:tplgen:sourceurl' => "Source URL:",
	'citadel_converter:tplgen:sourceterm' => "Source term:",
	'citadel_converter:tplgen:legend:semantic' => "Semantic fields mapping",
	'citadel_converter:tplgen:legend:display' => "Display fields",
	'citadel_converter:tplgen:poi_default_cat' => "POI default category:",
	'citadel_converter:tplgen:poi_id' => "POI ID field:",
	'citadel_converter:tplgen:poi_title' => "POI title:",
	'citadel_converter:tplgen:poi_descr' => "POI description field:",
	'citadel_converter:tplgen:poi_cat' => "POI category field:",
	'citadel_converter:tplgen:legend:geo' => "Geographical fields",
	'citadel_converter:tplgen:lat' => "POI latitude field:",
	'citadel_converter:tplgen:long' => "POI longitude field:",
	'citadel_converter:tplgen:geosystem' => "POI geographical coordinates system field:",
	'citadel_converter:tplgen:address' => "POI address field:",
	'citadel_converter:tplgen:postalcode' => "POI postal code field:",
	'citadel_converter:tplgen:city' => "POI city field:",
	'citadel_converter:tplgen:submit' => "Generate the conversion template",
	'citadel_converter:tplgen:action' => "What do you want to get ?",
	'citadel_converter:tplgen:action:generate' => "Output template and keep tweaking / editing it",
	'citadel_converter:tplgen:action:export' => "Export final template (form will disappear)",
	
	'citadel_converter:tplgen:legend:import' => "OR Import and edit existing template",
	'citadel_converter:tplgen:import' => "Template file content",
	
	
);


