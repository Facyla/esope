<?php
$url = elgg_get_site_url();

// Define dropdown options
$yn_opt = array('yes' => elgg_echo('option:yes'), 'no' => elgg_echo('option:no'));
$ny_opt = array('no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes'));


// Set default value
//if (!isset($vars['entity']->setting_name)) { $vars['entity']->setting_name = 'default'; }


// Example yes/no setting
//echo '<p><label>' . elgg_echo('content_facets:settings:settingname') . ' ' . elgg_view('input/select', array('name' => 'params[settingname]', 'options_values' => $yes_no_opt, 'value' => $vars['entity']->settingname)) . '</label><br /><em>' . elgg_echo('content_facets:settings:settingname:details'). '</em></p>';


// Example text setting
//echo '<p><label>' . elgg_echo('content_facets:settings:settingname') . ' ' . elgg_view('input/text', array('name' => 'params[setting_name2]', 'value' => $vars['entity']->setting_name2)) . '</label><br /><em>' . elgg_echo('content_facets:settings:settingname:details'). '</em></p>';


/* CONVERSION INLINE
 * Convertir automatiquement les liens en divers types de ressources : lecteurs embarqués, vidéos, images
 */
// Global switch
echo '<p><label>' . elgg_echo('content_facets:settings:convert_longtext') . ' ' . elgg_view('input/select', array('name' => 'params[convert_longtext]', 'options_values' => $ny_opt, 'value' => $vars['entity']->convert_longtext)) . '</label><br /><em>' . elgg_echo('content_facets:settings:convert_longtext:details'). '</em></p>';
echo '<fieldset>';
	echo '<legend>' . elgg_echo('content_facets:settings:convert_longtext') . '</legend>';
	// URLs
	echo '<p><label>' . elgg_echo('content_facets:settings:render_urls') . ' ' . elgg_view('input/select', array('name' => 'params[render_urls]', 'options_values' => $ny_opt, 'value' => $vars['entity']->render_urls)) . '</label><br /><em>' . elgg_echo('content_facets:settings:render_urls:details'). '</em></p>';
	// Hashtags #
	echo '<p><label>' . elgg_echo('content_facets:settings:render_hashtags') . ' ' . elgg_view('input/select', array('name' => 'params[render_hashtags]', 'options_values' => $ny_opt, 'value' => $vars['entity']->render_hashtags)) . '</label><br /><em>' . elgg_echo('content_facets:settings:render_hashtags:details'). '</em></p>';
	// Mentions @
	echo '<p><label>' . elgg_echo('content_facets:settings:render_mentions') . ' ' . elgg_view('input/select', array('name' => 'params[render_mentions]', 'options_values' => $ny_opt, 'value' => $vars['entity']->render_mentions)) . '</label><br /><em>' . elgg_echo('content_facets:settings:render_mentions:details'). '</em></p>';
	// Videos
	echo '<p><label>' . elgg_echo('content_facets:settings:render_videos') . ' ' . elgg_view('input/select', array('name' => 'params[render_videos]', 'options_values' => $ny_opt, 'value' => $vars['entity']->render_videos)) . '</label><br /><em>' . elgg_echo('content_facets:settings:render_videos:details'). '</em></p>';
	// Images
	echo '<p><label>' . elgg_echo('content_facets:settings:render_images') . ' ' . elgg_view('input/select', array('name' => 'params[render_images]', 'options_values' => $ny_opt, 'value' => $vars['entity']->render_images)) . '</label><br /><em>' . elgg_echo('content_facets:settings:render_images:details'). '</em></p>';
	// URL preview
	echo '<p><label>' . elgg_echo('content_facets:settings:render_url_previews') . ' ' . elgg_view('input/select', array('name' => 'params[render_url_previews]', 'options_values' => $ny_opt, 'value' => $vars['entity']->render_url_previews)) . '</label><br /><em>' . elgg_echo('content_facets:settings:render_url_previews:details'). '</em></p>';
echo '</fieldset>';



/* EXTENSION
 * Ajouter les ressources après le contenu
 */
// Global switch
echo '<p><label>' . elgg_echo('content_facets:settings:extend_longtext') . ' ' . elgg_view('input/select', array('name' => 'params[extend_longtext]', 'options_values' => $ny_opt, 'value' => $vars['entity']->extend_longtext)) . '</label><br /><em>' . elgg_echo('content_facets:settings:extend_longtext:details'). '</em></p>';

echo '<fieldset>';
	echo '<legend>' . elgg_echo('content_facets:settings:extend_longtext') . '</legend>';
	// Videos
	echo '<p><label>' . elgg_echo('content_facets:settings:extend_videos') . ' ' . elgg_view('input/select', array('name' => 'params[extend_videos]', 'options_values' => $ny_opt, 'value' => $vars['entity']->extend_videos)) . '</label><br /><em>' . elgg_echo('content_facets:settings:extend_videos:details'). '</em></p>';
	// Preview
	echo '<p><label>' . elgg_echo('content_facets:settings:extend_url_previews') . ' ' . elgg_view('input/select', array('name' => 'params[extend_url_previews]', 'options_values' => $ny_opt, 'value' => $vars['entity']->extend_url_previews)) . '</label><br /><em>' . elgg_echo('content_facets:settings:extend_url_previews:details'). '</em></p>';
echo '</fieldset>';






