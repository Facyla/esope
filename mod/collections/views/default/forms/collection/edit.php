<?php
elgg_load_js('elgg.collections.edit');

// Get current collection (if exists)
$guid = get_input('guid', false);
$collection = get_entity($guid);


// Get collection vars
if (elgg_instanceof($collection, 'object', 'collection')) {
	$collection_title = $collection->title; // Collection title, for easier listing
	$collection_name = $collection->name; // Collection title, for easier listing
	if (empty($collection_name) && !empty($collection_title)) {
		$collection_name = elgg_get_friendly_title($collection_title);
	}
	$collection_description = $collection->description; // Clear description of what this collection is for
	// Complete collection content - except the first-level <ul> tag (we could use an array instead..) - Use several blocks si we can have an array of individual slides
	$collection_slides = $collection->slides;
	$collection_slides = $collection->slides_comment;
	$collection_access = $collection->access_id; // Default access level
	
} else {
	$collection_css = elgg_get_plugin_setting('css', 'collection'); // CSS
	$collection_access = get_default_access(); // Default access level
}


// Edit form
// Param vars
$content = '';
if ($collection) { $content .= elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid)) . '</p>'; }

// Titre
$content .= '<p><label>' . elgg_echo('collections:edit:title') . ' ' . elgg_view('input/text', array('name' => 'title', 'value' => $collection_title, 'style' => "width: 40ex; max-width: 80%;")) . '</label><br /><em>' . elgg_echo('collections:edit:title:details') . '</em></p>';

// Identifiant (slurl)
$content .= '<p><label>' . elgg_echo('collections:edit:name') . ' ' . elgg_view('input/text', array('name' => 'name', 'value' => $collection_name, 'style' => "width: 40ex; max-width: 80%;")) . '</label><br /><em>' . elgg_echo('collections:edit:name:details') . '</em></p>';

// Description
$content .= '<p><label>' . elgg_echo('collections:edit:description') . ' ' . elgg_view('input/plaintext', array('name' => 'description', 'value' => $collection_description, 'style' => 'height:15ex;')) . '</label><br /><em>' . elgg_echo('collections:edit:description:details') . '</em></p>';

// Access
$content .= '<p><label>' . elgg_echo('collections:edit:access') . ' ' . elgg_view('input/access', array('name' => 'access_id', 'value' => $collection_access)) . '</label><br /><em>' . elgg_echo('collections:edit:access:details') . '</em></p>';

$content .= '<div class="clearfloat"></div>';


// SLIDES
// Sortable blocks + JS add new block
$content .= '<div class="collection-edit-slides">';
$content .= '<p><strong>' . elgg_echo('collections:edit:content') . '</strong><br />';
$content .= '<em>' . elgg_echo('collections:edit:content:details') . '</em></p>';

// Collections slides (sortable)
if (!empty($collection_slides) && !is_array($collection_slides)) { $collection_slides = array($collection_slides); }
if (is_array($collection_slides)) {
	foreach($collection_slides as $slide_content) {
		$content .= elgg_view('collections/input/slide', array('value' => $slide_content));
	}
} else {
	$content .= elgg_view('collections/input/slide', array());
}
$content .= '</div>';
// Add new slide
$content .= elgg_view('input/button', array(
		'id' => 'collection-edit-add-slide',
		'value' => elgg_echo('collections:edit:addslide'),
		'class' => 'elgg-button elgg-button-action',
	));
$content .= '<div class="clearfloat"></div><br />';


$content .= '<p>' . elgg_view('input/submit', array('value' => elgg_echo('collections:edit:submit'))) . '</p>';



/* AFFICHAGE DE LA PAGE D'ÉDITION */
echo '<h2>' . elgg_echo('collections:edit') . '</h2>';

// Affichage du formulaire
// Display the form - Affichage du formulaire
echo elgg_view('input/form', array('action' => elgg_get_site_url() . "action/collection/edit", 'body' => $content, 'id' => "collection-edit-form", 'enctype' => 'multipart/form-data'));

// Informations on embed and insert
if ($collection) {
	echo '<h3><i class="fa fa-info-circle"></i>' . elgg_echo('collections:embed:instructions') . '</h3>';
	echo '<p><blockquote>';
	echo elgg_echo('collections:iframe:instructions', array($collection->guid)) . '<br />';
	if (elgg_is_active_plugin('shortcodes')) { echo elgg_echo('collections:shortcode:instructions', array($collection->guid)) . '<br />'; }
	if (elgg_is_active_plugin('cmspages')) {
		echo elgg_echo('collections:cmspages:instructions', array($collection->guid)) . '<br />';
		if (elgg_is_active_plugin('shortcodes')) { echo elgg_echo('collections:cmspages:instructions:shortcode', array($collection->guid)) . '<br />'; }
	}
	echo '</blockquote></p>';
}

// Prévisualisation
if ($collection) {
	echo '<div class="clearfloat"></div><br /><br />';
	echo '<a href="' . $collection->getURL() . '" style="float:right" target="_blank" class="elgg-button elgg-button-action">' . elgg_echo('collections:edit:view') . '</a>';
	echo '<h2>' . elgg_echo('collections:edit:preview') . '</h2>';
	echo elgg_view('collection/view', array('entity' => $collection));
}


